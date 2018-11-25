<?php
Class login extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Db_login','',TRUE);
		$this->simwisuda = $this->load->database('simwisuda', TRUE);
		$this->load->library(array('form_validation','session','encrypt'));
	}
	
	function index()
	{/*
		$this->load->library('form_validation');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$result_login = $this->check_database($password, $username);
		
		if($result_login == null)
		{
		$data['check_database']= 'Maaf, username atau password yang anda masukkan salah, silakan coba lagi.';
		//Field validation failed.  User redirected to login page
		$this->load->view('index',$data);
		}
		else if(strlen($username)==10)
		{
		//Go to private area
			redirect('mahasiswa', 'refresh');
		}*/
		$this->load->view('login_view');
	}
	
	public function login_form()
    {   
        //memberi validasi pa da username dan password
        //$this->form_validation->set_rules('username', 'username', 'required|trim|xss_clean');
        //$this->form_validation->set_rules('password', 'password', 'required|md5|xss_clean');
		$this->form_validation->set_rules('username', 'username', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        //jika form yang di isi salah , akan kembali lagi ke form_login
        if($this->form_validation->run()==FALSE){
            $this->load->view('login_view');
        }else{
        //jika form yang di isi benar 
                		
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $cek = $this->Db_login->ambilPengguna($username, $password, 1);
		foreach ($cek->result() as $row) {
            $user = $row->id_pdf; 
			$nama = $row->nama_user; 
			$hak_akses = $row->hak_akses; 
		}
			
        if($cek <> 0){
        $this->session->set_userdata('isLogin', TRUE);
        $this->session->set_userdata('username',$username);
		//$newdata = array('username' => $data['user'],'level' => $data['level'], 'status'=>'ok');
        redirect(base_url().'/mhs');
        }else{
        // jika salah
        ?>
            <script>
            alert('Gagal Login: Cek username dan password anda!');
            history.go(-1);
            </script>
            <?php
            }
        }
    }
	
	/*
	private function check_database($password, $username)
	{
		//Field validation succeeded.  Validate against database
		if(strlen($username)==10){
			//query the database
			$result=$this->Db_login->data_mhs($username, $password);
		}
		else (strlen($username)==9){
			$result=$this->Db_login->data_peg($username, $password);
		}
		
		//$data['hasil'] = $this->Db_model->get_edit_lulusanke($data_id);
		
		if($result)
		{
			$sess_array=array();
			foreach($result as $row)
			{
				$sess_array=array(
					'id' => $row->MA_Nrp,
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
	}*/
	
	
		
}
?>