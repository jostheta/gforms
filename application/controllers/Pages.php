<?php

//This controller only manipulates the pages
class Pages extends CI_Controller {

    public function view($page = 'home')
    {
        if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
            show_404();
        }
        
        //storing the title of the page
        $data['title'] = ucfirst($page);

        $this->load->view('templates/header_home');
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer');
    }

    public function hero()
    {
        //storing the title of the page
        
        $this->load->view('pages/hero');
        
    }


}

