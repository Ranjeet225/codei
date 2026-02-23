<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->   helper('url');
        $this->load->library('form_validation');
    }   

    public function index() {
        $data['users'] = $this->user_model->get_all();
        $this->load->view('users/index', $data);
    }

    public function create() {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('users/create');
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->user_model->insert($data);
            redirect('users');
        }
    }

    public function edit($id) {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        $data['user'] = $this->user_model->get_by_id($id);

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('users/edit', $data);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email')
            );
            $this->user_model->update($id, $data);
            redirect('users');
        }
    }

    public function delete($id) {
        $this->user_model->delete($id);
        redirect('users');
    }
}