<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Claim_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_claim(
        array $page = [],
        array $column = [],
        array $filter = [],
        array $sort = []
    ) {
        // Set Default Value

        if (!@$column) {
            $column = [
                'claim.id',
                'claim.claim_status_id',
                'vehicle_unit.police_number',
                'vehicle_unit.machine_number',
                'vehicle_unit.chassis_number',
                'vehicle_unit.merk_id',
                'vehicle_unit.vehicle_variant_id',
                'event.event_type_id',
                'event_type.name event_type_name',
                'event.description',
                'customer.first_name customer_first_name',
                'customer.last_name customer_last_name',
                'customer.email customer_email',
                'claim.created_at'
            ];
        }

        if (!$sort) {
            $sort = ['claim.created_at' => 'desc'];
        }

        $this->db->select($column);

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('claim.id', $filter['id']);
                } else {
                    $this->db->where('claim.id', $filter['id']);
                }
            }

            if (@$filter['created_at_min']) {
                $this->db->where('claim.created_at <', $filter['created_at_min']);
            }

            if (@$filter['created_at_max']) {
                $this->db->where('claim.created_at >', $filter['created_at_max']);
            }

            if (@$filter['status']) {
                if (is_array($filter['status'])) {
                    $this->db->where_in('claim.claim_status_id', $filter['status']);
                } else {
                    $this->db->where('claim.claim_status_id', $filter['status']);
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

        // join table
        $this->db->join('vehicle_unit', 'vehicle_unit.id = claim.vehicle_unit_id');
        $this->db->join('event', 'event.id = claim.event_id');
        $this->db->join('customer', 'customer.id = claim.customer_id');
        $this->db->join('event_type', 'event_type.id = `event`.event_type_id');

        $query = $this->db->get('claim');

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

    public function count_claim(array $filter = [])
    {
        $this->db->select('COUNT(claim.id) count');

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('claim.id', $filter['id']);
                } else {
                    $this->db->where('claim.id', $filter['id']);
                }
            }

            if (@$filter['created_at_min']) {
                $this->db->where('claim.created_at <', $filter['created_at_min']);
            }

            if (@$filter['created_at_max']) {
                $this->db->where('claim.created_at >', $filter['created_at_max']);
            }

            if (@$filter['status']) {
                if (is_array($filter['status'])) {
                    $this->db->where_in('claim.claim_status_id', $filter['status']);
                } else {
                    $this->db->where('claim.claim_status_id', $filter['status']);
                }
            }
        }

        $query = $this->db->get('claim');

        $data = $query->row_array();

        $output = (int) $data['count'];

        return $output;
    }

    public function insert_claim(array $data_insert = [])
    {
        if (!@$data_insert) {
            return false;
        }

        $this->db->insert('claim', $data_insert);

        return $this->db->trans_status();
    }

    public function update_claim(
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
                    $this->db->where_in('claim.id', $filter['id']);
                } else {
                    $this->db->where('claim.id', $filter['id']);
                }
            }
        }

        $this->db->limit(1);
        $this->db->update('claim', $data_update);

        return $this->db->affected_rows();
    }

    public function delete_claim(array $filter = [])
    {
        if (!@$filter['id']) {
            return false;
        }

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('claim.id', $filter['id']);
                } else {
                    $this->db->where('claim.id', $filter['id']);
                }
            }
        }

        $this->db->limit(1);
        $this->db->delete('claim');

        return $this->db->affected_rows();
    }
}
