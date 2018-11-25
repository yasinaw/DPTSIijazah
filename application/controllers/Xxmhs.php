<?php
Class Mhs extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Db_model','',TRUE);
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
		$this->load->view('upload_buku');
	}
	
	public function tes_gambar(){
    $data_foto = $this->Db_model->get_foto();
        
        foreach ($data_foto->result_array() as $row) {
            header('Content-type:image');
            echo $row['MA_Photo'];
            break;
        }    
	}
		
}
?>