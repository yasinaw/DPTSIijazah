<?php
class Admin extends CI_Controller
{
	private $nama_pengguna;
	
	function __construct() 
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Db_admin','',TRUE);
		$this->simwisuda = $this->load->database('simwisuda', TRUE);
		
		$this->load->library(array('form_validation','session','encrypt'));
		
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
		
		if($hak_akses!='ADMIN'){
			redirect(base_url(), 'refresh');
		}
		//;$data['sess_nama'] = $nama_user;
		//echo $hak_akses.'-'.$session_data['nama_user'];
		//echo anchor(base_url().'login/logout');
		$this->nama_pengguna = $nama_user;
		//$data['isi_status']='normal';
	}
	
	public function index()
	{
		$data['namauser'] = $this->nama_pengguna;
		$this->load->view('admin/home');
	}
	
	public function tambah_pengguna()
	{
        $this->load->model('Db_kursi','',TRUE);
		$per = $this->input->post('periodewisuda');
        $mulai = $this->input->post('tglmulai');
        $jumlah_hari = $this->input->post('jmlhari');
		$jumlah_baris = $this->input->post('jmlbaris');
		$data2["data_prodi"] = $this->Db_kursi->ambil_data_prodi();
        $data2["n"] = $jumlah_hari;
		$data2["nbaris"] = $jumlah_baris;
        $data2["mulai"] = date('Y-m-d',strtotime($mulai));
        $data2["pr"] = $per;
		$data2["data_kelulusan"] = $this->Db_kursi->ambil_jadwal($per);
		$data2['namauser'] = $this->nama_pengguna;
        $this->load->view('kursi/pengaturan_kursi', $data2);		
	}
	
	public function list_pengguna()
	{	
		$data["hasil"] = $this->Db_admin->get_data_user();
		$data['isi_status']='normal';
		$data['namauser'] = $this->nama_pengguna;
		$this->load->view('admin/lihat_user', $data);
    }
	
	public function edit_pengguna(){
		$data_id = $this->uri->segment(3);
		$data['hasil'] = $this->Db_admin->get_edit_user($data_id);
		foreach($data['hasil'] as $row){
			$value1['username'] = $row->username;
			$value1['nama'] = $row->nama_user;
			$value1['hak_akses'] = $row->hak_akses;
		}
		$value1['namauser'] = $this->nama_pengguna;
		$this->load->view('admin/edit_hakakses_user',$value1);		
	}
	
	public function update_pengguna(){
		$username = $this->input->post('input_username');	
		$hak_akses = $this->input->post('combo_akses');	
		$nama = $this->input->post('input_name');	
		
		$this->form_validation->set_rules('combo_akses', 'NRP', 'required|xss_clean');
		$this->form_validation->set_message('required', 'Pilih Hak Akses');
		$this->form_validation->set_message('min_length', 'Jumlah Karakter %s Kurang Dari %s');
		$this->form_validation->set_message('max_length', 'Jumlah Karakter %s Lebih Dari %s');
		$data['isi_status']='normal';
		
		if($this->form_validation->run()==false)
        {	
			//Field validation failed.  User redirected to login page
			$value1['username'] = $username;
			$value1['nama'] = $nama;
			$value1['hak_akses'] = $hak_akses;
			$value1['namauser'] = $this->nama_pengguna;
			$this->load->view('admin/edit_hakakses_user',$value1);			
		}
		else
		{	
			$update_data = array(
					'hak_akses' => $hak_akses
				);
			$this->simwisuda->where('username', $username);
			$this->simwisuda->update('user_simwisuda', $update_data);//Update data to database 
			
			//$data['username'] = $usernmae;
			//$data['nama'] = $nama;
			//$data['hak_akses'] = $hak_akses;
			$data["hasil"] = $this->Db_admin->get_data_user();
			$data['isi_status']='berhasil';
			$data['alasan']='Hak Akses '.$nama.'  Berhasil Dirubah<br>Menjadi<br>HAK AKSES : '.$hak_akses;
			$data['namauser'] = $this->nama_pengguna;
			$this->load->view('admin/lihat_user', $data);
		}		
	}
	
	/*HAPUS PENGGUNA*/
	public function hapus_pengguna(){
		$data_id = $this->uri->segment(3);
				
		$this->simwisuda->where('username', $data_id);
		$this->simwisuda->delete('user_simwisuda');
		$data["hasil"] = $this->Db_admin->get_data_user();
		$data['isi_status']='berhasil';
		$data['alasan']='Data '.$data_id	.' Berhasil Dihapus ';
		$data['namauser'] = $this->nama_pengguna;
		$this->load->view('admin/lihat_user', $data); //load halaman menampilkan data buku
	}
	
	
} 
?>