<?php $this->load->view('includes/header'); ?>

<script type="text/javascript" src="http://localhost/CodeIgniter_Registration/javascripts/tabs_specific.js"></script>

<?php $this->load->view('includes/header_bar'); ?>

<?php $this->load->view('app_form_tabs/header_tabs');  ?>

<div id="load_next_tab">  <!-- will be used to populate the tab coming from ajax -->
    <?php $this->load->view('app_form_tabs/'.$new_tabname);  ?>
</div>

<?php $this->load->view('includes/footer'); ?>