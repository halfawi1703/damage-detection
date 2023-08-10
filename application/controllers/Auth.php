<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/core/Web_Controller.php';

class Auth extends Web_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $fcm_id = null;
        $type = 'email';
        $platform = 'Web';
        $app_version = '1.0.0-appsys';
        $os_version = get_os();
        $device_manufacturer = '-';
        $device_model = '-';
        // $location = get_ip_info('loc');

        $payload = [
            'email' => $email,
            'password' => $password,
            'type' => $type,
            'fcm_id' => 'webapp',
            'platform' => $platform,
            'app_version' => $app_version,
            'os_version' => $os_version,
            'device_manufacturer' => $device_manufacturer,
            'device_model' => $device_model,
            'location' => -6.175372,106.827194
        ];

        $auth = api_request('POST', 'v1/auth/login', $payload);

        $status = @$auth->status ?: 'error';
        $message = @$auth->message ?: null;
        $data = @$auth->data ?: [];

        $output = (object)[
            'status' => @$auth->status ?: 'error',
            'message' => @$auth->message ?: 'An error encoured',
            'data' => @$auth->data ?: (object)[]
        ];

        if (@$auth->status == 'success') {
            $output->data->redirect_url = base_url();

			$session_data = $this->decode_token($output->data->access_token, 'access_token');

			$session = [
				'id' => $session_data->id,
				'email' => $session_data->email,
				'first_name' => $session_data->first_name,
				'last_name' => $session_data->last_name,
				'role' => $session_data->role,
				'expired' => date('Y-m-d H:i:s',$session_data->exp),
				'time' => date('Y-m-d H:i:s')
			];

			$this->session->set_userdata($session);
            
            // setcookie('_psi_session', $output->data->access_token, time() + 60 * 60 * 12, "/");
            // setcookie('_psi_rsession', $output->data->refresh_token, time() + 60 * 60 * 24 * 14, "/");
        } else {
            $output->data->redirect_url = null;
        }

        echo json_encode($output);
        exit();
    }

    public function logout()
    {
        $auth = api_request('POST', 'v1/auth/logout');

        $this->session->sess_destroy();

        unset($_COOKIE['_psi_session']);
        unset($_COOKIE['_psi_rsession']);

        redirect('/login');
        exit();
    }

}
