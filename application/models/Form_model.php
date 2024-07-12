class Form_model extends CI_Model {

public function save_form_data($formData) {
    // Save the form data to the database
    $this->db->insert('forms', [
        'title' => $formData['title'],
        'description' => $formData['description']
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
}
