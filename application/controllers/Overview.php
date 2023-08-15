<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/core/Web_Controller.php';

class Overview extends Web_Controller {
	
	public function __construct()
    {
        parent::__construct();

        $this->auth();
    }
    
    public function index()
    {
        $data = [];

        $data['breadcrumb'] = [
            [
                'name' => 'Overview',
                'href' => null
            ]
        ];

        $data['page_title'] = 'Overview';
        $data['menu_active'] = 'overview';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/menu', $data);
        $this->load->view('modules/overview/main', $data);
        $this->load->view('templates/footer', $data);
    }
}
