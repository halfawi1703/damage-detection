<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Location_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_city(
        array $page = [],
        array $column = [],
        array $filter = [],
        array $sort = []
    ) {
        // Set Default Value

        if (!@$column) {
            $column = ['city.*'];
        }

        if (!$sort) {
            $sort = ['city.created_at' => 'desc'];
        }

        $this->db->select($column);

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('city.id', $filter['id']);
                } else {
                    $this->db->where('city.id', $filter['id']);
                }
            }

            if (@$filter['created_at_min']) {
                $this->db->where('city.created_at <', $filter['created_at_min']);
            }

            if (@$filter['created_at_max']) {
                $this->db->where('city.created_at >', $filter['created_at_max']);
            }

            if (@$filter['status']) {
                if (is_array($filter['status'])) {
                    $this->db->where_in('city.status', $filter['status']);
                } else {
                    $this->db->where('city.status', $filter['status']);
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

        $query = $this->db->get('city');

        $data = $query->result_array();

        $output = [];

        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $row = $value;

                if (@$row['id']) {
                    $row['id'] = (int) $row['id'];
                }

                if (@$row['state_id']) {
                    $row['state_id'] = (int) $row['state_id'];
                }

                if (@$row['country_id']) {
                    $row['country_id'] = (int) $row['country_id'];
                }

                if (@$row['lat']) {
                    $row['lat'] = (float) $row['lat'];
                }

                if (@$row['lng']) {
                    $row['lng'] = (float) $row['lng'];
                }

                if (@$row['postal_code']) {
                    $row['postal_code'] = (int) $row['postal_code'];
                }

                $output[$key] = $row;
            }
        }

        return $output;
    }

    public function count_city(array $filter = [])
    {
        $this->db->select('COUNT(city.id) count');

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('city.id', $filter['id']);
                } else {
                    $this->db->where('city.id', $filter['id']);
                }
            }

            if (@$filter['created_at_min']) {
                $this->db->where('city.created_at <', $filter['created_at_min']);
            }

            if (@$filter['created_at_max']) {
                $this->db->where('city.created_at >', $filter['created_at_max']);
            }

            if (@$filter['status']) {
                if (is_array($filter['status'])) {
                    $this->db->where_in('city.status', $filter['status']);
                } else {
                    $this->db->where('city.status', $filter['status']);
                }
            }
        }
        
        $query = $this->db->get('city');

        $data = $query->row_array();

        $output = (int) $data['count'];

        return $output;
    }

    public function insert_city(array $data_insert = [])
    {
        if (!@$data_insert) {
            return false;
        }

        $this->db->insert('city', $data_insert);

        return $this->db->trans_status();
    }

    public function update_city(
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
                    $this->db->where_in('city.id', $filter['id']);
                } else {
                    $this->db->where('city.id', $filter['id']);
                }
            }
        }

        $this->db->limit(1);
        $this->db->update('city', $data_update);

        return $this->db->affected_rows();
    }

    public function delete_city(array $filter = [])
    {
        if (!@$filter['id']) {
            return false;
        }

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('city.id', $filter['id']);
                } else {
                    $this->db->where('city.id', $filter['id']);
                }
            }
        }

        $this->db->limit(1);
        $this->db->delete('city');

        return $this->db->affected_rows();
    }
}
