<?PHP
	tcpdf();
	ini_set("memory_limit","512M");
    	
	$this->load->helper('url');
	$title = "WISUDA ".$periodewisuda;
	$judul = '\n'.'Tanggal Wisuda';
	//$pdf = new TCPDF("P", "mm",$ukurankertas, true, 'UTF-8', false); //DEFULT UTF-8 UNICODE
	if ($cetak=='DENAH')
	{
		if ($ukurankertas=='ITS PAPER'){
			$pdf = new TCPDF("L", "mm",array(190,230), false, 'UTF-8', false);
		}
		else{
			$pdf = new TCPDF("L", "mm",$ukurankertas, false, 'ISO-8859-1', false);			
		}
	}
	else
	{
		if ($ukurankertas=='ITS PAPER'){
			$pdf = new TCPDF("P", "mm",array(190,230), false, 'UTF-8', false);
		}
		else{
			$pdf = new TCPDF("P", "mm",$ukurankertas, true, 'UTF-8', false); //DEFULT UTF-8 UNICODE
			//$pdf = new TCPDF("P", "mm",$ukurankertas, false, 'ISO-8859-1', false);			
		}
	}
	
	$pdf->SetAuthor('BAKP');
	$pdf->SetTitle($title, $judul);
	$pdf->SetSubject('Kursi Wisuda');
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
	$pdf->SetFont('times', '', 10);
	$pdf->setFontSubsetting(false);
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	
	$program='';
	$fakultas='';
	$jurusan='';
	$nama_program='';
	$lulusan_ke='';
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
	
	/*konversi tanggal wisuda ke format Indonesia
	if (!function_exists('konv')) 
	{
		function konv($tanggal)
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
	}*/
	
	if ($cetak=='DETAIL')
	{
			$halaman=0;
			$ctr=0;
			
			/*for ($i=1; $i<=$nbaris; $i++)
			{
				echo $data_kursikiri[$i];
				echo $data_kursikanan[$i];
			}*/
			//echo $data_kursikiri1;
				
			foreach ($data_prodi as $key => $value) 
				{
							
					$valarr = explode("-", $value); 
					
					$data_tglperiode = $this->Db_kursi->ambil_kelulusan($periodewisuda);
					foreach ($data_tglperiode as $row)
					{
						$tglkelulusan = $row->TGLKELULUSAN;			
					}
					
					/*
					$data_tgl_kelulusan = $this->Db_model->fakultas_jurusan_program($periodewisuda);
					foreach ($data_tgl_kelulusan->result_array() as $row)
					{
						$tgl_lulus = $row['TGLKELULUSAN'];			
					}
					*/
					$fak_jur_prog = $this->Db_kursi->fakultas_jurusan_program($valarr[0]);
					foreach ($fak_jur_prog->result_array() as $row)
					{
						//$fakultas = $row['FA_Nama'];
						//$jurusan = $row['JU_Nama'];
						//$program = $row['PS_Nama'];
						//$namajur = $row['PS_NamaJurusan'];
						
						//$lulusan_ke = $row['lulusan_ke']+1;	
						//$kojur = $row['kojur'];
						
						$fakultas = $row['NAMAFAKULTAS_2'];
						$jurusan = $row['NAMAJURUSAN'];
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
						$namajur = $program.'-'.$jurusan;
					}
								
					$fak_jur = $this->Db_kursi->ambil_fakultas_jurusan($valarr[0],$urutandata,$periodewisuda);						
					
					foreach ($fak_jur->result_array() as $row)
					{	
						$ctr=$ctr+1;
						
						/*SIM WISUDA*/
						$nrptbl[$ctr]=$row['NRP'];
						$namafakultas[$ctr]=$fakultas;
						
						$namajurusan[$ctr]=$namajur;
						
						if(substr($nrptbl[$ctr],0,2)=='27'){
							$namajurusan[$ctr]='S1-T. Material & Metalurgi';
						}
						
						$namatbl[$ctr]=ucwords(strtolower($row['NAMA']));
						$ipktbl[$ctr]=$row['IPK'];
						$lamastuditbl[$ctr]=$row['LAMASTUDI'];
						$predikat[$ctr]=$row['PREDIKAT'];
						
						$periode_lama[$ctr] = $row['PERIODEWISUDA'];
						
						$testing=trim($namatbl[$ctr]) 	;
						//if(mb_strlen($testing), "UTF-8">28){
						if(mb_strlen($testing, "UTF-8")>28){
						//if(mb_strlen(trim($namatbl[$ctr]))>27){
							//Hapus Last Name Kalau Kepanjangan
							$parts = explode(' ', $namatbl[$ctr]); 
							$name_first = array_shift($parts);
							$name_last = array_pop($parts);
							$name_middle = trim(implode(' ', $parts));
							
							$ceknama= $name_first.$name_middle;
							if(strlen(trim($ceknama) > 27)){
								$parts = explode(' ', $ceknama); 
								$name_first = array_shift($parts);
								$name_last = array_pop($parts);
								$name_middle = trim(implode(' ', $parts));
								$namatbl[$ctr]=strtoupper($name_first).' '.strtoupper($name_middle);
								//$namatbl[$ctr]=strtoupper($name_first).' '.strtoupper($name_middle).strlen(rtrim($namatbl[$ctr]));
							}
							else{									
								$namatbl[$ctr]=strtoupper($name_first).' '.strtoupper($name_middle);
							}
						
							
						;	
						}
						else{
							$namatbl[$ctr]=strtoupper($namatbl[$ctr]);
						}
						
						$panjang_baris[$ctr]=false;
						
						$wisuda_lama[$ctr]='';
						if($periode_lama[$ctr] != $periodewisuda){
							$wisuda_lama[$ctr]=$periode_lama[$ctr];
						}
						
						if($predikat[$ctr] == 'D'){
							$predikat[$ctr] = 'DP';
						}
						else if($predikat[$ctr] == 'S'){
							$predikat[$ctr] = 'SM';
						}
						
					}	
				}
				


					$halaman=$halaman+1;
					$pdf->AddPage();
					//$pdf->setPage($halaman, true);
											
					$no=0;	
					$urut=0;
					$jumlah=1;
					$html='';
					
					$tinggi = ($tinggi_kertas-$margintop-$marginbottom-10)."mm";
							$html=$html."
							<table width='100%'>
								<tr>
									<td style=\"width:'100%'; height:'".$tinggi.".mm'\">
										<table border='0' width='100%'>
											<tr>
												<td style=\"width:'100%'; height:'".($tinggi-10).".mm';\">";	
					
					//HEADER HALAMAN 1
					$html=$html.'
							<style>
								 td.tes {
									border-style:double;
								}
								td.atas {
									border-top: 1px solid black;
								}
								td.f9 {
									font-size: 9pt;
								}
								td.nama {
									border-right: 1px solid black;
									border-top: 1px solid black;
									border-bottom: 1px solid black;
								}
								td.border1mm {
									border-top: 1px solid black;
									border-bottom: 1px solid black;
								}
							</style>
								
							<br>&nbsp;
									
																
									<div align="center">
									<table border="0" align="center" >
										<tr>
											<td align="center" width="10%"><img src="/simwisuda/inc/logo_its.gif" style="width: 50; height: 50" /></td>
											<td align="center" width="80%">	
												<h2 align="center">
													DAFTAR WISUDAWAN<br>
													PROGRAM DOKTOR, MAGISTER, SARJANA, DIPLOMA DAN POLITEKNIK<br>
													WISUDA KE '.$periodewisuda.', '.$tanggal_id.'
												</h2><br>
											</td>
											<td align="center" width="10%"><img src="/simwisuda/inc/eco.jpg" style="width: 60; height: 50" /></td>
										</tr>
										<tr>
											<td class="border1" style="width:4%"><b>NO</b></td>
											<td class="border1" style="width:19%"><b>JURUSAN</b></td>
											<td class="f9" style="width:7%; border: 1px solid black"><b>DERET</b></td>
											<td class="border1" style="width:5%"></td>		
											<td  class="f9" style="width:7%; border: 1px solid black;"><b>KURSI</b></td>																							
											<td class="f9" style="width:7%; border: 1px solid black;"><b>URUT</b></td>
											<td class="border1" style="width:11%"><b>NRP</b></td>
											<td class="border1mm" style="width:1mm"></td>	
											<td class="nama" style="width:34%"><b>N A M A </b></td>	
											<td style="width:6%;border: 1px solid black;" class="f9"><b>CEK1</b></td>
										</tr>
										';
					$var_tempnrp="";
					$var_tempfakultas="";
					$var_prodisimwisuda="";
					$flag=1;
					$cekbidangkeahlian=0;	
					$ctrbaris=0;
					$no=0;
					$cekkursikiri=0;
					$cekkursikanan=0;
					$namakursi=0;
					$nomorkursi=0;
					$ctrkursi=1;
					for ($j=1; $j<=$ctr; $j++)
					{
						$ctrbaris=$ctrbaris+1;
						//$jumlah=$jumlah+1;
						if ($flag==0)
							{
								$tinggi = ($tinggi_kertas-$margintop-$marginbottom)."mm";
							$html=$html."<br>
							<!--table border='0' style=\"border:1px solid black;\" width='100%'-->
							<table  width='100%'>
								<tr>
									<td style=\"width:'100%'; height:'".$tinggi.".mm'\">
										<table border='0' width='100%'>
											<tr>
												<td style=\"width:'100%'; height:'".($tinggi-$marginbottom).".mm';\">";	
					
					//HEADER HALAMAN >1
					$html=$html.'
							<style>
								td.font9 {
									font-size:9pt;
									border: 1px solid black;
								}
								td.font10 {
									font-size:10pt;
									border: 1px solid black;
								}
								td.font11 {
								font-size:11pt;
								}
								td.border1 {
									border: 1px solid black;
								}
								td.nama {
									border-right: 1px solid black;
									border-top: 1px solid black;
									border-bottom: 1px solid black;
								}
								td.border1mm {
									border-top: 1px solid black;
									border-bottom: 1px solid black;
								}
							</style>
													
									<div align="center">
									<table align="center" >
										<tr>
											<td align="center" width="10%"><img src="/simwisuda/inc/logo_its.gif" style="width: 50; height: 50" /></td>
											<td align="center" width="80%">	
												<h2 align="center">
													DAFTAR WISUDAWAN<br>
													PROGRAM DOKTOR, MAGISTER, SARJANA, DIPLOMA DAN POLITEKNIK<br>
													WISUDA KE '.$periodewisuda.', '.$tanggal_id.'
												</h2><br>
											</td>
											<td align="center" width="10%"><img src="/simwisuda/inc/eco.jpg" style="width: 60; height: 50" /></td>
										</tr>
										<tr>
											<td class="border1" style="width:4%"><b>NO</b></td>
											<td class="border1" style="width:19%"><b>JURUSAN</b></td>
											<td class="f9" style="width:7%; border: 1px solid black"><b>DERET</b></td>
											<td class="border1" style="width:5%"></td>		
											<td  class="f9" style="width:7%; border: 1px solid black;"><b>KURSI</b></td>																							
											<td class="f9" style="width:7%; border: 1px solid black;"><b>URUT</b></td>
											<td class="border1" style="width:11%"><b>NRP</b></td>
											<td class="border1mm" style="width:1mm"></td>		
											<td class="nama" style="width:34%"><b>N A M A </b></td>	
											<td style="width:6%;border: 1px solid black;" class="f9"><b>CEK1</b></td>
										</tr>
										';
								$flag=1;	
							}
						$cont = 0;
						
						/*TAMPIL FAKULTAS*/
						//echo $var_tempfakultas.'-'.substr($nrptbl[$j],0,1).'<br>';
						if ($var_tempfakultas!=substr($nrptbl[$j],0,1))
						{	
							foreach ($fak_jur_prog->result_array() as $row)
							{
								$var_fakultas =  $row['NAMAFAKULTAS_2'];
							}
							$cekbidangkeahlian=$cekbidangkeahlian+1;	
							$ctrbaris=$ctrbaris+1;
							$html=$html.'					
								<tr>
									<td class="border1" colspan="10" align="center"><b style="font-size:12pt">'.strtoupper($namafakultas[$j]). '</b></td>
								</tr>';
							
						}
						
						/*TAMPIL NAMA JURUSAN SEBELUM DATA WISUDAWAN*/
						if ($var_tempnrp!=substr($nrptbl[$j],0,2).substr($nrptbl[$j],4,2))
						{	$no=0;
							$cekbidangkeahlian=$cekbidangkeahlian+1;
							$ctrbaris=$ctrbaris+1;
							$html=$html.'					
								<tr>
									<td class="border1" colspan="10" align="center"><br><b style="font-size:11pt">'.strtoupper($namajurusan[$j]). '</b></td>
								</tr>';
							$jumlah=$jumlah+1;
							
							$cont = $jumlah;
						}
							//cek kursi kanan
							if ($data_kursikiri[$ctrkursi]==$cekkursikiri)
							{									
								$cekkursikanan=$cekkursikanan+1;
								$nomorkursi=$cekkursikanan;
								$kursi='Kanan';
							}
							//cek kursi kiri
							else
							{
								$cekkursikiri=$cekkursikiri+1;
								$nomorkursi=$cekkursikiri;
								$kursi='Kiri';
							}
							$kodekursi=chr(65+$namakursi);
						//jika cek data sudah sampai kanan 
							if ($data_kursikanan[$ctrkursi]==$cekkursikanan)
							{
								$cekkursikiri=0;
								$cekkursikanan=0;
								$namakursi=$namakursi+1;
								$ctrkursi=$ctrkursi+1;
							}
								
							$no=$no+1;
							$urut=$urut+1;
							//TAMPIL DATA DETAIL WISUDAWAN
							$html=$html.'		
							<style>
								td.font9 {
									font-size:9pt;
									border: 1px solid black;
								}
								td.font10 {
									font-size:10pt;
									border: 1px solid black;
								}
								td.font11 {
								font-size:11pt;
								}
								td.border1 {
									border: 1px solid black;
								}
								td.border1mm {
									border-top: 1px solid black;
									border-bottom: 1px solid black;
								}
								td.font10_nama {
									font-size:10pt;
									border-right: 1px solid black;
									border-top: 1px solid black;
									border-bottom: 1px solid black;
								}
							</style>
							<tr>
								<td class="border1" style="width:4%">'.$no.'</td>
								<td class="border1" style="width:19%" class="font9">';
								$panjang_jurusan=0;
								if(mb_strlen(rtrim($namajurusan[$j]))>24){
									$panjang_jurusan=1;
								}
							$html=$html.''.$namajurusan[$j].'</td>
								<td class="border1" style="width:7%">'.$kodekursi.'</td>
								<td class="border1" style="width:5%">'.$nomorkursi.'</td>
								<td class="border1" style="width:7%">'.$kursi.'</td>
								<td class="border1" style="width:7%">'.$urut.'</td>
								<td class="border1" style="width:11%">'.$nrptbl[$j].'</td>		
								<td class="border1mm" style="width:1mm"></td>			
							';
							
								$html=$html.'
									<td class="font10_nama" style="width:34%" align="left">'.strtoupper($namatbl[$j]).'</td>
							';	
							//}
									
							if($predikat[$j]=='DP'){
								$html=$html.'
								<td style="width:6%; border: 1px solid black">'.$predikat[$j].'</td>
								</tr>';
							}
							else if(isset($wisuda_lama[$j])){
								$html=$html.'
								<td style="width:6%; border: 1px solid black">'.$wisuda_lama[$j].'</td>
								</tr>';
							}
							else{
								$html=$html.'
								<td style="width:6%; border: 1px solid black"></td>
								</tr>';
							}	

							if($cek_insert == 'yes')
							{
								$cekdata = $this->Db_kursi->cekinsert_kursi($nrptbl[$j]);
								foreach ($cekdata as $row)
								{
									$cek_nrp = $row->nrp;			
								}
								
								//JIKA DATA NRP tsb SUDAH ADA DI DATABASE			
								if(isset($cek_nrp))
								{
									if($cek_nrp == $nrptbl[$j]){
										$update_data = array(
											'nrp' => $nrptbl[$j],
											'nama' => $namatbl[$j] ,
											'periodewisuda' => $periodewisuda,
											'hari_tanggal_wisuda' => $tanggal_id,
											'jurusan_mhs' => $namajurusan[$j],
											'deret' => $kodekursi,
											'no_deret' => $nomorkursi,
											'kursi' => $kursi,
											'urut' => $urut
											);
										$this->simwisuda->where('nrp', $cek_nrp);
										$this->simwisuda->update('kursiwisuda', $update_data);//Update data to database 	
									}
								}
									else{
										$insert_data = array(
										'nrp' => $nrptbl[$j],
										'nama' => $namatbl[$j] ,
										'periodewisuda' => $periodewisuda,
										'hari_tanggal_wisuda' => $tanggal_id,
										'jurusan_mhs' => $namajurusan[$j],
										'deret' => $kodekursi,
										'no_deret' => $nomorkursi,
										'kursi' => $kursi,
										'urut' => $urut
										);
										$this->simwisuda->insert('kursiwisuda', $insert_data);//insert data to database 
									}								
							}
									
									$var_tempnrp=substr($nrptbl[$j],0,2).substr($nrptbl[$j],4,2);	
									$var_tempfakultas=substr($nrptbl[$j],0,1);											
									
									$banyaknya=0;	
									
									$cekbaris=$ctrbaris;
									$jumbaris=50;
									
									/*Penomeran halaman Awal Sampai Akhir-1 */
									if ($cekbaris==$jumbaris){
											$html=$html.'</table></div></td></tr>											
											<tr>
												<td width="45%"></td>
												<td align="center" width="1.5cm" border="0" style=\"border-radius: 10px;\">
													<b>'.$halaman.'</b>
												</td>
												<td width="45%"></td>
											</tr>										
										</table>
										</td></tr>
										</table>';
											$pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
											
											$flag=0;
											$html='';
											$pdf->AddPage();
											$halaman=$halaman+1;
										//}
										$cekbaris=0;
										$ctrbaris=0;
										$cekbidangkeahlian=0;
									 }	 
							
					}
					
				
						
					$html=$html."</table></div><br><br>";
					/*Penomeran halaman Akhir*/
					$html=$html.'</td></tr>
								<tr>
											<td width="45%"></td>
											<td align="center" width="1.5cm">
												'.$halaman.'
											</td>
											<td width="45%"></td>
										</tr>
										
								</table></td></tr></table>';
					$pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
								
	
			$pdf->Output("Wisuda ".$periodewisuda." Hari ".$buku_ke ,"I");
	}
	//GENERATE DENAH
	else 
	{
		$halaman=0;
		$ctr=0;
		foreach ($data_prodi as $key => $value) 
		{
					
			$valarr = explode("-", $value); 
			
			$fak_jur_prog = $this->Db_kursi->fakultas_jurusan_program($valarr[0]);
			foreach ($fak_jur_prog->result_array() as $row)
			{
				
				$fakultas = $row['NAMAFAKULTAS_2'];
				$jurusan = $row['NAMAJURUSAN'];
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
				$namajur = $program.'-'.$jurusan;
				
			}
						
			$fak_jur = $this->Db_kursi->ambil_fakultas_jurusan($valarr[0],$urutandata,$periodewisuda);		
			foreach ($fak_jur->result_array() as $row)
			{	
				$ctr=$ctr+1;				
				/*SIM WISUDA*/				
				$namajurusan[$ctr]=$namajur;
				$namatbl[$ctr]=ucwords(strtolower($row['NAMA']));
			}	
		}
			
			
		$pdf->AddPage();
		$html='';
		
		$var_tempnrp="";
		$var_prodisimwisuda="";
		$cekbidangkeahlian=0;	
		$ctrbaris=0;
		$ctrdenah=1;
		$no=0;
		$cekkursikiri=0;
		$cekkursikanan=0;//jumlah mhs per jurusan di baris x <KANAN> 17-20 ->$cekkursikanan
		$namakursi=0;
		$nomorkursi=0;
		$ctrkursi=1;
		$kodekursi='';
		$testkiri='';
		$testkanan='';
		$flagkanan=0;
		$flagkiri=0;
		$tempkursikiri=0;
		$tempkursikanan=0;//berapa banyak mhs di kurs kanan ex:41-61, $tempkursikanan=20
		$tempkursikiri1=0;//nomer urut akhir  kursi per jurusan <KIRI> ex : 41-61(S2 - Fisika ), $tempkursikiri1=61
		$tempkursikanan1=0;		
		$cekjumlahkursi=0;
		$nourutkursi=0;
		$baris='';
		$data_kiri='';
		$data_kanan='';
		$cb_kiri='';
		
		$coba_kode='';
		
		for ($j=1; $j<=$ctr; $j++)
		{
			$ctrbaris=$ctrbaris+1;
				
			if ($var_tempnrp!=$namajurusan[$j])//beda jurusan
			{	
				$tempkursikiri=$cekkursikiri;
				$tempkursikanan=$cekkursikanan;
				
				if (($tempkursikiri!=0) || ($tempkursikanan!=0))//cek apakah kursi ada mhs
				{
					if ($data_kursikiri[$ctrkursi]!=$cekkursikiri)
					{
						if ($tempkursikiri>0)
						{													
							$data_kiri=$data_kiri."-".$nourutkursi." (".$var_tempnrp."), "; // baris kiri jurusan beda
							
							$denahkiri[$ctrdenah]=$data_kiri;
							$tempkursikiri1=$nourutkursi;
							$data_kiri=$data_kiri.($nourutkursi+1);
							
					    }	
					}	
					if ($data_kursikanan[$ctrkursi]!=$cekkursikanan)
					{
						$data_kanan2='';
						if ($tempkursikanan>0)
						{
							//$testkanan=$testkanan." - ".$nourutkursi." ".$var_tempnrp." awkan ";  //beda jurusan di baris kanan
							//$data_kanan=$testkanan." - ".$nourutkursi." ".$var_tempnrp." awkan ";  //beda jurusan di baris kanan
							
							$data_kanan=$data_kanan."-".$nourutkursi." (".$var_tempnrp."), ";  //beda jurusan di baris kanan
							//$denahkanan[$ctrdenah]=$testkanan;
							
							$denahkanan[$ctrdenah]=$data_kanan;
							$tempkursikanan1=$nourutkursi;
							$data_kanan=$data_kanan.($nourutkursi+1);
						}						
					}		
				}		
			}	
			$kodekursi=chr(65+$namakursi);
			
			//$html=$html."apaini ".$data_kursikiri[$ctrkursi]." ".$cekkursikiri."<br>";
			
			if ($data_kursikiri[$ctrkursi]==$cekkursikiri) //jika counter == jumlah kursi kiri
			{
				if ($flagkiri==0)
				{
					if ($tempkursikiri1>0)
					{						
						//JIKA BERAKHIR DI KIRI BARIS X (data berikutnya di kolom kanan pada baris yang sama)
						$data_kiri=$data_kiri."-".$nourutkursi." (".$namajurusan[$j].")"; //jurusan akhir kolom kiri
						$tempkursikiri1=0;
					}
					//kiri pertamax !!!
					else
					{							
						//$testkiri=$testkiri." - ".$nourutkursi." ".$namajurusan[$j]." ";							
						$data_kiri=$data_kiri."-".$nourutkursi." (".$namajurusan[$j].") ";	//kiri pertamax dan kiri hanya 1 prodi
					}
					
					$denahkiri[$ctrdenah]=$data_kiri;
					$flagkiri=1;
					
				}
				$cekkursikanan=$cekkursikanan+1;
				$nourutkursi=$nourutkursi+1;
				if ($cekkursikanan==1)
					{	
						//$testkanan=$testkanan.$kodekursi."(".$data_kursikanan[$ctrkursi].") ".$nourutkursi;
						//$data_kanan=$testkanan.$kodekursi."(".$data_kursikanan[$ctrkursi].") ".$nourutkursi;
						$data_kanan=$nourutkursi;
						$denahkanan[$ctrdenah]=$data_kanan;
						
						$coba_kode[$ctrdenah]=$kodekursi;
					}
				
				$nomorkursi=$cekkursikanan;
				$kursi='Kanan';
			}
			else
			{
				$cekkursikiri=$cekkursikiri+1;
				$nourutkursi=$nourutkursi+1;
				if ($cekkursikiri==1)
				{
					//$testkiri=$testkiri.$kodekursi."(".$data_kursikiri[$ctrkursi].") ".$nourutkursi;
					//$data_kiri=$testkiri."KODE".$kodekursi."(".$data_kursikiri[$ctrkursi].") ".$nourutkursi;
					$data_kiri=$nourutkursi;
					$denahkiri[$ctrdenah]=$data_kiri;
					$coba_kode[$ctrdenah]=$kodekursi;
				}
			
				$nomorkursi=$cekkursikiri;
				
				$kursi='Kiri';
			}
					
			if ($data_kursikanan[$ctrkursi]==$cekkursikanan)
				{
					$cekjumlahkursi=$cekjumlahkursi+$data_kursikanan[$ctrkursi];
					$cekjumlahkursi=$cekjumlahkursi+$data_kursikiri[$ctrkursi];
				
					if ($flagkanan==0)
					{
						if ($tempkursikanan1>0)
							{
								//$testkanan=$testkanan.($tempkursikanan1+1)." - ".$nourutkursi." ".$namajurusan[$j]." apa "; //kursi kanan
								
								//beda jurusan di baris yg sama <kanan>
								$data_kanan=$data_kanan."-".$nourutkursi." (".$namajurusan[$j].")"; //kursi kanan 
								$tempkursikanan1=0;
							}
						else
							{
								//$testkanan=$testkanan." - ".$nourutkursi." ".$namajurusan[$j]." ";
								//$data_kanan=$testkanan." - ".$nourutkursi." ".$namajurusan[$j]." ";
								$data_kanan=$data_kanan."-".$nourutkursi." (".$namajurusan[$j].")";	//kanan pertamax !!!
								
							}
						//$denahkanan[$ctrdenah]=$testkanan;
						$denahkanan[$ctrdenah]=$data_kanan;
						$flagkanan=1;
					}
					$ctrdenah=$ctrdenah+1;		
					$cekkursikiri=0;
					$cekkursikanan=0;
					$flagkanan=0;
					$flagkiri=0;
					$namakursi=$namakursi+1;
					$ctrkursi=$ctrkursi+1;
					$testkanan='';
					$testkiri='aaa';
					
					$data_kiri='bbb';
					$data_kanan='';
					
				}
						
			$var_tempnrp=$namajurusan[$j];
			
			$tempkursikiri=0;
			$tempkursikanan=0;	
			
		}
		
		$tinggi = '180';	
		$html=$html.'';
		$html=$html."		
			<br>
				<table width='100%'>
					<tr>
						<td style=\"width:'100%'; height:'".$tinggi.".mm'; border:3px solid black;\">
							<br><br>
							<table width=\"100%\" >
								<tr>
									<td align=\"center\" width=\"10%\"><img src=\"/simwisuda/inc/logo_its.gif\" style=\"width: 80; height: 80\" /></td>
									<td align=\"center\" width=\"80%\">	
										<h1 align=\"center\">
											DENAH TEMPAT DUDUK WISUDAWAN KE ".$periodewisuda."<br>
											INSTITUT TEKNOLOGI SEPULUH NOPEMBER<br>										
											Program Doktor, Magister, Sarjana, Diploma dan Politeknik<br>										
											Tanggal Wisuda : ".$tanggal_id.", PUKUL 07. 00 s.d selesai
										</h1>
										<br>
									</td>
									<td align=\"center\" width=\"10%\"><img src=\"/simwisuda/inc/eco.jpg\" style=\"width: 80; height: 80\" /></td>
								</tr>
							</table>
							
							
							<!--table width=\"100%\" style=\"border:1px solid black;\"-->
							<table width=\"100%\">
							<tr>
								<td width=\"2%\"></td>
								<td width=\"32%\"><h2 align=\"left\">KURSI KIRI</h2></td>
								<td width=\"32%\"><h1 align=\"center\">TEMPAT PROSESI</h1></td>
								<td width=\"32%\"><h2 align=\"right\">KURSI KANAN</h2></td>
								<td width=\"2%\"></td>
							</tr>
							</table>
							<br>
							<p align=\"center\">
							<table width=\"100%\">
							";
							
						$cekjumlahkursi=$cekjumlahkursi+$data_kursikanan[$ctrkursi];
						$cekjumlahkursi=$cekjumlahkursi+$data_kursikiri[$ctrkursi];
										
						if ($cekkursikanan>0)
						{
							if ($data_kursikanan[$ctrkursi]>$cekkursikanan)
							{
								if ($tempkursikanan1>0)
								{
									//$testkanan=$testkanan.($tempkursikanan1+1)." - ".$nourutkursi." ".$namajurusan[$ctr]." ** ";
									//$data_kanan=$testkanan.($tempkursikanan1+1)." - ".$nourutkursi." ".$namajurusan[$ctr]." ** ";
									$data_kanan=$data_kanan."-".$nourutkursi." ".$namajurusan[$ctr]." ";
									$tempkursikanan1=0;
								}
								else
									{
										//$testkanan=$testkanan." - ".$nourutkursi." ".$namajurusan[$ctr]." + "; //denah kanan akhir
										$data_kanan=$data_kanan."-".$nourutkursi." (".$namajurusan[$ctr].")"; //denah kanan akhir
									}	
								//$denahkanan[$ctrdenah]=$testkanan;				
								$denahkanan[$ctrdenah]=$data_kanan;				
							}
						}
						else
						{
							//$denahkanan[$ctrdenah]="-";
							$denahkanan[$ctrdenah]=""; //sisa denah kanan kosong
                        } 
						if ($cekkursikiri>0)
						{  
						if ($data_kursikiri[$ctrkursi]>$cekkursikiri)
							{
								if ($tempkursikiri1>0)
									{
										//$testkiri=$testkiri.($tempkursikiri1+1)." - ".$nourutkursi." ".$namajurusan[$ctr]." ";
										
										//DATA TERAKHIR DI KIRI
										$data_kiri=$data_kiri."-".$nourutkursi." (".$namajurusan[$ctr].") ";
										$tempkursikiri1=0;
									}
								else
								{
									//$testkiri=$testkiri." - ".$nourutkursi." ".$namajurusan[$ctr]." ";
									
									//baris akhir kiri (sebelum data akhir prodi)
									//$data_kiri=$data_kiri."cak-".$nourutkursi." (".$namajurusan[$ctr].") ";
									$data_kiri=$data_kiri."-".$nourutkursi." (".$namajurusan[$ctr].") ";
									//$cb_kiri = $testkiri;
								}	
								//$denahkiri[$ctrdenah]=$testkiri.'  '.$cb_kiri;				
								//$denahkiri[$ctrdenah]=$data_kiri.'- hf'.$cb_kiri; //kiri akhir	
								$denahkiri[$ctrdenah]=$data_kiri.' '.$cb_kiri; //kiri akhir	
								//$cb_kiri[$ctrdenah] = $testkiri;
							}		
						}  	
							else
							{
								//$denahkiri[$ctrdenah]="-";
								$denahkiri[$ctrdenah]=""; //kosong
                            } 											  
						
						$html=$html."
						<tr>
							<td width=\"9.5%\"><br><br><img src=\"/simwisuda/inc/baris_kiri.png\" style=\" height: 200\" /></td>
							<td width=\"35%\">
						";
						$html=$html."
										<table  width=\"100%\" >";
						$coba_kodean='';
						$total_kiri=0;
												
						if($banyak_baris>$ctrdenah){
							$banyak_baris = $ctrdenah;
						}		
					
						for ($j=1; $j<=$banyak_baris; $j++)
						{
							//$kodekursi2=chr(65);
							$html=$html."
								<tr>
									<td width=\"12%\" style=\"border:1px solid black;\">".$coba_kode[$j]." : ".$data_kursikiri[$j]."</td>
									<td width=\"88%\" style=\"border:1px solid black;\">".$denahkiri[$j]."</td>
								</tr>										
							";
							$total_kiri = $total_kiri + $data_kursikiri[$j];
						}
						$html=$html."
									<tr>
										<td style=\"border:1px solid black;\">".$total_kiri."</td>
										<td style=\"border:1px solid black;\"></td>
									</tr>
								</table>	
							</td>	
							<td style=\"width:11%\">
								<br><br>
								<img src=\"/simwisuda/inc/masuk.png\"  style=\" height: 200\" />
							</td>";
						$html=$html."									
							<td width=\"35%\">				
								<table border='1' style=\"border:1px solid black;\" width=\"100%\">";
						
						$total_kanan=0;
						for ($j=1; $j<=$banyak_baris; $j++)
						{
							//$kodekursi2=chr(65);
							$html=$html."
									<tr>
										<td width=\"88%\" style=\"border:1px solid black;\">".$denahkanan[$j]."</td>
										<td width=\"13%\" style=\"border:1px solid black;\">".$coba_kode[$j]." : ".$data_kursikanan[$j]."</td>							
									</tr>										
							";
							$total_kanan = $total_kiri + $data_kursikanan[$j];
							
							
						}
				$html=$html."	
							<tr>
								<td></td>
								<td style=\"border:1px solid black;\">".$total_kanan."</td>
							</tr>
						</table>
					</td>
					<td style=\"width:4.25%\"><br><br>
						&nbsp;&nbsp;<img src=\"/simwisuda/inc/masuk.png\" />
						
					</td>
					<td style=\"width:4.25%\"><br><br>
						<img src=\"/simwisuda/inc/baris_kanan.png\"  style=\" height: 200\" />
					</td>
				</tr>
				<tr>
					<!--td style=\"border:1px solid red\"-->
					<td>
						<img src=\"/simwisuda/inc/panah_ataskiri.png\" style=\"height:30\"/>
					</td>
					<td>
						<img src=\"/simwisuda/inc/panah_bariskiri.png\" style=\"height:30\"/><br>
					</td>
					<td>
						<img src=\"/simwisuda/inc/panah_tengah.png\" style=\"height:30\"/>
					</td>
					<td>
						<img src=\"/simwisuda/inc/panah_bariskanan.png\" style=\"height:30\"/><br>
						<img src=\"/simwisuda/inc/panah_kanan-kiri.png\" style=\"height:20\" />
					</td>
					<td></td>
					<td>
						<img src=\"/simwisuda/inc/bawah_kiri.png\" />
					</td>
				</tr>
				";					
								
				$html=$html."</table></p>		
						</td>
					</tr>
				</table>
				<table width=\"190%\">
					<tr>
						<td align=\"right\"><h3><i><strong>Panitia Wisuda Ke-".$periodewisuda." ITS</strong></i></h3></td>
						<td style=\"width:3.5%\"></td>
					</tr>
				</table>";
		//$pdf->AddPage();
		////$html='';
		//$html=$html."heheheheh";
		$pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');	
		
		if($ctrdenah > $banyak_baris){
			/*PAGE 2*/
			$pdf->AddPage();		
			//$html2="CERTIFICATE NUMBER 1 IMAGE HERE";
			
			$tinggi = '180';
			$html2="		
			<br>
				<table width='100%'>
					<tr>
						<td style=\"width:'100%'; height:'".$tinggi.".mm'; border:3px solid black;\">
							<br><br>
							<table width=\"100%\" >
								<tr>
									<td align=\"center\" width=\"10%\"><img src=\"/simwisuda/inc/logo_its.gif\" style=\"width: 80; height: 80\" /></td>
									<td align=\"center\" width=\"80%\">	
										<h1 align=\"center\">
											DENAH TEMPAT DUDUK WISUDAWAN KE ".$periodewisuda."<br>
											INSTITUT TEKNOLOGI SEPULUH NOPEMBER<br>										
											Program Doktor, Magister, Sarjana, Diploma dan Politeknik<br>										
											Tanggal Wisuda : ".$tanggal_id.", PUKUL 07. 00 s.d selesai
										</h1>
										<br>
									</td>
									<td align=\"center\" width=\"10%\"><img src=\"/simwisuda/inc/eco.jpg\" style=\"width: 80; height: 80\" /></td>
								</tr>
							</table>
							<table width=\"100%\">
							<tr>
								<td width=\"2%\"></td>
								<td width=\"32%\"><h2 align=\"left\">KURSI KIRI</h2></td>
								<td width=\"32%\"><h1 align=\"center\">TEMPAT PROSESI</h1></td>
								<td width=\"32%\"><h2 align=\"right\">KURSI KANAN</h2></td>
								<td width=\"2%\"></td>
							</tr>
							</table>
							<br>
							<p align=\"center\">
							<table width=\"100%\">
								<tr>
									<td width=\"9.5%\"><br><br><img src=\"/simwisuda/inc/baris_kiri.png\" style=\" height: 200\" /></td>
									<td width=\"35%\">
										<table  width=\"100%\" >
							";
				$total_kiri=0;
				for ($j=$banyak_baris+1; $j<=$ctrdenah; $j++)
				//for ($j=1; $j<=$ctrdenah; $j++)
				{
					//$kodekursi2=chr(65);
					$html2=$html2."
						<tr>
							<td width=\"12%\" style=\"border:1px solid black;\">".$coba_kode[$j]." : ".$data_kursikiri[$j]."</td>
							<td width=\"88%\" style=\"border:1px solid black;\">".$denahkiri[$j]."</td>
						</tr>										
					";
					$total_kiri = $total_kiri + $data_kursikiri[$j];
				}
				$html2=$html2."
						<tr>
							<td style=\"border:1px solid black;\">".$total_kiri."</td>
							<td style=\"border:1px solid black;\"></td>
						</tr>
					</table>	
				</td>	
				<td style=\"width:11%\">
					<br><br>
					<img src=\"/simwisuda/inc/masuk.png\"  style=\" height: 200\" />
				</td>";
				$html2=$html2."
				<td width=\"35%\">				
					<table border='1' style=\"border:1px solid black;\" width=\"100%\">
				";
				$total_kanan=0;
				for ($j=($banyak_baris+1); $j<=$ctrdenah; $j++)
				{
					//$kodekursi2=chr(65);
					$html2=$html2."
						<tr>
							<td width=\"88%\" style=\"border:1px solid black;\">".$denahkanan[$j]."</td>
							<td width=\"13%\" style=\"border:1px solid black;\">".$coba_kode[$j]." : ".$data_kursikanan[$j]."</td>							
						</tr>	
					
					";
					$total_kanan = $total_kanan + $data_kursikanan[$j];
				}
				$html2=$html2."
							<tr>
								<td></td>
								<td style=\"border:1px solid black;\">".$total_kanan."</td>
							</tr>
						</table>
					</td>
					<td style=\"width:4.25%\"><br><br>
						&nbsp;&nbsp;<img src=\"/simwisuda/inc/masuk.png\" />
						
					</td>
					<td style=\"width:4.25%\"><br><br>
						<img src=\"/simwisuda/inc/baris_kanan.png\"  style=\" height: 200\" />
					</td>	
				</tr>
				<tr>
					<!--td style=\"border:1px solid red\"-->
					<td>
						<img src=\"/simwisuda/inc/panah_ataskiri.png\" style=\"height:30\"/>
					</td>
					<td>
						<img src=\"/simwisuda/inc/panah_bariskiri.png\" style=\"height:30\"/><br>
					</td>
					<td>
						<img src=\"/simwisuda/inc/panah_tengah.png\" style=\"height:30\"/>
					</td>
					<td>
						<img src=\"/simwisuda/inc/panah_bariskanan.png\" style=\"height:30\"/><br>
						<img src=\"/simwisuda/inc/panah_kanan-kiri.png\" style=\"height:20\" />
					</td>
					<td></td>
					<td>
						<img src=\"/simwisuda/inc/bawah_kiri.png\" />
					</td>
				</tr>
				
				";
				
			
			$html2=$html2."			
											
						</table></p>						
						</td>
					</tr>
				</table>
				<table width=\"190%\">
					<tr>
						<td align=\"right\"><h3><i><strong>Panitia Wisuda Ke-".$periodewisuda." ITS</strong></i></h3></td>
						<td style=\"width:3.5%\"></td>
					</tr>
				</table>
			";
			
			
			// output the HTML content
			$pdf->writeHTML($html2, true, 0, true, 0);
			//$pdf->writeHTML($html2,FALSE,FALSE,FALSE,'L');	
			// reset pointer to the last page
			$pdf->lastPage();		
			
		}
		
		
		$pdf->Output("Denah Wisuda ".$periodewisuda." Hari ".$buku_ke ,"I");
	
	}
	
?>	