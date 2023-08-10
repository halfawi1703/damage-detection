<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends PSI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_m');
		$this->load->model('User_session_m');
    }

    public function login_post()
    {
        $type = $this->post('type');
        $email = $this->post('email');
        $password = $this->post('password');
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $platform = $this->post('platform');
        $fcm_id = $this->post('fcm_id');
        $app_version = $this->post('app_version');
        $os_version = $this->post('os_version');
        $device_manufacturer = $this->post('device_manufacturer');
        $device_model = $this->post('device_model');
        $location = $this->post('location');

        $validation['data'] = $this->post();
        $validation['rules'] = [
            [
                'field' => 'type',
                'label' => 'Type',
                'rules' => 'trim|required|in_list[email,google]',
            ],
            [
                'field' => 'email',
                'label' => $this->lang->line('email'),
                'rules' => 'trim|required|valid_email',
            ],
            [
                'field' => 'fcm_id',
                'label' => 'FCM ID',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'platform',
                'label' => 'Platform',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'app_version',
                'label' => 'App Version',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'os_version',
                'label' => 'OS Version',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'device_manufacturer',
                'label' => 'Device Manufacturer',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'device_model',
                'label' => 'Device Model',
                'rules' => 'trim|required',
            ]
        ];

        if ($type == 'email') {
            $validation['rules'][] = [
                'field' => 'password',
                'label' => $this->lang->line('password'),
                'rules' => 'trim|required',
            ];
        }

        $links = [
            [
                'href' => $_SERVER['QUERY_STRING'] ? '/' . uri_string() . '?' . $_SERVER['QUERY_STRING'] : '/' . uri_string(),
                'method' => strtoupper($this->_detect_method()),
                'rel' => 'self',
            ],
            [
                'href' => '/v1/profile',
                'method' => 'GET',
                'rel' => 'profile',
            ]
        ];

        $this->form_validation->set_data($validation['data']);
        $this->form_validation->set_rules($validation['rules']);

        $errors = [];
        $output = new stdClass();

        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();

            $output = $this->rscode->output('1001', null, $errors, $links);

            $this->response($output->response, $output->code);
        }

        # get user
        $user_payload['page'] = [
            'offset' => 0,
            'limit' => 1
        ];

        $user_payload['column'] = [];

        $user_payload['filter']['email'] = $email;
        $user_payload['filter']['status'] = 1;

        $user_payload['sort'] = [];

        $user = [];

        $user = $this->User_m->get_user(
            $user_payload['page'],
            $user_payload['column'],
            $user_payload['filter'],
            $user_payload['sort']
        );

        $user = $user ? $user[0] : null;

        if (!$user) {
            $output = $this->rscode->output('1002', null, $errors, $links);

            $this->response($output->response, $output->code);
        }

        $hash_password = false;

        if ($type == 'email') {
            $hash_password = hash_password($password);
        }

        $auth = $this->User_m->auth($email, $hash_password);
		
        if (!$auth) {
            $output = $this->rscode->output('1003', null, $errors, $links);

            $this->response($output->response, $output->code);
        }

        # get user role
        $user_role_payload['page'] = [
            'offset' => 0,
            'limit' => 1
        ];

        $user_role_payload['column'] = [];

        $user_role_payload['filter']['user_id'] = $user['id'];

        $user_role_payload['sort'] = [];

        $user_role = [];

        $user_role = $this->User_m->get_user_role(
            $user_role_payload['page'],
            $user_role_payload['column'],
            $user_role_payload['filter'],
            $user_role_payload['sort']
        );

        $payload['id'] = $user['id'];
        $payload['email'] = $user['email'];
        $payload['first_name'] = $user['first_name'];
		$payload['last_name'] = $user['last_name'];
        $payload['role'] = $user_role;
        $payload['platform'] = $platform;
        $payload['app_version'] = $app_version;

        $token = $this->gen_token($payload);
        $payload_token = $this->decode_token($token->access_token, 'access_token');

        // Insert Session Log
        $data_insert_session = [
            'user_id' => $payload_token->id,
            'session_id' => $payload_token->sub,
            'access_token' => $token->access_token,
            'refresh_token' => $token->refresh_token,
            'fcm_id' => $fcm_id,
            'platform' => $platform,
            'user_agent' => $user_agent,
            'app_version' => $app_version,
            'os_version' => $os_version,
            'device_manufacturer' => $device_manufacturer,
            'device_model' => $device_model,
            'lat' => null,
            'lng' => null,
            'status' => 1,
            'expired_at' => date('Y-m-d H:i:s'),
            'last_activity_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $insert_session = $this->User_session_m->insert_session($data_insert_session);

        $data = $token;
        $output = $this->rscode->output('1000', $data, $errors, $links);

        $this->response($output->response, $output->code);
    }

    public function refresh_token_post()
    {
        $refresh_token = $this->input->post('refresh_token');
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $app_version = $this->post('app_version');
        $os_version = $this->post('os_version');
        $location = $this->post('location');

        $validation['data'] = $this->post();
        $validation['rules'] = [
            [
                'field' => 'refresh_token',
                'label' => 'Refresh Token',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'app_version',
                'label' => 'App Version',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'os_version',
                'label' => 'OS Version',
                'rules' => 'trim|required',
            ],
        ];

        $this->form_validation->set_data($validation['data']);
        $this->form_validation->set_rules($validation['rules']);

        $errors = [];
        $output = new stdClass();

        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();

            $output = $this->rscode->output('1007', null, $errors);

            $this->response($output->response, $output->code);
        }

        $get_session = $this->User_session_m->get_session(1, 1, false, false, false, false, false, $refresh_token);
        $session = $get_session ? $get_session[0] : null;

        if (!$session) {
            $output = $this->rscode->output('1005');

            $this->response($output->response, $output->code);
        }

        if ($session->status == 0) {
            // Prevent action for stealing refresh token
            // If has request refresh_token greather than 1
            // system will be voided all token with same session_id
            $data_update_session = [
                'status' => 2,
                'updated_at' => time()
            ];

            $this->db->trans_start();
            $update_session = $this->User_session_m->update_session($data_update_session, false, false, $session->session_id, false ,false, 1);

            if (!$update_session) {
                $output = $this->rscode->output('1008');

                $this->response($output->response, $output->code);
            }

            $this->db->trans_complete();
            $output = $this->rscode->output('1005');

            $this->response($output->response, $output->code);
        }

        $new_token = $this->refresh_token($refresh_token);
        $payload_token = $this->decode_token($new_token->access_token, 'access_token');

        // Set Inactive old_token
        $data_update_session = [
            'status' => 0,
            'last_activity_at' => time(),
            'updated_at' => time()
        ];

        $update_session = $this->User_session_m->update_session($data_update_session, false, false, $payload_token->sub, false, $refresh_token);

        if (!$update_session) {
            $output = $this->rscode->output('1005');

            $this->response($output->response, $output->code);
        }

        // Insert Session Log
        $data_insert_session = [
            'user_id' => $payload_token->id,
            'session_id' => $payload_token->sub,
            'access_token' => $new_token->access_token,
            'refresh_token' => $new_token->refresh_token,
            'fcm_id' => $session->fcm_id,
            'platform' => $session->platform,
            'user_agent' => $user_agent,
            'app_version' => $app_version,
            'os_version' => $os_version,
            'device_manufacturer' => $session->device_manufacturer,
            'device_model' => $session->device_model,
            'lat' => null,
            'lng' => null,
            'status' => 1,
            'expired_at' => $payload_token->exp,
            'last_activity_at' => $payload_token->iat,
            'created_at' => $payload_token->iat,
            'updated_at' => $payload_token->iat
        ];

        $insert_session = $this->User_session_m->insert_session($data_insert_session);

        if (!$insert_session) {
            $output = $this->rscode->output('1005');

            $this->response($output->response, $output->code);
        }

        $data = $new_token;

        $output = $this->rscode->output('1006', $data);

        $this->response($output->response, $output->code);
    }

    public function logout_post()
    {
        $this->auth();

        $user_id = $this->userdata->id;
        $session_id = $this->userdata->sub;

        $data_update_session = [
            'status' => 3,
            'updated_at' => time()
        ];

        $update_session_payload['filter']['user_id'] = $user_id;
        $update_session_payload['filter']['session_id'] = $session_id;
        
        $update_session = $this->User_session_m->update_session($data_update_session, $update_session_payload['filter']);

        if (!$update_session) {
            $output = $this->rscode->output('1005');

            $this->response($output->response, $output->code);
        }

        $data = [
            'user_id' => $user_id,
            'session_id' => $session_id
        ];

        $output = $this->rscode->output('1006', $data);

        $this->response($output->response, $output->code);

    }

}
