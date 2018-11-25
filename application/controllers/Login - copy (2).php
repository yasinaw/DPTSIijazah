<?php
Class login extends CI_Controller 
{
	public $status_login=false;
	
	function __construct() 
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Db_login','',TRUE);
		$this->simwisuda = $this->load->database('simwisuda', TRUE);
		$this->load->library(array('form_validation','session','encrypt', 'form_validation'));
		//$this->load->library();
	}
	
	function index()
	{
		
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		
		$this->form_validation->set_rules("username", "Username", "trim|required|min_length[1]|max_length[15]|xss_clean");
		$this->form_validation->set_rules("password", "Password", "trim|required|min_length[1]|max_length[15]|xss_clean");
		
		if($this->form_validation->run()==false)
        {	
			//Field validation failed.  User redirected to login page
			$this->load->view('login_view');			
		}
		else{			
			$result_login = $this->check_database($password, $username);
			if($result_login == null)
			{
				$data['check_database']= 'Maaf, username atau password yang anda masukkan salah, silakan coba lagi.';
				//Field validation failed.  User redirected to login page
				$this->load->view('login_view',$data);
			}
			else if($result_login['akses'] == 'ADMIN')
			{
				//Go to private area
				redirect(base_url().'admin/list_pengguna');
			}
			else if($result_login['akses'] == 'BUKU'){
				redirect(base_url().'buku');
			}
			else if($result_login['akses'] == 'KURSI'){
				redirect(base_url().'/kursiwisuda');
			}
		}
		
	}
	
	private function check_database($password, $username)
	{
		//Field validation succeeded.  Validate against database
		
		//query the database
		$result=$this->Db_login->get_user($username, $password);
		
		if($result)
		{
			$sess_array=array();
			foreach($result as $row)
			{
				$sess_array=array(
					'user' => $row->username,
					'nama_user' => $row->nama_user,
					'akses' => $row->hak_akses,
					'status_login' => true
				);
				$this->session->set_userdata('logged_in', $sess_array);
			}
			//print_r($sess_array);
			return $sess_array;
		}
		else
		{
			
			return null;
		}
	}
	
	public function logout()
	{
            $this->session->unset_userdata('logged_in');
            session_destroy();
            redirect(base_url());
	}
		
}
?>