<?php
Class Db_admin extends CI_Model 
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
	
	

	
	public function get_data_user(){
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
		$query = "SELECT username, nama_user, hak_akses
				FROM user_simwisuda";
		$hasil = $this->simwisuda->query($query);
        return $hasil->result();
	}
	
	public function get_edit_user($username){
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
		$query = "SELECT username, nama_user, hak_akses
				FROM user_simwisuda
				WHERE username like '$username'";
		$hasil = $this->simwisuda->query($query);
        return $hasil->result();
	}
	
	public function get_list_idpdf_buku(){
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
		$query = "SELECT id_pdf FROM pdf_buku_wisuda";
		$hasil = $this->simwisuda->query($query);
        return $hasil->result();
	}
	
	/*Menampilkan Data Kelulusan ke yang Akan Diedit*/
	public function get_edit_lulusanke($id){
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
		$query = "SELECT     KODEPRODI, NAMAPRODI, lulusan_ke
				FROM         PRODI
				WHERE     KODEPRODI like '$id'";
		$hasil = $this->simwisuda->query($query);
        return $hasil->result();
	}
	
	public function update_lulusanke($kode, $lulusan){
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
		/*$update_data = array(
			'lulusan_ke' => $lulusan
		);*/
		$query = "UPDATE    PRODI
				SET lulusan_ke = '$lulusan'
				WHERE (KODEPRODI LIKE '$kode%')";
		$this->simwisuda->query($query);
		
	}
	
	

}
?>