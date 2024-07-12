<?php

class Forms extends CI_Controller
{
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
}



