<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testing extends PSI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index_post()
    {
		$this->auth();
        $id = $this->post('id');

        $validation['data'] = $this->post();
        $validation['rules'] = [
            [
                'field' => 'id',
                'label' => 'ID',
                'rules' => 'trim|required',
            ]
        ];

        $links = [
            [
                'href' => $_SERVER['QUERY_STRING'] ? '/' . uri_string() . '?' . $_SERVER['QUERY_STRING'] : '/' . uri_string(),
                'method' => strtoupper($this->_detect_method()),
                'rel' => 'self',
            ],
            [
                'href' => '/v1/testing',
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

        $data = [];
        $output = $this->rscode->output('1000', $data, $errors, $links);

        $this->response($output->response, $output->code);
    }

}
