<?PHP
	tcpdf();
	ini_set("memory_limit","512M");
    	
	$this->load->helper('url');
	$title = "WISUDA ".$periodewisuda;
	$judul = '\n'.'Tanggal Wisuda';
	//$pdf = new TCPDF("P", "mm",$ukurankertas, true, 'UTF-8', false); //DEFULT UTF-8 UNICODE
	if ($ukurankertas=='ITS PAPER')
		{
			//$pdf = new TCPDF("P", "mm",array(190,230), false, 'ISO-8859-1', false);
			$pdf = new TCPDF("P", "mm",array(190,230), true, 'UTF-8', false); //DEFULT UTF-8 UNICODE
		}
	else
		{
			$pdf = new TCPDF("P", "mm",$ukurankertas, false, 'ISO-8859-1', false);			
		}
	$pdf->SetAuthor('TC');
	$pdf->SetTitle($title, $judul);
	$pdf->SetSubject('Cetak Buku Wisuda');
	$pdf->SetKeywords('wisuda, PDF');
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title);
	//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	$pdf->SetDefaultMonospacedFont('helvetica');
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$pdf->SetMargins($marginleft, $margintop, $marginright);
	$pdf->SetAutoPageBreak(TRUE, $marginbottom);
	$pdf->SetFont('arial', '', 8);
	$pdf->setFontSubsetting(false);
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	
	setlocale (LC_TIME, 'INDONESIA');
	//$tanggalcoba=date(strtotime($tanggal));
	/*$tanggal_indo=date("d M Y",($tanggal));
	
	function konversi($tanggal_indo)
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
	}*/
 
// Fri, 04 Jun 1993
//$tanggal = date('D, d M Y', strtotime('06/04/1993'));
 
// Jumat, 04 Juni 1993
//echo konversi($tanggalcoba);
	
	$program='';
	$fakultas='';
	$jurusan='';
	$nama_program='';
	$lulusan_ke='';
	$lebih='';
	if($ukurankertas == 'A4'){
		$tinggi_kertas = 295;
	}
	else if($ukurankertas == 'A5'){
		$tinggi_kertas = 210;
	}
	else if($ukurankertas == 'B5'){
		$tinggi_kertas = 249;
	}
	else if($ukurankertas == 'F4'){
		$tinggi_kertas = 329;
	}
	else if($ukurankertas == 'ITS PAPER'){
		$tinggi_kertas = 230;
	}
				
	$halaman=0;
	foreach ($data_prodi as $key => $value) 
		{
			$halaman=$halaman+1;
			$pdf->AddPage();
			//$pdf->setPage($halaman, true);
									
			$no=0;	
			$jumlah=1;
			$ip=0;
			$lamastudi=0;
			
			$nolj=0;	
			$iplj=0;
			$lamastudilj=0;
			$html='';
			$iprata2=0;
			$lamastudirata2=0;
			
			$no_kerjasama=0;
			$ip_kerjasama=0;
			$lamastudi_kerjasama=0;
			$ip_kerjasama_rata2='';
			$lamastudirata2_kerjasama=0;
			
			$cek_lj = false;
			$cek_kj = false;
			
			$valarr = explode("-", $value); 
			/*TANGGAL KELULUSAN*/
			$data_tglperiode = $this->Db_model->ambil_kelulusan($periodewisuda);
			foreach ($data_tglperiode->result_array() as $row)
			{
				$tglkelulusan = $row['tgl'];		
				$tanggal_indo=date("d M Y",strtotime($tglkelulusan));
				if (!function_exists('konv')) 
				{
					function konv($tglkelulusan)
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
						return strtr($tglkelulusan, $format);
					}
					$konv_tgl=konv($tglkelulusan);
				}
			}
			
			$tinggi = ($tinggi_kertas-$margintop-$marginbottom)."mm";
			$html=$html."
			<style>
				 td.tes {
					border-style:double;
				}
				td.atas {
					border-top: 1px solid black;
				}
				td.bawah {
					border-bottom: 1px solid black;
				}
			</style>
			
				
			
			<!-- HALAMAN 1 -->
	<table>
		<tr>
			<td width=\"162mm\"><img src=\"/simwisuda/inc/atas.png\" style=\"width: '2500'; height: 80\" ></td>
		</tr>
		<tr>
		<td style=\"height:215mm\">
			<table width=\"100%\">	
				<tr>					
					<td>
						<table>
						<tr>
							<td valign=\"middle\" width=\"2%\" >
								<!-- GAMBAR BORDER KIRI -->
								<br>
								<img src=\"/simwisuda/inc/side.png\" style=\"width: 30; height: 2000\" >
								
							</td>
							<td style=\"width:'94%'; height:215mm\">
							<table  width='100%'>
								<tr>
									<td style=\"width:'100%'; height:200mm\">";	
			
			/*
			$data_tgl_kelulusan = $this->Db_model->fakultas_jurusan_program($periodewisuda);
			foreach ($data_tgl_kelulusan->result_array() as $row)
			{
				$tgl_lulus = $row['TGLKELULUSAN'];			
			}*/
			
			$data_lulusanke = $this->Db_model->lulusanke($valarr[0]);
			foreach ($data_lulusanke as $row)
			{
				$lulusan_ke = ($row->lulusan_ke)+1;	
			}
			
			$fak_jur_prog = $this->Db_model->fakultas_jurusan_program($valarr[0]);
			foreach ($fak_jur_prog->result_array() as $row)
			{
				//$fakultas = $row['FA_Nama'];
				//$jurusan = $row['JU_Nama'];
				//$program = $row['PS_Nama'];
				////$lulusan_ke = 1001;	
				//$kojur = $row['kojur'];
				
				$fakultas = $row['NAMAFAKULTAS_2'];
				$jurusan = $row['NAMAJURUSAN'];
				//$program = $row['PS_Nama'];
				$kojur = $row['KODEPRODI'];
				
				if(substr($kojur, 2, 2) == 30){
					$program = 'S3';
				}
				else if(substr($kojur, 2, 2) == 20){
					$program = 'S2';
				}
				else if(substr($kojur, 2, 2) == 10){
					$program = 'S1';
				}
				else if(substr($kojur, 2, 2) == 04){
					$program = 'D4';
				}
				else if(substr($kojur, 2, 2) == 03){
					$program = 'D3';
				}
				
				//$lulusan_ke = 1001;	
				
			}
			
			$nama_judul='';			
			if($program == 'S3'){
				$nama_program = "Doktor (S-3)";
				$nama_judul='Judul Disertasi:';	
			}
			else if($program == 'S2' || substr($kojur,2,1) == '2'){
				$nama_program = "Magister (S-2)";
				$nama_judul='Judul Thesis:';	
			}
			else if($program == 'S1'){
				$nama_program = "Sarjana (S-1)";
				$nama_judul='Judul TA:';	
			}
			else if($program == 'D3'){
				$nama_program = "Diploma (D-III)";
				$nama_judul='Judul TA:';
			}
			else if($program == 'D4'){
				$nama_program = "Diploma (D-IV)";
				$nama_judul='Judul TA:';
			}
				
			//$pdf->setCellPaddings(5,0,0 ,0);
			//$html=$html."".$nama_program."";
									
			$fak_jur = $this->Db_model->ambil_fakultas_jurusan($valarr[0],$urutandata,$periodewisuda);						
			$ctr=0;
			foreach ($fak_jur->result_array() as $row)
            {	
				$ctr=$ctr+1;
				/*AKADEMIK*/
				//$nrptbl[$ctr]=$row['MA_Nrp'];
				//$namatbl[$ctr]=ucwords(strtolower($row['MW_ma_nama']));
				//$ipktbl[$ctr]=$row['MA_IPK'];
				//$lamastuditbl[$ctr]=$row['MA_LamaStudi'];
				//$predikatkelulusantbl[$ctr]=$row['MA_IDPredikatKelulusan'];
				//$lulusanketbl[$ctr]=substr($row['MA_Nrp'],4,3);
				//$mhskojurtbl[$ctr]=$row['mhs_kojur'];
				
				/*SIM WISUDA*/
				$nrptbl[$ctr]=$row['NRP'];
				$namatbl[$ctr]=ucwords(strtolower($row['NAMA']));
				$ipktbl[$ctr]=$row['IPK'];
				$lamastuditbl[$ctr]=$row['LAMASTUDI'];
				$predikat[$ctr]=$row['PREDIKAT'];
				$lulusanketbl[$ctr]=substr($row['NRP'],4,3);
				
				if($predikat[$ctr] == 'D'){
					$predikat[$ctr] = 'DP';
				}
				else if($predikat[$ctr] == 'S'){
					$predikat[$ctr] = 'SM';
				}
				
			}	
			$cekbidangkeahlian=0;	
			$ctrbaris=0;
			$html=$html.'
				<style>
					 td.tes {
						border-style:double;
					}
					td.atas {
						border-top: 1px solid black;
					}
					td.bawah {
						border-bottom: 1px solid black;
					}
				</style>
						
				<!-- KEPALA BUKU HAL 1 -->
					<div align="center">
					<table border="0" align="center">
					<h3 align=\"center\">
						DAFTAR PESERTA WISUDA KE-'.$periodewisuda.'<br>
						INSTITUT TEKNOLOGI SEPULUH NOPEMBER<br>
						Tanggal Lulus : '.$konv_tgl.' <br>
						Tanggal Wisuda : '.$tanggal_id.'
					</h3>
							<tr border="1">
								<td style="width:1%" ></td>
								<td align="left">
									Fakultas <br>
									Jurusan <br>
									Program
								</td>
								<td align="left" colspan="5">
									: '.$fakultas.'<br>
									: '.$jurusan.'<br>
									: '.$nama_program.'<br>
								</td>									
							</tr>
							<tr>
								<td style="width:1%"></td>
								<td style="width:5%" class="atas"></td>
								<td style="width:15%" class="atas"></td>
								<td style="width:40%" class="atas"></td>
								<td style="width:6%" class="atas"></td>
								<td style="width:8%" class="atas">LAMA</td>
								<td style="width:13%" class="atas"></td>
								<td style="width:13%" class="atas">LULUSAN</td>
								
							</tr>
							<tr>
								<td style="width:1%"></td>
								<td style="width:5%">NO</td>
								<td style="width:15%"><br/>NRP</td>
								<td style="width:40%"><br>N A M A </td>
								<td style="width:6%">IP</td>
								<td style="width:8%">STUDI (SEM)</td>
								<td style="width:13%">PREDIKAT</td>				
								<td style="width:13%"><pre>
									<br>KE</pre></td>		
								
							</tr>
							<tr>
									<td style="width:1%"></td>
									<td style="height:3mm" class="atas" colspan="7"></td>
									
							</tr>
						';
			$var_tempnrp="";
			$var_prodisimwisuda="";
			$flag=1;
			//$cekbidangkeahlian=0;	
			//$ctrbaris=0;
			for ($j=1; $j<=$ctr; $j++)
			{
				$no=$no+1;
				
				
				if($program=='S2'){
					$ctrbaris=$ctrbaris+1;
				}
				else{
					$ctrbaris=$ctrbaris+1;
				}
				
				//$jumlah=$jumlah+1;
				if ($flag==0)
					{
						$tinggi = ($tinggi_kertas-$margintop-$marginbottom)."mm";
						
						$html=$html."
			<style>
				 td.tes {
					border-style:double;
				}
				td.atas {
					border-top: 1px solid black;
				}
				td.bawah {
					border-bottom: 1px solid black;
				}
			</style>
			
			<!-- HALAMAN >1 -->
		<table>
		<tr>
			<td width=\"162mm\"><img src=\"/simwisuda/inc/atas.png\" style=\"width: '2500'; height: 80\" ></td>
		</tr>
		<tr>
		<td style=\"height:215mm\">
			<table width=\"100%\">	
				<tr>					
					<td>
						<table>
						<tr>
							<td valign=\"middle\" width=\"2%\" >
								<!-- GAMBAR BORDER KIRI -->
								<br>
								<img src=\"/simwisuda/inc/side.png\" style=\"width: 30; height: 2000\" >
								
							</td>
							<td style=\"width:'94%'; height:215mm\">
							<table  width='100%'>
								<tr>
									<td style=\"width:'100%'; height:200mm\">";

						$html=$html.'
				<style>
					 td.tes {
						border-style:double;
					}
					td.atas {
						border-top: 1px solid black;
					}
					td.bawah {
						border-bottom: 1px solid black;
					}
				</style>
						
				<!-- KEPALA BUKU HAL 1 -->
					<div align="center">
					<table border="0" align="center">
					<h3 align=\"center\">
						DAFTAR PESERTA WISUDA KE-'.$periodewisuda.'<br>
						INSTITUT TEKNOLOGI SEPULUH NOPEMBER<br>
						Tanggal Lulus : '.$konv_tgl.' <br>
						Tanggal Wisuda : '.$tanggal_id.'
					</h3>
							<tr border="1">
								<td style="width:1%" ></td>
								<td align="left">
									Fakultas <br>
									Jurusan <br>
									Program
								</td>
								<td align="left" colspan="5">
									: '.$fakultas.'<br>
									: '.$jurusan.'<br>
									: '.$nama_program.'<br>
								</td>									
							</tr>
							<tr>
								<td style="width:1%"></td>
								<td style="width:5%" class="atas"></td>
								<td style="width:15%" class="atas"></td>
								<td style="width:40%" class="atas"></td>
								<td style="width:6%" class="atas"></td>
								<td style="width:8%" class="atas">LAMA</td>
								<td style="width:13%" class="atas"></td>
								<td style="width:13%" class="atas">LULUSAN</td>
								
							</tr>
							<tr>
								<td style="width:1%"></td>
								<td style="width:5%">NO</td>
								<td style="width:15%"><br/>NRP</td>
								<td style="width:40%"><br>N A M A </td>
								<td style="width:6%">IP</td>
								<td style="width:8%">STUDI (SEM)</td>
								<td style="width:13%">PREDIKAT</td>				
								<td style="width:13%"><pre>
									<br>KE</pre></td>		
								
							</tr>
							<tr>
									<td style="width:1%"></td>
									<td style="height:3mm" class="atas" colspan="7"></td>
									
							</tr>
						';			
				
						$flag=1;	
					}
				$cont = 0;
				//if ($var_tempnrp!=substr($nrptbl[$j],0,3).substr($nrptbl[$j],5,2) && $program == 'S2')
				if ($var_tempnrp!=substr($nrptbl[$j],0,2).substr($nrptbl[$j],4,3) && ($program == 'S2'))
				//if ($program == 'S2')
				{
					$cekbidangkeahlian=$cekbidangkeahlian+1;
					$var_kodeprodi=substr($nrptbl[$j],0,2).substr($nrptbl[$j],4,3);
					$var_a = substr($nrptbl[$j],0,2);
					$var_b = substr($nrptbl[$j],4,3);
					$var_c = substr($nrptbl[$j],0,2);
					$var_d = substr($nrptbl[$j],4,3);
					$prodi_simwisuda=$this->Db_model->ambil_prodi_simwisuda($var_kodeprodi);
					foreach ($prodi_simwisuda->result_array() as $rowprodi)
					{
						$var_prodisimwisuda=ucwords(strtolower($rowprodi['BidangKeahlian']));	
					}
					
					$cek_bidang = false;
					if(isset($var_prodisimwisuda)){
						$cek_bidang=true;
						$status_baris=1;
						$html=$html.'	
						<tr>
							<td colspan="8"></td>
						</tr>';
						$ctrbaris=$ctrbaris+1;
						$status_baris=2;
						$html=$html.'
						<tr>
							<td style="width:5mm"></td>
							<td colspan="6" align="left">Bidang Keahlian : '.$var_prodisimwisuda. '</td>
							<td style="width:5mm"></td>
						</tr>';
						$ctrbaris=$ctrbaris+1;
						$status_baris=3;
						$html=$html.'
						<tr>
							<td colspan="8"></td>
						</tr>';
						
					}
					$ctrbaris=$ctrbaris+1;
					
					$cont = $jumlah;
				}
				
							
				$html=$html.'								
				<tr>
					<td style="width:1%"></td>
					<td style="width:5%">'.$no.'</td>
					<td style="width:15%">'.$nrptbl[$j].' </td>
					<td style="width:40%" align="left">'.$namatbl[$j].'</td>
					<td style="width:6%">'.number_format($ipktbl[$j],2).'</td>
					<td style="width:8%">'.$lamastuditbl[$j].'</td>
					<td style="width:13%">'.$predikat[$j].'</td>
					<td style="width:13%">'.$lulusan_ke++.'</td>
					<td style="width:1%"></td>
				</tr>';				
							
				//$var_tempnrp=substr($nrptbl[$j],0,3).substr($nrptbl[$j],5,2);
				$var_tempnrp=substr($nrptbl[$j],0,2).substr($nrptbl[$j],4,3);							
				
				/*PERHITUNGAN IP DAN LAMA STUDI RATA-RATA*/
				if($program == 'S3' || $program == 'S2')//Jika Program S-3
				{
					$ip=$ip+$ipktbl[$j];
					$iprata2=$ip/$no;
					$lamastudi=$lamastudi+$lamastuditbl[$j];
					$lamastudirata2=$lamastudi/$no;
				}
				//$cek_lj = false;
				if($program == 'S1')//Jika Program S-1
				{					
					if(substr($nrptbl[$j],4,3) == '105' || substr($nrptbl[$j],4,3) == '106') //Mahsiswa LJ
					{
						$nolj=$nolj+1;
						$iplj=$iplj+$ipktbl[$j];
						$iprata2lj=$iplj/$nolj;
						$lamastudilj=$lamastudilj+$lamastuditbl[$j];
						$lamastudirata2lj=$lamastudilj/$nolj;
						$cek_lj = true;
					}
					else{
						$ip=$ip+$ipktbl[$j];
						$iprata2=$ip/$no;
						$lamastudi=$lamastudi+$lamastuditbl[$j];
						$lamastudirata2=$lamastudi/$no;
						//$cek_lj = false;
					}
				}
				//$cek_kj = false;
				
				if($program == 'D4')//Jika Program D-4
				{					
					//if(substr($nrptbl[$j],4,3) == '040' || substr($nrptbl[$j],4,3) == '039') //Mahsiswa Kerjasama
					//{
					//	$no_kerjasama=$no_kerjasama+1;
					//	$ip_kerjasama=$ip_kerjasama+$ipktbl[$j];
					//	$ip_kerjasama_rata2=$ip_kerjasama/$no_kerjasama;
					//	$lamastudi_kerjasama=$lamastudi_kerjasama+$lamastuditbl[$j];
					//	$lamastudirata2_kerjasama=$lamastudi_kerjasama/$no_kerjasama;
					//	$cek_kj = true;
					//}
					//else{
						//$cek_kj = false;
						$ip=$ip+$ipktbl[$j];
						$iprata2=$ip/$no;
						$lamastudi=$lamastudi+$lamastuditbl[$j];
						$lamastudirata2=$lamastudi/$no;
					//}
				}
				
				if($program == 'D3')//Jika Program D-3
				{					
					if(substr($nrptbl[$j],4,3) == '038' || substr($nrptbl[$j],4,3) == '039') //Mahsiswa Kerjasama
					{
						
						//$nolj=$nolj+1;
						//$iplj=$iplj+$ipktbl[$j];
						//$iprata2lj=$iplj/$nolj;
						//$lamastudilj=$lamastudilj+$lamastuditbl[$j];
						//$lamastudirata2lj=$lamastudilj/$nolj;
						
						$no_kerjasama=$no_kerjasama+1;
						$ip_kerjasama=$ip_kerjasama+$ipktbl[$j];
						$ip_kerjasama_rata2=$ip_kerjasama/$no_kerjasama;
						$lamastudi_kerjasama=$lamastudi_kerjasama+$lamastuditbl[$j];
						$lamastudirata2_kerjasama=$lamastudi_kerjasama/$no_kerjasama;
						$cek_kj = true;
					}
					else{
						//$cek_kj = false;
						$ip=$ip+$ipktbl[$j];
						$iprata2=$ip/$no;
						$lamastudi=$lamastudi+$lamastuditbl[$j];
						$lamastudirata2=$lamastudi/$no;
					}
				}
				
				//$cek_lj = false;
				//if(substr($nrptbl[$j],4,3) == '105' || substr($nrptbl[$j],4,3) == '106') //Mahsiswa LJ
				//{
				//	$nolj=$nolj+1;
				//	$iplj=$iplj+$ipktbl[$j];
				//	$iprata2lj=$iplj/$nolj;
				//	$lamastudilj=$lamastudilj+$lamastuditbl[$j];
				//	$lamastudirata2lj=$lamastudilj/$nolj;
				//	$cek_lj = true;
				//}
				//
				//$banyaknya=0;	
				
				
				$cekbaris=$ctrbaris+($cekbidangkeahlian*3);
				
				//JUMLAH DATA KEPALA BUKU PER HALAMAN
				if ($cekbidangkeahlian<=0)
				{
					$jumbaris=34;
				}
				else
				{
					$jumbaris=34;
					if($cek_bidang==true){
						$jumbaris=$jumbaris-$status_baris;
					}
				}
				//if ($cekbaris==$jumbaris)
				if ($ctrbaris==$jumbaris)
				{									
					/*Penomeran halaman 1 sampai (akhir-1) */
					$html=$html.'<!--/td></tr-->
						</table></div></td></tr>							
							<tr>
								<td width="45%" align="right"></td>
								<td align="center" width="1.5cm" border-bottom="1" style=\"border-radius: 10px;\">
									<img src="/simwisuda/inc/page.jpg" style="width: 55; height: 10" />
									'.$halaman.'
									<!--img src="/simwisuda/inc/kanan_atas.png" style="width: 15; height: 15" /-->		
									
								</td>
								<td width="45%" ></td>
							</tr>
							<tr>								
								<td align="center" colspan="3"><b>Wisuda ke-'.$periodewisuda.' ITS</b></td>
							</tr>							
						</table>
					</td>
					<td width="2%"></td>
					<td width="2%" height="100%">
						<!BORDER VERTICAL KANAN-->
						<br>
						<img src="/simwisuda/inc/side.png" style="width: 30; height: 2000" >
						<!--img src="/simwisuda/inc/side.png" style=\"width: 30; height: 2050" -->
						<!--img src="/simwisuda/inc/side.png" style=\"width: 30; height: 2050" -->
					</td>
				</tr>
				<tr>
					<td colspan="4" >
						<img src="/simwisuda/inc/bawah.png" style="width: 1500; height: 55" >
					</td>
				</tr>
				</table>
			</td>
		</tr>
	</table>
	</td>
	</tr>
	</table>
						';//mentos
									
									
					$pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
					
					$flag=0;
					$html='';
					$pdf->AddPage();
					$halaman=$halaman+1;
					$cekbaris=0;
					$ctrbaris=0;
					$cekbidangkeahlian=0;
				}	 
					
			}
			
			$garis_border = '';
			if ($cek_lj == true && $program == 'S1'){
			//if (substr($nrptbl[$j],4,3) == '105' || substr($nrptbl[$j],4,3) == '106'&& $program == 'S1'){
				$html=$html.'
				<style>
				td.atas_bawah {
					border-style:double;
					border-top: 1px solid black;							
					border-bottom: 1px solid black;
				}	
				td.top {
					border-top: 1px solid black;	
				}	
				td.bawah {
					border-bottom: 1px solid black;	
				}
				</style>
				<tr>
					<td></td>
				</tr>
			   	<tr>
					<td style="width:1%"></td>
					<td style="width:5%" class="top"></td>
					<td style="width:55%" class="top" colspan="2"></td>
					<td style="width:6%" class="top"></td>
					<td style="width:8%" class="top"></td>
					<td style="width:13%" class="top"></td>
					<td style="width:13%" class="top"></td>
				</tr>
				<tr>	
					<td style="width:1%"></td>
					<td style="width:5%" ></td>
					<td style="width:55%" align="left" colspan="2">IP / Lama Studi Rata-Rata</td>
					<td style="width:6%" >'.number_format($iprata2,2).'</td>
					<td style="width:8%" >'.number_format($lamastudirata2,2).'</td>
					<td style="width:13%" ></td>
					<td style="width:13%" ></td>
				</tr>
				<tr>	
					<td style="width:1%"></td>
					<td style="width:5%" ></td>
					<td style="width:55%" align="left" colspan="2">IP / Lama Studi Rata-Rata LJ</td>
					<td style="width:6%" >'.number_format($iprata2lj,2).'</td>
					<td style="width:8%" >'.number_format($lamastudirata2lj,2).'</td>
					<td style="width:13%" ></td>
					<td style="width:13%" ></td>
				</tr>	
				<tr>
					<td style="width:1%"></td>
					<td class="bawah"></td>
					<td class="bawah" colspan="2"></td>
					<td class="bawah"></td>
					<td class="bawah"></td>	
					<td class="bawah" colspan="2"></td>
				</tr>
				';
				$ctrbaris = $ctrbaris+4;
			//break;
			}
			if ($cek_kj == true && $program == 'D3') //jika ada mhs D3-Kerjasama
			{ 
			   $html=$html.'
				<style>
				td.atas_bawah {
					border-style:double;
					border-top: 1px solid black;							
					border-bottom: 1px solid black;
				}	
				td.top {
					border-top: 1px solid black;	
				}	
				td.bawah {
					border-bottom: 1px solid black;	
				}
				</style>
				<tr>
					<td></td>
				</tr>
			   	<tr>
					<td style="width:1%"></td>
					<td style="width:5%" class="top"></td>
					<td style="width:55%" class="top" colspan="2"></td>
					<td style="width:6%" class="top"></td>
					<td style="width:8%" class="top"></td>
					<td style="width:13%" class="top"></td>
					<td style="width:13%" class="top"></td>
				</tr>
				<tr>	
					<td style="width:1%"></td>
					<td style="width:5%" ></td>
					<td style="width:55%" align="left"  colspan="2">IP / Lama Studi Rata-Rata</td>
					<td style="width:6%" >'.number_format($iprata2,2).'</td>
					<td style="width:8%" >'.number_format($lamastudirata2,2).'</td>
					<td style="width:13%" ></td>
					<td style="width:13%" ></td>
				</tr>
				<tr>
					<td style="width:1%"></td>
					<td ></td>
					<td  align="left" colspan="2">IP / Lama Studi Rata-Rata Kerjasama</td>
					<td >'.number_format($ip_kerjasama_rata2,2).'</td>
					<td >'.number_format($lamastudirata2_kerjasama,2).'</td>	
					<td  colspan="2"></td>
				</tr>
				<tr>
					<td style="width:1%"></td>
					<td class="bawah"></td>
					<td class="bawah" colspan="2"></td>
					<td class="bawah"></td>
					<td class="bawah"></td>	
					<td class="bawah" colspan="2"></td>
				</tr>
				';
			} 
			//$cek_lj = false;
			//$cek_kj = false;
			if($cek_lj != true && $cek_kj != true){
			//else{
				$html=$html.'
				<style>
				td.atas_bawah {
					border-style:double;
					border-top: 1px solid black;							
					border-bottom: 1px solid black;
				}	
				td.top {
					border-top: 1px solid black;	
				}			
				</style>
			<tr>
				<td></td>
			</tr>
			   <tr>
				<td style="width:1%"></td>
				<td style="width:5%" class="top"></td>
				<td style="width:55%" class="top" colspan="2"></td>
				<td style="width:6%" class="top"></td>
				<td style="width:8%" class="top"></td>
				<td style="width:13%" class="top"></td>
				<td style="width:13%" class="top"></td>
			</tr>		
			<tr>	
				<td style="width:1%"></td>
				<td style="width:5%" ></td>
				<td style="width:55%" align="left"  colspan="2">IP / Lama Studi Rata-Rata</td>
				<td style="width:6%" >'.number_format($iprata2,2).'</td>
				<td style="width:8%" >'.number_format($lamastudirata2,2).'</td>
				<td style="width:13%" ></td>
				<td style="width:13%" ></td>
			</tr>
			<tr>
				<td style="width:1%"></td>
				<td class="bawah"></td>
				<td class="bawah" colspan="2"></td>
				<td class="bawah"></td>
				<td class="bawah"></td>	
				<td class="bawah" colspan="2"></td>
			</tr>
				';
			}
			
			
			$html=$html.'
				<tr>
					<td></td>
				</tr>
				<tr>
					<td style="width:1%"></td>
					<td align="left" width="20%" colspan="2" ><b>  Keterangan : </b></td>
					<td align="left" width="40%" >
						 Memuaskan<br>
						 Sangat Memuaskan<br>
						 Dengan Pujian<br>
						 Semester
					</td>
					<td align="left" width="2.2cm">
						  : M<br>
						  : SM<br>
						  : DP<br>
						  : SEM
					</td>					
				</tr>
				';
				$ctrbaris = $ctrbaris + 5;
				
			//$html=$html."</table></div><br><br>";
			/*Penomeran halaman akhir kepala buku */
			$html=$html.'<!--/td></tr-->
						</table></div></td></tr>							
							<tr>
								<td width="45%"  align="right"></td>
								<td align="center" width="1.5cm" border-bottom="1" style=\"border-radius: 10px;\">
									<img src="/simwisuda/inc/page.jpg" style="width: 55; height: 10" />
									'.$halaman.'
									<!--img src="/simwisuda/inc/kanan_atas.png" style="width: 15; height: 15" /-->		
									
								</td>
								<td width="45%"  ></td>
							</tr>
							<tr>								
								<td align="center" colspan="3"><b>Wisuda ke-'.$periodewisuda.' ITS</b></td>							
							</tr>							
						</table>
					</td>
					<td width="2%"></td>
					<td width="2%" height="100%" >
						<!BORDER VERTICAL KANAN-->
						<br>
						<img src="/simwisuda/inc/side.png" style="width: 30; height: 2000" >
						<!--img src="/simwisuda/inc/side.png" style=\"width: 30; height: 4200" -->
					</td>
				</tr>
				<tr>
					<td colspan="4" >
						<img src="/simwisuda/inc/bawah.png" style="width: 1500; height: 55" >
					</td>
				</tr>
				</table>
			</td>
		</tr>
	</table>		
</td>
		</tr>
	</table>	
						';
			
				
				
			$pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
						
						
			$halaman=$halaman+1;
			
			$html='';
			$pdf->AddPage();
			//$pdf->setPage($halaman, true);
			$ctr=0;
			$ctrtgl=1;
            $fak_jur = $this->Db_model->ambil_fakultas_jurusan($valarr[0],$urutandata,$periodewisuda);			
			foreach ($fak_jur->result_array() as $row)
            {	
				$pottgl="";
				$potbln="";
				$potthn="";
				$blnind="";
				$MA_blnind="";
				$ctr=$ctr+1;
				
				/*AKDADEMIK*/
				//$nrpdata[$ctr]=$row['MA_Nrp'];
				//$namadata[$ctr]=strtoupper($row['MW_ma_nama']);
				//$alamatdata[$ctr]=strtoupper($row['MW_ma_AlamatOrtu'].' '.$row['MW_ma_AlamatOrtuKota']);
				//$judulta[$ctr]=$row['MA_JudulTugasAkhir'].$row['MA_JudulTugasAkhir2'];
				//$pembimbing1[$ctr]=$row['Pembimbing1'];
				//$pembimbing2[$ctr]=$row['Pembimbing2'];
				//$pembimbing3[$ctr]=$row['Pembimbing3'];
				
				/*SIM WISUDA*/
				$nrpdata[$ctr]=$row['NRP'];
				$namadata[$ctr]=strtoupper($row['NAMA']);
				$alamatdata[$ctr]=strtoupper($row['ALAMAT'].' '.$row['KOTA']);
				$email[$ctr]=strtolower($row['email']);
				$judulta[$ctr]=$row['JUDULTA'];
				$pembimbing1[$ctr]=$row['pembimbing1'];
				$pembimbing2[$ctr]=$row['pembimbing2'];
				$pembimbing3[$ctr]=$row['pembimbing3'];
				
				if(empty($row['email'])){
					$email[$ctr]=strtolower($row['email']);
				}

				
				/*
				if (empty($row['tgl']) || ($row['tgl']==' ') || ($row['tgl']=='') || ($row['tgl']=='0'))
				{
					$temptgl[$ctr]=$row['tgl'];
					$isinya[$ctr] = "ada";
				}
				else{
					$temptgl[$ctr]="tes";
					$isinya[$ctr] = "tidak";
				}
				*/
				
				$temptgl=$row['tgllahir_indo'];
				$ctrtgl=1;
				for ($x=0; $x<=strlen($temptgl); $x++)
				{
					if (substr($temptgl,$x,1)==' '){
						$ctrtgl=$ctrtgl+1;	
					}
					if ($ctrtgl==1){
						$pottgl=$pottgl.substr($temptgl,$x,1);
					}
					else if ($ctrtgl==2){
						$potbln=$potbln.substr($temptgl,$x,1);
					}
					else if ($ctrtgl==3){
						$potthn=$potthn.substr($temptgl,$x,1);
					}	
				}
			
			
				if (trim($potbln)=='January')
					{
						$blnind='Januari';
					}
				else if (trim($potbln)=='February')
					{
						$blnind='Februari';
					}
				else if (trim($potbln)=='March')
					{
						$blnind='Maret';
						$MA_blnind='Maret';
					}
				else if (trim($potbln)=='April')
					{
						$blnind='April';
					}
				else if (trim($potbln)=='May')
					{
						$blnind='Mei';
					}
				else if (trim($potbln)=='June')
					{
						$blnind='Juni';
					}
				else if (trim($potbln)=='July')
					{
						$blnind='Juli';
					}
				else if (trim($potbln)=='August')
					{
						$blnind='Agustus';
					}
				else if (trim($potbln)=='September')
					{
						$blnind='September';
					}
				else if (trim($potbln)=='October')
					{
						$blnind='Oktober';
					}
				else if (trim($potbln)=='November')
					{
						$blnind='November';
					}
				else if (trim($potbln)=='December')
					{
						$blnind='Desember';
					}
				
				$tgllahir[$ctr]=strtoupper($row['TMPLAHIR'].', '.$pottgl." ".$blnind." ".trim($potthn));
				//$tgllahir[$ctr]=strtoupper($row['MW_ma_tmplahir'].', '.$pottgl." ".$blnind." ".trim($potthn));//AKDEMIK
				
				/*TANGGAL LAHIR (ADA TIDAKNYA DATA)* 
				if(isset($row['MW_ma_tmplahir'])){
					$tgllahir[$ctr]=strtoupper($row['MW_ma_tmplahir'].', '.$pottgl." ".$blnind." ".trim($potthn));
				}
				else if(isset($row['MA_tgl']) ){
					$tgllahir[$ctr]=strtoupper($row['MA_TmpLahir'].', '.$MA_pottgl." ".$MA_blnind." ".trim($MA_potthn));
				}
				else
					$tgllahir[$ctr]='';
				*/
				
				if (empty($row['TELP']) || ($row['TELP']==' ') || ($row['TELP']=='') || ($row['TELP']=='0'))
				{
					if(isset($row['MA_TelpOrtu'])){
						$telp[$ctr]=$row['MA_TelpOrtu'];
					}
					else
						$telp[$ctr]="-";
				}
				else{
					$telp[$ctr]=$row['TELP'];
				}
				
				
				
				/*SIM AKADEMIK*/
				//$ortu[$ctr]=strtoupper($row['MW_ma_namaAyah']);
				//$email[$ctr]=strtolower($row['MW_ma_Email']);
				
				/*TABEL IJAZAH*/
				//$ortu[$ctr]=strtoupper($row['NAMAORTU']);
				$ortu[$ctr]=($row['NAMAORTU']);
				
				//if(isset($row['NAMAORTU'])){
				//	//$ortu[$ctr]=strtoupper($row['NAMAORTU']);
				//	$ortu[$ctr]=strtoupper($row['NAMAORTU']);
				//}
				//else{
				//	//$ortu[$ctr]=strtoupper($row['MA_NamaAyah']);
				//	$ortu[$ctr]=strtoupper($row['MA_NamaAyah']);
				//}
				
				$ctrhuruf=0;
				$cekbr=0;
				$ctrspasi2=0;
				$tempjudul2='';
				$tempjudul3='';
				
				//$data_foto = $this->Db_model->foto_mhs($nrpdata[$ctr]);			
				//foreach ($data_foto as $row)
				//{
				//	$datafoto = $row->MW_ma_Foto;
				//}
				//
				//$foto[$ctr]=$datafoto;
				//file_put_contents('../simwisuda/inc/img/'.$nrpdata[$ctr].'.jpg', $foto[$ctr]);
			}
			
			
			
			$jumkolom=$jumlah_data;			
			$jumhalaman=ceil(($ctr/($jumkolom*2)));
			$jumdata=0;
			$ctrawal=0;
			
			for ($j=1; $j<=$jumhalaman; $j++)
				{
					if ($j>1)
					  { 
						$pdf->AddPage();
						$halaman=$halaman+1;
					  }
					  
			/*	<table>
		<tr>
			<td width=\"162mm\"><img src=\"/simwisuda/inc/atas.png\" style=\"width: '2500'; height: 80\" ></td>
		</tr>
		<tr>
		<td style=\"height:215mm\">
			<table width=\"100%\">	
				<tr>					
					<td>
						<table>
						<tr>
							<td valign=\"middle\" width=\"2%\" >
								<!-- GAMBAR BORDER KIRI -->
								<br>
								<img src=\"/simwisuda/inc/side.png\" style=\"width: 30; height: 2000\" >
								
							</td>
							<td style=\"width:'94%'; height:215mm\">
							<table  width='100%'>
								<tr>
									<td style=\"width:'100%'; height:200mm\">*/
					  
					$tinggi = ($tinggi_kertas-$margintop-$marginbottom);
					$html=$html."
						<!-- WISUDAWAN -->		
						<!--table width='100%' style=\"border:3px solid red;\"-->
			<table>
				<tr>	
					<td width=\"158mm\" style=\"height:187mm; border:3px solid red\">	
						<table> 
						<tr>
							<td  colspan=\"4\">
								<img src=\"/simwisuda/inc/atas.png\" style=\"width: '2500'; height: 80\">
							</td>
						</tr>
						<tr>
							<td valign=\"middle\" width=\"4mm\" style=\"height:180mm;border:3px solid green\">
								<!-- GAMBAR BORDER KIRI -->
								<br>
								<img src=\"/simwisuda/inc/side.png\" style=\"width: 20; height: 500\" >
								
							</td>
							<td style=\"width:148mm; height:180mm; border:3px solid blue\">
								<!-- table green-->		
								<!--table width='100%' style=\"border:3px solid green\"-->
								<table width=\"100%\">
								<tr>
									<!--td style=\"width:3%\"></td-->
									<td style=\"width:'100%'; height:180mm; border:3px solid pink\">"; 
					/*Border layout kolom kiri kanan*/
					$html=$html.'<table style="width: 100%;border:3px solid black;height:195mm">
							<tr >';
					//$html=$html.'<table style="width: 96%; height:'.($tinggi-$marginbottom-40).'mm; border:3px solid red">
					//		<tr >';
					
					//lebar tabel kolom kiri
					if (($ukurankertas=='ITS PAPER') || ($ukurankertas=='B5'))
						{		
							$html=$html.'<td style="width: 50%">';
							//$html=$html.'<td style="width: 50%; border:3px solid pink">';
						}
					else
						{		
							$html=$html.'<td width="3mm"></td>
							<td style="width: 70mm; height:175mm">';
							//$html=$html.'<td style="width: 50%; border:3px solid pink">';
						}
					
					
					$jumdata=$jumdata+($jumkolom*2);
					$ctrawal=($jumkolom*2)-1;
					//echo "aa ".($jumdata-$ctrawal)."<br>";
					//echo "bb ".($jumdata-$jumkolom)."<br>";
					
					//echo ($jumdata-$ctrawal); 
					for ($i=($jumdata-$ctrawal); $i<=($jumdata-$jumkolom); $i++)
					{						
						if ($i<=$ctr)
							{				
								$html=$html.'';
								$html=$html.'
					<table>
						<tr>
							<td style="height:65mm">
								<table width="98%">
									<tr>
										<td width="2.2cm">';							
								$filename ='../simwisuda/inc/Wisudawan/'.$periodewisuda.'/'.$valarr[0].'/'.$nrpdata[$i].'.jpg';
								if (file_exists($filename)) {
									//$html=$html.'<img src=simwisuda/inc/Wisudawan/'.$periodewisuda.'/'.$valarr[0].'/'.$nrpdata[$i].'.jpg" width="2cm" height="3cm" />';			
									//$html=$html.'ADA';
									$html=$html.'<img src="'.$filename.'" width="2cm" height="3cm" />';
								}
								else{
									$html=$html.'<img src="/simwisuda/inc/img/no-images.png" width="2cm" height="3cm" />';		
									//$html=$html.'<br><img src="/simwisuda/inc/img/no-images.jpg" width="2cm" height="3cm" />';
									//$html=$html.'TIDAK';
								}
								
								 $html=$html.'</td>';
								 if ($ukurankertas=='ITS PAPER')
									{
										$html=$html.'<td width="70%"height="3cm">';		
									}
								 else
									{
										$html=$html.'<td width="48mm"height="3cm">';			
										//$html=$html.'<td width="70%"height="3cm" style="border:1px solid green">';			
									}
								/*Data NRP, Nama, Foto Kolom Kiri*/
								 $html=$html.'	
										<div >
											Nama: <b>'.ucwords(strtolower($namadata[$i])).'</b><br>
											NRP: '.$nrpdata[$i].'<br>
											TTL: '.ucwords(strtolower($tgllahir[$i])).'<br>
											ORTU: '.ucwords(strtolower($ortu[$i])).'<br>
											Alamat: '.ucwords(strtolower($alamatdata[$i])).'<br>
											Email: <font size:"7pt">';
												if(strlen($email[$i])>22){
													$html=$html.'	<br>hah'.$email[$i];
												}
												else {
												$html=$html.$email[$i];
												}
											$html=$html.'</font>											
											';
											
											
											//if (strlen($namadata[$i])<=28 )
											//{ $html=$html.'<br>'; }
											//if (strlen($alamatdata[$i])<=28 )
											//{ $html=$html.'<br>'; }
											//
											//if (strlen($email[$i])<=28 )
											//{ $html=$html.'<br>'; }
											$html=$html.'
										</div>
										</td>
									</tr>
								';
									
						//		$html=$html.'<table width="100%" border="1" style=\"border:1px solid black;\" height="27mm" >';
								/*judul TA KOLOM KIRI*/
								$cek_baris_pembimbing=0;
								//$nama_judul='';
								//if(trim($program) == 'S3'){
								//	$nama_judul='Judul Disertasi:';									
								//}
								//else if($program == 'S2'){
								//	$nama_judul='Judul Thesis:';									
								//}
								//else{
								//	$nama_judul='Judul TA:';	
								//}
								$html=$html.'
								<tr>
								<td colspan="2">
								<table width="96%">
									<tr >
										<td width="100%" colspan="2">'.$nama_judul.' '.$judulta[$i].'</td>
									</tr>
								';
								if(isset($pembimbing1[$i])){
									$html=$html.'
									<tr>
										<td width="20mm"><i>Pembimbing 1:</i></td>
										<td width="70%">'.$pembimbing1[$i].'</td>
									</tr>
									';
									$cek_baris_pembimbing=1;
								}								
										
								if(isset($pembimbing2[$i])){
									$html=$html.'
									<tr>
										<td><i>Pembimbing 2:</i></td>
										<td>'.$pembimbing2[$i].'</td>
									</tr>';
									$cek_baris_pembimbing=$cek_baris_pembimbing+1;
								}
								//else{									
								//	$html=$html.'<tr><td>P2 Kosong</td></tr>';
								//}
								//$html=$html.'tes '.$cek_baris_pembimbing.'';
								if(isset($pembimbing3[$i]) && $pembimbing3[$i]!='- tidak terdata -'){
									$html=$html.'
									<tr>
										<td><i>Pembimbing 3:</i></td>
										<td>'.$pembimbing3[$i].'</td>
									</tr>';
									$cek_baris_pembimbing=$cek_baris_pembimbing+1;
								}	
								
									//$cek_baris_pembimbing=0;
									if((strlen($pembimbing1[$i])>36 ) ) 
									{
										$lebih='P1';
										$cek_baris_pembimbing=($cek_baris_pembimbing+1);
										//$html=$html.'<tr><td>P1</td></tr>';
									}
									if(strlen($pembimbing2[$i])>36){
										$lebih='P2';
										$cek_baris_pembimbing=($cek_baris_pembimbing+1);
										//$html=$html.'<tr><td>P2</td></tr>';
									}
									if(strlen($pembimbing1[$i])>36 && strlen($pembimbing2[$i])>36){
										$cek_baris_pembimbing=4;
										//$lebih='lebih';
										//$html=$html.'<tr><td>'.$cek_baris_pembimbing.'lebih</td></tr>';
										//$html=$html.'<tr><td>Lebih</td></tr>';
										//$html=$html.'<tr><td></td></tr>';
									}
									
									//if($lebih=='kurang'){
									//	$html=$html.'<tr><td>'.$cek_baris_pembimbing.'kurang</td></tr>';
									//}
								//if($cek_baris_pembimbing<4){
								//	$loop = '';
								//	for($loop=$cek_baris_pembimbing; $loop<4; $loop++){
								//		$html=$html.'<tr><td></td></tr>';
								//		//break;
								//	}
								//}
								

								
								/*if (strlen($judulta[$i])<=115)
									{
										$html=$html.'<br>';
									}*/
								//tutup tabel kolom kiri
								$html=$html.'									
								</table>
								</td>								
							</tr>
							</table>
						</td>
						</tr>
						</table>';
							}	
					}
					$html=$html.'</td>
							';
					
					if (($ukurankertas=='ITS PAPER') || ($ukurankertas=='B5'))
						{		
							$html=$html.'<td style="width: 50%">';
							//$html=$html.'<td style="width: 50%; border:3px solid yellow">';
						}
					else
						{		
							$html=$html.'<td style="width: 5mm"></td><td style="width:70mm; height:185mm">';
							//$html=$html.'<td style="width: 50%; border:3px solid pink">';
						}
										
					for ($i=(($jumdata-$jumkolom)+1); $i<=$jumdata; $i++)
					{
						if ($i<=$ctr)
							{								
								/*nama nrp email kanan*/
								$html=$html.'
						<table>
							<tr>
								<td style="height:65mm">
								<table width="100%">
									<tr>
										<td width="2.2cm">';
								
								$filename ='../simwisuda/inc/Wisudawan/'.$periodewisuda.'/'.$valarr[0].'/'.$nrpdata[$i].'.jpg';
								if (file_exists($filename)) {
									$html=$html.'<img src="'.$filename.'" width="2cm" height="3cm" />';
								}
								else{
									$html=$html.'<img src="/simwisuda/inc/img/no-images.png" width="2cm" height="3cm" />';		
								
								}
									
								if ($ukurankertas=='ITS PAPER'){
									$html=$html.'</td><td width="68%"height="3cm">';		
								}
								 else{
									$html=$html.'</td><td width="70%"height="3cm">';			
								}	
								/*Data NRP, Nama, Foto Kolom Kanan*/
								//$html=$html.'	
								//	<div >
								//		Nama: <b>'.ucwords(strtolower($namadata[$i])).'</b><br>
								//		NRP: '.$nrpdata[$i].'<br>
								//		TTL: '.ucwords(strtolower($tgllahir[$i])).'<br>
								//		ORTU: '.($ortu[$i]).'<br>
								//		Alamat: '.ucwords(strtolower($alamatdata[$i])).'<br>
								//		Email: '.$email[$i].'';
								//		if (strlen($alamatdata[$i])<=28 )
								//			{ $html=$html.'<br>'; }
								//			if (strlen($namadata[$i])<=28)
								//			{ $html=$html.'<br>'; }
								//$html=$html.'
								//	</div>
								//		</td>
								//	</tr>
								//</table><br>';
								
								/*Data NRP, Nama, Foto Kolom Kanan*/
								 $html=$html.'	
										<div >
											Nama: <b>'.ucwords(strtolower($namadata[$i])).'</b><br>
											NRP: '.$nrpdata[$i].'<br>
											TTL: '.ucwords(strtolower($tgllahir[$i])).'<br>
											ORTU: '.ucwords(strtolower($ortu[$i])).'<br>
											Alamat: '.ucwords(strtolower($alamatdata[$i])).'<br>
											Email: <font size:"7pt">';
												if(strlen($email[$i])>22){
													$html=$html.'	<br>hah'.$email[$i];
												}
												else {
												$html=$html.$email[$i];
												}
								$html=$html.'</font>											
											';
											//if (strlen($namadata[$i])<=28 )
											//{ $html=$html.'<br>'; }
											//if (strlen($alamatdata[$i])<=28 )
											//{ $html=$html.'<br>'; }
											//
											//if (strlen($email[$i])<=28 )
											//{ $html=$html.'<br>'; }
											$html=$html.'
										</div>
										</td>
									</tr>
								';
								//$nama_judul='';
								//if($program == 'S3'){
								//	$nama_judul='Judul Disertasi:';									
								//}
								//if($program == 'S2'){
								//	$nama_judul='Judul Thesis:';									
								//}
								//else{
								//	$nama_judul='Judul TA:';	
								//}
								/*judul TA kanan*/
								$html=$html.'
								<tr>
								<td colspan="2">
								<table width="96%">
									<tr >
										<td width="100%" colspan="2">'.$nama_judul.' '.$judulta[$i].'</td>
									</tr>
								';
								$cek_baris_pembimbing=0;								
								 																
								//PEMBIMBING TA KOLOM KANAN
								if(isset($pembimbing1[$i])){
									$html=$html.'
									<tr>
										<td width="20mm"><i>Pembimbing 1:</i></td>
										<td width="70%">'.$pembimbing1[$i].'</td>
									</tr>
									';
									$cek_baris_pembimbing=1;
								}								
										
								if(isset($pembimbing2[$i])){
									$html=$html.'
									<tr>
										<td><i>Pembimbing 2:</i></td>
										<td>'.$pembimbing2[$i].'</td>
									</tr>';
									$cek_baris_pembimbing=$cek_baris_pembimbing+1;
								}
								//else{									
								//	$html=$html.'<tr><td>P2 Kosong</td></tr>';
								//}
								//$html=$html.'tes '.$cek_baris_pembimbing.'';
								if(isset($pembimbing3[$i]) && $pembimbing3[$i]!='- tidak terdata -'){
									$html=$html.'
									<tr>
										<td><i>Pembimbing 3:</i></td>
										<td>'.$pembimbing3[$i].'</td>
									</tr>';
									$cek_baris_pembimbing=$cek_baris_pembimbing+1;
								}	
								
									//$cek_baris_pembimbing=0;
									if((strlen($pembimbing1[$i])>36 ) ) 
									{
										$lebih='P1';
										$cek_baris_pembimbing=($cek_baris_pembimbing+1);
										//$html=$html.'<tr><td>P1</td></tr>';
									}
									if(strlen($pembimbing2[$i])>36){
										$lebih='P2';
										$cek_baris_pembimbing=($cek_baris_pembimbing+1);
										//$html=$html.'<tr><td>P2</td></tr>';
									}
									
									if(strlen($pembimbing1[$i])>36 && strlen($pembimbing2[$i])>36){
										$cek_baris_pembimbing=4;										
									}
									///if($cek_baris_pembimbing<4){
									//	/$loop = '';
									//	/for($loop=$cek_baris_pembimbing; $loop<4; $loop++){
									//		/$html=$html.'<tr><td></td></tr>';
									//		///break;
									//	/}
									///}
								
								//tutup tabel data wisudawan dan judul TA kolom kanan
								$html=$html.'
								</table>
							</td>
							</tr>
							</table>
						</td>				
					</tr>
				</table>
								';
								
							}	
					}

					$html=$html.'</td>
					';
					$html=$html.'</tr>
								
						</table><!-- table green-->	
					</td>
					
					</tr>';
										
					/*Penomeran halaman wisudawan*/
					$html=$html.'
					
					<!-- table blue-->
					</table>					
					<table width="100%">
						<tr>
								<td width="45%" border="0" align="right"></td>
								<td align="center" width="1.5cm" border-bottom="1" style=\"border-radius: 10px;\">
									<img src="/simwisuda/inc/page.jpg" style="width: 55; height: 10" />
									'.$halaman.' 
								</td>
								<td width="45%"></td>
							</tr>
							<tr>								
								<td align="center" colspan="3">
									<b>Wisuda ke-'.$periodewisuda.' ITS</b>
								</td>							
							</tr>					
						</table>	
					</td>		
					<td width="2mm"></td>
					<td width="4mm" height="105mm" style="border:3px solid green">					
						<br>
						<img src="/simwisuda/inc/sidekanan.png" style="width: 20; height: 500" >
					</td>
					</tr>
					<tr>
						<td colspan="4" height="5mm">
						<!-- border bawah -->
							<img src="/simwisuda/inc/bawah.png" style="width: 3500; height: 120">			
						</td>						
					</tr>
					</table><!-- tabel red-->
				</td>
			</tr>
		</table>
						';
					
				
							
					$pdf->writeHTML($html,true, false, true, false, '');
					
					$html='';
					
				}	
				/*cek update*/
					if($cek_update == 'yes'){
						//$html=$html.'<b>Kojur '.substr($valarr[0],0,4).' ASLI '.$valarr[0].' Update '.($lulusan_ke-1).'</b>';
						$this->Db_model->update_lulusanke($valarr[0], ($lulusan_ke-1));
					}
					//else{
					//	$html=$html.'<b>KOSONG</b>';
					//}
					/*$html=$html."
					<table>
						<tr>
							<td>
							<img src=\"/simwisuda/inc/side.png\" height=\"50mm\" >
							</td>
							<td>HAHA AHIAHIHAI dzbu </td>
						</tr>
						<tr>
							<td><img src=\"/simwisuda/inc/bawah.png\" >
							</td>
						</tr>
					</table>
					";*/
					$pdf->writeHTML($html,true, false, true, false, '');
		}
	
	

	/*$html="<table >
			<tr >
				<td style=\"width: 100mm;\">
				Kolom 1</td>
	<td style=\"width: 100mm;\">
	Kolom 2
	</td>
	</tr></table>";*/
	
	$pdf->Output("Wisuda ".$periodewisuda." Hari ".$buku_ke ,"I");
	
	
?>	