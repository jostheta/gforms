<?php

class Forms extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('Form_model');
    }

    public function create(){
        //check login
        if(!$this->session->userdata('logged_in')){
            redirect('users/login');
        }
        $data['title'] = 'Create Form';
        $this->load->view('templates/header');
        $this->load->view('forms/create', $data);
        $this->load->view('templates/footer');
        }


    public function submit_form() {
        $formData = $this->input->post('formData');
        $decodedData = json_decode($formData, true);
    
        // Process the form data here
        // Example: Save the form data to the database
    
        $this->load->model('Form_model');
        
        $this->Form_model->save_form_data($decodedData);
    
        echo json_encode(['status' => 'success', 'message' => 'Form data submitted successfully']);
    }

    public function my_forms() {

        $this->load->model('Form_model');
        $data['forms'] = $this->Form_model->get_all_forms();
        $this->load->view('templates/header');
        $this->load->view('forms/myforms', $data);
        $this->load->view('templates/footer');

    }

    public function my_drafts() {

        $this->load->model('Form_model');
        $data['forms'] = $this->Form_model->get_all_forms();
        $this->load->view('templates/header');
        $this->load->view('forms/mydrafts', $data);
        $this->load->view('templates/footer');

    }

    public function view_form($form_id) {
        $data['form'] = $this->Form_model->get_form_by_id($form_id);
        $data['questions'] = $this->Form_model->get_questions_by_form_id($form_id);
        foreach ($data['questions'] as &$question) {
            $question->options = $this->Form_model->get_options_by_question_id($question->question_id);
        }
        $this->load->view('templates/header', $data);
        $this->load->view('forms/view_form', $data);
        $this->load->view('templates/footer', $data);
    }
}



