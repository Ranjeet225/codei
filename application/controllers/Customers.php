    <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Customer_model');
        // Profiler gives a great debugging view for learning!
        $this->output->enable_profiler(TRUE); 
    }

    public function index() {
        // --- PAGINATION & SEARCH FEATURE ---
        $search = $this->input->get('q'); // Get search query
        
        $config['base_url'] = base_url('customers/index');
        $config['total_rows'] = $this->Customer_model->get_customers_count($search);
        $config['per_page'] = 5;
        $config['page_query_string'] = TRUE; // use ?per_page=X
        $config['reuse_query_string'] = TRUE; // keeps ?q=search in links

        // Bootstrap 4/5 Pagination Styling Configuration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);
        
        $page = $this->input->get('per_page') ? $this->input->get('per_page') : 0;
        
        // Fetch Data
        $data['customers'] = $this->Customer_model->get_paginated_customers($config['per_page'], $page, $search);
        $data['pagination_links'] = $this->pagination->create_links();
        $data['search'] = $search;

        $this->load->view('admin/header');
        $this->load->view('admin/sidebar');
        $this->load->view('admin/customers/index', $data);
        $this->load->view('admin/footer');
    }

    public function create() {
        // Display the form to create a new customer
        $this->load->view('admin/header');
        $this->load->view('admin/sidebar');
        $this->load->view('admin/customers/create');
        $this->load->view('admin/footer');
    }

    public function store() {
        // --- FORM VALIDATION FEATURE ---
        // Rules array for validation
        $rules = [
            [
                'field' => 'name',
                'label' => 'Full Name',
                'rules' => 'required|min_length[3]|max_length[100]'
            ],
            [
                'field' => 'email',
                'label' => 'Email Address',
                'rules' => 'required|valid_email|is_unique[users.email]' // is_unique checks the DB automatically!
            ],
            [
                'field' => 'phone',
                'label' => 'Phone Number',
                'rules' => 'numeric|min_length[10]|max_length[15]'
            ],
            [
                'field' => 'status',
                'label' => 'Account Status',
                'rules' => 'required|in_list[Active,Inactive]'
            ]
        ];

        $this->form_validation->set_rules($rules);
        $this->form_validation->set_error_delimiters('<div class="error-msg" style="color:red; font-size:12px; margin-top:4px;">', '</div>'); // Format errors

        if ($this->form_validation->run() == FALSE) {
            // Validation Failed -> Reload form (it will show errors and repopulate data using set_value)
            $this->create(); 
        } else {
            // Validation Passed -> Handle Data & File Upload

            // --- FILE UPLOAD FEATURE ---
            $avatar_path = NULL;
            if (!empty($_FILES['avatar']['name'])) {
                $config['upload_path']   = './uploads/avatars/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = 2048; // 2MB
                $config['encrypt_name']  = TRUE; // Randomize file name for security

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('avatar')) {
                    // Upload failed -> Set an error string to the view and reload
                    $data['upload_error'] = $this->upload->display_errors('<div style="color:red">', '</div>');
                    $this->load->view('admin/header');
                    $this->load->view('admin/sidebar');
                    $this->load->view('admin/customers/create', $data);
                    $this->load->view('admin/footer');
                    return; // Stop execution
                } else {
                    // Upload success
                    $upload_data = $this->upload->data();
                    $avatar_path = base_url('uploads/avatars/' . $upload_data['file_name']);
                }
            }

            // Prep Data Array (XSS filtering is ON globally, so $this->input->post is safe)
            $data = [
                'name'     => $this->input->post('name'),
                'email'    => $this->input->post('email'),
                'phone'    => $this->input->post('phone'),
                'status'   => $this->input->post('status'),
                'role'     => 'customer',
                'initials' => strtoupper(substr($this->input->post('name'), 0, 2))
            ];

            if ($avatar_path) {
                $data['avatar'] = $avatar_path;
            }

            // --- DATABASE INSERT FEATURE ---
            if ($this->Customer_model->insert_customer($data)) {
                // --- SESSION FLASHDATA FEATURE ---
                log_message('info', 'New customer created: ' . $data['email']); // --- LOGGING FEATURE ---
                $this->session->set_flashdata('success', 'Customer successfully created!');
                redirect('customers/index');
            } else {
                log_message('error', 'Failed to insert customer: ' . $data['email']);
                $this->session->set_flashdata('error', 'Database error occurred while adding customer.');
                $this->create();
            }
        }
    }

    public function delete($id) {
        if ($this->Customer_model->delete_customer($id)) {
            $this->session->set_flashdata('success', 'Customer successfully deleted.');
        } else {
            $this->session->set_flashdata('error', 'Could not delete customer.');
        }
        redirect('customers/index');
    }
}
