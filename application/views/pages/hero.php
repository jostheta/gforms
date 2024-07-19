<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hero Page</title>
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/hero-styles.css"> <!-- Link to your new CSS file -->
</head>
<body >

  <!-- Your Navbar code -->
  <nav class="navbar-custom">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="<?= base_url(); ?>hero">Gforms</a>
      </div>
      <div class="navbar-links">
        <ul class="nav-left">
          <?php if($this->session->userdata('logged_in')) : ?>
            <li><a href="<?= base_url(); ?>home">Home</a></li>
            <li><a href="<?= base_url(); ?>my_forms">My Forms</a></li>
            <li><a href="<?= base_url(); ?>my_drafts">My Drafts</a></li>
            <li><a href="<?= base_url(); ?>responses">Responses</a></li>
          <?php endif; ?>
        </ul>
        <ul class="nav-right">
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


  <header>
    <section class="hero">
      <h1 class="hero-message">
        <div>Simple yet Functional</div>
        <div>Google Forms</div>
      </h1>
      <p class="under-hero">Start creating your forms with Google Forms clone,create,edit and publish your forms today!</p>
      <div class="button-list">
        <button class="primary">Login</button>
        <button>Register</button>
      </div>
    </section>
    <picture class="promo-art">
      <img src="<?= base_url() ?>assets/images/analysis.png" height="800" width="800" alt="pie charts">
    </picture>
  </header>

  <!-- Your other content -->

</body>
</html>
