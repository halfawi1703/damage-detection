<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vehicle_unit_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_vehicle_unit(
        array $page = [],
        array $column = [],
        array $filter = [],
        array $sort = []
    ) {
        // Set Default Value

        if (!@$column) {
            $column = ['vehicle_unit.*'];
        }

        if (!$sort) {
            $sort = ['vehicle_unit.created_at' => 'desc'];
        }

        $this->db->select($column);

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('vehicle_unit.id', $filter['id']);
                } else {
                    $this->db->where('vehicle_unit.id', $filter['id']);
                }
            }

            if (@$filter['created_at_min']) {
                $this->db->where('vehicle_unit.created_at <', $filter['created_at_min']);
            }

            if (@$filter['created_at_max']) {
                $this->db->where('vehicle_unit.created_at >', $filter['created_at_max']);
            }

            if (@$filter['status']) {
                if (is_array($filter['status'])) {
                    $this->db->where_in('vehicle_unit.status', $filter['status']);
                } else {
                    $this->db->where('vehicle_unit.status', $filter['status']);
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

        $query = $this->db->get('vehicle_unit');

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

    public function count_vehicle_unit(array $filter = [])
    {
        $this->db->select('COUNT(vehicle_unit.id) count');

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('vehicle_unit.id', $filter['id']);
                } else {
                    $this->db->where('vehicle_unit.id', $filter['id']);
                }
            }

            if (@$filter['created_at_min']) {
                $this->db->where('vehicle_unit.created_at <', $filter['created_at_min']);
            }

            if (@$filter['created_at_max']) {
                $this->db->where('vehicle_unit.created_at >', $filter['created_at_max']);
            }

            if (@$filter['status']) {
                if (is_array($filter['status'])) {
                    $this->db->where_in('vehicle_unit.status', $filter['status']);
                } else {
                    $this->db->where('vehicle_unit.status', $filter['status']);
                }
            }
        }
        
        $query = $this->db->get('vehicle_unit');

        $data = $query->row_array();

        $output = (int) $data['count'];

        return $output;
    }

    public function insert_vehicle_unit(array $data_insert = [])
    {
        if (!@$data_insert) {
            return false;
        }

        $this->db->insert('vehicle_unit', $data_insert);

        return $this->db->trans_status();
    }

    public function update_vehicle_unit(
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
                    $this->db->where_in('vehicle_unit.id', $filter['id']);
                } else {
                    $this->db->where('vehicle_unit.id', $filter['id']);
                }
            }
        }

        $this->db->limit(1);
        $this->db->update('vehicle_unit', $data_update);

        return $this->db->affected_rows();
    }

    public function delete_vehicle_unit(array $filter = [])
    {
        if (!@$filter['id']) {
            return false;
        }

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('vehicle_unit.id', $filter['id']);
                } else {
                    $this->db->where('vehicle_unit.id', $filter['id']);
                }
            }
        }

        $this->db->limit(1);
        $this->db->delete('vehicle_unit');

        return $this->db->affected_rows();
    }
}
