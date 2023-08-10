<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/core/Web_Controller.php';

class Request extends Web_Controller {
	
	public function __construct()
    {
        parent::__construct();

        if (!$this->is_login) {
            redirect('login');
        }
        
    }
    
    public function index()
    {
        $data = [];

        $data['is_login'] = $this->is_login;
        $data['userdata'] = $this->userdata;

        $data['breadcrumb'] = [
            [
                'name' => 'Request',
                'href' => null
            ]
        ];

        $data['page_title'] = 'Request';
        $data['menu_active'] = 'request';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('modules/request/main', $data);
        $this->load->view('templates/footer', $data);
    }
}
