<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/core/Web_Controller.php';

class Welcome extends Web_Controller {

	public function __construct()
    {
        parent::__construct();

		# print_r($this->session->all_userdata());
		$now = date('Y-m-d H:i:s');
		$expired = $this->session->userdata('expired');

		if ($now >= $expired) {
			
			redirect('login','refresh');
			
		}

    }
	
	public function index()
	{
		$data = [];
        $data['breadcrumb'] = [
            [
                'name' => 'Dashboard',
                'href' => null
            ]
        ];

        $this->load->view('templates/header', $data);
		$this->load->view('templates/menu', $data);
		$this->load->view('templates/navbar', $data);
		
        $this->load->view('modules/admin/dashboard', $data);
        $this->load->view('templates/footer', $data);
	}
}
