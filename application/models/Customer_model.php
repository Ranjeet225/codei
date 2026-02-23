<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {
    
    // --- QUERY BUILDER SHOWCASE ---

    public function get_customers_count($search = '') {
        $this->db->where('role', 'customer');
        if (!empty($search)) {
            // Grouping allows OR statements without breaking the initial WHERE role='customer'
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('phone', $search);
            $this->db->group_end();
        }
        return $this->db->count_all_results('users');
    }

    public function get_paginated_customers($limit, $start, $search = '') {
        $this->db->where('role', 'customer');
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('phone', $search);
            $this->db->group_end();
        }
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $start);
        
        $query = $this->db->get('users');
        return $query->result();
    }

    public function insert_customer($data) {
        return $this->db->insert('users', $data);
    }

    public function get_customer($id) {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function update_customer($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function delete_customer($id) {
        return $this->db->delete('users', ['id' => $id]);
    }
}
