<?php
Class profil extends CI_Controller 
{
	private $username_pengguna;	
	private $nama_pengguna;
	
	function __construct() 
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Db_login','',TRUE);
		$this->simwisuda = $this->load->database('simwisuda', TRUE);
		$this->load->library(array('form_validation','session','encrypt', 'form_validation'));
		//$this->load->library();
		
		if($this->session->userdata('logged_in'))
        {
            $session_data=$this->session->userdata('logged_in');
			$user=$session_data['user'];
			$hak_akses=$session_data['akses'];
			$nama_user = $session_data['nama_user'];			
        }
		else
        {
			//If no session, redirect to login page
			redirect(base_url(), 'refresh');
        }
		$this->username_pengguna = $user;
		$this->nama_pengguna = $nama_user;
	}
	
	function index()
	{
		$username = $this->username_pengguna;
		////$this->load->view('');
		$data['hasil'] = $this->Db_login->dataPengguna($username);			
		//if($data['hasil'] == null)
		//{
		//	$data['check_database']= 'Maaf, Data Tidak Ditemukan.';
		//	$data['namauser'] = $this->nama_pengguna;
		//	//Field validation failed.  User redirected to login page
		//	$this->load->view('kursi/cari_mhs_sisip',$data);
		//}
		//else
		//{
			foreach($data['hasil'] as $row){
				$data['nama'] = $row->nama_user; 
				$data['akses'] = $row->hak_akses;
			}
			$data['isi_status']='normal';
			$data['username'] = $this->username_pengguna;
			$data['namauser'] = $this->nama_pengguna;
			$this->load->view('profil/tampil', $data);
		//}
		
	}
	
	
		
}
?>