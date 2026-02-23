<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Admin_model');
    }

    public function index() {
        $data['kpis'] = $this->Admin_model->get_kpis();
        $data['transactions'] = $this->Admin_model->get_recent_transactions();
        $data['quick_transfers'] = $this->Admin_model->get_quick_transfer_users();

        $this->load->view('admin/header');
        $this->load->view('admin/sidebar');
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/footer');
    }
}
