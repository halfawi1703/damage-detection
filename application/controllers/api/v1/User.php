<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends PSI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('User_m');
    }

    public function index_get()
    {
        $this->auth();

        $page = $this->get('page') ?: 1;
        $limit = $this->get('limit') ?: 10;
        $id = $this->userdata->id;

        $data = [];
        $pagination = [];
        $errors = [];
        $output = [];

        $links = [
            [
                'href' => $_SERVER['QUERY_STRING'] ? '/' . uri_string() . '?' . $_SERVER['QUERY_STRING'] : '/' . uri_string(),
                'method' => strtoupper($this->_detect_method()),
                'rel' => 'self',
            ],
            [
                'href' => '/v1/user',
                'method' => 'GET',
                'rel' => 'user',
            ]
        ];

        # Validation
        $offset = $page ? ((int)$page - 1) * (int)$limit : 0;

        # Validation
        $validation['data'] = [
            'id' => $id,
            'page' => $page,
            'limit' => $limit,
        ];

        $validation['rules'] = [
            [
                'field' => 'page',
                'label' => 'Page',
                'rules' => 'trim|is_natural',
            ],
            [
                'field' => 'limit',
                'label' => 'Limit',
                'rules' => 'trim|is_natural',
            ],
        ];

        $this->form_validation->set_data($validation['data']);
        $this->form_validation->set_rules($validation['rules']);

        $data = [];

        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();

            $output = $this->rscode->output('0002', $data, $pagination, $errors, $links);

            $this->response($output->response, $output->code);
        }

        # Data
        $user_payload['page'] = [];

        $user_payload['page'] = [
            'offset' => $offset,
            'limit' => $limit
        ];

        $user_payload['column'] = [];

        $user_payload['filter'] = [];

        $user_payload['filter']['id'] = $id;

        $user_payload['sort'] = [];

        $user = [];

        $user = $this->User_m->get_user(
            $user_payload['page'],
            $user_payload['column'],
            $user_payload['filter'],
            $user_payload['sort']
        );

        if ($id) {
            $user = @$user ? $user[0] : [];
        }

        $data = $user;

        if (!$data) {
            $output = $this->rscode->output('0001', $data, $pagination, $errors, $links);

            $this->response($output->response, $output->code);
        }

        # Pagination
        if (!$id) {

            $user_count_filtered = $this->User_m->count_user($user_payload['filter']);
            $user_count_all = $this->User_m->count_user();

            $pagination = [
                'page' => (int) $page,
                'limit' => (int) $limit,
                'filtered' => (int) $user_count_filtered,
                'total_page' => (int) ceil($user_count_filtered / $limit),
                'total_record' => (int) $user_count_all        
            ];
        }
        
        # Output
        $output = $this->rscode->output('0000', $data, $pagination, $errors, $links);

        $this->response($output->response, $output->code);
    }
}
