<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends PSI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index_post()
    {
        $this->auth();

        $image_front = $this->post('image_front');

        // $validation['data'] = $this->post();
        // $validation['rules'] = [
        //     [
        //         'field' => 'image_front',
        //         'label' => 'Image Front',
        //         'rules' => 'trim|required',
        //     ]
        // ];

        // $links = [
        //     [
        //         'href' => $_SERVER['QUERY_STRING'] ? '/' . uri_string() . '?' . $_SERVER['QUERY_STRING'] : '/' . uri_string(),
        //         'method' => strtoupper($this->_detect_method()),
        //         'rel' => 'self',
        //     ],
        //     [
        //         'href' => '/v1/report',
        //         'method' => 'GET',
        //         'rel' => 'report',
        //     ]
        // ];

        // $this->form_validation->set_data($validation['data']);
        // $this->form_validation->set_rules($validation['rules']);

        // $errors = [];
        // $output = new stdClass();

        // if ($this->form_validation->run() == false) {
        //     $errors = $this->form_validation->error_array();

        //     $output = $this->rscode->output('1001', null, $errors, $links);

        //     $this->response($output->response, $output->code);
        // }

        $imagePath = 'assets/20230809_173735.jpg';
        $processImage = image_coordinate($imagePath);

        $data = $processImage;
        $output = $this->rscode->output('1000', $data, $errors = [], $links = []);

        $this->response($output->response, $output->code);
    }
}
