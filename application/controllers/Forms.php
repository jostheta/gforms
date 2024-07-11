<?php

class Forms extends CI_Controller
{
    public function create(){
        //check login
        if(!$this->session->userdata('logged_in')){
            redirect('users/login');
        }
        $data['title'] = 'Create Post';
        $this->load->view('templates/header');    
        $this->load->view('forms/create', $data);
        $this->load->view('templates/footer');
        }
}



