<?php
Class Db_login extends CI_Model 
{
	var $simwisuda;
	
	function __construct() 
	{
		parent::__construct();
		$this->db = $this->load->database('simwisuda', TRUE);
		//$this->simwisuda = $this->load->database('simwisuda', TRUE); 
	}
	
	public function simwisuda_model(){		
        parent::Model();
      //  $this->simwisuda = $this->load->database('simwisuda', TRUE);   
	} 
	
	public function get_user($username, $password){
		$this->db->select('*');
		$this->db->from('user_simwisuda');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$this->db->limit(1);
		
		$query=$this->db->get();
		
		if($query->num_rows()==1){
			return $query->result();
		}
		else{
			return false;
		}
		/*
        //menselec database codeigniter yang dari tabel user
        $this->simwisuda->select('*');
        $this->simwisuda->from('user_simwisuda');        
        $this->simwisuda->where('username', $username);        
        $this->simwisuda->where('password', $password);
        
        // membuat query yang mengambil datase
        $query = $this->simwisuda->get();
        // kembali ke query
        return $query->num_rows();
		//return $query;
		*/
    }   
	
    public function dataPengguna($username){
        $this->db->select('*');
        $this->db->from('user_simwisuda');
        $this->db->where('username', $username);
        $this->db->limit(1);
		
		$query=$this->db->get();
		
		if($query->num_rows()==1){
			return $query->result();
		}
		else{
			return false;
		}
    }
	
}
?>