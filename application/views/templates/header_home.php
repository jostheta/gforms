<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gforms</title>
   
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/css/tailwind.min.css">
    <link rel= "stylesheet" href = "<?= base_url() ?>assets/css/style.css">
</head>
<body style="background-color:white;"><!--#f0ebf8-->
    <nav class = "navbar navbar-inverse" style="background-color:rgb(103, 58, 183); margin-bottom:0px;">
        <div class = "container">
            <div id = "nav-header" class = "navbar-header">
                <a  class = "navbar-brand" href="<?= base_url(); ?>hero">Gforms</a>
            </div>
            <div id = "navbar">
                <ul class = "nav navbar-nav">
                    <li><a href = "<?= base_url(); ?>home">Home</a></li>
                <?php if($this->session->userdata('logged_in')) : ?>
                    <li><a href="<?= base_url(); ?>my_forms">My Forms</a></li>
                    <li><a href="<?= base_url(); ?>my_drafts">My Drafts</a></li>
                    <li><a href="<?=base_url(); ?>responses">Responses</a></li>
                <?php endif; ?>
                </ul>
                <ul class = "nav navbar-nav navbar-right">
                <?php if(!$this->session->userdata('logged_in')) : ?>
                    <li><a href="<?php echo base_url(); ?>users/login">Login</a></li>
                    <li><a href="<?php echo base_url(); ?>users/register">Register</a></li>
                <?php endif; ?>
                <?php if($this->session->userdata('logged_in')) : ?>
                    <li><a href="<?php echo base_url(); ?>create">Create Form</a></li>
                    <li><a href="<?php echo base_url(); ?>users/logout">Logout</a></li>
                <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

  <div class = "layout"  >  

    <?php if($this->session->flashdata('user_registered')): ?>
            <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_registered').'</p>'; ?>
    <?php endif; ?>

    <?php if($this->session->flashdata('login_failed')): ?>
            <?php echo '<p class="alert alert-danger">'.$this->session->flashdata('login_failed').'</p>'; ?>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('user_loggedin')): ?>
            <?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_loggedin').'</p>'; ?>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('user_loggedout')): ?>
            <?php echo '<p class="alert alert-danger">'.$this->session->flashdata('user_loggedout').'</p>'; ?>
    <?php endif; ?>