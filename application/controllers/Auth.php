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
            $output->data->redirect_url = base_url('auth/redirect');

            setcookie('_psi_session', $output->data->access_token, time() + 60 * 60 * 12, "/", $this->config->item('domain_name'), true, true);
            setcookie('_psi_rsession', $output->data->refresh_token, time() + 60 * 60 * 24 * 14, "/", $this->config->item('domain_name'), true, true);
        } else {
            $output->data->redirect_url = null;
        }

        echo json_encode($output);
        exit();
    }

    public function redirect()
    {
        // Get Profile
        $profile = api_request('GET', 'v1/user');
        $profile = @$profile->data ?: null;

        if (!$profile) {
            redirect(base_url());
        }

        setcookie('_psi_userdata', '', time() - 3600, "/", $this->config->item('domain_name'), true, true);
        setcookie('_psi_userdata', json_encode($profile), time() + 60 * 60 * 12, "/", $this->config->item('domain_name'), true, true);

        redirect(base_url('overview'));
    }

    public function logout()
    {
        $auth = api_request('POST', 'v1/auth/logout');

        setcookie('_psi_session', '', time() - 3600, "/", $this->config->item('domain_name'), true, true);
        setcookie('_psi_rsession', '', time() - 3600, "/", $this->config->item('domain_name'), true, true);
        setcookie('_psi_userdata', '', time() - 3600, "/", $this->config->item('domain_name'), true, true);

        redirect(base_url());
        exit();
    }

    // public function logout()
    // {
    //     $auth = api_request('POST', 'v1/auth/logout');

    //     // $this->session->sess_destroy();

    //     unset($_COOKIE['_psi_session']);
    //     unset($_COOKIE['_psi_rsession']);

    //     redirect('/login');
    //     exit();
    // }

}
