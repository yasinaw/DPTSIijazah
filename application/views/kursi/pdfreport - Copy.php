<?PHP
	tcpdf();
	ini_set("memory_limit","512M");
    	
	$this->load->helper('url');
	$title = "WISUDA ".$periodewisuda;
	$judul = '\n'.'Tanggal Wisuda';
	//$pdf = new TCPDF("P", "mm",$ukurankertas, true, 'UTF-8', false); //DEFULT UTF-8 UNICODE
	if ($cetak=='DENAH')
		{
			if ($ukurankertas=='ITS PAPER')
				{
					$pdf = new TCPDF("L", "mm",array(190,230), false, 'ISO-8859-1', false);
				}
			else
				{
					$pdf = new TCPDF("L", "mm",$ukurankertas, false, 'ISO-8859-1', false);			
				}
		}
	else
		{
			if ($ukurankertas=='ITS PAPER')
				{
					$pdf = new TCPDF("P", "mm",array(190,230), false, 'ISO-8859-1', false);
				}
			else
				{
					$pdf = new TCPDF("P", "mm",$ukurankertas, false, 'ISO-8859-1', false);			
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
	$pdf->SetFont('helvetica', '', 9);
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
						
						$data_tglperiode = $this->Db_model->ambil_kelulusan($periodewisuda);
						foreach ($data_tglperiode->result_array() as $row)
						{
							$tglkelulusan = $row['TGLKELULUSAN'];			
						}
						
						
						$data_tgl_kelulusan = $this->Db_model->fakultas_jurusan_program($periodewisuda);
						foreach ($data_tgl_kelulusan->result_array() as $row)
						{
							$tgl_lulus = $row['TGLKELULUSAN'];			
						}
						
						$fak_jur_prog = $this->Db_model->fakultas_jurusan_program($valarr[0]);
						foreach ($fak_jur_prog->result_array() as $row)
						{
							$fakultas = $row['FA_Nama'];
							$jurusan = $row['JU_Nama'];
							$program = $row['PS_Nama'];
							$namajur = $row['PS_Nama'];
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
										<h3 align="center">
											DAFTAR PESERTA WISUDA KE-'.$periodewisuda.''.$program.'<br>
											INSTITUT TEKNOLOGI SEPULUH NOPEMBER<br>
											Tanggal Lulus : '.date("d-m-Y",strtotime($tglkelulusan)).' <br>
											Tanggal Wisuda : '.date("d-m-Y",strtotime($tanggal)).'<br>
										</h3>
																	
										<div align="center">
										<table align="center">
											<tr>
													<td style="width:5mm"></td>
													<td style="width:7mm" class="atas"></td>
													<td style="width:45mm" class="atas"></td>
													<td style="width:11mm" class="atas"></td>
													<td style="width:9mm" class="atas"></td>
													<td style="width:10mm" class="atas"></td>												
													<td style="width:6%" class="atas"></td>
													<td style="width:22mm" class="atas"></td>
													<td style="width:35%" class="atas"></td>
													<td style="width:5mm"></td>
												</tr>
												<tr>
													<td style="width:5mm"></td>
															<td style="width:7mm">NO</td>
															<td style="width:45mm"><br/>JURUSAN</td>
															<td style="width:11mm"><br/>DERET</td>
															<td style="width:9mm"></td>			
															<td style="width:10mm">KURSI</td>																					
															<td style="width:6%">URUT</td>
															<td style="width:22mm">NRP</td>
															<td style="width:35%" rowspan="2"><br>N A M A </td>
													<td style="width:5mm"></td>
												</tr>
											<tr>
													<td style="width:5mm"></td>
													<td style="height:3mm" class="atas" colspan="8"></td>
													<td style="width:5mm"></td>
												</tr>
											';
						$var_tempnrp="";
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
											<table align="center">
												
												<tr>
													<td style="width:5mm"></td>
													<td style="width:7mm" class="atas"></td>
													<td style="width:45mm" class="atas"></td>
													<td style="width:11mm" class="atas"></td>
													<td style="width:9mm" class="atas"></td>			
													<td style="width:10mm" class="atas"></td>
													<td style="width:6%" class="atas"></td>
													<td style="width:22mm" class="atas"></td>
													<td style="width:35%" class="atas"></td>
													<td style="width:5mm"></td>
												</tr>
												<tr>
													<td style="width:5mm"></td>
															<td style="width:7mm">NO</td>
															<td style="width:45mm"><br/>JURUSAN</td>
															<td style="width:11mm"><br/>DERET</td>
															<td style="width:9mm"></td>		
															<td style="width:10mm">KURSI</td>																							
															<td style="width:6%">URUT</td>
															<td style="width:22mm">NRP</td>
															<td style="width:35%" rowspan="2"><br>N A M A </td>	
													<td style="width:5mm"></td>
												</tr>
												<tr>
													<td style="width:5mm"></td>
													<td style="height:3mm" class="atas" colspan="8"></td>
													<td style="width:5mm"></td>
												</tr>
												';
									$flag=1;	
								}
							$cont = 0;
							
							if ($var_tempnrp!=$namajurusan[$j])
							{	$no=0;
								$cekbidangkeahlian=$cekbidangkeahlian+1;	
								$html=$html.'					
									<tr>
										<td style="width:5mm"></td>
										<td colspan="8" align="center"><br><br><b>'.$namajurusan[$j]. '</b><br></td>
										<td style="width:5mm"></td>
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
								
								if ($data_kursikanan[$ctrkursi]==$cekkursikanan)
									{
										$cekkursikiri=0;
										$cekkursikanan=0;
										$namakursi=$namakursi+1;
										$ctrkursi=$ctrkursi+1;
									}
									
								$kodekursi=chr(65+$namakursi);
								$no=$no+1;
								$urut=$urut+1;	
								$html=$html.'								
								<tr>
									<td style="width:5mm"></td>
											<td>'.$no.'</td>
											<td>'.$namajurusan[$j].'</td>
											<td>'.$kodekursi.'</td>';
								
								$html=$html.'<td>'.$nomorkursi.'</td>
												<td>'.$kursi.'</td>';
								
								$html=$html.'<td>'.$urut.'</td>
											<td>'.$nrptbl[$j].'</td>
											<td align="left"> '.$namatbl[$j].'</td>
									<td style="width:5mm"></td>
								</tr>';				
										
										//$var_tempnrp=substr($nrptbl[$j],0,2).substr($nrptbl[$j],4,3);							
										$var_tempnrp=$namajurusan[$j];
										
										$banyaknya=0;	
										
										$cekbaris=$ctrbaris+($cekbidangkeahlian*3);
										if ($cekbidangkeahlian<=0)
										{
											$jumbaris=50;
										}
										else
										{
											$jumbaris=48;
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
	else
		{
				$halaman=0;
				$ctr=0;
				foreach ($data_prodi as $key => $value) 
					{
								
						$valarr = explode("-", $value); 
						
						$data_tglperiode = $this->Db_model->ambil_kelulusan($periodewisuda);
						foreach ($data_tglperiode->result_array() as $row)
						{
							$tglkelulusan = $row['TGLKELULUSAN'];			
						}
						
						
						$data_tgl_kelulusan = $this->Db_model->fakultas_jurusan_program($periodewisuda);
						foreach ($data_tgl_kelulusan->result_array() as $row)
						{
							$tgl_lulus = $row['TGLKELULUSAN'];			
						}
						
						$fak_jur_prog = $this->Db_model->fakultas_jurusan_program($valarr[0]);
						foreach ($fak_jur_prog->result_array() as $row)
						{
							$fakultas = $row['FA_Nama'];
							$jurusan = $row['JU_Nama'];
							$program = $row['PS_Nama'];
							$namajur = $row['PS_NamaJurusan'];
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
				$tinggi = '200'."mm";	
				$html=$html."<br>
								<table border='1' style=\"border:1px solid black;\" width='100%'>
									<tr>
										<td style=\"width:'100%'; height:'".$tinggi.".mm'; border:3px solid black;\">
											<br><br>
											<table style=\"border:1px solid black;\" width='70%'>";
											$var_tempnrp="";
											$var_prodisimwisuda="";
											$cekbidangkeahlian=0;	
											$ctrbaris=0;
											$ctrdenah=0;
											$no=0;
											$cekkursikiri=0;
											$cekkursikanan=0;
											$namakursi=0;
											$nomorkursi=0;
											for ($j=1; $j<=$ctr; $j++)
												{
													$ctrbaris=$ctrbaris+1;
												
													if ($var_tempnrp!=$namajurusan[$j])
														{	//$no=0;
															//$cekbidangkeahlian=$cekbidangkeahlian+1;	
															//$namajurusan[$j]
															//$jumlah=$jumlah+1;
															
															//$cont = $jumlah;
														}
														
													if ($kursikiri==$cekkursikiri)
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
															
													if ($kursikanan==$cekkursikanan)
														{
															$ctrdenah=$ctrdenah+1;
															$denah[$ctrdenah]=$kodekursi." ".$cekkursikiri;
															$cekkursikiri=0;
															$cekkursikanan=0;
															$namakursi=$namakursi+1;
														}
																
													
													$var_tempnrp=$namajurusan[$j];
													
												}		


										$html=$html."<tr>
																	<td>".$denah[1]."
																	</td>
																</tr>";												
								$html=$html."</table>		
										</td>
									</tr>
								</table>";
				$pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');		
				$pdf->Output("Wisuda ".$periodewisuda." Hari ".$buku_ke ,"I");
	
		}
	
?>	