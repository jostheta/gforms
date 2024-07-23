<?php

class Forms extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('Form_model');
        $this->load->library('session');
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
        $data['forms'] = $this->Form_model->get_all_user_forms();
        $this->load->view('templates/header');
        $this->load->view('forms/myforms', $data);
        $this->load->view('templates/footer');

    }

    public function my_drafts() {

        $this->load->model('Form_model');
        $data['forms'] = $this->Form_model->get_all_user_forms();
        $this->load->view('templates/header');
        $this->load->view('forms/mydrafts', $data);
        $this->load->view('templates/footer');
       //footer omitted on purpose

    }

    public function view_form($form_id) {
        $data['form'] = $this->Form_model->get_form_by_id($form_id);
        $data['questions'] = $this->Form_model->get_questions_by_form_id($form_id);
        foreach ($data['questions'] as &$question) {
            $question->options = $this->Form_model->get_options_by_question_id($question->question_id);
        }
        $this->load->view('templates/header', $data);
        $this->load->view('forms/view_form', $data);
       //footer intentionally omitted
    }

    public function delete_form($form_id) {
        $this->load->model('Form_Model');
        if ($this->Form_Model->delete_form($form_id)) {
            $this->session->set_flashdata('message', 'Form deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'There was a problem deleting the form.');
        }
        redirect('forms/my_drafts');
    }

    public function update_form() {
        $form_id = $this->input->post('form_id');
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $questions = json_decode($this->input->post('questions'), true);
    
        // Load the model
        $this->load->model('Form_Model');
    
        // Update form details
        $form_data = array(
            'title' => $title,
            'description' => $description,
        );
        $this->Form_Model->update_form($form_id, $form_data);

        // Update or add questions
        foreach ($questions as $question) {
            $question_id = isset($question['question_id']) ? $question['question_id'] : null;
            $question_data = array(
                'form_id' => $form_id,
                'question_text' => $question['question_text'],
                'question_type' => $question['question_type'],
            );
            if ($question_id) {
                // Update existing question
                $this->Form_Model->update_question($question_id, $question_data);
            } else {
                // Add new question
                $question_id = $this->Form_Model->add_question($question_data);
            }

            // Update or add options for each question
            if (isset($question['options']) && is_array($question['options'])) {
                foreach ($question['options'] as $option) {
                    $option_id = isset($option['option_id']) ? $option['option_id'] : null;
                    $option_data = array(
                        'question_id' => $question_id,
                        'option_text' => $option['option_text'],
                    );
                    if ($option_id) {
                        // Update existing option
                        $this->Form_Model->update_option($option_id, $option_data);

                    } else {
                        // Add new option
                        $this->Form_Model->add_option($option_data);

                    }

                }
            }
        }
    
        // Return success response or redirect
        echo json_encode(array('success' => true));
    }

    public function preview($form_id){
        $data['form'] = $this->Form_model->get_form_by_id($form_id);
        $data['questions'] = $this->Form_model->get_questions_by_form_id($form_id);
        foreach ($data['questions'] as &$question) {
            $question->options = $this->Form_model->get_options_by_question_id($question->question_id);
        }
        $this->load->view('templates/header');
        $this->load->view('forms/preview', $data);
        $this->load->view('templates/footer');
    }
    
    public function publish_form($form_id) {
        // Load form and questions data
        $form = $this->Form_model->get_form_by_id($form_id);
        $questions = $this->Form_model->get_questions_by_form_id($form_id);
    
        // Validation checks
        if (empty($form->title)) {
            $this->session->set_flashdata('error', 'Form title cannot be empty.');
            redirect('forms/preview/' . $form_id);
            return;
        }
    
        foreach ($questions as $question) {
            if (empty($question->question_text)) {
                $this->session->set_flashdata('error', 'All questions must have text.');
                redirect('forms/preview/' . $form_id);
                return;
            }
    
            // Check if question type is multiple-choice or checkbox
            if (in_array($question->question_type, ['multiple-choice', 'checkbox'])) {
                $options = $this->Form_model->get_options_by_question_id($question->question_id);
                if (empty($options)) {
                    $this->session->set_flashdata('error', 'Questions of type multiple-choice or checkbox must have at least one option.');
                    redirect('forms/preview/' . $form_id);
                    return;
                }
            }
        }
    
        // Generate a unique link
        $response_link = base_url("forms/respond/" . $form_id);
    
        // Update is_published to 1 and set the response link
        $this->Form_model->update_form($form_id, [
            'is_published' => 1,
            'response_link' => $response_link
        ]);
    
        // Redirect to the list_user_forms function
        redirect('forms/list_user_published_forms');
    }
    
    
        
    

    public function respond($form_id) {
        // Check if user is logged in
        if (!$this->session->userdata('user_id')) {
            // Set flash message
            $this->session->set_flashdata('error', 'Please login to respond to the form.');
    
            // Redirect to login page with form ID
            redirect('users/login_redirect/' . $form_id);
        }
    
        // Load form, questions, and options data if user is logged in
        $data['form'] = $this->Form_model->get_form_by_id($form_id);
        $data['questions'] = $this->Form_model->get_questions_by_form_id($form_id);
        foreach ($data['questions'] as &$question) {
            $question->options = $this->Form_model->get_options_by_question_id($question->question_id);
        }
    
        // Load the views
        $this->load->view('templates/header');
        $this->load->view('forms/respond_form', $data);
        $this->load->view('templates/footer');
    }
    

    

    public function submit_response() {
        $this->load->model('Form_model');
    
        $form_id = $this->input->post('form_id');
        $responses = $this->input->post('responses');
        $questions = $this->Form_model->get_questions_by_form_id($form_id);
    
        $errors = [];
    
        foreach ($questions as $question) {
            if ($question->is_required && empty($responses[$question->question_id])) {
                $errors[$question->question_id] = 'This is a required question';
            }
        }
    
        if (!empty($errors)) {
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode(['success' => false, 'errors' => $errors]));
        } else {
            if ($this->Form_model->save_responses($form_id, $responses)) {
                $this->output
                     ->set_content_type('application/json')
                     ->set_output(json_encode(['success' => true]));
            } else {
                $this->output
                     ->set_content_type('application/json')
                     ->set_output(json_encode(['success' => false]));
            }
        }
    }
    
    
    public function respond_form($form_id) {
        $this->load->model('Form_model');
    
        $form = $this->Form_model->get_form_by_id($form_id);
        $questions = $this->Form_model->get_questions_by_form_id($form_id);
    
        $responses = $this->session->flashdata('responses');
        $errors = $this->session->flashdata('errors');
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
    
        $data = [
            'form' => $form,
            'questions' => $questions,
            'responses' => $responses,
            'errors' => $errors,
            'success' => $success,
            'error' => $error,
        ];
    
        $this->load->view('forms/respond_form', $data);
    }
    

    // List all forms of the current logged-in user
    public function list_user_forms() {
        $user_id = $this->session->userdata('user_id');
        $data['forms'] = $this->Form_model->get_forms_by_user($user_id);
        
        $this->load->view('templates/header');
        $this->load->view('forms/user_forms', $data);
        $this->load->view('templates/footer');
    }
    
    // List all responses for a particular form
    public function list_form_responses($form_id) {
        $user_id = $this->session->userdata('user_id');
        $data['responses'] = $this->Form_model->get_responses_by_form($form_id);
        $data['form'] = $this->Form_model->get_form($form_id);
        $responses = $this->Form_model->get_responses_by_form($form_id);
        

        
        $this->load->view('templates/header');
        $this->load->view('forms/form_responses', $data);
        $this->load->view('templates/footer');
    }
    
    // View a specific response
    public function view_response($response_id) {
        // Get the response details
        $data['response'] = $this->Form_model->get_response($response_id);
        if (empty($data['response'])) {
        show_404();
        }

        // Get the form details using the form ID from the response
        $form_id = $data['response']->form_id;
        $data['form'] = $this->Form_model->get_form($form_id);

        // Get the questions and their options for the form
        $data['questions'] = $this->Form_model->get_questions_by_form_id($form_id);
        foreach ($data['questions'] as &$question) {
        $question->options = $this->Form_model->get_options_by_question_id($question->question_id);
    }


    // Load the views
    $this->load->view('templates/header');
    $this->load->view('forms/view_response', $data);
    $this->load->view('templates/footer');
}

    public function list_user_published_forms() {
    $user_id = $this->session->userdata('user_id');
    $data['forms'] = $this->Form_model->get_published_forms_by_user($user_id);

    $this->load->view('templates/header');
    $this->load->view('forms/user_forms', $data);
    $this->load->view('templates/footer');
    }

    public function edit_form($form_id) {
        $this->load->model('Form_model');
    
        $formData = $this->input->post('formData');
        $decodedData = json_decode($formData, true);
    
        if (!$decodedData) {
            log_message('error', 'Failed to decode form data: ' . $formData);
            echo json_encode(['status' => 'error', 'message' => 'Invalid form data']);
            return;
        }
    
        log_message('debug', 'Decoded form data: ' . print_r($decodedData, true));
    
        $form_data = array(
            'title' => $decodedData['title'],
            'description' => $decodedData['description'],
        );
    
        try {
            $this->Form_model->update_form($form_id, $form_data);
            $this->Form_model->delete_for_edit($form_id);
            $this->Form_model->save_for_edit($decodedData, $form_id);
    
            echo json_encode(['status' => 'success', 'message' => 'Form data updated successfully.']);
        } catch (Exception $e) {
            log_message('error', 'Exception occurred: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'An error occurred while updating the form data.']);
        }
    }
    
    
    


}



