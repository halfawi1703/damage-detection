<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/core/Web_Controller.php';

class Login extends Web_Controller {
	
	public function index()
    {
        
        $data = [];
        $data['breadcrumb'] = [
            [
                'name' => 'Login',
                'href' => null
            ]
        ];

        $data['redirect_url'] = $this->input->get('redirect_url');

        $this->load->view('templates/header', $data);
        $this->load->view('modules/login/main', $data);
        $this->load->view('templates/footer', $data);
    }
}
