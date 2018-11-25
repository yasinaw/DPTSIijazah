<?php
Class Mhs extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Db_model','',TRUE);
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
	}
	
	function index() 
	{
		$this->load->model('Db_model','',TRUE);
		//$data["data_mhs"] = $this->Db_model->ambil_data();
		$data["data_jadwal"] = $this->Db_model->ambil_jadwal();
		$this->load->view('mhs',$data);
	}
	
	public function pengaturan_buku()
	{ 
        $this->load->model('Db_model','',TRUE);
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
	
	public function generate_buku_pdf()
	{ 
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
		$data2["tanggal"] = $tanggalwisuda;
		
		$this->load->view('pdfreport', $data2);
    }
	
	public function master_lulusan_ke(){
		$data["hasil"] = $this->Db_model->get_lulusanke();		
		$this->load->view('lulusan_ke', $data);
	}
	
	public function upload_buku(){	
		$data_status['isi_status']='normal';
		$data_status['alasan']='normal';
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
		//$config['allowed_types'] = 'gif|jpg|png';
		$config['allowed_types'] = 'pdf';
		$config['max_size']	= '10000';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';
		
		$periode = $this->input->post('periode');
		$hari = $this->input->post('hari');
		
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
			$data_id = $periode.$hari;
			$data_path = $data['upload_data']['full_path'];
			$data_namafile = $data['upload_data']['file_name'];
			
			$data['hasil']=$this->Db_model->get_list_idpdf_buku();
			$status=false;
			foreach ($data['hasil'] as $row){
				$cekid = $row->id_pdf; 
				/*ID SAMA*/
				if($data_id == $cekid){
					$status=true;
				}
			}
			
			if($status==false){
				/*ID BEDA*/
				$insert_data = array(
					'id_pdf' => $data_id,
					'periode' => $periode,
					'hari' => $hari,
					'path'=> $data_path,
					'nama_file' => $data_namafile
				);
		
				$this->simwisuda->insert('pdf_buku_wisuda', $insert_data);//load array to database 
				$this->load->view('upload_success', $data);
				
				$data_status['isi_status']='berhasil';
				$data_status['alasan']='Data Periode <b>'.$periode.'</b> Hari <b>'.$hari.'</b> berhasil dimasukkan';
			}
			else{
				//redirect('mhs/upload_buku');
				//$this->load->view('js_notif');
				$data_status['isi_status']='error';
				$data_status['alasan']='Data Periode <b>'.$periode.'</b> Hari <b>'.$hari.'</b> sudah ada';
				$this->load->view('upload_buku', $data_status);
			}
			
			
				
			
			
			
			//if($data_id==$data["hasil"])
			
			
			//echo get_filenames('./uploads/');
			//$dir = new DirectoryIterator("./uploads/");
			//$dir = "./uploads/";
			/*foreach ($dir as $fileinfo) {
				echo $fileinfo->getFilename() . "\n";
			}
			echo "ini ".$this->input->post('userfile')."\n";
			echo "<br>Periode ".$periode." Hari ".$hari;
			
			echo "<br>Nama ".$data['upload_data']['file_name'];
			echo "<br>Path ".$data['upload_data']['full_path'];*/
			
			
			
			//create array to load to database			
           
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
	
	public function data_buku($id=null){
		//$this->load->library('pagination');
		//$this->load->library('table');
		$data['hasil'] = $this->Db_model->get_data_buku();
		$data['isi_status']='normal';
		$data['alasan']='normal';
		$this->load->view('lihat_pdf', $data);
		
		/*$jml = $this->db->get('pdf_buku_wisuda');

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
		$data['hasil'] = $this->Db_model->get_data_buku($config['per_page'], $id);
		//$data["hasil"] = $this->Db_model->get_data_buku();
		
		$this->load->view('lihat_pdf', $data);*/
	}
	
	public function edit_data_pdf(){
		$data_id = $this->uri->segment(3);
		$data = $this->Db_model->get_edit_buku($data_id);
		foreach($data as $row){
			$value['periode'] = $row->periode;
			$value['hari'] = $row->hari;
			$value['nama_file'] = $row->nama_file;
		}
		$this->load->view('edit_pdf_view',$value);
	}
	
	/*PROSES UPDATE BUKU*
	public function proses_update_bukutanpa(){		
		$periode = $this->input->post('input_periode');
		$hari = $this->input->post('input_hari');
		$nama_file = $this->input->post('nama_file');
		$awal_periode = $this->input->post('periode_awal');
		$awal_hari=$this->input->post('hari_awal');
		
//		if($periode!=||$hari==)
		
		$update_data = array(
			'id_pdf' => $periode.$hari,
			'periode' => $periode,
			'hari' => $hari,
		);
		$this->simwisuda->where('id_pdf', $awal_periode.$awal_hari);
		$this->simwisuda->update('pdf_buku_wisuda', $update_data);//load array to database 
		$status='bisa';
		
		$data['status']='berhasil';
		//$this->load->view('lihat_pdf', $data);
		redirect ('mhs/data_buku');
		
	}*/
	
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
		$path = realpath(APPPATH . base_url()."uploads/".$nama_file);
		delete_files($path);
		//delete_files APPPATH (base_url()."uploads/".$nama_file, true); // Read the file's contents
						
		
		
		
		/*
		if (!delete_files($file_hapus))
		{
			echo 'GAGAL<br>';
		}
		else{
			echo 'File dihapus<br>';
		}*/
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
		$awal_hari=$this->input->post('hari_awal');
		
		
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
			$data_id = $periode.$hari;
			
			$data = array('upload_data' => $this->upload->data());	
			$data_path = $data['upload_data']['full_path'];
			$data_namafile = $data['upload_data']['file_name'];
			
			

			$update_data = array(
				'periode' => $periode,
				'hari' => $hari,
				'path'=> $data_path,
				'nama_file' => $data_namafile
			);
			$this->simwisuda->where('id_pdf', $awal_periode.$awal_hari);
			$this->simwisuda->update('pdf_buku_wisuda', $update_data);//load array to database 
			
			
			$data['hasil'] = $this->Db_model->get_data_buku();
			$data['isi_status']='normal';
			$data['alasan']='Data Berhasil Dirubah';
			$this->load->view('lihat_pdf', $data); 
			$this->load->view('upload_success', $data);
			} 
		}
	
}
?>