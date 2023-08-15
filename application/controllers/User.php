<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/core/Web_Controller.php';

class User extends Web_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->auth();

        $this->load->model('User_m');

        $this->load->helper('url');
    }

    public function index()
    {
        $data = [];

        $data['breadcrumb'] = [
            [
                'name' => 'User',
                'href' => null
            ]
        ];

        $data['page_title'] = 'User';
        $data['menu_active'] = 'user';

        $category_payload['page'] = [
            'offset' => 0,
            'limit' => 1000
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('modules/user/main', $data);
        $this->load->view('templates/footer', $data);
    }

    public function list_data()
    {
        $limit = $this->input->get('length');
        $page = $this->input->get('start') + 1;

        $keyword = $this->input->get('keyword');

        # payload pagination datatables
        if ($page > 1) {
            $page = ($this->input->get('start') / $limit) + 1;
        }

        $payload = [
            'offset' => $page ?: 0,
            'limit' => $limit ?: 1000
        ];

        $offset = $page ? ((int)$page - 1) * (int)$limit : 0;

        # count user
        $count_user_payload['page'] = [
            'offset' => $offset ?: 0,
            'limit' => $limit ?: 1000
        ];

        $count_user_payload['column'] = [];
        $count_user_payload['filter']['keyword'] = $keyword;
        $count_user_payload['filter']['status'] = 1;
        $count_user_payload['sort'] = [];

        $count_user = [];

        $count_user = $this->User_m->count_user(
            $count_user_payload['filter']
        );

        $count_user = @$count_user ? $count_user : null;

        $user_payload['page'] = [
            'offset' => $offset ?: 0,
            'limit' => $limit ?: 1000
        ];

        $user_payload['column'] = [];

        $user_payload['filter']['keyword'] = $keyword;
        $user_payload['filter']['status'] = 1;

        $user_payload['sort'] = [];

        $user = [];

        $user = $this->User_m->get_user(
            $user_payload['page'],
            $user_payload['column'],
            $user_payload['filter'],
            $user_payload['sort']
        );

        $user = @$user ? $user : null;

        $records_total = $count_user;

        if ($keyword) {
            $records_filtered = @$user ? count($user) : 0;
        } else {
            $records_filtered = $count_user;
        }


        $data = [];

        if (@$user) {
            foreach ($user as $key => $value) {

                $data[] = [
                    $value['id'],
                    $value['first_name'] .' '. $value['last_name'],
                    $value['email'],
                    $value['phone'],
                    $value['status'] == 1 ? 'Active' : 'Non Active',
                    $value['created_at']
                ];
            }
        }

        $output = [
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $records_total,
            "recordsFiltered" => $records_filtered,
            "data" => $data,
            "payload" => $payload
        ];

        echo json_encode($output);
    }

    public function data()
    {
        $id = $this->input->get('id');

        $user_payload['page'] = [
            'offset' => 0,
            'limit' => 1
        ];

        $user_payload['column'] = [];

        $user_payload['filter']['id'] = $id;
        $user_payload['filter']['status'] = 1;

        $user_payload['sort'] = [];

        $user = [];

        $user = $this->User_m->get_user(
            $user_payload['page'],
            $user_payload['column'],
            $user_payload['filter'],
            $user_payload['sort']
        );

        $user = @$user ? $user[0] : null;

        if (!$user) {

            $output = (object)[
                'status' => 'error',
                'message' => 'Data not found',
                'data' => (object)[]
            ];

            echo json_encode($output);
            exit();
        }

        echo json_encode($user);
        exit();
    }

    public function insert()
    {
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $nik = $this->input->post('nik');
        $password = $this->input->post('password');
        $gender = $this->input->post('gender');
        $dob = $this->input->post('dob');

        $validation['data'] = $this->input->post();

        $validation['rules'] = [
            [
                'field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email|is_unique[user.email]',
            ],
            [
                'field' => 'phone',
                'label' => 'Phone',
                'rules' => 'trim|required|is_natural|min_length[10]|max_length[12]',
            ],
            [
                'field' => 'nik',
                'label' => 'NIK',
                'rules' => 'trim|required|is_natural|min_length[16]|max_length[16]',
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required|min_length[6]|max_length[8]',
            ],
            [
                'field' => 'gender',
                'label' => 'Gender',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'dob',
                'label' => 'Date Of Birth',
                'rules' => 'trim|required',
            ]
        ];

        $this->form_validation->set_data($validation['data']);
        $this->form_validation->set_rules($validation['rules']);

        $errors = [];
        $output = new stdClass();

        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();

            $output = (object)[
                'status' => 'error',
                'message' => $errors,
                'data' => (object)[]
            ];

            echo json_encode($output);
            exit();
        }

        $this->db->trans_start();

        $id = gen_id();

        # insert process
        $data_insert = [
            'id' => $id,
            'first_name' => ucwords($first_name),
            'last_name' => ucwords($last_name),
            'email' => $email,
            'phone' => $phone,
            'nik' => $nik,
            'password' => $password,
            'gender' => $gender,
            'dob' => $dob,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $insert_user = $this->User_m->insert_user($data_insert);

        if (!$insert_user) {

            $output = (object)[
                'status' => 'error',
                'message' => 'Error',
                'data' => (object)[]
            ];

            echo json_encode($output);
            exit();
        }

        $this->db->trans_complete();

        $output = (object)[
            'status' => 'success',
            'message' => 'Success',
            'data' => (object)[]
        ];

        echo json_encode($output);
        exit();
    }

    public function update()
    {
        $id = $this->input->post('id');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $nik = $this->input->post('nik');
        $password = $this->input->post('password');
        $gender = $this->input->post('gender');
        $dob = $this->input->post('dob');

        $validation['data'] = $this->input->post();

        $validation['rules'] = [
            [
                'field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email|is_unique[user.email]',
            ],
            [
                'field' => 'phone',
                'label' => 'Phone',
                'rules' => 'trim|required|is_natural|min_length[10]|max_length[12]',
            ],
            [
                'field' => 'nik',
                'label' => 'NIK',
                'rules' => 'trim|required|is_natural|min_length[16]|max_length[16]',
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required|min_length[6]|max_length[8]',
            ],
            [
                'field' => 'gender',
                'label' => 'Gender',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'dob',
                'label' => 'Date Of Birth',
                'rules' => 'trim|required',
            ]
        ];

        $this->form_validation->set_data($validation['data']);
        $this->form_validation->set_rules($validation['rules']);

        $errors = [];
        $output = new stdClass();

        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();

            $output = (object)[
                'status' => 'error',
                'message' => $errors,
                'data' => (object)[]
            ];

            echo json_encode($output);
            exit();
        }

        $user_payload['page'] = [
            'offset' => 0,
            'limit' => 1
        ];

        $user_payload['column'] = [];

        $user_payload['filter']['id'] = $id;
        $user_payload['filter']['status'] = 1;

        $user_payload['sort'] = [];

        $user = [];

        $user = $this->User_m->get_user(
            $user_payload['page'],
            $user_payload['column'],
            $user_payload['filter'],
            $user_payload['sort']
        );

        $user = @$user ? $user[0] : null;

        if (!$user) {

            $output = (object)[
                'status' => 'error',
                'message' => 'Error',
                'data' => (object)[]
            ];

            echo json_encode($output);
            exit();
        }

        $this->db->trans_start();

       
        $data_update = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone' => $phone,
            'nik' => $nik,
            'password' => $password,
            'gender' => $gender,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $update_payload['filter']['id'] = $id;
        $update_user = $this->User_m->update_user($data_update, $update_payload['filter']);

        if (!$update_user) {

            $output = (object)[
                'status' => 'error',
                'message' => 'Error',
                'data' => (object)[]
            ];

            echo json_encode($output);
            exit();
        }

        $this->db->trans_complete();

        $output = (object)[
            'status' => 'success',
            'message' => 'Success',
            'data' => (object)[]
        ];

        echo json_encode($output);
        exit();
    }
}
