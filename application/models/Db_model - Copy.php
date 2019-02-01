<?php
Class Db_model extends CI_Model 
{
	var $simwisuda;
	
	function __construct() 
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		//$this->simwisuda = $this->load->database('simwisuda', TRUE); 
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
						SELECT TOP 1 CONVERT(varchar, TGLKELULUSAN, 106) AS tgl
						FROM IJAZAH
						WHERE (PERIODEWISUDA = '$periode')");
		return $data_lulus;
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
        $data_prodi=$this->db->query("SELECT     *
			FROM         Akademik_SIMITS.dbo.ProgramStudi a INNER JOIN
                      Akademik_SIMITS.dbo.Fakultas b ON a.PS_FA_ID = b.FA_ID");
		return $data_prodi->result();
    }

	public function ambil_fakultas_jurusan($val,$valurutan,$periode)
	{
        $this->simwisuda = $this->load->database('simwisuda', TRUE); 
		if ($valurutan=='NRP')
			{					
				$data_jurusan_akd = "SELECT     b.MA_Nrp, b.MA_IPK, b.MA_WisudaKe, c.MA_JudulTugasAkhir, c.MA_JudulTugasAkhir2, c.MA_JudulTugasAkhir3, c.MA_JudulTugasAkhir4, c.MA_IDPredikatKelulusan, c.MA_LamaStudi, 
                      mahasiswa_wisuda.MW_ma_AlamatOrtu, mahasiswa_wisuda.MW_ma_AlamatOrtuKota, mahasiswa_wisuda.MW_ma_telpOrtu, mahasiswa_wisuda.MW_ma_Email, 
                      mahasiswa_wisuda.MW_ma_Foto, mahasiswa_wisuda.MW_ma_nama, c.MaDL_Nip1, c.maDL_Nip2, c.MaDL_Nip3, mahasiswa_wisuda.MW_ma_namaAyah, mahasiswa_wisuda.MW_ma_tgllahir, 
                      mahasiswa_wisuda.MW_ma_tmplahir, Pegawai.PE_NamaLengkap AS Pembimbing1, ds2.PE_NamaLengkap AS Pembimbing2, ds3.PE_NamaLengkap AS Pembimbing3, 
                      CAST(DAY(mahasiswa_wisuda.MW_ma_tgllahir) AS VARCHAR(2)) + ' ' + DATENAME(MM, mahasiswa_wisuda.MW_ma_tgllahir) + ' ' + CAST(YEAR(mahasiswa_wisuda.MW_ma_tgllahir) 
                      AS VARCHAR(4)) AS tgl, b.MA_NamaLengkap, b.MA_TmpLahir, b.MA_AlamatKota, b.MA_Email, b.MA_NamaAyah, b.MA_NamaIbu, b.MA_AlamatOrtu, CAST(DAY(b.MA_TglLahir) AS VARCHAR(2)) 
                      + ' ' + DATENAME(MM, b.MA_TglLahir) + ' ' + CAST(YEAR(b.MA_TglLahir) AS VARCHAR(4)) AS MA_tgl, b.MA_TelpOrtu, 
				FROM         Mahasiswa b INNER JOIN
									Mahasiswa_dataKelulusan c ON b.MA_Nrp = c.MADL_NRP INNER JOIN
									mahasiswa_wisuda ON c.MADL_NRP = mahasiswa_wisuda.MW_ma_nrp INNER JOIN
									Pegawai ON c.MaDL_Nip1 = Pegawai.PE_Nip LEFT OUTER JOIN
									Pegawai ds2 ON c.maDL_Nip2 = ds2.PE_Nip LEFT OUTER JOIN
									Pegawai ds3 ON c.MaDL_Nip3 = ds3.PE_Nip
				WHERE     (b.MA_WisudaKe LIKE '$periode') AND (LEFT(b.MA_Nrp, 2) + SUBSTRING(b.MA_Nrp, 5, 3) LIKE '$val%')
				ORDER BY b.MA_Nrp
				";
				
				
				$data_jurusan = "SELECT     ij.NRP, ij.NAMA, ij.TMPLAHIR, ij.TGLLAHIR, ij.ALAMAT, ij.KOTA, ij.TELP, ij.NAMAORTU, ij.IPK, ij.LAMASTUDI, ij.PREDIKAT, ij.email, ij.pembimbing1, ij.pembimbing2, ij.pembimbing3, 
                      mw.MW_ma_Foto, mhs.MA_TmpLahir, mhs.MA_TglLahir, mhs.MA_AlamatKota, mhs.MA_TelpOrtu, mhs.MA_NamaAyah, ij.JUDULTA, CAST(DAY(ij.TGLLAHIR) AS VARCHAR(2)) + ' ' + DATENAME(MM, ij.TGLLAHIR) + ' ' + CAST(YEAR(ij.TGLLAHIR) AS VARCHAR(4)) AS tgl, CAST(DAY(mhs.MA_TglLahir) AS VARCHAR(2)) + ' ' + DATENAME(MM, mhs.MA_TglLahir) + ' ' + CAST(YEAR(mhs.MA_TglLahir) 
                      AS VARCHAR(4)) AS ma_tgl,  NRP, SUBSTRING(NRP, 0, 5) AS satu, SUBSTRING(NRP, 5, 3) AS dua
				FROM IJAZAH ij LEFT OUTER JOIN
					 Akademik_SIMITS.dbo.mahasiswa_wisuda mw ON ij.NRP = mw.MW_ma_nrp LEFT OUTER JOIN
					 Akademik_SIMITS.dbo.Mahasiswa mhs ON ij.NRP = mhs.MA_Nrp
				WHERE (ij.PERIODEWISUDA = '$periode') AND (LEFT(ij.NRP, 2) + SUBSTRING(ij.NRP, 5, 3) LIKE '$val%')	
				ORDER BY dua, satu				
				";
			}
		else	
			{	
				$data_jurusan = "SELECT     ij.NRP, ij.NAMA, ij.TMPLAHIR, ij.TGLLAHIR, ij.ALAMAT, ij.KOTA, ij.TELP, ij.NAMAORTU, ij.IPK, ij.LAMASTUDI, ij.PREDIKAT, ij.email, ij.pembimbing1, ij.pembimbing2, ij.pembimbing3, 
                      mw.MW_ma_Foto, mhs.MA_TmpLahir, mhs.MA_TglLahir, mhs.MA_AlamatKota, mhs.MA_TelpOrtu, mhs.MA_NamaAyah, ij.JUDULTA, CAST(DAY(ij.TGLLAHIR) AS VARCHAR(2)) + ' ' + DATENAME(MM, 
                      ij.TGLLAHIR) + ' ' + CAST(YEAR(ij.TGLLAHIR) AS VARCHAR(4)) AS tgl, CAST(DAY(mhs.MA_TglLahir) AS VARCHAR(2)) + ' ' + DATENAME(MM, mhs.MA_TglLahir) + ' ' + CAST(YEAR(mhs.MA_TglLahir) 
                      AS VARCHAR(4)) AS ma_tgl, ij.NRP AS Expr1, SUBSTRING(ij.NRP, 0, 5) AS satu, SUBSTRING(ij.NRP, 5, 3) AS dua
				FROM         sim_wisuda.dbo.IJAZAH ij LEFT OUTER JOIN
									mahasiswa_wisuda mw ON ij.NRP = mw.MW_ma_nrp LEFT OUTER JOIN
									Mahasiswa mhs ON ij.NRP = mhs.MA_Nrp
				WHERE     (ij.PERIODEWISUDA = '$periode') AND (LEFT(ij.NRP, 2) + SUBSTRING(ij.NRP, 5, 3) LIKE '$val%')
				ORDER BY ij.IPK DESC";
			}		
		//$result = $this->db->query($data_jurusan);        
        $result = $this->simwisuda->query($data_jurusan);        
        return $result;
    }
	
	public function foto_mhs($nrp){
		$query = "SELECT     MW_ma_Foto
					FROM         Akademik_SIMITS.dbo.mahasiswa_wisuda
					WHERE     (MW_ma_nrp LIKE '$nrp')				
				";
		$hasil = $this->db->query($query);
        return $hasil->result();
	}
	
	public function fakultas_jurusan_program($val){
            /*$query = "
               SELECT     SUBSTRING(Akademik_SIMITS.dbo.ProgramStudi.PS_Nama, 0, 3) AS PS_Nama, Akademik_SIMITS.dbo.Jurusan.JU_Nama, Akademik_SIMITS.dbo.Fakultas.FA_Nama, 
                      Akademik_SIMITS.dbo.ProgramStudi.PS_FA_ID + Akademik_SIMITS.dbo.ProgramStudi.PS_JU_ID + Akademik_SIMITS.dbo.ProgramStudi.PS_ID AS kojur, 
                      Akademik_SIMITS.dbo.ProgramStudi.PS_Nama AS Nama
				FROM         Akademik_SIMITS.dbo.ProgramStudi INNER JOIN
									Akademik_SIMITS.dbo.Jurusan ON Akademik_SIMITS.dbo.ProgramStudi.PS_FA_ID = Akademik_SIMITS.dbo.Jurusan.JU_FA_ID AND 
									Akademik_SIMITS.dbo.ProgramStudi.PS_JU_ID = Akademik_SIMITS.dbo.Jurusan.JU_ID INNER JOIN
									Akademik_SIMITS.dbo.Fakultas ON Akademik_SIMITS.dbo.Jurusan.JU_FA_ID = Akademik_SIMITS.dbo.Fakultas.FA_ID
				WHERE     (Akademik_SIMITS.dbo.ProgramStudi.PS_FA_ID + Akademik_SIMITS.dbo.ProgramStudi.PS_JU_ID + Akademik_SIMITS.dbo.ProgramStudi.PS_ID LIKE '$val%')
                ";*/
			$this->simwisuda = $this->load->database('simwisuda', TRUE); 
			$query = "SELECT TOP 1    
					SUBSTRING(Akademik_SIMITS.dbo.ProgramStudi.PS_Nama, 0, 3) AS PS_Nama, Akademik_SIMITS.dbo.Jurusan.JU_Nama, 		Akademik_SIMITS.dbo.Fakultas.FA_Nama, Akademik_SIMITS.dbo.ProgramStudi.PS_FA_ID + Akademik_SIMITS.dbo.ProgramStudi.PS_JU_ID + Akademik_SIMITS.dbo.ProgramStudi.PS_ID AS kojur, Akademik_SIMITS.dbo.ProgramStudi.PS_Nama AS Nama, pr.lulusan_ke
				FROM 
					Akademik_SIMITS.dbo.ProgramStudi INNER JOIN
                    Akademik_SIMITS.dbo.Jurusan ON Akademik_SIMITS.dbo.ProgramStudi.PS_FA_ID = Akademik_SIMITS.dbo.Jurusan.JU_FA_ID AND 
                    Akademik_SIMITS.dbo.ProgramStudi.PS_JU_ID = Akademik_SIMITS.dbo.Jurusan.JU_ID INNER JOIN
                    Akademik_SIMITS.dbo.Fakultas ON Akademik_SIMITS.dbo.Jurusan.JU_FA_ID = Akademik_SIMITS.dbo.Fakultas.FA_ID LEFT OUTER JOIN
                    PRODI pr ON Akademik_SIMITS.dbo.ProgramStudi.PS_FA_ID + Akademik_SIMITS.dbo.ProgramStudi.PS_JU_ID + Akademik_SIMITS.dbo.ProgramStudi.PS_ID = pr.KODEPRODI
				WHERE (Akademik_SIMITS.dbo.ProgramStudi.PS_FA_ID + Akademik_SIMITS.dbo.ProgramStudi.PS_JU_ID + Akademik_SIMITS.dbo.ProgramStudi.PS_ID LIKE '$val%') AND (pr.lulusan_ke IS NOT NULL)
			";
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
		
	public function get_lulusanke(){
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
		$query = "SELECT     KODEPRODI, NAMAPRODI, lulusan_ke
				FROM PRODI
				WHERE (SUBSTRING(KODEPRODI, 5, 1) LIKE '0') OR (SUBSTRING(KODEPRODI, 5, 1) LIKE '1')
		";
		$hasil = $this->simwisuda->query($query);
        return $hasil->result();
	}
	
	public function get_data_buku(){
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
		$query = "SELECT periode, hari, path, nama_file
				FROM pdf_buku_wisuda 
				ORDER BY periode.hari DESC";
		$hasil = $this->simwisuda->query($query);
        return $hasil->result();
	}
	
	public function get_edit_buku($id){
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
		$query = "SELECT *
				FROM pdf_buku_wisuda 
				WHERE id_pdf like '$id'";
		$hasil = $this->simwisuda->query($query);
        return $hasil->result();
	}
	
	public function get_list_idpdf_buku(){
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
		$query = "SELECT id_pdf FROM pdf_buku_wisuda";
		$hasil = $this->simwisuda->query($query);
        return $hasil->result();
	}
	
	/*Menampilkan Data Kelulusan ke yang Akan Diedit*/
	public function get_edit_lulusanke($id){
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
		$query = "SELECT     KODEPRODI, NAMAPRODI, lulusan_ke
				FROM         PRODI
				WHERE     KODEPRODI like '$id'";
		$hasil = $this->simwisuda->query($query);
        return $hasil->result();
	}
	
	public function update_lulusanke($kode, $lulusan){
		$this->simwisuda = $this->load->database('simwisuda', TRUE); 
		/*$update_data = array(
			'lulusan_ke' => $lulusan
		);*/
		$query = "UPDATE    PRODI
				SET lulusan_ke = '$lulusan'
				WHERE (KODEPRODI LIKE '$kode%')";
		$this->simwisuda->query($query);
		
	}
	
	

}
?>