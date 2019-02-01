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
	$pdf->SetFont('helvetica', '', 9);
	$pdf->setFontSubsetting(false);
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	
	
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
			$ip=0;
			$lamastudi=0;
			$nolj=0;	
			$iplj=0;
			$lamastudilj=0;
			$html='';
			$iprata2=0;
			$lamastudirata2=0;
			
			$tinggi = ($tinggi_kertas-$margintop-$marginbottom)."mm";
					$html=$html."<br>
					<table border='1' style=\"border:1px solid black;\" width='100%'>
						<tr>
							<td style=\"width:'100%'; height:'".$tinggi.".mm'; border:3px solid black;\">
								<table border='0'  width='100%'>
									<tr>
										<td style=\"width:'100%'; height:'".($tinggi-$marginbottom-$marginbottom).".mm';\">";	
					
			$valarr = explode("-", $value); 	
			$fak_jur_prog = $this->Db_model->fakultas_jurusan_program($valarr[0]);
			foreach ($fak_jur_prog->result_array() as $row)
			{
				$fakultas = $row['FA_Nama'];
				$jurusan = $row['JU_Nama'];
				$program = $row['PS_Nama'];
			}
			
			if($program == 'S3'){
					$nama_program = "Doktor (S-3)";
				}
			else if($program == 'S2'){
					$nama_program = "Magister (S-2)";
				}
			else if($program == 'S1'){
					$nama_program = "Sarjana (S-1)";
				}
			else if($program == 'D3'){
					$nama_program = "Diploma (D-III)";
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
				$predikatkelulusantbl[$ctr]=$row['PREDIKAT'];
				$lulusanketbl[$ctr]=substr($row['NRP'],4,3);
				
				/*
				$lulus = $this->Db_model->get_lulusanke($valarr[0]);
				foreach ($lulus->result_array() as $row)
				{
					$lulusanke=$row['lulusan_ke'];
				}
				*/
			}	
			
			$html=$html.'
					<style>
						 td.tes {
							border-top: 1px solid black;
							border-style:double;
							border-bottom: 1px solid black;
						}
					</style>
						
					<br>&nbsp;
							<h2 align="center">
								DAFTAR PESERTA WISUDA KE-'.$periodewisuda.'<br>
								INSTITUT TEKNOLOGI SEPULUH NOPEMBER<br>
								Tanggal Lulus : <br>
								Tanggal Wisuda : <br>
							</h2>
							
						   <pre>Fakultas         : '.$fakultas.'<br>			
								Jurusan          : '.$jurusan.'<br>
								Program         : '.$nama_program.'
							</pre>
							
							<div align="center">
							<table align="center">
								<tr ><td style="height:3mm"></td></tr>
								<tr>
									<td style="width:5mm"></td>
											<td style="width:7mm" class="tes">NO</td>
											<td style="width:20mm" class="tes">NRP</td>
											<td style="width:40%" rowspan="2" valign="middle" class="tes">N A M A </td>
											<td style="width:6%" class="tes">IP</td>
											<td style="width:15mm" class="tes">LAMA STUDI SEM)</td>
											<td style="width:18mm" class="tes">PREDIKAT</td>				
											<td style="width:18mm" class="tes">LULUSAN KE</td>		
									<td style="width:5mm"></td>
								</tr>
								<tr>
									<td></td>
								</tr>';
			$flag=1;	
			for ($j=1; $j<=$ctr; $j++)
			  {
				$no=$no+1;
				
				if ($flag==0)
					{
						$tinggi = ($tinggi_kertas-$margintop-$marginbottom)."mm";
						$html=$html."<br>
						<table border='1' style=\"border:1px solid black;\" width='100%'>
							<tr>
								<td style=\"width:'100%'; height:'".$tinggi.".mm'; border:3px solid black;\">
									<table border='0'  width='100%'>
										<tr>
											<td style=\"width:'100%'; height:'".($tinggi-$marginbottom-$marginbottom).".mm';\">";	
					
						$html=$html.'
						<style>
						 td.tes {
							border-style:double;
							border-top: 1px solid black;							
							border-bottom: 1px solid black;
						}
						</style>
						
						<br>&nbsp;
						<h2 align="center">
							DAFTAR PESERTA WISUDA KE-'.$periodewisuda.'<br>
							INSTITUT TEKNOLOGI SEPULUH NOPEMBER<br>
							Tanggal Lulus : <br>
							Tanggal Wisuda : <br>
						</h2>
						
					   <pre>Fakultas         : '.$fakultas.'<br>			
							Jurusan          : '.$jurusan.'<br>
							Program         : '.$nama_program.'
						</pre>
						
						<div align="center">
						<table align="center">															
							<tr>
								<td style="width:5mm"></td>
										<td style="width:7mm" class="tes">NO1</td>
										<td style="width:20mm" class="tes">NRP</td>
										<td style="width:40%" class="tes">N A M A </td>
										<td style="width:6%" class="tes">IP</td>
										<td style="width:15mm" class="tes">LAMA STUDI SEM)</td>
										<td style="width:18mm" class="tes">PREDIKAT</td>				
										<td style="width:18mm" class="tes">LULUSAN KE</td>	
								<td style="width:5mm"></td>
							</tr>
							<tr>
								<td></td>
							</tr>';	
						$flag=1;	
					}
								
							$predikat = $predikatkelulusantbl[$ctr];
							
							if($predikat == 'D'){
								$predikat = 'DP';
							}
							else if($predikat == 'S'){
								$predikat = 'SM';
							}
							
							$html=$html.'								
							<tr>
								<td style="width:5mm"></td>
										<td>'.$no.'</td>
										<td>'.$nrptbl[$j].'</td>
										<td align="left"> '.$namatbl[$j].'</td>
										<td>'.round($ipktbl[$j],2).'</td>
										<td>'.$lamastuditbl[$j].'</td>
										<td>'.$predikat.'</td>
										<td>'.substr($row['NRP'],4,3).'</td>
								<td style="width:5mm"></td>
							</tr>';					
							
							
							
							/*PERHITUNGAN IP DAN LAMA STUDI RATA-RATA*/
							if($program == 'S3' || $program == 'S2')//Jika Program S-3
							{
								$ip=$ip+$ipktbl[$j];
								$iprata2=$ip/$no;
								$lamastudi=$lamastudi+$lamastuditbl[$j];
								$lamastudirata2=$lamastudi/$no;
							}
							if($program == 'S1')//Jika Program S-1
							{
								if(substr($nrptbl[$j],4,3) == '105' || substr($nrptbl[$j],4,3) == '106') //Mahsiswa LJ
								{
									$nolj=$nolj+1;
									$iplj=$iplj+$ipktbl[$j];
									$iprata2lj=$iplj/$nolj;
									$lamastudilj=$lamastudilj+$lamastuditbl[$j];
									$lamastudirata2lj=$lamastudilj/$nolj;
								}
								else{
									$ip=$ip+$ipktbl[$j];
									$iprata2=$ip/$no;
									$lamastudi=$lamastudi+$lamastuditbl[$j];
									$lamastudirata2=$lamastudi/$no;
								}
							}
							if($program == 'D3')//Jika Program D-3
							{
								if(substr($nrptbl[$j],4,3) == '309') //Mahsiswa Kerjasama
								{
									$no_kerjasama=$no_kerjasama++;
									$ip_kerjasama=$ip_kerjasama+$ipktbl[$j];
									$ip_kerjasama_rata2=$ip_kerjasama_rata2/$no_kerjasama;
									$lamastudi_kerjasama=$lamastudi_kerjasama+$lamastuditbl[$j];
									$lamastudirata2_kerjasama=$lamastudirata2_kerjasama/$no_kerjasama;
								}
								else{
									$ip=$ip+$ipktbl[$j];
									$iprata2=$ip/$no;
									$lamastudi=$lamastudi+$lamastuditbl[$j];
									$lamastudirata2=$lamastudi/$no;
								}
							}
							
							if(substr($nrptbl[$j],4,3) == '105' || substr($nrptbl[$j],4,3) == '106') //Mahsiswa LJ
							{
								$nolj=$nolj+1;
								$iplj=$iplj+$ipktbl[$j];
								$iprata2lj=$iplj/$nolj;
								$lamastudilj=$lamastudilj+$lamastuditbl[$j];
								$lamastudirata2lj=$lamastudilj/$nolj;
							}
								
							if (($no%24)==0)
							{								
								$html=$html.'</table></div><br><br></td></tr>
								<style>
								</style>
								<tr>
									<td width="45%"></td>
									<td align="center" width="1.5cm" border="1" style=\"border-radius: 10px;\">
										'.$halaman.'
									</td>
									<td width="45%"></td>
								</tr>
								<tr>
									<td width="25%"></td>
									<td align="center" width="50%" background="/coba/inc/img/no-images.jpg"><b>Wisuda ITS ke-'.$periodewisuda.'</b></td>
									<td width="25%"></td>
								</tr>
								</table></td></tr></table>';
								$pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
								
								
								$flag=0;
								$html='';
								$pdf->AddPage();
								$halaman=$halaman+1;
							}
					
			}
			
			$toponly = 'top_only';
			
			$html=$html.'
			<style>
			td.tes {
				border-style:double;
				border-top: 1px solid black;							
				border-bottom: 1px solid black;
			}	
			td.coba {
				border-style:double;
				border-top: 1px solid black;	
			}
			
			</style>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td style="width:5mm"></td>
					<td class="tes"></td>
					<td class="tes" align="left" colspan="2">IP / Lama Studi Rata-Rata</td>
					<td class="tes">'.number_format($iprata2,2).'</td>
					<td class="tes">'.number_format($lamastudirata2,2).'</td>
					<td class="tes" colspan="2"></td>
				</tr>
			';
			if (isset($lamastudirata2lj)&& $program == 'S1') //jika ada mhs LJ
			{ 
			   $html=$html.'
			   <style>
					td.tes {
						border-style:double;
						border-bottom: 1px solid black;
					}
				</style>
				<tr>
					<td style="width:5mm"></td>
					<td class="tes"></td>
					<td class="tes" align="left"  colspan="2">IP / Lama Studi Rata-Rata LJ</td>
					<td class="tes">'.number_format($iprata2lj,2).'</td>
					<td class="tes">'.number_format($lamastudirata2lj,2).'</td>
					<td class="tes" colspan="2"></td>
				</tr>
				';
			} 
			
			if (isset($lamastudirata2_kerjasama)&& $program == 'D3') //jika ada mhs D3-Kerjasama
			{ 
			   $html=$html.'
				<style>
					td.tes {
						border-style:double;
						border-top: 1px solid black;							
						border-bottom: 1px solid black;
					}
				</style>
			   
				<tr>
					<td style="width:5mm"></td>
					<td class="tes"></td>
					<td class="tes" align="left" colspan="2">IP / Lama Studi Rata-Rata Kerjasama</td>
					<td class="tes">'.number_format($ip_kerjasama_rata2,2).'</td>
					<td class="tes">'.number_format($lamastudirata2_kerjasama,2).'</td>	
					<td class="tes" colspan="2"></td>
				</tr>
				';
			} 
			$html=$html.'
				<tr>
					<td style="width:5mm"></td>
					<td align="left" colspan="2">  Keterangan : </td>
					<td align="left" width>
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
				
			$html=$html."</table></div><br><br>";
			$html=$html.'</td></tr>
						<tr>
							<td width="45%"></td>
							<td align="center" width="1.5cm" border="1" style=\"border-radius: 10px;\">
								'.$halaman.'
							</td>
							<td width="45%"></td>
						</tr>
						<tr>
							<td width="25%"></td>
							<td align="center" width="50%"><b>Wisuda ITS ke-'.$periodewisuda.'</b></td>
							<td width="25%"></td>
						</tr>
						</table></td></tr></table>';
			//$html=$html.'</td></tr><tr><td align="center"><h2>'.$halaman.'<br>Wisuda ITS ke-'.$periodewisuda.'</h2></td></tr></table></td></tr></table>';
						
				
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
				
				$temptgl=$row['tgl'];
				$ctrtgl=1;
				for ($x=0; $x<=strlen($temptgl); $x++)
					{
						if (substr($temptgl,$x,1)==' ')
							{
								$ctrtgl=$ctrtgl+1;	
							}
						if ($ctrtgl==1)
							{
								$pottgl=$pottgl.substr($temptgl,$x,1);
							}
						else if ($ctrtgl==2)
							{
								$potbln=$potbln.substr($temptgl,$x,1);
							}
						else if ($ctrtgl==3)
							{
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
				
				$foto[$ctr]=$row['MW_ma_Foto'];
				
				/*SIM AKADEMIK*/
				//$ortu[$ctr]=strtoupper($row['MW_ma_namaAyah']);
				//$email[$ctr]=strtolower($row['MW_ma_Email']);
				
				/*TABEL IJAZAH*/
				if(isset($row['NAMAORTU'])){
					$ortu[$ctr]=strtoupper($row['NAMAORTU']);
				}
				else{
					$ortu[$ctr]=strtoupper($row['MA_NamaAyah']);
				}
				
				$ctrhuruf=0;
				$cekbr=0;
				$ctrspasi2=0;
				$tempjudul2='';
				$tempjudul3='';
								
				file_put_contents('../coba/inc/img/'.$nrpdata[$ctr].'.jpg', $foto[$ctr]);
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
					  
					$tinggi = ($tinggi_kertas-$margintop-$marginbottom);
							$html=$html."<br>
							<table border='1' style=\"border:1px solid black;\" width='100%'>
							<tr>
								<td style=\"width:'100%'; height:'".$tinggi.".mm'; border:3px solid black;\">
									<table border='1' width='100%'>
									<tr>
										<td style=\"width:'100%'; height:'".($tinggi-$marginbottom-$marginbottom).".mm';\">"; 
					
					$html=$html.'<table width="100%" border="1">
							<tr >';
					
					if (($ukurankertas=='ITS PAPER') || ($ukurankertas=='B5'))
						{		
							$html=$html.'<td style=\"width: 120mm;\"><br><br>';
						}
					else
						{		
							$html=$html.'<td style=\"width: 100mm;\"><br><br>';
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
								$html=$html.'<table width="100%" border="1" style=\"border:1px solid black;\" >';
								$html=$html.'
									<tr>
										<td width="2.2cm">';
								if (!empty($foto[$i]))	
									{
										$filename='../coba/inc/img/'.$nrpdata[$i].'.jpg';
										$size = @getimagesize($filename);
										$fp = fopen($filename, "rb");
										if ($size && $fp) 
											{
												$html=$html.'<img src="/coba/inc/img/'.$nrpdata[$i].'.jpg" width="2cm" height="3cm" />';
											} 
											else 
											{
												$html=$html.'<img src="/coba/inc/img/no-images.jpg" width="2cm" height="3cm" />';		
											}									
									}
								else
									{
										$html=$html.'<img src="/coba/inc/img/no-images.jpg" width="2cm" height="3cm" />';		
									}
								 $html=$html.'</td>';
								 if ($ukurankertas=='ITS PAPER')
									{
										$html=$html.'<td width="85%"height="3.5cm">';		
									}
								 else
									{
										$html=$html.'<td width="70%"height="3.5cm">';			
									}
								 $html=$html.'	
										<div >
											<b>'.$namadata[$i].'</b><br>
											'.$nrpdata[$i].'<br>
											'.$tgllahir[$i].'<br>
											ORTU: '.$ortu[$i].'<br>
											'.$alamatdata[$i].'<br>';
											if (strlen($alamatdata[$i])<=30)
											{ $html=$html.'<br>'; }
								
											$html=$html.'Email: '.$email[$i].'
											<br>Tlp: '.$telp[$i].'
										</div>
										</td>
									</tr>
								</table><br><br>';
									
								$html=$html.'<table width="100%" border="1" style=\"border:1px solid black;\" >';
								$html=$html.'
									<tr >
										<td width="100%" height="27mm">'.$judulta[$i].'<br>
									';
								if(isset($pembimbing1[$i])){
									$html=$html.'<i>Pembimbing 1: </i>'.$pembimbing1[$i].'<br>
									';
								}		
								if(isset($pembimbing2[$i])){
									$html=$html.'
									<i>Pembimbing 2: </i>'.$pembimbing2[$i].'<br>';
								}
								if(isset($pembimbing3[$i])){
									$html=$html.'
									<i>Pembimbing 3: </i>'.$pembimbing3[$i].'';
								}					
								if (strlen($judulta[$i])<=115)
									{
										$html=$html.'<br>';
									}
								$html=$html.'
									</td>
									</tr>
								</table><br>';
								
							}	
					}
					$html=$html."</td>";
					
					if (($ukurankertas=='ITS PAPER') || ($ukurankertas=='B5'))
						{		
							$html=$html.'<td style=\"width: 80mm;\"><br><br>';
						}
					else
						{		
							$html=$html.'<td style=\"width: 100mm;\"><br><br>';
						}
										
					for ($i=(($jumdata-$jumkolom)+1); $i<=$jumdata; $i++)
					{
						if ($i<=$ctr)
							{								
								$html=$html.'
								<table width="100%" border="1" style=\"border:1px solid black;\" >
									<tr>
										<td width="2.2cm">';
								if (!empty($foto[$i]))	
									{
										$filename='../coba/inc/img/'.$nrpdata[$i].'.jpg';
										$size = @getimagesize($filename);
										$fp = fopen($filename, "rb");
										if ($size && $fp) 
											{
												$html=$html.'<img src="/coba/inc/img/'.$nrpdata[$i].'.jpg" width="2cm" height="3cm" />';
											} 
											else 
											{
												$html=$html.'<img src="/coba/inc/img/no-images.jpg" width="2cm" height="3cm" />';		
											}									
									}
								else
									{
										$html=$html.'<img src="/coba/inc/img/no-images.jpg" width="2cm" height="3cm" />';		
									}
								if ($ukurankertas=='ITS PAPER')
									{
										$html=$html.'</td><td width="85%"height="3.5cm">';		
									}
								 else
									{
										$html=$html.'</td><td width="70%"height="3.5cm">';			
									}		
								$html=$html.'	
									<div >
											<b>'.$namadata[$i].'</b><br>
											'.$nrpdata[$i].'<br>
											'.$tgllahir[$i]/*->format('d F Y')*/.'<br>
											ORTU: '.$ortu[$i].'<br>
											'.$alamatdata[$i].'<br>';
								if (strlen($alamatdata[$i])<=30)
									{ $html=$html.'<br>'; }			
								$html=$html.'Email: '.$email[$i].'
											<br>Tlp: '.$telp[$i].'
										</div>
										</td>
									</tr>
								</table><br><br>';
								$html=$html.'
								<table border="1" style=\"border:1px solid black;\" >
									<tr >
										<td width="100%" height="27mm">'.$judulta[$i].'<br>
								';
								if(isset($pembimbing1[$i])){
									$html=$html.'<i>Pembimbing 1: </i>'.$pembimbing1[$i].'<br>
									';
								}
										
								if(isset($pembimbing2[$i])){
									$html=$html.'
									<i>Pembimbing 2: </i>'.$pembimbing2[$i].'<br>';
								}
								if(isset($pembimbing3[$i])){
									$html=$html.'
									<i>Pembimbing 3: </i>'.$pembimbing3[$i].'';
								}							
								if (strlen($judulta[$i])<=115)
									{
										$html=$html.'<br>';
									}
												
								$html=$html.'
									</td>
									</tr>
								</table><br>';
								
							}	
					}

					$html=$html."</td>";
					$html=$html."</tr></table></td></tr>";
					$html=$html.'
					<table width="100%">
						<tr>
							<td width="45%"></td>
							<td align="center" width="1.5cm" border="1" style=\"border-radius: 10px;\">
								'.$halaman.'
							</td>
							<td width="45%"></td>
						</tr>
						<tr>
							<td width="25%"></td>
							<td align="center" width="50%"><b>Wisuda ITS ke-'.$periodewisuda.'</b></td>
							<td width="25%"></td>
						</tr>
					</table>
					</table></td></tr></table>';
							
					$pdf->writeHTML($html,true, false, true, false, '');
					
					$html='';
					
				}	

		}
	
	

	/*$html="<table >
			<tr >
				<td style=\"width: 100mm;\">
				Kolom 1</td>
	<td style=\"width: 100mm;\">
	Kolom 2
	</td>
	</tr></table>";*/
	
	$pdf->Output("coba","I");
	
	
?>	