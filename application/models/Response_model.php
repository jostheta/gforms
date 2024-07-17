<?php
class Response_model extends CI_Model {
    public function get_responses($form_id) {
        $this->db->select('q.question_id, q.question_text, q.question_type, ra.answer_text');
        $this->db->from('Questions q');
        $this->db->join('Response_Answers ra', 'q.question_id = ra.question_id');
        $this->db->join('Responses r', 'ra.response_id = r.response_id');
        $this->db->where('q.form_id', $form_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_options($question_id) {
        $this->db->select('option_id, option_text');
        $this->db->from('Options');
        $this->db->where('question_id', $question_id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
