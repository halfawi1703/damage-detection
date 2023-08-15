<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends PSI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Vehicle_unit_m');
        $this->load->model('Insured_m');
        $this->load->model('Customer_m');
        $this->load->model('Event_m');
        $this->load->model('Claim_m');
    }

    public function index_get()
    {
        $page = $this->get('page') ?: 1;
        $limit = $this->get('limit') ?: 10;
        $id = $this->get('id');
        $status = $this->get('status') ?: 1;

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
                'href' => '/v1/report',
                'method' => 'GET',
                'rel' => 'report',
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
        $claim_payload['page'] = [];

        $claim_payload['page'] = [
            'offset' => $offset,
            'limit' => $limit
        ];

        $claim_payload['column'] = [];

        $claim_payload['filter'] = [];

        $claim_payload['filter']['id'] = $id;
        $claim_payload['filter']['status'] = 1;

        $claim_payload['sort'] = [];

        $claim = [];

        $claim = $this->Claim_m->get_claim(
            $claim_payload['page'],
            $claim_payload['column'],
            $claim_payload['filter'],
            $claim_payload['sort']
        );

        if ($id) {
            $claim = @$claim ? $claim[0] : [];
        }

        $data = $claim;

        if (!$data) {
            $output = $this->rscode->output('0001', $data, $pagination, $errors, $links);

            $this->response($output->response, $output->code);
        }

        # Pagination
        if (!$id) {

            $claim_count_filtered = $this->Claim_m->count_claim($claim_payload['filter']);
            $claim_count_all = $this->Claim_m->count_claim();

            $pagination = [
                'page' => (int) $page,
                'limit' => (int) $limit,
                'filtered' => (int) $claim_count_filtered,
                'total_page' => (int) ceil($claim_count_filtered / $limit),
                'total_record' => (int) $claim_count_all        
            ];
        }
        
        # Output
        $output = $this->rscode->output('0000', $data, $pagination, $errors, $links);

        $this->response($output->response, $output->code);
    }

    public function index_post()
    {
        
        $this->auth();
        
        $data = [];
        $pagination = [];
        $errors = [];
        $links = [];
        $output = [];

        $police_number = $this->post('police_number');
        $machine_number = $this->post('machine_number');
        $chassis_number = $this->post('chassis_number');
        $vehicle_brand = $this->post('vehicle_brand');
        $vehicle_model = $this->post('vehicle_model');
        $vehicle_year = $this->post('vehicle_year');

        $insured_police_number = $this->post('insured_police_number');
        $insured_name = $this->post('insured_name');

        $reporting_name = $this->post('reporting_name');
        $reporting_phone_number = $this->post('reporting_phone_number');
        $reporting_email = $this->post('reporting_email');
        $rider_name = $this->post('rider_name');
        $rider_phone_number = $this->post('rider_phone_number');
        $sim_expired_date = $this->post('sim_expired_date');

        $event_date = $this->post('event_date');
        $event_type = $this->post('event_type');
        $event_location = $this->post('event_location');
        $event_chronology = $this->post('event_chronology');

        $front_image = $this->post('front_image');
        $right_image = $this->post('right_image');

        $validation['data'] = $this->post();
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
                'field' => 'vehicle_model',
                'label' => 'Vehicle Model',
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

        $links = [
            [
                'href' => $_SERVER['QUERY_STRING'] ? '/' . uri_string() . '?' . $_SERVER['QUERY_STRING'] : '/' . uri_string(),
                'method' => strtoupper($this->_detect_method()),
                'rel' => 'self',
            ],
            [
                'href' => '/v1/report',
                'method' => 'GET',
                'rel' => 'report',
            ]
        ];

        $this->form_validation->set_data($validation['data']);
        $this->form_validation->set_rules($validation['rules']);

        $errors = [];
        $output = new stdClass();

        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();

            $output = $this->rscode->output('1007', $data, $pagination, $errors, $links);

            $this->response($output->response, $output->code);
        }

        $this->db->trans_start();
        # vehicle_unit
        $vehicle_unit_id = gen_id();

        $vehicle_unit_data = [
            'id' => $vehicle_unit_id,
            'police_number' => $police_number,
            'machine_number' => $machine_number,
            'chassis_number' => $chassis_number,
            'merk_id' => $vehicle_brand,
            'vehicle_model_id' => $vehicle_model,
            'year' => $vehicle_year,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $insert_vehicle_unit = $this->Vehicle_unit_m->insert_vehicle_unit($vehicle_unit_data);

        if (!$insert_vehicle_unit) {

            $errors = ['Failed insert data Vehicle Unit'];
            $output = $this->rscode->output('1007', $data, $pagination, $errors, $links);
            $this->response($output->response, $output->code);
        }

        # insured
        $insured_id = gen_id();

        $insured_data = [
            'id' => $insured_id,
            'police_number' => $insured_police_number,
            'name' => $insured_name,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $insert_insured = $this->Insured_m->insert_insured($insured_data);

        if (!$insert_insured) {

            $errors = ['Failed insert data Insured'];
            $output = $this->rscode->output('1007', $data, $pagination, $errors, $links);
            $this->response($output->response, $output->code);
        }

        # customer
        $customer_id = gen_id();

        $customer_data = [
            'id' => $customer_id,
            'first_name' => $reporting_name,
            'last_name' => null,
            'email' => $reporting_email,
            'phone' => $reporting_phone_number,
            'nik' => null,
            'gender' => null,
            'rider_name' => $rider_name,
            'rider_phone' => $rider_phone_number,
            'sim_expired_date' => $sim_expired_date,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $insert_customer = $this->Customer_m->insert_customer($customer_data);

        if (!$insert_customer) {

            $errors = ['Failed insert data Customer'];
            $output = $this->rscode->output('1007', $data, $pagination, $errors, $links);
            $this->response($output->response, $output->code);
        }

        # event
        $event_id = gen_id();

        $event_data = [
            'id' => $event_id,
            'event_type_id' => $event_type,
            'city_id' => $event_location,
            'description' => $event_chronology,
            'event_date' => $event_date,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $insert_event = $this->Event_m->insert_event($event_data);

        if (!$insert_event) {

            $errors = ['Failed insert data Event'];
            $output = $this->rscode->output('1007', $data, $pagination, $errors, $links);
            $this->response($output->response, $output->code);
        }

        # claim
        $claim_id = gen_id();

        $claim_data = [
            'id' => $claim_id,
            'vehicle_unit_id' => $vehicle_unit_id,
            'insured_id' => $insured_id,
            'customer_id' => $customer_id,
            'event_id' => $event_id,
            'surveyor_id' => null,
            'claim_status_id' => 1,
            'created_by' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $insert_claim = $this->Claim_m->insert_claim($claim_data);

        if (!$insert_claim) {

            $errors = ['Failed insert data Claim'];
            $output = $this->rscode->output('1007', $data, $pagination, $errors, $links);
            $this->response($output->response, $output->code);
        }

        # claim_attachment

        $this->db->trans_complete();

        $imagePath = 'assets/20230809_173735.jpg';
        $processImage = image_coordinate($imagePath);

        $data = [];

        $output = $this->rscode->output('1006', $data, $pagination, $errors, $links);

        $this->response($output->response, $output->code);
    }
}
