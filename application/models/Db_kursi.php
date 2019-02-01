<?php
Class Db_kursi extends CI_Model 
{
	var $simwisuda;
	
	function __construct() 
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
	}
	
	public function simwisuda_model(){		
        parent::Model();
        $this->simwisuda = $this->load->database('simwisuda', TRUE);   
	} 
	
	function ambil_data() 
	{
		$data_mhs=$this->db->query("SELECT * FROM yudisium_jadwal");
		return $data_mhs;
	}
	
	public function ambil_jadwal(){	
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
		$data_jadwal = $this->simwisuda->query("SELECT DISTINCT PERIODEWISUDA FROM IJAZAH");
		return $data_jadwal;
	}
	/*TANGGAL KELULUSAN*/
	public function ambil_kelulusan($periode){	
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
		$data_lulus = $this->simwisuda->query("
					SELECT     TOP 1 TGLKELULUSAN
					FROM         IJAZAH
					WHERE     (PERIODEWISUDA = '$periode') ");
		//print_r($data_lulus);
		return $data_lulus->result();
	}
	
	/*BIDANG KEAHLIAN*/
	public function ambil_prodi_simwisuda($kode){	
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
		//$data_prodi = "SELECT * FROM PRODI WHERE KODEPRODI='$kodeprodi'";
		$data_prodi = "SELECT SUBSTRING(NAMAPRODI, 1, CHARINDEX(' ', NAMAPRODI) - 1) AS Jenjang
		, SUBSTRING(NAMAPRODI, CHARINDEX(' ', NAMAPRODI) + 1, LEN(NAMAPRODI)) AS BidangKeahlian
		FROM PRODI
		WHERE (KODEPRODI LIKE '$kode%')";
		$result = $this->simwisuda->query($data_prodi); 
		return $result;
	}
	
	
	public function ambil_data_prodi()
	{
		//$this->simwisuda = $this->load->database('simwisuda', TRUE); 
	
        $data_prodixx=$this->db->query("SELECT     *
			FROM         Akademik_SIMITS.dbo.ProgramStudi a INNER JOIN
                      Akademik_SIMITS.dbo.Fakultas b ON a.PS_FA_ID = b.FA_ID");
		$data_prodi=$this->simwisuda->query("SELECT     a.KODEPRODI, a.NAMAPRODI, b.NAMAFAKULTAS_2, b.NAMASINGKATAN
					FROM PRODI a INNER JOIN
					FAKULTAS b ON SUBSTRING(a.KODEPRODI, 1, 1) = b.KODEFAKULTAS");
		//$result = $this->simwisuda->query($data_prodi); 
		//return $result;
		return $data_prodi->result();
    }

	public function ambil_fakultas_jurusan($val,$valurutan,$periode)
	{
        $this->simwisuda = $this->load->database('simwisuda', TRUE); 
		if ($valurutan=='NRP')
			{					
				$data_jurusan = "SELECT    PERIODEWISUDA, NRP, NAMA, TMPLAHIR, TGLLAHIR, ALAMAT, KOTA, TELP, NAMAORTU, IPK, LAMASTUDI, PREDIKAT, email, pembimbing1, pembimbing2, pembimbing3, JUDULTA, SUBSTRING(NRP, 0, 5) AS satu, 
                      SUBSTRING(NRP, 5, 3) AS dua,  CAST(DAY(TGLLAHIR) AS VARCHAR(2)) + ' ' + DATENAME(MM, TGLLAHIR) + ' ' + CAST(YEAR(TGLLAHIR) AS VARCHAR(4)) AS tgllahir_indo
				FROM         IJAZAH ij
				WHERE     (LEFT(NRP_URUT, 2) + SUBSTRING(NRP_URUT, 5, 3) LIKE '$val%') AND (PROSESI_WISUDA LIKE '$periode')
				ORDER BY LEFT(NRP_URUT,2)+SUBSTRING(NRP_URUT,5,3), NRP				
				";
			}
		else	
			{	
				$data_jurusan = "SELECT     NRP, NAMA, TMPLAHIR, TGLLAHIR, ALAMAT, KOTA, TELP, NAMAORTU, IPK, LAMASTUDI, PREDIKAT, email, pembimbing1, pembimbing2, pembimbing3, JUDULTA, SUBSTRING(NRP, 0, 5) AS satu, 
                      SUBSTRING(NRP, 5, 3) AS dua,  CAST(DAY(TGLLAHIR) AS VARCHAR(2)) + ' ' + DATENAME(MM, TGLLAHIR) + ' ' + CAST(YEAR(TGLLAHIR) AS VARCHAR(4)) AS tgllahir_indo
				FROM         IJAZAH ij
				WHERE     (LEFT(NRP, 2) + SUBSTRING(NRP, 5, 3) LIKE '$val%') AND (PERIODEWISUDA LIKE '$periode')
				ORDER BY IPK DESC";
			}		
		//$result = $this->db->query($data_jurusan);        
        $result = $this->simwisuda->query($data_jurusan);        
        return $result;
    }
	
	public function fakultas_jurusan_program($val){
			$this->simwisuda = $this->load->database('simwisuda', TRUE); 
			$query = "SELECT     TOP 1 PRODI.KODEPRODI, PRODI.NAMAPRODI, FAKULTAS.NAMAFAKULTAS, FAKULTAS.NAMAFAKULTAS_2, 		FAKULTAS.NAMASINGKATAN, JURUSAN.NAMAJURUSAN
			FROM         PRODI INNER JOIN
								FAKULTAS ON SUBSTRING(PRODI.KODEPRODI, 1, 1) = FAKULTAS.KODEFAKULTAS INNER JOIN
								JURUSAN ON SUBSTRING(PRODI.KODEPRODI, 1, 2) = JURUSAN.KODEJURUSAN
			WHERE     (PRODI.KODEPRODI LIKE '$val%')";
			$result = $this->simwisuda->query($query);        
            return $result;
        }
		
	public function pembimbing1($nrp){
		$query = "
               SELECT     Mahasiswa_dataKelulusan.MADL_NRP, Mahasiswa_dataKelulusan.MaDL_Nip1, Pegawai.PE_NamaLengkap
			FROM         Mahasiswa_dataKelulusan INNER JOIN
								  Pegawai ON Mahasiswa_dataKelulusan.MaDL_Nip1 = Pegawai.PE_Nip
			WHERE     (Mahasiswa_dataKelulusan.MADL_NRP LIKE '$nrp')
               ";
           $result = $this->db->query($query);  
           return $result;
	}
	
		public function pembimbing2($nrp){
			$query = "
                SELECT     Mahasiswa_dataKelulusan.MADL_NRP, Mahasiswa_dataKelulusan.maDL_Nip2, Pegawai.PE_NamaLengkap
				FROM         Mahasiswa_dataKelulusan INNER JOIN
									  Pegawai ON Mahasiswa_dataKelulusan.maDL_Nip2 = Pegawai.PE_Nip
				WHERE     (Mahasiswa_dataKelulusan.MADL_NRP LIKE '$nrp')
                ";
            $result = $this->db->query($query);  
            return $result;
		}
	
	public function get_foto(){
            $nrp = $_GET('nrp_mhs');
            $query = "
                SELECT MW_ma_Foto
                FROM mahasiswa_wisuda
                WHERE MA_Nrp = '$nrp'
                ";
                //echo $query;
            $result = $this->db->query($query);
            return $result;
        }
		
	public function cari_nrp($nrp){
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
		$query = "SELECT     NRP, NAMA,PERIODEWISUDA, PROSESI_WISUDA
				FROM         IJAZAH
				WHERE     NRP like '$nrp'";
		$hasil = $this->simwisuda->query($query);
		return $hasil->result();
	}
	
	public function update_prosesi($nrp, $prosesi){
		$update_data = array(
					'PROSESI_WISUDA' => $prosesi
				);
		$this->simwisuda->where('NRP', $nrp);
		$this->simwisuda->update('IJAZAH', $update_data);//Update data to database 	
	}
	
	public function cekinsert_kursi($nrp){
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
		$query = "SELECT     *
				FROM         kursiwisuda
				WHERE     nrp like '$nrp'";
		$hasil = $this->simwisuda->query($query);
		return $hasil->result();
	}

}
?>