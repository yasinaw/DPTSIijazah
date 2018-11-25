<?php
Class buku extends CI_Controller 
{
	private $nama_pengguna;
	
	function __construct() 
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Db_model','',TRUE);
		$this->load->model('Db_kursi','',TRUE);
		$this->simwisuda = $this->load->database('simwisuda', TRUE);
		//$this->load->library('form_validation');
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
		
		if($hak_akses!='BUKU'){
			redirect(base_url(), 'refresh');
		}
		$this->nama_pengguna = $nama_user;
		//echo $hak_akses;
		//echo anchor(base_url().'login/logout');
		
	}
	function index() 
	{
		$this->load->model('Db_model','',TRUE);
		//$data["data_mhs"] = $this->Db_model->ambil_data();
		$data["data_jadwal"] = $this->Db_model->ambil_jadwal();
		$data['namauser'] = $this->nama_pengguna;
		$this->load->view('mhs',$data);
	}
	
	public function pengaturan_buku()
	{ 
        $this->load->model('Db_model','',TRUE);				
        $per = $this->input->post('periodewisuda');
        $mulai = $this->input->post('tglmulai');
        $jumlah_hari = $this->input->post('jmlhari');
		$data2["data_fakultas"] = $this->Db_model->ambil_data_fakultas();
        $data2["data_prodi"] = $this->Db_model->ambil_data_prodi();
        $data2["n"] = $jumlah_hari;
        $data2["mulai"] = date('Y-m-d',strtotime($mulai));
        $data2["pr"] = $per;
		$data2['namauser'] = $this->nama_pengguna;
        $this->load->view('cetak_buku_view', $data2);
		//$this->load->view('pengaturan_buku', $data2);
        //$data2["data_kelulusan"] = $this->Db_model->ambil_jadwal($per);
    }
		
	public function generate_buku_pdf()
	{ 
		/*$this->form_validation->set_rules('marginleft', 'marginkiri', 'required');
		if ($this->form_validation->run() == FALSE){
			$per = $this->input->post('periodewisuda');
			$mulai = $this->input->post('tglmulai');
			$jumlah_hari = $this->input->post('jmlhari');
			$data2["data_prodi"] = $this->Db_model->ambil_data_prodi();
			$data2["n"] = $jumlah_hari;
			$data2["mulai"] = date('Y-m-d',strtotime($mulai));
			$data2["pr"] = $per;
			$data2["data_kelulusan"] = $this->Db_model->ambil_jadwal($per);
			$this->load->view('cetak_buku_view', $data2);
		}
		else{
			$this->load->view('success');
		}*/
		
		//$this->load->database('simwisuda',TRUE);
		$this->load->helper('pdf_helper');
        $this->load->model('Db_model','',TRUE);
		//$this->load->model('Db_model','simwisuda',TRUE);
		$buku=$_GET['buku'];
		$periode_wisuda = $this->input->post('periodewisuda');
		$margin_left = $this->input->post('marginleft');
		$margin_right = $this->input->post('marginright');
		$margin_top = $this->input->post('margintop');
		$margin_bottom = $this->input->post('marginbottom');
		$urutan_data = $this->input->post('urutan');
		$ukuran_kertas = $this->input->post('ukuran');
		$mhs_kojur = $this->input->post('mhskojur');
		$jum_data = $this->input->post('jumlah_data');
		$tanggalwisuda = $this->input->post('tanggal');
		
		$tanggal_indo=date("d M Y",strtotime($tanggalwisuda));
		function konversi($tanggal_indo) //KONVERSI TANGGAL WISUDA KE FORMAT INDONESIA
		{	
			$format = array(
				'Sun' => 'Minggu',
				'Mon' => 'Senin',
				'Tue' => 'Selasa',
				'Wed' => 'Rabu',
				'Thu' => 'Kamis',
				'Fri' => 'Jumat',
				'Sat' => 'Sabtu',
				'Jan' => 'Januari',
				'Feb' => 'Februari',
				'Mar' => 'Maret',
				'Apr' => 'April',
				'May' => 'Mei',
				'Jun' => 'Juni',
				'Jul' => 'Juli',
				'Aug' => 'Agustus',
				'Sep' => 'September',
				'Oct' => 'Oktober',
				'Nov' => 'November',
				'Dec' => 'Desember'
			); 
			return strtr($tanggal_indo, $format);
		}
		
				
		$data2["data_prodi"] = $this->input->post('input_hidden');
	    $data2["periodewisuda"] = $periode_wisuda;
		$data2["marginleft"] = $margin_left;
		$data2["marginright"] = $margin_right;
		$data2["margintop"] = $margin_top;
		$data2["marginbottom"] = $margin_bottom;
		$data2["urutandata"] = $urutan_data;
		$data2["ukurankertas"] = $ukuran_kertas;
		$data2["jumlah_data"] = $jum_data;
		$data2["buku_ke"] = $buku;
		$data2["tanggal"] = strtotime($tanggalwisuda);
		$data2["tanggal_id"] = konversi($tanggal_indo);
		$data2["cek_update"] = $this->input->post('cek_update');
		
		//$this->load->view('pdfreport', $data2);
		$this->load->view('pdfreport _foto', $data2);
    }
	
	public function master_lulusan_ke(){
		$data["hasil"] = $this->Db_model->get_lulusanke();	
		$data['isi_status']='normal';
		$data['namauser'] = $this->nama_pengguna;
		$this->load->view('lulusan_ke', $data);
	}
	
	public function edit_lulusanke(){
		$data_id = $this->uri->segment(3);
		$data['hasil'] = $this->Db_model->get_edit_lulusanke($data_id);
		foreach($data['hasil'] as $row){
			$value1['kodeprodi'] = $row->KODEPRODI;
			$value1['nama_prodi'] = $row->NAMAPRODI;
			$value1['lulusanke'] = $row->lulusan_ke;
		}
		$value1['namauser'] = $this->nama_pengguna;
		$this->load->view('lulusanke_edit',$value1);
	}
	
	public function proses_lulusanke(){
		$kodeprodi = $this->input->post('kodeprodi');
		$prodi = $this->input->post('namaprodi');
		$lulusan = $this->input->post('input_lulusan');
		
		$this->Db_model->update_lulusanke($kodeprodi, $lulusan);
		
		$data['hasil'] = $this->Db_model->get_lulusanke();	
		$data['isi_status']='berhasil';
		$data['alasan']='Data Lulusan Ke '.$prodi.'<br> Berhasil Dirubah<br>Menjadi '.$lulusan;
		$data['namauser'] = $this->nama_pengguna;
		$this->load->view('lulusan_ke', $data);
	}
	
	public function upload_buku(){	
		$data_status['isi_status']='normal';
		$data_status['alasan']='normal';
		$data_status['namauser'] = $this->nama_pengguna;
		$this->load->view('upload_buku', $data_status);
	}
	
	public function tes_gambar(){
            $data_foto = $this->Db_model->get_foto();
        
            foreach ($data_foto->result_array() as $row) {
                header('Content-type:image');
                echo $row['MA_Photo'];
                break;
            }    
	}
	
	public function upload_bukuwisuda()
	{
		$this->load->helper('file'); 
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'pdf';
		$config['max_size']	= '100000';
		
		$periode = $this->input->post('periode');
		$hari = $this->input->post('hari');
		$data_id = $periode.$hari;
		
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			$error = array(
					'error' => $this->upload->display_errors()
					,'pesan'=>'Bukan file pdf');
			$this->load->view('upload_form', $error);
		}
		else
		{			
			$data = array('upload_data' => $this->upload->data());
			$data_path = $data['upload_data']['full_path'];
			$data_namafile = $data['upload_data']['file_name'];
			
		//echo $data_namafile;
			/*get data id_pdf*/
			$data['hasil']=$this->Db_model->get_list_idpdf_buku();
			$status=false;
			foreach ($data['hasil'] as $row){
				$cekid = $row->id_pdf; 
				/*ID SAMA*/
				if($data_id == $cekid){
					$status=true;					
					break;
				}
				else $status=false;
			}
			
			if($status==false){				
				/*ID BEDA*/
					//upload file ke direktori
				
				$insert_data = array(
					'id_pdf' => $data_id,
					'periode' => $periode,
					'hari' => $hari,
					'path'=> $data_path,
					'nama_file' => $data_namafile
				);
		
				$this->simwisuda->insert('pdf_buku_wisuda', $insert_data);//insert data to database 
				
				$data['hasil'] = $this->Db_model->get_data_buku();
				$data['isi_status']='berhasil';
				$data['alasan']='Data Periode <b>'.$periode.'</b> Hari <b>'.$hari.'</b> Berhasil Dimasukkan';
				$data['namauser'] = $this->nama_pengguna;
				$this->load->view('lihat_pdf', $data); //load halaman menampilkan data buku
			}
			else{				
				unlink('./uploads/'.$data_namafile); //hapus file yang di upload
				$data_status['isi_status']='error';
				$data_status['alasan']='Data Periode <b>'.$periode.'</b> Hari <b>'.$hari.'</b> sudah ada';
				$data_status['namauser'] = $this->nama_pengguna;
				$this->load->view('upload_buku', $data_status);
			}
		}
	}
	
	/*DOWNLOAD BUKU*/
	public function unduh_buku(){
		$this->load->helper('download');
		$file = $this->uri->segment(3);
		$data_id = $this->uri->segment(3);
		$data = $this->Db_model->get_edit_buku($data_id);
		foreach($data as $row){
			$file = $row->nama_file;
		}
		if(empty($file)){
			redirect('home','refresh');
		}
		$data = file_get_contents(base_url()."uploads/".$file); // Read the file's contents
		$name = $file;
		
		force_download($name, $data);
	}
	
	public function data_buku(){
		$this->load->library('pagination');
		$this->load->library('table');
		$data['hasil'] = $this->Db_model->get_data_buku();
		$data['isi_status']='normal';
		$data['alasan']='normal';
		$data['namauser'] = $this->nama_pengguna;
		//$this->load->view('lihat_pdf', $data);
		/*
		$jml = $this->db->get('pdf_buku_wisuda');

		//pengaturan pagination
		$config['base_url'] = base_url().'index.php/mhs/data_buku';
		$config['total_rows'] = $jml->num_rows();
		$config['per_page'] = '3';
		$config['first_page'] = 'Awal';
		$config['last_page'] = 'Akhir';
		$config['next_page'] = '&laquo;';
		$config['prev_page'] = '&raquo;';
		
		//inisialisasi config
		$this->pagination->initialize($config);
		
		//buat pagination
		$data['halaman'] = $this->pagination->create_links();
		
		//tamplikan data
		$data['hasil'] = $this->Db_model->get_data_buku($config['per_page'], $id);*/
		//$data["hasil"] = $this->Db_model->get_data_buku();
		
		$this->load->view('lihat_pdf', $data);
	}
	
	public function edit_data_pdf(){
		$data_id = $this->uri->segment(3);
		$data = $this->Db_model->get_edit_buku($data_id);
		foreach($data as $row){
			$value['periode'] = $row->periode;
			$value['hari'] = $row->hari;
			$value['nama_file'] = $row->nama_file;
		}
		$value['namauser'] = $this->nama_pengguna;
		$this->load->view('edit_pdf_view',$value);
	}
		
	/*DELETE BUKU*/
	public function delete_data_buku(){	
		$this->load->helper('file');
		$data_id = $this->uri->segment(3);
		$data = $this->Db_model->get_edit_buku($data_id);
		foreach($data as $row){
			$nama_file = $row->nama_file;
		}
		
		$this->simwisuda->where('id_pdf', $data_id);
		$this->simwisuda->delete('pdf_buku_wisuda');
		$path = ('./uploads/'.$nama_file);
		
		if (!unlink($path))
		{
			echo 'GAGAL<br>'.$path;
		}
		else{
			echo 'File dihapus<br>';
		}
		$data['namauser'] = $this->nama_pengguna;
		$data['hasil'] = $this->Db_model->get_data_buku();
		$data['isi_status']='berhasil';
		$data['alasan']='Data Berhasil Dihapus '.$path;
		$this->load->view('lihat_pdf', $data); //load halaman menampilkan data buku
	}
	
	/*PROSES UPDATE BUKU*/
	public function proses_update_buku()
	{
		$this->load->helper('file');
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'pdf';
		$config['max_size']	= '10000';

		$periode = $this->input->post('input_periode');
		$hari = $this->input->post('input_hari');
		$nama_file = $this->input->post('nama_file');
		$awal_periode = $this->input->post('periode_awal');
		$awal_hari = $this->input->post('hari_awal');
		$temp_id = $periode.$hari;
				
		$this->load->library('upload', $config);
		
		$data['hasil']=$this->Db_model->get_list_idpdf_buku();
		$status=false;
		foreach ($data['hasil'] as $row){
			$cekid = $row->id_pdf; 
			/*ID SAMA*/
			if($temp_id == $cekid){
				$status=true;					
				break;
			}
			else $status=false;
		}
		//echo $status;
		if($status==false){
			//Cek Input File		
			if($_FILES['userfile']['error'] == 0)
			{
				/*TERDAPAT FILE*/
				if ( ! $this->upload->do_upload())
				{
					//Bukan File PDF
					$error = array(
							'error' => $this->upload->display_errors()
							,'pesan'=>'Bukan file pdf');
					$this->load->view('upload_form', $error);
				}
				else
				{			
					$data_id = $periode.$hari;
					//Ambil nama file lama
					$data = $this->Db_model->get_edit_buku($data_id);
					foreach($data as $row){
						$nama_file = $row->nama_file;
					}
					
					
					
					$filename = './uploads/'.$nama_file;
					if (file_exists($filename)) {
						//Terdapat File lama
						unlink('./uploads/'.$nama_file);
					}
					//unlink('./uploads/'.$nama_file);//hapus file lama
					
					$data = array('upload_data' => $this->upload->data());	
					$data_path = $data['upload_data']['full_path'];
					$data_namafile = $data['upload_data']['file_name'];
		
					$update_data = array(
						'id_pdf' => $periode.$hari,
						'periode' => $periode,
						'hari' => $hari,
						'path'=> $data_path,
						'nama_file' => $data_namafile
					);
					$this->simwisuda->where('id_pdf', $awal_periode.$awal_hari);
					$this->simwisuda->update('pdf_buku_wisuda', $update_data);//Update data to database 
					
					
					$data['hasil'] = $this->Db_model->get_data_buku();
					$data['isi_status']='berhasil';
					$data['alasan']='Data Periode '.$awal_periode.' Hari '.$awal_hari.' Berhasil Dirubah<br>Menjadi<br>Periode '.$periode.' Hari '.$hari;
					$data['namauser'] = $this->nama_pengguna;
					$this->load->view('lihat_pdf', $data); 
				} 			
			}
			else {
				/*INPUT FILE KOSONG*/
				//Update Data tanpa Update FILE
				$update_data = array(
					'id_pdf' => $periode.$hari,
					'periode' => $periode,
					'hari' => $hari,
				);
				$this->simwisuda->where('id_pdf', $awal_periode.$awal_hari);
				$this->simwisuda->update('pdf_buku_wisuda', $update_data);//Update DAta to database 
				
				
				$data['hasil'] = $this->Db_model->get_data_buku();
				$data['isi_status']='berhasil';
				$data['alasan']='Data Periode '.$awal_periode.' Hari '.$awal_hari.' Berhasil Dirubah<br>Menjadi<br>Periode '.$periode.' Hari '.$hari;
				$data['namauser'] = $this->nama_pengguna;
				$this->load->view('lihat_pdf', $data); 
			}
		}
		else{
			$data_status['periode'] = $periode;
			$data_status['hari'] = $hari;
			$data_status['nama_file'] = $nama_file;
			$data_status['isi_status']='error';
			$data_status['alasan']='Data Periode <b>'.$periode.'</b> Hari <b>'.$hari.'</b> sudah ada';
			$data_status['namauser'] = $this->nama_pengguna;
			$this->load->view('edit_pdf_view',$data_status);
		}
	}
	
	
}
?>