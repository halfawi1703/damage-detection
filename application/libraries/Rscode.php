<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rscode
{
    public function __construct()
    {
        $this->_CI =& get_instance();
    }

    private function _code($code)
    {
        // Format Response Code [status, message, http_response_code]
        $response_code = [];

        // General
        $response_code['0000'] = ['success', $this->_CI->lang->line('message_data_available'), 200];
        $response_code['0001'] = ['success', $this->_CI->lang->line('message_empty_result'), 200];
        $response_code['0002'] = ['error', $this->_CI->lang->line('message_process_failed'), 400];

        // Auth
        $response_code['1000'] = ['success', $this->_CI->lang->line('message_login_success'), 200];
        $response_code['1001'] = ['error', $this->_CI->lang->line('message_login_failed'), 400];
        $response_code['1002'] = ['error', $this->_CI->lang->line('message_account_not_registered'), 422];
        $response_code['1003'] = ['error', $this->_CI->lang->line('message_invalid_login'), 422];
        $response_code['1004'] = ['error', $this->_CI->lang->line('message_token_expired'), 401];
        $response_code['1005'] = ['error', $this->_CI->lang->line('message_token_invalid'), 401];
        $response_code['1006'] = ['success', $this->_CI->lang->line('message_process_success'), 201];
        $response_code['1007'] = ['error', $this->_CI->lang->line('message_process_failed'), 400];
        $response_code['1008'] = ['error', $this->_CI->lang->line('message_process_failed'), 422];
        $response_code['1009'] = ['success', $this->_CI->lang->line('message_register_success'), 200];
        $response_code['1010'] = ['error', $this->_CI->lang->line('message_register_failed'), 400];
        $response_code['1011'] = ['success', $this->_CI->lang->line('message_update_profile_success'), 200];
        $response_code['1012'] = ['error', $this->_CI->lang->line('message_update_profile_failed'), 400];

        $response_code['1018'] = ['error', $this->_CI->lang->line('message_email_already_registered'), 422];
        $response_code['1019'] = ['success', $this->_CI->lang->line('message_email_available'), 200];

        // User Address
        $response_code['3000'] = ['success', $this->_CI->lang->line('message_add_address_success'), 200];
        $response_code['3001'] = ['error', $this->_CI->lang->line('message_add_address_failed'), 400];
        $response_code['3002'] = ['success', $this->_CI->lang->line('message_update_address_success'), 200];
        $response_code['3003'] = ['error', $this->_CI->lang->line('message_update_address_failed'), 400];

        return $response_code[$code];
    }

    public function _hyperlink($links = [])
    {
        $output = [];

        foreach ($links as $key => $value) {
            $output[] = (object) $value;
        }

        return $output;
    }

    public function output($code = '', $data = null, $pagination = null, $errors = null, $links = null)
    {
        $response_code = $this->_code($code);

        $output = new stdClass();

        $output->response = new stdClass();

        $output->response->status = $response_code[0];
        $output->response->message = $response_code[1];
        $output->response->timestamp = date('c');
        
        if ($response_code[0] == 'error') {
            $output->response->error = (object)[
                'code' => $code,
                'reason' => $errors
            ];
        }

        $output->response->data = $data;

        if ($pagination) {
            $output->response->pagination = $pagination;
        }

        if ($links) {
            $hyperlink = $this->_hyperlink($links);

            $output->response->links = $hyperlink;
        }

        $output->code = $response_code[2];

        return $output;
    }
}
