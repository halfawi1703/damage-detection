<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * ALT Codeigniter Base Controller
 *
 * @package         CodeIgniter
 * @subpackage      ALT CodeIgniter Base Controller
 * @category        Controller
 * @author          Shures Arwasyi
 * @license         Alternate Creative
 * @link            https://www.alternatecreative.id
 * @version         1.0.0
 */

require 'vendor/autoload.php'; // Jika menggunakan library Firebase JWT
use \Firebase\JWT\JWT;

class Web_Controller extends CI_Controller
{

    private $user_credential;

    protected function auth()
    {
        $links = [];

        // JWT Auth middleware
        $access_token = $_COOKIE['_psi_session'];

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
            // echo 'Error: ' . $e->getMessage();
        }
    }
}
