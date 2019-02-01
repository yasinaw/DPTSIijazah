<?PHP
	tcpdf();
	ini_set("memory_limit","512M");
    	
	$this->load->helper('url');
	$title = "WISUDA ".$periodewisuda;
	$judul = '\n'.'Tanggal Wisuda';
	//$pdf = new TCPDF("P", "mm",$ukurankertas, true, 'UTF-8', false); //DEFULT UTF-8 UNICODE
	if ($ukurankertas=='ITS PAPER')
		{
			$pdf = new TCPDF("P", "mm",array(190,230), false, 'ISO-8859-1', false);
		}
	else
		{
			//$pdf = new TCPDF("P", "mm",$ukurankertas, false, 'ISO-8859-1', false);			
			$pdf = new TCPDF("P", "mm","F4", false, 'ISO-8859-1', false);			
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
						
			/*if($program == 'S3'){
				$nama_program = "Doktor (S-3)";
			}
			else if($program == 'S2' || substr($kojur,2,1) == '2'){
				$nama_program = "Magister (S-2)";
			}
			else if($program == 'S1'){
				$nama_program = "Sarjana (S-1)";
			}
			else if($program == 'D3'){
				$nama_program = "Diploma (D-III)";
			}
			else if($program == 'D4'){
				$nama_program = "Diploma (D-IV)";
			}
				
					*/			
			$fak_jur = $this->Db_model->ambil_fakultas_jurusan($valarr[0],$urutandata,$periodewisuda);						
			
			foreach ($fak_jur->result_array() as $row)
            {	
				$ctr=$ctr+1;
				
				/*SIM WISUDA*/
				$nrptbl[$ctr]=$row['NRP'];
				$namajurusan[$ctr]=$namajur;
				$namafakultas[$ctr]=$fakultas;
				$namatbl[$ctr]=ucwords(strtolower($row['NAMA']));
				$ipktbl[$ctr]=$row['IPK'];
				$lamastuditbl[$ctr]=$row['LAMASTUDI'];
				$predikat[$ctr]=$row['PREDIKAT'];
				$lulusanketbl[$ctr]=substr($row['NRP'],4,3);
				
				if($predikat[$ctr] == 'D'){
					$predikat[$ctr] = 'DP';
					$pred[$ctr] = 'DP';
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
					<table border='1' style=\"border:5px solid red;\" width='100%'>
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
							<table align="center" style="border:1px solid black;">
								<tr style="border:1px solid black;">
									<td style="width:7mm; border:1px solid black">NO</td>
									<td style="width:45mm; border:1px solid black"><br/>JURUSAN</td>
									<td style="width:15mm; border:1px solid black"><br/>DERET</td>
									<td style="width:9mm; border:1px solid black"></td>			
									<td style="width:12mm; border:1px solid black">KURSI</td>																					
									<td style="width:6%; border:1px solid black">URUT</td>
									<td style="width:22mm; border:1px solid black">NRP</td>
									<td style="width:35%; border:1px solid black"><br>N A M A </td>
									<td style="width:15mm; border:1px solid black"> Cek 1 </td>
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
							td.border {
								border: 1px solid black;
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
										<td class="border" style="width:7mm">NO</td>
										<td class="border" style="width:45mm"><br/>JURUSAN</td>
										<td class="border" style="width:15mm"><br/>DERET</td>
										<td class="border" style="width:9mm"></td>		
										<td class="border" style="width:12mm">KURSI</td>																							
										<td class="border" style="width:6%">URUT</td>
										<td class="border" style="width:22mm">NRP</td>
										<td class="border" style="width:35%"><br>N A M A </td>	
										<td class="border" style="width:15mm"> Cek 1 </td>
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
							<td style="width:5mm"></td>
							<td colspan="8" align="center"><b>'.$namafakultas[$j]. '</b></td>
							<td style="width:5mm"></td>
						</tr>';
					
				}
				
				if ($var_tempnrp!=$namajurusan[$j])
				{	$no=0;
					$cekbidangkeahlian=$cekbidangkeahlian+1;	
					$html=$html.'					
						<tr>
							<td style="width:5mm"></td>
							<td colspan="8" align="center"><b>'.$namajurusan[$j]. '</b></td>
							<td style="width:5mm"></td>
						</tr>';
					$jumlah=$jumlah+1;
					
					$cont = $jumlah;
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
					
					if ($kursikanan==$cekkursikanan)
					{
						$cekkursikiri=0;
						$cekkursikanan=0;
						$namakursi=$namakursi+1;
					}
						
					$kodekursi=chr(65+$namakursi);
					$no=$no+1;
					$urut=$urut+1;	
					$html=$html.'	
					<style>							
						td.border {
							border: 1px solid black;
						}
					</style>					
					<tr>
						<td class="border" style="width:7mm">'.$no.'</td>
						<td class="border">'.$namajurusan[$j].'</td>
						<td class="border">'.$kodekursi.'</td>
						<td class="border">'.$nomorkursi.'</td>
						<td class="border">'.$kursi.'</td>
						<td class="border">'.$urut.'</td>
						<td class="border">'.$nrptbl[$j].'</td>
						<td class="border" align="left" style="font-size:10px"> '.strtoupper($namatbl[$j]).'</td>
					';
					if($predikat[$j]=='DP'){
						$html=$html.'
						<td style="width:15mm; border: 1px solid black">'.$predikat[$j].'</td>
						</tr>';
					}
					else{
						$html=$html.'
						<td style="width:15mm; border: 1px solid black"></td>
						</tr>';
					}
									
							
										
							$var_tempnrp=$namajurusan[$j];
							$var_tempfakultas=substr($nrptbl[$j],0,2);			
							
							$banyaknya=0;	
							
							$cekbaris=$ctrbaris+($cekbidangkeahlian*3);
							if ($cekbidangkeahlian<=0)
							{
								$jumbaris=25;
							}
							else
							{
								$jumbaris=25;
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