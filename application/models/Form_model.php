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

}
