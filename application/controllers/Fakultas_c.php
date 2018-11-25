<?php
    class fakultas_c extends CI_Controller{
        function __construct() {
            parent::__construct();        
            $this->load->model('fakultas');
            $this->load->helper(array('url', 'form'));
        }
        
        function view_fakultas(){
            //$data['fakultas'] = $this->view_fakultas();
            $this->load->view('fakultas_view');
        }
        
    }
?>
