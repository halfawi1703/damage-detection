<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_user(
        array $page = [],
        array $column = [],
        array $filter = [],
        array $sort = []
    ) {
        // Set Default Value

        if (!@$column) {
            $column = ['user.*'];
        }

        if (!$sort) {
            $sort = ['user.created_at' => 'desc'];
        }

        $this->db->select($column);

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('user.id', $filter['id']);
                } else {
                    $this->db->where('user.id', $filter['id']);
                }
            }

            if (@$filter['email']) {
                if (is_array($filter['email'])) {
                    $this->db->where_in('user.email', $filter['email']);
                } else {
                    $this->db->where('user.email', $filter['email']);
                }
            }

            if (@$filter['phone']) {
                if (is_array($filter['phone'])) {
                    $this->db->where_in('user.phone', $filter['phone']);
                } else {
                    $this->db->where('user.phone', $filter['phone']);
                }
            }

            if (@$filter['nik']) {
                if (is_array($filter['nik'])) {
                    $this->db->where_in('user.nik', $filter['nik']);
                } else {
                    $this->db->where('user.nik', $filter['nik']);
                }
            }

            if (@$filter['created_at_min']) {
                $this->db->where('user.created_at <', $filter['created_at_min']);
            }

            if (@$filter['created_at_max']) {
                $this->db->where('user.created_at >', $filter['created_at_max']);
            }

            if (@$filter['status']) {
                if (is_array($filter['status'])) {
                    $this->db->where_in('user.status', $filter['status']);
                } else {
                    $this->db->where('user.status', $filter['status']);
                }
            }

            if (@$filter['role_id']) {
                if (is_array($filter['role_id'])) {
                    $this->db->where_in('user_role.role_id', $filter['role_id']);
                } else {
                    $this->db->where('user_role.role_id', $filter['role_id']);
                }
            }

            if (@$filter['keyword']) {

                $this->db->group_start();

                $this->db->like('user.first_name', $filter['keyword']);
                $this->db->or_like('user.last_name', $filter['keyword']);
                $this->db->or_like('user.email', $filter['keyword']);
                $this->db->or_like('user.phone', $filter['keyword']);

                $this->db->group_end();
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

        $this->db->join('user_role', 'user_role.user_id = user.id', 'left');

        $query = $this->db->get('user');

        $data = $query->result_array();

        $output = [];

        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $row = $value;

                if (!in_array('user.password', $column)) {
                    unset($row['password']);
                }

                if (@$row['join_date']) {
                    $row['join_date'] = date('d-m-Y', strtotime($row['join_date']));
                }

                if (@$row['dob']) {
                    $row['dob'] = date('d-m-Y', strtotime($row['dob']));
                }

                $output[$key] = $row;
            }
        }

        return $output;
    }

    public function get_user_role(
        array $page = [],
        array $column = [],
        array $filter = [],
        array $sort = []
    ) {

        if (!$column) {
            $column = ['role.id', 'role.name', 'role.description', 'user_role.created_at', 'user_role.updated_at'];
        }

        if (!$sort) {
            $sort = ['user_role.created_at' => 'desc'];
        }

        $this->db->select($column);

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('user_role.id', $filter['id']);
                } else {
                    $this->db->where('user_role.id', $filter['id']);
                }
            }

            if (@$filter['user_id']) {
                if (is_array($filter['user_id'])) {
                    $this->db->where_in('user_role.user_id', $filter['user_id']);
                } else {
                    $this->db->where('user_role.user_id', $filter['user_id']);
                }
            }

            if (@$filter['branch_id']) {
                if (is_array($filter['branch_id'])) {
                    $this->db->where_in('user_role.branch_id', $filter['branch_id']);
                } else {
                    $this->db->where('user_role.branch_id', $filter['branch_id']);
                }
            }

            if (@$filter['status']) {
                if (is_array($filter['status'])) {
                    $this->db->where_in('user_role.status', $filter['status']);
                } else {
                    $this->db->where('user_role.status', $filter['status']);
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

        $this->db->join('role', 'role.id = user_role.role_id');

        $query = $this->db->get('user_role');

        $data = $query->result_array();

        $output = [];

        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $row = $value;

                if (!in_array('user.password', $column)) {
                    unset($row['password']);
                }

                $output[$key] = $row;
            }
        }

        return $output;
    }

    public function count_user(array $filter = [])
    {
        $this->db->select('COUNT(user.id) count');

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('user.id', $filter['id']);
                } else {
                    $this->db->where('user.id', $filter['id']);
                }
            }

            if (@$filter['email']) {
                if (is_array($filter['email'])) {
                    $this->db->where_in('user.email', $filter['email']);
                } else {
                    $this->db->where('user.email', $filter['email']);
                }
            }

            if (@$filter['phone']) {
                if (is_array($filter['phone'])) {
                    $this->db->where_in('user.phone', $filter['phone']);
                } else {
                    $this->db->where('user.phone', $filter['phone']);
                }
            }

            if (@$filter['nik']) {
                if (is_array($filter['nik'])) {
                    $this->db->where_in('user.nik', $filter['nik']);
                } else {
                    $this->db->where('user.nik', $filter['nik']);
                }
            }
            
            if (@$filter['created_at_min']) {
                $this->db->where('user.created_at <', $filter['created_at_min']);
            }

            if (@$filter['created_at_max']) {
                $this->db->where('user.created_at >', $filter['created_at_max']);
            }

            if (@$filter['status']) {
                if (is_array($filter['status'])) {
                    $this->db->where_in('user.status', $filter['status']);
                } else {
                    $this->db->where('user.status', $filter['status']);
                }
            }

            if (@$filter['role_id']) {
                if (is_array($filter['role_id'])) {
                    $this->db->where_in('user_role.role_id', $filter['role_id']);
                } else {
                    $this->db->where('user_role.role_id', $filter['role_id']);
                }
            }

            if (@$filter['keyword']) {

                $this->db->group_start();

                $this->db->like('user.first_name', $filter['keyword']);
                $this->db->or_like('user.last_name', $filter['keyword']);
                $this->db->or_like('user.email', $filter['keyword']);
                $this->db->or_like('user.phone', $filter['keyword']);

                $this->db->group_end();
            }
        }

        $this->db->join('user_role', 'user_role.user_id = user.id', 'left');

        $query = $this->db->get('user');

        $data = $query->row_array();

        $output = (int) $data['count'];

        return $output;
    }

    public function auth($email, $hash_password = false)
    {
        $this->db->where('user.email', $email);

        if ($hash_password) {
            $this->db->where('user.password', $hash_password);
        }

        $this->db->where('status', 1);

        $query = $this->db->get('user', 1);

        $data = $query->num_rows();

        $output = ($data > 0) ? true : false;

        return $output;
    }

    public function insert_user(array $data_insert = [])
    {
        if (!@$data_insert) {
            return false;
        }

        $this->db->insert('user', $data_insert);

        return $this->db->trans_status();
    }

    public function update_user(
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
                    $this->db->where_in('user.id', $filter['id']);
                } else {
                    $this->db->where('user.id', $filter['id']);
                }
            }
        }

        $this->db->limit(1);
        $this->db->update('user', $data_update);

        return $this->db->affected_rows();
    }

    public function delete_user(array $filter = [])
    {
        if (!@$filter['id']) {
            return false;
        }

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('user.id', $filter['id']);
                } else {
                    $this->db->where('user.id', $filter['id']);
                }
            }
        }

        $this->db->limit(1);
        $this->db->delete('user');

        return $this->db->affected_rows();
    }

    public function insert_user_role(array $data_insert = [])
    {
        if (!@$data_insert) {
            return false;
        }

        $this->db->insert('user_role', $data_insert);

        return $this->db->trans_status();
    }

    public function update_user_role(
        array $data_update = [],
        array $filter = []
    ) {
        if (!@$data_update) {
            return false;
        }

        if (!@$filter['id'] && !@$filter['user_id']) {
            return false;
        }

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('user_role.id', $filter['id']);
                } else {
                    $this->db->where('user_role.id', $filter['id']);
                }
            }

            if (@$filter['user_id']) {
                if (is_array($filter['user_id'])) {
                    $this->db->where_in('user_role.user_id', $filter['user_id']);
                } else {
                    $this->db->where('user_role.user_id', $filter['user_id']);
                }
            }
        }

        $this->db->limit(1);
        $this->db->update('user_role', $data_update);

        return $this->db->affected_rows();
    }

    public function delete_user_role(array $filter = [])
    {
        if (!@$filter['id']) {
            return false;
        }

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('user_role.id', $filter['id']);
                } else {
                    $this->db->where('user_role.id', $filter['id']);
                }
            }
        }

        $this->db->limit(1);
        $this->db->delete('user_role');

        return $this->db->affected_rows();
    }

    public function get_user_file(
        array $page = [],
        array $column = [],
        array $filter = [],
        array $sort = []
    ) {
        // Set Default Value

        if (!@$column) {
            $column = ['*'];
        }

        if (!$sort) {
            $sort = ['user_file.created_at' => 'desc'];
        }

        $this->db->select($column);

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('user_file.id', $filter['id']);
                } else {
                    $this->db->where('user_file.id', $filter['id']);
                }
            }

            if (@$filter['user_id']) {
                if (is_array($filter['user_id'])) {
                    $this->db->where_in('user_file.user_id', $filter['user_id']);
                } else {
                    $this->db->where('user_file.user_id', $filter['user_id']);
                }
            }

            if (@$filter['file_type_id']) {
                if (is_array($filter['file_type_id'])) {
                    $this->db->where_in('user_file.file_type_id', $filter['file_type_id']);
                } else {
                    $this->db->where('user_file.file_type_id', $filter['file_type_id']);
                }
            }
        }

        $this->db->where('user_file.status', 1);

        if (@$sort) {
            foreach ($sort as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }

        if (@$page) {
            $this->db->limit($page['limit'], $page['offset']);
        }

        $query = $this->db->get('user_file');

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


    public function count_user_file(array $filter = [])
    {
        $this->db->select('COUNT(user_file.id) count');

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('user_file.id', $filter['id']);
                } else {
                    $this->db->where('user_file.id', $filter['id']);
                }
            }
        }

        $query = $this->db->get('user_file');

        $data = $query->row_array();

        $output = (int) $data['count'];

        return $output;
    }

    public function insert_user_file(array $data_insert = [])
    {
        if (!@$data_insert) {
            return false;
        }

        $this->db->insert('user_file', $data_insert);

        return $this->db->trans_status();
    }

    public function update_user_file(
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
                    $this->db->where_in('user_file.id', $filter['id']);
                } else {
                    $this->db->where('user_file.id', $filter['id']);
                }
            }
        }

        $this->db->limit(1);
        $this->db->update('user_file', $data_update);

        return $this->db->affected_rows();
    }

    public function delete_user_file(array $filter = [])
    {
        if (!@$filter['id']) {
            return false;
        }

        if (@$filter) {
            if (@$filter['id']) {
                if (is_array($filter['id'])) {
                    $this->db->where_in('user_file.id', $filter['id']);
                } else {
                    $this->db->where('user_file.id', $filter['id']);
                }
            }
        }

        $this->db->limit(1);
        $this->db->delete('user_file');

        return $this->db->affected_rows();
    }
}
