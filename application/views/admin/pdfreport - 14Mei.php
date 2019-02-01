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
			$pdf = new TCPDF("L", "mm",array(190,230), false, 'ISO-8859-1', false);
		}
		else{
			$pdf = new TCPDF("L", "mm",$ukurankertas, false, 'ISO-8859-1', false);			
		}
	}
	else
	{
		if ($ukurankertas=='ITS PAPER'){
			$pdf = new TCPDF("P", "mm",array(190,230), false, 'ISO-8859-1', false);
		}
		else{
			$pdf = new TCPDF("P", "mm",$ukurankertas, true, 'UTF-8', false); //DEFULT UTF-8 UNICODE
			//$pdf = new TCPDF("P", "mm",$ukurankertas, false, 'ISO-8859-1', false);			
		}
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
	$pdf->SetFont('times', '', 9);
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
					$fak_jur_prog = $this->Db_model->fakultas_jurusan_program($valarr[0]);
					foreach ($fak_jur_prog->result_array() as $row)
					{
						$fakultas = $row['FA_Nama'];
						$jurusan = $row['JU_Nama'];
						$program = $row['PS_Nama'];
						//$namajur = $row['PS_NamaJurusan'];
						$namajur = $program.' - '.$jurusan;
						$lulusan_ke = $row['lulusan_ke']+1;	
						$kojur = $row['kojur'];
					}
								
					$fak_jur = $this->Db_model->ambil_fakultas_jurusan($valarr[0],$urutandata,$periodewisuda);						
					
					foreach ($fak_jur->result_array() as $row)
					{	
						$ctr=$ctr+1;
						
						/*SIM WISUDA*/
						$nrptbl[$ctr]=$row['NRP'];
						$namafakultas[$ctr]=$fakultas;
						$namajurusan[$ctr]=$namajur;
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
				}
				


					$halaman=$halaman+1;
					$pdf->AddPage();
					//$pdf->setPage($halaman, true);
											
					$no=0;	
					$urut=0;
					$jumlah=1;
					$html='';
					
					$tinggi = ($tinggi_kertas-$margintop-$marginbottom)."mm";
							$html=$html."<br>
							<table border='1' style=\"border:1px solid black;\" width='100%'>
								<tr>
									<td style=\"width:'100%'; height:'".$tinggi.".mm'; border:3px solid black;\">
										<table border='0' width='100%'>
											<tr>
												<td style=\"width:'100%'; height:'".($tinggi-$marginbottom).".mm';\">";	
					
					
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
								
							<br>&nbsp;
									
																
									<div align="center">
									<table border="1" align="center" >
										<tr>
											<td align="center" width="10%"><img src="/coba/inc/logo_its.gif" style="width: 50; height: 50" /></td>
											<td align="center" width="80%">	
												<h3 align="center">
													DAFTAR WISUDAWAN<br>
													???PROGRAM DOKTOR, MAGISTER, DAN POLITEKNIK???<br>
													WISUDA KE '.$periodewisuda.', '.$tanggal_id.'
												</h3>
											</td>
											<td align="center" width="10%"><img src="/coba/inc/eco.jpg" style="width: 50; height: 50" /></td>
										</tr>
										<tr>
											<td style="width:7mm"><b>NO</b></td>
											<td style="width:35mm"><b>JURUSAN</b></td>
											<td style="width:13mm"><b>DERET</b></td>
											<td style="width:10mm"></td>		
											<td style="width:12mm"><b>KURSI</b></td>																							
											<td style="width:6%"><b>URUT</b></td>
											<td style="width:22mm"><b>NRP</b></td>
											<td style="width:35%"><b>N A M A </b></td>	
											<td style="width:10mm"><b>CEK1</b></td>
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
								<table border='1' style=\"border:1px solid black;\" width='100%'>
									<tr>
										<td style=\"width:'100%'; height:'".$tinggi.".mm'; border:3px solid black;\">
											<table border='0' width='100%'>
												<tr>
													<td style=\"width:'100%'; height:'".($tinggi-$marginbottom).".mm';\">";	
							
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
								
								<br>&nbsp;
										<h3 align="center">
											DAFTAR PESERTA WISUDA KE-'.$periodewisuda.'<br>
											INSTITUT TEKNOLOGI SEPULUH NOPEMBER<br>
											Tanggal Lulus : '.date("d-m-Y",strtotime($tglkelulusan)).' <br>
											Tanggal Wisuda : '.date("d-m-Y",strtotime($tanggal)).'<br>
										</h3>
																	
										<div align="center">
										<table border="1" align="center" >
											<tr>
												<td style="width:7mm"><b>NO</b></td>
												<td style="width:35mm"><b>JURUSAN</b></td>
												<td style="width:13mm"><b>DERET</b></td>
												<td style="width:10mm"></td>		
												<td style="width:12mm"><b>KURSI</b></td>																							
												<td style="width:6%"><b>URUT</b></td>
												<td style="width:22mm"><b>NRP</b></td>
												<td style="width:35%"><b>N A M A </b></td>	
												<td style="width:10mm"><b>CEK1</b></td>
											</tr>
											';
								$flag=1;	
							}
						$cont = 0;
						
						/*TAMPIL FAKULTAS*/
						if ($var_tempfakultas!=substr($nrptbl[$j],0,2))
						{	
							foreach ($fak_jur_prog->result_array() as $row)
							{
								$var_fakultas = $row['FA_Nama'];
							}
							$html=$html.'					
								<tr>
									<td colspan="9" align="center"><b>'.strtoupper($namafakultas[$j]). '</b></td>
								</tr>';
							
						}
						
						/*TAMPIL NAMA JURUSAN SEBELUM DATA WISUDAWAN*/
						if ($var_tempnrp!=$namajurusan[$j])
						{	$no=0;
							$cekbidangkeahlian=$cekbidangkeahlian+1;	
							$html=$html.'					
								<tr>
									<td colspan="9" align="center"><br><b>'.strtoupper($namajurusan[$j]). '</b></td>
								</tr>';
							$jumlah=$jumlah+1;
							
							$cont = $jumlah;
						}
						
							if ($data_kursikiri[$ctrkursi]==$cekkursikiri)
								{
									$cekkursikanan=$cekkursikanan+1;
									$nomorkursi=$cekkursikanan;
									$kursi='Kanan';
								}
							else
								{
									$cekkursikiri=$cekkursikiri+1;
									$nomorkursi=$cekkursikiri;
									$kursi='Kiri';
								}
							$kodekursi=chr(65+$namakursi);
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
								}
								td.font10 {
									font-size:10pt;
								}
								td.font11 {
								font-size:11pt;
								}
							</style>
							<tr>
								<td style="width:7mm">'.$no.'</td>
								<td style="width:35mm" class="font9">'.$namajurusan[$j].'</td>
								<td style="width:13mm">'.$kodekursi.'</td>';
							
							$html=$html.'<td style="width:10mm">'.$nomorkursi.'</td>
											<td style="width:12mm">'.$kursi.'</td>';
							
							$html=$html.'<td style="width:6%">'.$urut.'</td>
										<td style="width:22mm">'.$nrptbl[$j].'</td>
										';
							if(strlen($namatbl[$j])>31){
								$namatbl[$j] = rtrim($namatbl[$j], ' ');
								$html=$html.'
										<td class="font10" style="width:35%" align="left"> '.strtoupper($namatbl[$j]).'</td>
							';	
							}
							else{
								$html=$html.'
										<td class="font10" style="width:35%" align="left"> '.strtoupper($namatbl[$j]).'</td>
							';	
							}
									
							if($predikat[$j]=='DP'){
								$html=$html.'
								<td style="width:10mm; border: 1px solid black">'.$predikat[$j].'</td>
								</tr>';
							}
							else{
								$html=$html.'
								<td style="width:10mm; border: 1px solid black"></td>
								</tr>';
							}							
									
									//$var_tempnrp=substr($nrptbl[$j],0,2).substr($nrptbl[$j],4,3);	
									$var_tempfakultas=substr($nrptbl[$j],0,2);											
									$var_tempnrp=$namajurusan[$j];
									
									$banyaknya=0;	
									
									$cekbaris=$ctrbaris+($cekbidangkeahlian*3);
									if ($cekbidangkeahlian<=0)
									{
										$jumbaris=50;
									}
									else
									{
										$jumbaris=50;
									}
									if ($cekbaris==$jumbaris){
											$html=$html.'</table></div></td></tr>
											<tr>
												<td width="45%"></td>
												<td align="center" width="1.5cm" border="1" style=\"border-radius: 10px;\">
													'.$halaman.'
												</td>
												<td width="45%"></td>
											</tr>
											</table>
											</td></tr></table>';
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
					/*Penomeran halaman */
					$html=$html.'</td></tr>
								<tr>
											<td width="45%"></td>
											<td align="center" width="1.5cm" border="1" style=\"border-radius: 10px;\">
												'.$halaman.'
											</td>
											<td width="45%"></td>
										</tr>
										
								</table></td></tr></table>';
								
						
					$pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
								
	
			$pdf->Output("Wisuda ".$periodewisuda." Hari ".$buku_ke ,"I");
	}
	//DENAH
	else 
	{
		$halaman=0;
		$ctr=0;
		foreach ($data_prodi as $key => $value) 
		{
					
			$valarr = explode("-", $value); 
			/*
			$data_tglperiode = $this->Db_model->ambil_kelulusan($periodewisuda);
			foreach ($data_tglperiode->result_array() as $row)
			{
				$tglkelulusan = $row['TGLKELULUSAN'];			
			}
			
			
			$data_tgl_kelulusan = $this->Db_model->fakultas_jurusan_program($periodewisuda);
			foreach ($data_tgl_kelulusan as $row)
			{
				$tgl_lulus = $row['TGLKELULUSAN'];			
			}*/
			
			$fak_jur_prog = $this->Db_model->fakultas_jurusan_program($valarr[0]);
			foreach ($fak_jur_prog->result_array() as $row)
			{
				$fakultas = $row['FA_Nama'];
				$jurusan = $row['JU_Nama'];
				$program = $row['PS_Nama'];
				$namajur = $program.' - '.$jurusan;
				$lulusan_ke = $row['lulusan_ke']+1;	
				$kojur = $row['kojur'];
			}
						
			$fak_jur = $this->Db_model->ambil_fakultas_jurusan($valarr[0],$urutandata,$periodewisuda);						
			
			foreach ($fak_jur->result_array() as $row)
			{	
				$ctr=$ctr+1;
				
				/*SIM WISUDA*/
				$nrptbl[$ctr]=$row['NRP'];
				$namajurusan[$ctr]=$namajur;
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
		$cekkursikanan=0;
		$namakursi=0;
		$nomorkursi=0;
		$ctrkursi=1;
		$kodekursi='';
		$testkiri='';
		$testkanan='';
		$flagkanan=0;
		$flagkiri=0;
		$tempkursikiri=0;
		$tempkursikanan=0;
		$tempkursikiri1=0;
		$tempkursikanan1=0;		
		$cekjumlahkursi=0;
		for ($j=1; $j<=$ctr; $j++)
		{
			$ctrbaris=$ctrbaris+1;
				
			if ($var_tempnrp!=$namajurusan[$j])
			{	
				$tempkursikiri=$cekkursikiri;
				$tempkursikanan=$cekkursikanan;
				if (($tempkursikiri!=0) || ($tempkursikanan!=0))
				  {
					if ($data_kursikiri[$ctrkursi]!=$cekkursikiri)
						{
							if ($tempkursikiri>0)
							  {
								$testkiri=$testkiri." - ".$tempkursikiri." ".$var_tempnrp." ";
								$denahkiri[$ctrdenah]=$testkiri;
								$tempkursikiri1=$tempkursikiri;
							   }	
						}	
					if ($data_kursikanan[$ctrkursi]!=$cekkursikanan)
						{
							if ($tempkursikanan>0)
							  {
								$testkanan=$testkanan." - ".$tempkursikanan." ".$var_tempnrp." ";
								$denahkanan[$ctrdenah]=$testkanan;
								$tempkursikanan1=$tempkursikanan;
							  }	
						}		
				  }		
			}	
			$kodekursi=chr(65+$namakursi);
				
			if ($data_kursikiri[$ctrkursi]==$cekkursikiri)
			{
				if ($flagkiri==0)
				{
					if ($tempkursikiri1>0)
					{
						$testkiri=$testkiri.($tempkursikiri1+1)." - ".$cekkursikiri." ".$namajurusan[$j]." ";
					}
					else
					{
						$testkiri=$testkiri." - ".$cekkursikiri." ".$namajurusan[$j]." ";	
					}
					$denahkiri[$ctrdenah]=$testkiri;
					$flagkiri=1;
				}
				$cekkursikanan=$cekkursikanan+1;
				if ($cekkursikanan==1)
				{	
					$testkanan=$testkanan.$kodekursi."(".$data_kursikanan[$ctrkursi].") ".$cekkursikanan;
					$denahkanan[$ctrdenah]=$testkanan;
				}
				
				$nomorkursi=$cekkursikanan;
				$kursi='Kanan';
			}
			else
			{
				$cekkursikiri=$cekkursikiri+1;
				if ($cekkursikiri==1)
				{
					$testkiri=$testkiri.$kodekursi."(".$data_kursikiri[$ctrkursi].") ".$cekkursikiri;
					$denahkiri[$ctrdenah]=$testkiri;
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
							$testkanan=$testkanan.($tempkursikanan1+1)." - ".$cekkursikanan." ".$namajurusan[$j]." ";
						}
						else
						{
							$testkanan=$testkanan." - ".$cekkursikanan." ".$namajurusan[$j]." ";
						}
						$denahkanan[$ctrdenah]=$testkanan;
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
					$testkiri='';
					
				}
						
			$var_tempnrp=$namajurusan[$j];
			
			$tempkursikiri=0;
			$tempkursikanan=0;	
			
		}
		
		$tinggi = '180';	
		$html=$html.'';
		$html=$html."		
			<br>
				<table border='1' style=\"border:1px solid red;\" width='100%'>
					<tr>
						<td style=\"width:'100%'; height:'".$tinggi.".mm'; border:3px solid blue;\">
							<br><br>
							<table border=\"1\">
								<tr>
									<td align=\"center\" width=\"10%\"><img src=\"/coba/inc/logo_its.gif\" style=\"width: 50; height: 50\" /></td>
									<td align=\"center\" width=\"80%\">	
										<h3 align=\"center\">
											DENAH TEMPAT DUDUK WISUDAWAN KE ".$periodewisuda."<br>
											INSTITUT TEKNOLOGI SEPULUH NOPEMBER<br>
											Program Doktor, Magister, Sarjana, dan Poloteknik<br>
											Tanggal Wisuda : ".$tanggal_id.", PUKUL 07. 00 s.d selesai<br>
										</h3>
									</td>
									<td align=\"center\" width=\"10%\"><img src=\"/coba/inc/eco.jpg\" style=\"width: 50; height: 50\" /></td>
								</tr>
							</table>
							
							
							<table>
							<tr>
								<td><h2 align=\"left\">KURSI KIRI</h2></td>
								<td><h1 align=\"center\">TEMPAT PROSESI</h1></td>
								<td><h2 align=\"right\">KURSI KANAN</h2></td>
							</tr>
							</table>
							<br>
						<p align=\"center\">
							<table style=\"border:1px solid black;\" width='70%'>
							";
							
						$cekjumlahkursi=$cekjumlahkursi+$data_kursikanan[$ctrkursi];
						$cekjumlahkursi=$cekjumlahkursi+$data_kursikiri[$ctrkursi];
						
						if ($cekkursikanan>0)
						{
							if ($data_kursikanan[$ctrkursi]>$cekkursikanan)
							{
								$testkanan=$testkanan." - ".$cekkursikanan." ".$namajurusan[$ctr]." ";
								$denahkanan[$ctrdenah]=$testkanan;				
							}
						}
						else
						{
							$denahkanan[$ctrdenah]="-";
                        } 										  
						if ($cekkursikiri>0)
						  {  
							if ($data_kursikiri[$ctrkursi]>$cekkursikiri)
								{
									$testkiri=$testkiri." - ".$cekkursikiri." ".$namajurusan[$ctr]." ";
									$denahkiri[$ctrdenah]=$testkiri;				
								}		
						  }  	
						else
						  {
							$denahkiri[$ctrdenah]="-";
                          } 										  
						
						$html=$html."
									<tr>
										<td width=\"2cm\"><br><br><img src=\"/cobakursi/inc/images.jpg\" style=\"width: 20; height: 50\" /></td>
										<td width=\"10cm\">
									";
						
						for ($j=1; $j<=$ctrdenah; $j++)
						{
							$html=$html."
										<table border='1' style=\"border:1px solid red;\" >
											<tr>
												<td>".$denahkiri[$j]."</td>
											</tr>
										</table>
									";
						}
						$html=$html."
							</td>	
							<td style=\"width:30mm; border:1px solid red;\">
								&uarr;
								M<br>
								A<br>
								S<br>
								U<br>
								K<br>
							</td>";
						$html=$html."
									
									<td width=\"10cm\">";				
						
						for ($j=1; $j<=$ctrdenah; $j++)
						{
							$html=$html."
									
									
										<table border='1' style=\"border:1px solid red;\" width='8cm'>
											<tr>
												<td>".$denahkanan[$j]."</td>
											</tr>
										</table>"
									;
						}
			$html=$html."	
						
					</td>
					<td style=\"width:30mm; border:1px solid red;\"><br><br><img src=\"/cobakursi/inc/images.jpg\" style=\"width: 20; height: 50\" /></td>
				</tr>";					
																							
				$html=$html."</table></p>		
						</td>
					</tr>
				</table>";
		$pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');		
		$pdf->Output("Wisuda ".$periodewisuda." Hari ".$buku_ke ,"I");
	
	}
	
?>	