<?php
Class login extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
	}
	function index() 
	{
		$this->load->model('Db_model','',TRUE);
		//$data["data_mhs"] = $this->Db_model->ambil_data();
		//$data["data_jadwal"] = $this->Db_model->ambil_jadwal();
		$this->load->view('login_view');
	}
	
	
		
}
?>