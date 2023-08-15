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

    public function get_vehicle_brand(
        array $page = [],
        array $column = [],
        array $filter = [],
        array $sort = []
    ) {
        // Set Default Value

        if (!@$column) {
            $column = ['car_make.*'];
        }

        if (!$sort) {
            $sort = ['car_make.name' => 'asc'];
        }

        $this->db->select($column);

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('car_make.id_car_make', $filter['id']);
                } else {
                    $this->db->where('car_make.id_car_make', $filter['id']);
                }
            }

            if (@$filter['type']) {
                if (is_array($filter['type'])) {
                    $this->db->where_in('car_make.id_car_type', $filter['type']);
                } else {
                    $this->db->where('car_make.id_car_type', $filter['type']);
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

        $query = $this->db->get('car_make');

        $data = $query->result_array();

        $output = [];

        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $row = $value;

                if (@$row['id_car_make']) {
                    $row['id'] = (int) $row['id_car_make'];
                    unset($row['id_car_make']);
                }

                if (@$row['id_car_type']) {
                    $row['car_type_id'] = (int) $row['id_car_type'];
                    unset($row['id_car_type']);
                }

                if (@$row['date_create']) {
                    $row['created_at'] = date('c', $row['date_create']);
                    unset($row['date_create']);
                }

                if (@$row['date_update']) {
                    $row['updated_at'] = date('c', $row['date_update']);
                    unset($row['date_update']);
                }

                $output[$key] = $row;
            }
        }

        return $output;
    }

    public function count_vehicle_brand(array $filter = [])
    {
        $this->db->select('COUNT(car_make.id_car_make) count');

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('car_make.id', $filter['id']);
                } else {
                    $this->db->where('car_make.id', $filter['id']);
                }
            }

            if (@$filter['type']) {
                if (is_array($filter['type'])) {
                    $this->db->where_in('car_make.id_car_type', $filter['type']);
                } else {
                    $this->db->where('car_make.id_car_type', $filter['type']);
                }
            }
        }
        
        $query = $this->db->get('car_make');

        $data = $query->row_array();

        $output = (int) $data['count'];

        return $output;
    }

    public function get_vehicle_model(
        array $page = [],
        array $column = [],
        array $filter = [],
        array $sort = []
    ) {
        // Set Default Value

        if (!@$column) {
            $column = ['car_model.*'];
        }

        if (!$sort) {
            $sort = ['car_model.name' => 'asc'];
        }

        $this->db->select($column);

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('car_model.id_car_model', $filter['id']);
                } else {
                    $this->db->where('car_model.id_car_model', $filter['id']);
                }
            }

            if (@$filter['brand_id']) {
                if (is_array($filter['brand_id'])) {
                    $this->db->where_in('car_model.id_car_make', $filter['brand_id']);
                } else {
                    $this->db->where('car_model.id_car_make', $filter['brand_id']);
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

        $query = $this->db->get('car_model');

        $data = $query->result_array();

        $output = [];

        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $row = $value;

                if (@$row['id_car_model']) {
                    $row['id'] = (int) $row['id_car_model'];
                    unset($row['id_car_model']);

                }

                if (@$row['id_car_make']) {
                    $row['brand_id'] = (int) $row['id_car_make'];
                    unset($row['id_car_make']);
                }

                if (@$row['id_car_type']) {
                    $row['car_type_id'] = (int) $row['id_car_type'];
                    unset($row['id_car_type']);
                }

                if (@$row['date_create']) {
                    $row['created_at'] = date('c', $row['date_create']);
                    unset($row['date_create']);
                }

                if (@$row['date_update']) {
                    $row['updated_at'] = date('c', $row['date_update']);
                    unset($row['date_update']);
                }

                $output[$key] = $row;
            }
        }

        return $output;
    }

    public function count_vehicle_model(array $filter = [])
    {
        $this->db->select('COUNT(car_model.id_car_model) count');

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('car_model.id_car_model', $filter['id']);
                } else {
                    $this->db->where('car_model.id_car_model', $filter['id']);
                }
            }

            if (@$filter['brand_id']) {
                if (is_array($filter['brand_id'])) {
                    $this->db->where_in('car_model.id_car_make', $filter['brand_id']);
                } else {
                    $this->db->where('car_model.id_car_make', $filter['brand_id']);
                }
            }
        }
        
        $query = $this->db->get('car_model');

        $data = $query->row_array();

        $output = (int) $data['count'];

        return $output;
    }
}
