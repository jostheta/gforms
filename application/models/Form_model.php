<?php
class Form_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function save_form_data($formData) {

        $user_id = $this->session->userdata('user_id');

    // Save the form data to the database
        $this->db->insert('forms', [
        'title' => $formData['title'],
        'description' => $formData['description'],
        'user_id' => $user_id
         ]);

        $formId = $this->db->insert_id();

        foreach ($formData['questions'] as $question) {
        $this->db->insert('questions', [
            'form_id' => $formId,
            'question_text' => $question['question'],
            'question_type' => $question['type']
        ]);
        $questionId = $this->db->insert_id();

        if ($question['type'] !== 'paragraph') {
            foreach ($question['options'] as $option) {
                $this->db->insert('options', [
                    'question_id' => $questionId,
                    'option_text' => $option
                ]);
            }
        }
        }
}

    public function get_all_forms() {
    $query = $this->db->get('forms');
    return $query->result();
    }

    public function get_form_by_id($form_id) {
    $query = $this->db->get_where('forms', array('form_id' => $form_id));
    return $query->row();
    }

    public function get_questions_by_form_id($form_id) {
    $query = $this->db->get_where('questions', array('form_id' => $form_id));
    return $query->result();
    }

    public function get_options_by_question_id($question_id) {
    $query = $this->db->get_where('options', array('question_id' => $question_id));
    return $query->result();
    }

    public function delete_form($form_id) {
        // Begin transaction
        $this->db->trans_start();
        // Delete options related to the form using a join
        $this->db->query("DELETE o FROM options o
                          JOIN questions q ON o.question_id = q.question_id
                          WHERE q.form_id = ?", array($form_id));

        // Delete questions related to the form
        $this->db->where('form_id', $form_id);
        $this->db->delete('questions');

        // Delete the form itself
        $this->db->where('form_id', $form_id);
        $this->db->delete('forms');

        // Complete transaction
        $this->db->trans_complete();

        // Check transaction status
        return $this->db->trans_status();
    }

    public function update_form($form_id, $data) {
        $this->db->where('form_id', $form_id);
        $this->db->update('forms', $data);
    }

    // Update question details
    public function update_question($question_id, $data) {
        $this->db->where('question_id', $question_id);
        $this->db->update('questions', $data);
    }

    // Add new question
    public function add_question($data) {
        $this->db->insert('questions', $data);
        return $this->db->insert_id();
    }

    // Update option details
    public function update_option($option_id, $data) {
        $this->db->where('option_id', $option_id);
        $this->db->update('options', $data);
    }

    // Add new option
    public function add_option($data) {
        $this->db->insert('options', $data);
        return $this->db->insert_id();
    }

    public function save_responses($form_id, $responses) {
        $this->db->trans_start();
        
        // Insert response record
        $response_data = [
            'form_id' => $form_id,
            'user_id' => $this->session->userdata('user_id'), // Set user_id if applicable
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('responses', $response_data);
        $response_id = $this->db->insert_id();
        
        // Insert each answer
        foreach ($responses as $question_id => $answer) {
            if (is_array($answer)) {
                foreach ($answer as $answer_text) {
                    $answer_data = [
                        'response_id' => $response_id,
                        'question_id' => $question_id,
                        'answer_text' => $answer_text,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    $this->db->insert('response_answers', $answer_data);
                }
            } else {
                $answer_data = [
                    'response_id' => $response_id,
                    'question_id' => $question_id,
                    'answer_text' => $answer,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('response_answers', $answer_data);
            }
        }
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    public function get_forms_by_user($user_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('forms');
        return $query->result();
    }
    
    public function get_responses_by_form($form_id) {
        $this->db->where('form_id', $form_id);
        $query = $this->db->get('responses');
        return $query->result();
    }
    
    public function get_response($response_id) {
        $this->db->where('response_id', $response_id);
        $query = $this->db->get('responses');
        $response = $query->row();
        
        $this->db->where('response_id', $response_id);
        $query = $this->db->get('response_answers');
        $response->answers = $query->result();
        
        return $response;
    }
    
    public function get_form($form_id) {
        $this->db->where('form_id', $form_id);
        $query = $this->db->get('forms');
        return $query->row();
    }

    public function get_published_forms_by_user($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('is_published', 1); // Ensure only published forms are retrieved
        $query = $this->db->get('forms');
        return $query->result();
    }

    public function delete_for_edit($form_id) {
        // Fetch question IDs
        $question_ids = $this->db->select('question_id')
                                 ->from('questions')
                                 ->where('form_id', $form_id)
                                 ->get()
                                 ->result_array();
    
        // Extract question IDs to a simple array
        $question_ids = array_column($question_ids, 'question_id');
    
        // Delete existing options for the questions of this form
        if (!empty($question_ids)) {
            $this->db->where_in('question_id', $question_ids);
            $this->db->delete('options');
        }
    
        // Delete existing questions for the form
        $this->db->where('form_id', $form_id);
        $this->db->delete('questions');
    }
    
    public function save_for_edit($formData, $form_id) {
        $user_id = $this->session->userdata('user_id');
    
        // Log the formData being processed
        log_message('debug', 'Saving for form_id: ' . $form_id . ', formData: ' . print_r($formData, true));
    
        foreach ($formData['questions'] as $question) {
            $this->db->insert('questions', [
                'form_id' => $form_id,
                'question_text' => $question['question_text'],
                'question_type' => $question['question_type']
            ]);
            $question_id = $this->db->insert_id();
    
            // Log the insert question SQL
            log_message('debug', 'Insert question SQL: ' . $this->db->last_query());
    
            if ($question['question_type'] !== 'paragraph') {
                foreach ($question['options'] as $option) {
                    $this->db->insert('options', [
                        'question_id' => $question_id,
                        'option_text' => $option['option_text']
                    ]);
    
                    // Log the insert option SQL
                    log_message('debug', 'Insert option SQL: ' . $this->db->last_query());
                }
            }
        }
    }
    
    
    
    
}
  
    

