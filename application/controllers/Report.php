<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/core/Web_Controller.php';

class Report extends Web_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->is_login) {
            redirect('login');
        }

        $this->load->model('User_m');
    }

    public function index()
    {
        $data = [];

        $data['is_login'] = $this->is_login;
        $data['userdata'] = $this->userdata;

        $data['breadcrumb'] = [
            [
                'name' => 'Report',
                'href' => null
            ]
        ];

        $data['page_title'] = 'Report';
        $data['menu_active'] = 'report';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('modules/report/main', $data);
        $this->load->view('templates/footer', $data);
    }

    public function list_data()
    {
        $limit = $this->input->get('length');
        $page = $this->input->get('start') + 1;

        $data = [];

        # payload pagination datatables
        if ($page > 1) {
            $page = ($this->input->get('start') / $limit) + 1;
        }

        # count user
        $api_payload = [
            'page' => $page,
            'limit' => $limit
        ];

        $result = api_request('GET', 'v1/report', $api_payload);

        if (@$result->data) {
            foreach ($result->data as $key => $value) {

                $data[] = [
                    $value->id,
                    $value->police_number,
                    $value->event_type_name,
                    $value->description,
                    $value->claim_status_id,
                    $value->created_at
                ];
            }
        }

        
        $output = [
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $result->pagination->total_record,
            "recordsFiltered" => $result->pagination->filtered,
            "data" => $data
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
        $police_number = $this->input->post('police_number');
        $machine_number = $this->input->post('machine_number');
        $chassis_number = $this->input->post('chassis_number');
        $vehicle_brand = $this->input->post('vehicle_brand');
        $vehicle_variant = $this->input->post('vehicle_variant');
        $vehicle_year = $this->input->post('vehicle_year');

        $insured_police_number = $this->input->post('insured_police_number');
        $insured_name = $this->input->post('insured_name');

        $reporting_name = $this->input->post('reporting_name');
        $reporting_phone_number = $this->input->post('reporting_phone_number');
        $reporting_email = $this->input->post('reporting_email');
        $rider_name = $this->input->post('rider_name');
        $rider_phone_number = $this->input->post('rider_phone_number');
        $sim_expired_date = $this->input->post('sim_expired_date');

        $event_date = $this->input->post('event_date');
        $event_type = $this->input->post('event_type');
        $event_location = $this->input->post('event_location');
        $event_chronology = $this->input->post('event_chronology');

        $front_image = $this->input->post('front_image');
        $right_image = $this->input->post('right_image');

        $validation['data'] = $this->input->post();
        $validation['rules'] = [
            [
                'field' => 'police_number',
                'label' => 'Police Number',
                'rules' => 'trim|required|min_length[6]|max_length[10]',
            ],
            [
                'field' => 'machine_number',
                'label' => 'Machine Number',
                'rules' => 'trim|required|min_length[10]|max_length[12]',
            ],
            [
                'field' => 'chassis_number',
                'label' => 'Chassis Number',
                'rules' => 'trim|required|min_length[10]|max_length[20]',
            ],
            [
                'field' => 'vehicle_brand',
                'label' => 'Vehicle Brand',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'vehicle_variant',
                'label' => 'Vehicle Variant',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'vehicle_year',
                'label' => 'Vehicle Year',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'reporting_name',
                'label' => 'Reporting Name',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'rider_name',
                'label' => 'Rider Name',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'sim_expired_date',
                'label' => 'SIM Expired Date',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'event_date',
                'label' => 'Event Date',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'event_location',
                'label' => 'Vehicle Variant',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'event_chronology',
                'label' => 'Vehicle Variant',
                'rules' => 'trim|required|min_length[5]|max_length[225]',
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
        # count user
        $api_payload = [
            'police_number' => $police_number,
            'machine_number' => $machine_number,
            'chassis_number' => $chassis_number,
            'vehicle_brand' => $vehicle_brand,
            'vehicle_variant' => $vehicle_variant,
            'vehicle_year' => $vehicle_year,
            'insured_police_number' => $insured_police_number,
            'insured_name' => $insured_name,
            'reporting_name' => $reporting_name,
            'reporting_phone_number' => $reporting_phone_number,
            'reporting_email' => $reporting_email,
            'rider_name' => $rider_name,
            'rider_phone_number' => $rider_phone_number,
            'sim_expired_date' => $sim_expired_date,
            'event_date' => $event_date,
            'event_type' => $event_type,
            'event_location' => $event_location,
            'event_chronology' => $event_chronology,
            'front_image' => $front_image,
            'right_image' => $right_image
        ];

        $insert = api_request('POST', 'v1/report', $api_payload);

        if (!$insert->message == 'error') {

            $output = (object)[
                'status' => 'error',
                'message' => $insert->message,
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
