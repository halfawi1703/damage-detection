<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Location extends PSI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Location_m');
    }

    public function city_get()
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
        $city_payload['page'] = [];

        $city_payload['page'] = [
            'offset' => $offset,
            'limit' => $limit
        ];

        $city_payload['column'] = [];

        $city_payload['filter'] = [];

        $city_payload['filter']['id'] = $id;

        $city_payload['sort'] = [];

        $city = [];

        $city = $this->Location_m->get_city(
            $city_payload['page'],
            $city_payload['column'],
            $city_payload['filter'],
            $city_payload['sort']
        );

        if ($id) {
            $city = @$city ? $city[0] : [];
        }

        $data = $city;

        if (!$data) {
            $output = $this->rscode->output('0001', $data, $pagination, $errors, $links);

            $this->response($output->response, $output->code);
        }

        # Pagination
        if (!$id) {

            $city_count_filtered = $this->Location_m->count_city($city_payload['filter']);
            $city_count_all = $this->Location_m->count_city();

            $pagination = [
                'page' => (int) $page,
                'limit' => (int) $limit,
                'filtered' => (int) $city_count_filtered,
                'total_page' => (int) ceil($city_count_filtered / $limit),
                'total_record' => (int) $city_count_all        
            ];
        }
        
        # Output
        $output = $this->rscode->output('0000', $data, $pagination, $errors, $links);

        $this->response($output->response, $output->code);
    }
}
