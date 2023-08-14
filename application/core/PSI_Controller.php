<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Primasis Codeigniter Base Controller
 *
 * @package         CodeIgniter
 * @subpackage      Primasis CodeIgniter Base Controller
 * @category        Controller
 * @author          Halfawi
 * @license         LapakRumpin
 * @link            https://www.lapakrumpin.com
 * @version         1.0.0
 */

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/BeforeValidException.php';
require_once APPPATH . '/libraries/ExpiredException.php';
require_once APPPATH . '/libraries/SignatureInvalidException.php';

use \Firebase\JWT\JWT;

class PSI_Controller extends REST_Controller
{

	private $user_credential;

    public function __construct()
    {
        parent::__construct();
        $this->language = $this->_detect_language();

        $this->config->set_item('language', $this->language);
        $this->lang->load(array('content', 'message'));
		$this->load->model('User_session_m');

    }

    protected function _detect_language()
    {
        $headers = $this->input->request_headers();
        $language = (@$headers['Accept-Language'] == 'id') ? 'indonesian' : 'english';

        return $language;
    }

    protected function auth()
    {
        // JWT Auth middleware
        $headers = $this->input->request_headers();

       	if (!empty($headers['Authorization'])) {
        	if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'] , $matches)) {
                $access_token = $matches[1];
        	}
    	}

        $links = [
            [
                'href' => $_SERVER['QUERY_STRING'] ? '/' . uri_string() . '?' . $_SERVER['QUERY_STRING'] : '/' . uri_string(),
                'method' => strtoupper($this->_detect_method()),
                'rel' => 'self',
            ],
        ];

        if (!$access_token) {
            $output = $this->rscode->output('1005', null, false, $links);

            $this->response($output->response, $output->code);
        }

        $get_session_payload['page'] = [
            'page' => 0,
            'limit' => 1
        ];

        $get_session_payload['column'] = [];

        $get_session_payload['filter']['access_token'] = $access_token;

        $get_session_payload['sort'] = [];

        $get_session = $this->User_session_m->get_session(
            $get_session_payload['page'],
            $get_session_payload['column'],
            $get_session_payload['filter'],
            $get_session_payload['sort']
        );

        $session = $get_session ? $get_session[0] : null;
		
        
        if (!$session) {
            $output = $this->rscode->output('1005', null, false, $links);

            $this->response($output->response, $output->code);
        }

        if ($session['status'] != 1) {
            $output = $this->rscode->output('1005', null, false, $links);

            $this->response($output->response, $output->code);
        }

        $decode = $this->decode_token($access_token, 'access_token');

        if (!$decode) {
            
            $output = $this->rscode->output('1005', null, false, $links);

            $this->response($output->response, $output->code);
        }

        // Check Expired Token
        if (time() > $decode->exp) {

            $output = $this->rscode->output('1004', null, false, $links);

            $this->response($output->response, $output->code);
        }

        $this->userdata = $decode;
    }

    protected function gen_token($payload = [])
    {
        $session_id = @$payload['sub'] ? $payload['sub'] : gen_uuid();
        $issued_at = time();
        $access_expiry_time = 60 * 60 * 12; // 12 Hours
        $refresh_expire_time = 60 * 60 * 24 * 14; // 14 Days

        $payload_access = $payload;
        $payload_access['sub'] = $session_id;
        $payload_access['iat'] = $issued_at;
        $payload_access['exp'] = $issued_at + $access_expiry_time;

        $payload_refresh = $payload;
        $payload_refresh['sub'] = $session_id;
        $payload_refresh['iat'] = $issued_at;
        $payload_refresh['exp'] = $issued_at + $refresh_expire_time; // 2 Week

        $access_token = JWT::encode($payload_access, $this->config->item('access_secret'));
        $refresh_token = JWT::encode($payload_refresh, $this->config->item('refresh_secret'));

        $output = new stdClass();
        $output = (object)[
            'access_token' => $access_token,
            'refresh_token' => $refresh_token,
            'token_type' => 'Bearer',
            'expires' => $access_expiry_time
        ];

        return $output;
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

    protected function refresh_token($refresh_token)
    {
        $decode = $this->decode_token($refresh_token, 'refresh_token');

        if (!$decode) {
            $output = $this->rscode->output('1005', $decode);

            $this->response($output->response, $output->code);
        }

        if (time() > $decode->exp) {
            $output = $this->rscode->output('1004');

            $this->response($output->response, $output->code);
        }

        $payload = (array)$decode;

        $new_token = $this->gen_token($payload);

        return $new_token;
    }

    protected function auth_xendit_callback()
    {
        $request_header = getallheaders();
        $request_token = null;
        $xendit_callback_token = $this->config->item('xendit_callback_token');

        if (isset($request_header['x-callback-token'])) {
            $request_token = $request_header['x-callback-token'];
        } elseif (isset($request_header['X-CALLBACK-TOKEN'])) {
            $request_token = $request_header['X-CALLBACK-TOKEN'];
        }

        $links = [
            [
                'href' => $_SERVER['QUERY_STRING'] ? '/' . uri_string() . '?' . $_SERVER['QUERY_STRING'] : '/' . uri_string(),
                'method' => strtoupper($this->_detect_method()),
                'rel' => 'self',
            ],
        ];

        if ($request_token != $xendit_callback_token) {
            $output = $this->rscode->output('1005', null, false, $links);

            $this->response($output->response, $output->code);
        }
    }
}
