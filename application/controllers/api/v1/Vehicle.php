<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vehicle extends PSI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Vehicle_unit_m');
    }

    public function brand_get()
    {
        $page = $this->get('page') ?: 1;
        $limit = $this->get('limit') ?: 10;
        $id = $this->get('id');

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
                'href' => '/v1/vehicle',
                'method' => 'GET',
                'rel' => 'vehicle',
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
        $vehicle_brnad_payload['page'] = [];

        $vehicle_brnad_payload['page'] = [
            'offset' => $offset,
            'limit' => $limit
        ];

        $vehicle_brnad_payload['column'] = [];

        $vehicle_brnad_payload['filter'] = [];

        $vehicle_brnad_payload['filter']['id'] = $id;

        $vehicle_brnad_payload['sort'] = [];

        $vehicle_brnad = [];

        $vehicle_brnad = $this->Vehicle_unit_m->get_vehicle_brand(
            $vehicle_brnad_payload['page'],
            $vehicle_brnad_payload['column'],
            $vehicle_brnad_payload['filter'],
            $vehicle_brnad_payload['sort']
        );

        if ($id) {
            $vehicle_brnad = @$vehicle_brnad ? $vehicle_brnad[0] : [];
        }

        $data = $vehicle_brnad;

        if (!$data) {
            $output = $this->rscode->output('0001', $data, $pagination, $errors, $links);

            $this->response($output->response, $output->code);
        }

        # Pagination
        if (!$id) {

            $vehicle_brnad_count_filtered = $this->Vehicle_unit_m->count_vehicle_brand($vehicle_brnad_payload['filter']);
            $vehicle_brnad_count_all = $this->Vehicle_unit_m->count_vehicle_brand();

            $pagination = [
                'page' => (int) $page,
                'limit' => (int) $limit,
                'filtered' => (int) $vehicle_brnad_count_filtered,
                'total_page' => (int) ceil($vehicle_brnad_count_filtered / $limit),
                'total_record' => (int) $vehicle_brnad_count_all        
            ];
        }
        
        # Output
        $output = $this->rscode->output('0000', $data, $pagination, $errors, $links);

        $this->response($output->response, $output->code);
    }

    public function model_get()
    {
        $page = $this->get('page') ?: 1;
        $limit = $this->get('limit') ?: 10;
        $id = $this->get('id');
        $brand_id = $this->get('brand_id');

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
                'href' => '/v1/vehicle',
                'method' => 'GET',
                'rel' => 'vehicle',
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
        $vehicle_model_payload['page'] = [];

        $vehicle_model_payload['page'] = [
            'offset' => $offset,
            'limit' => $limit
        ];

        $vehicle_model_payload['column'] = [];

        $vehicle_model_payload['filter'] = [];

        $vehicle_model_payload['filter']['id'] = $id;
        $vehicle_model_payload['filter']['brand_id'] = $brand_id;

        $vehicle_model_payload['sort'] = [];

        $vehicle_model = [];

        $vehicle_model = $this->Vehicle_unit_m->get_vehicle_model(
            $vehicle_model_payload['page'],
            $vehicle_model_payload['column'],
            $vehicle_model_payload['filter'],
            $vehicle_model_payload['sort']
        );

        if ($id) {
            $vehicle_model = @$vehicle_model ? $vehicle_model[0] : [];
        }

        $data = $vehicle_model;

        if (!$data) {
            $output = $this->rscode->output('0001', $data, $pagination, $errors, $links);

            $this->response($output->response, $output->code);
        }

        # Pagination
        if (!$id) {

            $vehicle_model_count_filtered = $this->Vehicle_unit_m->count_vehicle_model($vehicle_model_payload['filter']);
            $vehicle_model_count_all = $this->Vehicle_unit_m->count_vehicle_model();

            $pagination = [
                'page' => (int) $page,
                'limit' => (int) $limit,
                'filtered' => (int) $vehicle_model_count_filtered,
                'total_page' => (int) ceil($vehicle_model_count_filtered / $limit),
                'total_record' => (int) $vehicle_model_count_all        
            ];
        }
        
        # Output
        $output = $this->rscode->output('0000', $data, $pagination, $errors, $links);

        $this->response($output->response, $output->code);
    }
}
