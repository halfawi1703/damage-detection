<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_session_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_session(
        Array $page = [], 
        Array $column = [],
        Array $filter = [],
        Array $sort = []
    ) {
        // Set Default Value

        if (!@$column) {
            $column = ['user_session_log.*'];
        }

        if (!@$sort) {
            $sort = ['user_session_log.created_at' => 'desc'];
        }

        $this->db->select($column);

        if (@$filter['id']) {
            if (is_array($filter['id'])) {
                $this->db->where_in('user_session_log.id', $filter['id']);
            } else {
                $this->db->where('user_session_log.id', $filter['id']);
            }
        }

        if (@$filter['user_id']) {
            if (is_array($filter['user_id'])) {
                $this->db->where_in('user_session_log.user_id', $filter['user_id']);
            } else {
                $this->db->where('user_session_log.user_id', $filter['user_id']);
            }
        }

        if (@$filter['session_id']) {
            if (is_array($filter['session_id'])) {
                $this->db->where_in('user_session_log.session_id', $filter['session_id']);
            } else {
                $this->db->where('user_session_log.session_id', $filter['session_id']);
            }
        }

        if (@$filter['access_token']) {
            if (is_array($filter['access_token'])) {
                $this->db->where_in('user_session_log.access_token', $filter['access_token']);
            } else {
                $this->db->where('user_session_log.access_token', $filter['access_token']);
            }
        }

        if (@$filter['refresh_token']) {
            if (is_array($filter['refresh_token'])) {
                $this->db->where_in('user_session_log.refresh_token', $filter['refresh_token']);
            } else {
                $this->db->where('user_session_log.refresh_token', $filter['refresh_token']);
            }
        }

        if (@$filter['status']) {
            if (is_array($filter['refresh_token'])) {
                $this->db->where_in('user_session_log.status', $filter['refresh_token']);
            } else {
                $this->db->where('user_session_log.status', $filter['refresh_token']);
            }
        }

        if ($sort) {
            foreach ($sort as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }

        if (@$sort) {
            foreach ($sort as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }

        if (@$page) {
            $this->db->limit($page['limit'], $page['page']);
        }

        $query = $this->db->get('user_session_log');

        $data = $query->result_array();

        $output = [];

        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $row = $value;

                $output[$key] = $row;
            }
        }

        return $output;
    }

    public function insert_session(Array $data_insert = [])
    {
        if (!@$data_insert) {
            return false;
        }
        
        $this->db->insert('user_session_log', $data_insert);

        return $this->db->trans_status();
    }

    public function update_session(
        Array $data_update = [], 
        Array $filter = []
    ) {
        if (!@$data_update) {
            return false;
        }

        if (!@$filter['user_id']) {
            return false;
        }

        if (!@$filter['session_id']) {
            return false;
        }

        if (@$filter) {
            if (@$filter['user_id']) {
                if (is_array($filter['user_id'])) {
                    $this->db->where_in('user_session_log.user_id', $filter['user_id']);
                } else {
                    $this->db->where('user_session_log.user_id', $filter['user_id']);
                }
            }

            if (@$filter['session_id']) {
                if (is_array($filter['session_id'])) {
                    $this->db->where_in('user_session_log.session_id', $filter['session_id']);
                } else {
                    $this->db->where('user_session_log.session_id', $filter['session_id']);
                }
            }
        }

        $this->db->limit(1);
        $this->db->update('user_session_log', $data_update);

        return $this->db->affected_rows();
    }

    public function delete_session(Array $filter = []) 
    {
        if (!@$filter['id']) {
            return false;
        }

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('user_session_log.id', $filter['id']);
                } else {
                    $this->db->where('user_session_log.id', $filter['id']);
                }
            }
        }

        $this->db->limit(1);
        $this->db->delete('user_session_log');

        return $this->db->affected_rows();
    }

}
