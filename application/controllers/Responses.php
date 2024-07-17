<?php
// application/controllers/Responses.php
class Responses extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Response_model');
    }

    public function index($form_id) {
        $responses = $this->Response_model->get_responses($form_id);

        $data = [];
        foreach ($responses as $response) {
            $question_id = $response['question_id'];
            $question_text = $response['question_text'];
            $question_type = $response['question_type'];
            $answer_text = $response['answer_text'];

            if (!isset($data[$question_id])) {
                $data[$question_id] = [
                    'question_text' => $question_text,
                    'question_type' => $question_type,
                    'answers' => []
                ];
                if ($question_type == 'multiple-choice' || $question_type == 'checkbox') {
                    $options = $this->Response_model->get_options($question_id);
                    foreach ($options as $option) {
                        $data[$question_id]['options'][$option['option_text']] = 0;
                    }
                }
            }

            if ($question_type == 'multiple-choice' || $question_type == 'checkbox') {
                if (isset($data[$question_id]['options'][$answer_text])) {
                    $data[$question_id]['options'][$answer_text]++;
                } else {
                    $data[$question_id]['options'][$answer_text] = 1; // Initialize the count for this option
                }
            } else {
                $data[$question_id]['answers'][] = $answer_text;
            }
        }

        // // Debug statement
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';

        $this->load->view('responses/view', ['data' => $data]);
    }
}


