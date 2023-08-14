<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Insured_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_insured(
        array $page = [],
        array $column = [],
        array $filter = [],
        array $sort = []
    ) {
        // Set Default Value

        if (!@$column) {
            $column = ['insured.*'];
        }

        if (!$sort) {
            $sort = ['insured.created_at' => 'desc'];
        }

        $this->db->select($column);

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('insured.id', $filter['id']);
                } else {
                    $this->db->where('insured.id', $filter['id']);
                }
            }

            if (@$filter['created_at_min']) {
                $this->db->where('insured.created_at <', $filter['created_at_min']);
            }

            if (@$filter['created_at_max']) {
                $this->db->where('insured.created_at >', $filter['created_at_max']);
            }

            if (@$filter['status']) {
                if (is_array($filter['status'])) {
                    $this->db->where_in('insured.status', $filter['status']);
                } else {
                    $this->db->where('insured.status', $filter['status']);
                }
            }
        }

        if (@$sort) {
            foreach ($sort as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }

        if (@$page) {
            $this->db->limit($page['limit'], $page['offset']);
        }

        $query = $this->db->get('insured');

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

    public function count_insured(array $filter = [])
    {
        $this->db->select('COUNT(insured.id) count');

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('insured.id', $filter['id']);
                } else {
                    $this->db->where('insured.id', $filter['id']);
                }
            }

            if (@$filter['created_at_min']) {
                $this->db->where('insured.created_at <', $filter['created_at_min']);
            }

            if (@$filter['created_at_max']) {
                $this->db->where('insured.created_at >', $filter['created_at_max']);
            }

            if (@$filter['status']) {
                if (is_array($filter['status'])) {
                    $this->db->where_in('insured.status', $filter['status']);
                } else {
                    $this->db->where('insured.status', $filter['status']);
                }
            }
        }
        
        $query = $this->db->get('insured');

        $data = $query->row_array();

        $output = (int) $data['count'];

        return $output;
    }

    public function insert_insured(array $data_insert = [])
    {
        if (!@$data_insert) {
            return false;
        }

        $this->db->insert('insured', $data_insert);

        return $this->db->trans_status();
    }

    public function update_insured(
        array $data_update = [],
        array $filter = []
    ) {
        if (!@$data_update) {
            return false;
        }

        if (!@$filter['id']) {
            return false;
        }

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('insured.id', $filter['id']);
                } else {
                    $this->db->where('insured.id', $filter['id']);
                }
            }
        }

        $this->db->limit(1);
        $this->db->update('insured', $data_update);

        return $this->db->affected_rows();
    }

    public function delete_insured(array $filter = [])
    {
        if (!@$filter['id']) {
            return false;
        }

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('insured.id', $filter['id']);
                } else {
                    $this->db->where('insured.id', $filter['id']);
                }
            }
        }

        $this->db->limit(1);
        $this->db->delete('insured');

        return $this->db->affected_rows();
    }
}
