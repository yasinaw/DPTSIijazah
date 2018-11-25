<?php
class kursiwisuda extends CI_Controller
{
	private $nama_pengguna;
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Db_kursi','',TRUE);
		$this->load->model('Db_model','',TRUE);
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
		
		if($hak_akses!='KURSI'){
			redirect(base_url(), 'refresh');
		}
		//;$data['sess_nama'] = $nama_user;
		$this->nama_pengguna = $nama_user;
		//echo $hak_akses.'-'.$session_data['nama_user'];
		//echo anchor(base_url().'login/logout');
				
	}
	
	public function index()
	{
		$this->load->model('Db_kursi','',TRUE);
		$data["data_jadwal"] = $this->Db_kursi->ambil_jadwal();
		$data['namauser'] = $this->nama_pengguna;
		$this->load->view('kursi/kursi', $data);
	}
	
	public function pengaturan_kursi()
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
	
	public function generate_kursi()
	{
		$this->load->helper('pdf_helper');
        $this->load->model('Db_kursi','',TRUE);
		//$this->load->model('Db_kursi','simwisuda',TRUE);
		$buku=$_GET['hari'];
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
		$kursikiri = $this->input->post('kursikiri');
		$kursikanan = $this->input->post('kursikanan');
		$cetak = $this->input->post('cetak');
		$nbaris = $this->input->post('nbaris');
		
		$data2["cek_insert"] = $this->input->post('cek_insert');		
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
		$data2["banyak_baris"] = $this->input->post('banyak_baris');	
		
		$tanggal_indo=date('D, d M Y', strtotime($tanggalwisuda));
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
		
		$data2["tanggal_id"] = konversi($tanggal_indo);
		//$data2["kursikiri"] = $kursikiri;
		//$data2["kursikanan"] = $kursikanan;
		$data2["cetak"] = $cetak;
		$data2["nbaris"] = $nbaris;
		
		for ($i=1; $i<=$nbaris; $i++)
		{
			$data_kursikiriarr[$i]=$this->input->post('kursikiri'.$i);
			$data_kursikananarr[$i]=$this->input->post('kursikanan'.$i);
		}
	    
		$data2["data_kursikiri"]=$data_kursikiriarr;
		$data2["data_kursikanan"]=$data_kursikananarr;
		
		
		
		$this->load->view('kursi/pdfreport', $data2);
    }
	
	public function sisipanwisuda(){
		$data['isi_status']='normal';
		$data['namauser'] = $this->nama_pengguna;
		$this->load->view('kursi/cari_mhs_sisip', $data);			
	}
	
	public function carimhs(){
		$nrp = $this->input->post('input_nrp');			
		$this->form_validation->set_rules('input_nrp', 'NRP', 'required|xss_clean|min_length[10]|max_length[10]');
		$this->form_validation->set_message('required', 'Wajib isi NRP');
		$this->form_validation->set_message('min_length', 'Jumlah Karakter %s Kurang Dari %s');
		$this->form_validation->set_message('max_length', 'Jumlah Karakter %s Lebih Dari %s');
		$data['isi_status']='normal';
		
		if($this->form_validation->run()==false)
        {	
			//Field validation failed.  User redirected to login page
			$data['namauser'] = $this->nama_pengguna;
			$this->load->view('kursi/cari_mhs_sisip', $data);			
		}
		else
		{	
			$data['hasil'] = $this->Db_kursi->cari_nrp($nrp);			
			if($data['hasil'] == null)
			{
				$data['check_database']= 'Maaf, Data Tidak Ditemukan.';
				$data['namauser'] = $this->nama_pengguna;
				//Field validation failed.  User redirected to login page
				$this->load->view('kursi/cari_mhs_sisip',$data);
			}
			else
			{
				foreach($data['hasil'] as $row){
				//echo 'cak';
				$data['namauser'] = $this->nama_pengguna;
				$data['nrp'] = $row->NRP;
				$data['nama'] = $row->NAMA; 
				$data['periode'] = $row->PERIODEWISUDA;
				$data['prosesi'] = $row->PROSESI_WISUDA;
				}
				$this->load->view('kursi/mhs_sisip', $data);
			}
		}
		
		
	}
	
	public function sisip_mhs(){
		$nrp = $this->input->post('input_nrp');
		$prosesi = $this->input->post('input_prosesi');
		$nama = $this->input->post('input_nama');
		$periode = $this->input->post('input_periode');
		
		$update_data = array(
					'PROSESI_WISUDA' => $prosesi
				);
		$this->simwisuda->where('NRP', $nrp);
		$this->simwisuda->update('IJAZAH', $update_data);//Update data to database 
		//$data['hasil'] = $this->Db_kursi->update_prosesi($nrp, $prosesi);
		  
		  
		$data['namauser'] = $this->nama_pengguna;
		$data['nrp'] = $nrp;
		$data['nama'] = $nama;
		$data['periode'] = $periode;
		$data['prosesi'] = $prosesi;
		$data['isi_status']='berhasil';
		$data['alasan']='Data Prosesi Wisuda  Berhasil Dirubah<br>Menjadi<br>Prosesi Wisuda : '.$prosesi;
		//echo $this->nama_pengguna.'adhoshdi';
		$this->load->view('kursi/sisip_sukses',$data);		
	}
} 
?>