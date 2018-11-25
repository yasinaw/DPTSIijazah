<?php
Class mahasiswa extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Db_mhs','',TRUE);
		$this->simwisuda = $this->load->database('simwisuda', TRUE);
		$this->load->library(array('form_validation','session'));
	}
	function index() 
	{		
		$this->load->view('mhs/carikursi');
	}
	
	public function carikursi()
	{
		$this->load->view('mhs/carikursi');
	}
	
	public function posisikursi()
	{
		$nrp = $this->input->post('input_nrp');
		
		//$this->form_validation->set_rules("nrp", "NRP", "trim|required|min_length[10]|max_length[10]");
		$this->form_validation->set_rules('input_nrp', 'NRP', 'required|xss_clean|min_length[10]|max_length[10]');
		
		$this->form_validation->set_message('required', 'Wajib isi NRP');
		$this->form_validation->set_message('min_length', 'Jumlah Karakter %s Kurang Dari %s');
		$this->form_validation->set_message('max_length', 'Jumlah Karakter %s Lebih Dari %s');
		
		if($this->form_validation->run()==false)
        {	
			//Field validation failed.
			$this->load->view('mhs/carikursi');			
		}
		else
		{
			$data['posisi'] = $this->Db_mhs->get_kursi($nrp);
			if($data['posisi'] == null)
			{
				$data['check_database']= 'Maaf, Data Tidak Ditemukan.';
				//Field validation failed.  User redirected to login page
				$this->load->view('mhs/carikursi',$data);
			}
			else{
				$this->load->view('mhs/lokasi', $data);
			}
			
		}
		
		
	}
}
?>