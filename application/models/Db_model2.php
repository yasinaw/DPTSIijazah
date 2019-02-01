<?php
Class Db_model2 extends CI_Model 
{
	var $simwisuda;
	
	function __construct() 
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		//$this->simwisuda = $this->load->database('simwisuda', TRUE); 
	}
	
	public function foto_mhs($nrp){
		$query = "SELECT      MW_ma_Foto
					FROM        Akademik_SIMITS.dbo.mahasiswa_wisuda
					WHERE     (MW_ma_nrp LIKE '$nrp')				
				";
		$hasil = $this->db->query($query);
        return $hasil->result();
	}

}
?>