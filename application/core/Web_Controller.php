<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * psi Codeigniter Base Controller
 *
 * @package         CodeIgniter
 * @subpackage      Primasis CodeIgniter Base Controller
 * @category        Controller
 * @author          Halfawi
 * @license         LapakRumpin
 * @link            https://www.lapakrumpin.id
 * @version         1.0.0
 */

use \Firebase\JWT\JWT;

class Web_Controller extends CI_Controller
{

	private $user_credential;

    public function __construct()
    {
        parent::__construct();

        $this->get_userdata();
        
        $this->is_login = @$this->session->userdata('id') ? true : false;
        $this->userdata = @$this->session->userdata ?: null;

		date_default_timezone_set('Asia/Jakarta'); 
    }

    protected function auth()
    {
        $links = []; 
        // JWT Auth middleware
        $headers = $this->input->get_request_header('_psi_session');

       	if (!empty($headers)) {
        	if (preg_match('/Bearer\s(\S+)/', $headers , $matches)) {
                $access_token = $matches[1];
        	}
    	}

        $decode = $this->decode_token($access_token, 'access_token');

        if (!$decode) {
            $output = $this->rscode->output('1005', null, false, $links);

            $this->response($output->response, $output->code);
        }

        // Check Expired Token
        if (time() > $decode->exp) {
        }

        $this->userdata = $decode;
    }

    protected function decode_token($token, $type = 'access_token')
    {
        if (!in_array($type, ['access_token', 'refresh_token'])) {
            return false;
        }

        if ($type == 'access_token') {
            $secret_key = $this->config->item('access_secret');
        } elseif ($type == 'refresh_token') {
            $secret_key = $this->config->item('refresh_secret');
        }

        try {
           $decode = JWT::decode($token, $secret_key, array('HS256'));

           $data = $decode;

           return $data;
        } catch (Exception $e) {
            return false;
        }
    }

    protected function get_userdata()
    {
        $userdata = (@$_COOKIE['_psi_userdata'] && @$_COOKIE['_psi_session']) ? json_decode($_COOKIE['_psi_userdata']) : null;

        $this->userdata = $userdata;
        $this->is_login = $userdata ? true : false;

        if (!$this->is_login) {
            if (@$_COOKIE['_psi_userdata']) {
                setcookie('_psi_session', '', time() - 3600, "/", $this->config->item('domain_name'), true, true);
                setcookie('_psi_rsession', '', time() - 3600, "/", $this->config->item('domain_name'), true, true);
                setcookie('_psi_userdata', '', time() - 3600, "/", $this->config->item('domain_name'), true, true);
            }
        }
    }
	
}
