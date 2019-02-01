<?php
Class Db_mhs extends CI_Model 
{
	var $simwisuda;
	
	function __construct() 
	{
		parent::__construct();
		//$this->db = $this->load->database('default', TRUE);
		//$this->simwisuda = $this->load->database('simwisuda', TRUE); 
	}
	
	public function simwisuda_model(){		
        parent::Model();
        $this->simwisuda = $this->load->database('simwisuda', TRUE);   
	} 
	
	public function get_kursi($nrp){
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
		$datakursi = "SELECT *
					FROM kursiwisuda
					WHERE (nrp LIKE '$nrp%')";
		$hasil = $this->simwisuda->query($datakursi); 
		return $hasil->result();
	}

}
?>