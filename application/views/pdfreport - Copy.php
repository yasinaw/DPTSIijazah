<?PHP
	tcpdf();
		
	$this->load->helper('url');
	$title = "WISUDA ".$periodewisuda;
	$judul = '\n'.'Tanggal Wisuda';
	$pdf = new TCPDF("P", "mm",$ukurankertas, true, 'UTF-8', false);
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
			//$html="Wisuda ke ".$periodewisuda;
			if ($ukurankertas=="A4")
				{	
					$tinggi = (295-$margintop-$marginbottom)."mm";
					$html=$html."<br>
					<table border='1' style=\"border:1px solid black;\" width='100%'>
						<tr>
							<td style=\"width:'100%'; height:'790px'; border:3px solid black;\">
								<table border='0' width='100%'>
									<tr>
										<td style=\"width:'100%'; height:'750px';\">";					
				}
			else if ($ukurankertas=="F4")
				{	
					$html=$html."<br><table border='1' style=\"border:1px solid black;\" width='100%'><tr><td style=\"width:'100%'; height:'860px'; border:3px solid black;\"><table border='0'  width='100%'><tr><td style=\"width:'100%'; height:'790px';\">";
				}

			
			$ctr=0;
			$valarr = explode("-", $value); 	
			$fak_jur = $this->Db_model->ambil_fakultas_jurusan($valarr[0],$urutandata,$periodewisuda);		
			foreach ($fak_jur->result_array() as $row)
            {	
				$ctr=$ctr+1;
				$nrptbl[$ctr]=$row['MA_Nrp'];
				$namatbl[$ctr]=ucwords(strtolower($row['MW_ma_nama']));
				$ipktbl[$ctr]=$row['MA_IPK'];
				$lamastuditbl[$ctr]=$row['MA_LamaStudi'];
				$predikatkelulusantbl[$ctr]=$row['MA_IDPredikatKelulusan'];
				$lulusanketbl[$ctr]=substr($row['MA_Nrp'],4,3);
				$mhskojurtbl[$ctr]=$row['mhs_kojur'];
				
			}	
				
			$html=$html."<br>&nbsp;
							<h2 align=\"center\">
								DAFTAR PESERTA WISUDA KE-".$periodewisuda."<br>
								INSTITUT TEKNOLOGI SEPULUH NOPEMBER<br>
								Tanggal Lulus : <br>
								Tanggal Wisuda : <br>
							</h2>
							
							<pre>Fakultas         : <br>
							Jurusan          : <br>
							Program         : <br><br>
							</pre>
							<div align=\"center\">
							<table border='1' align=\"center\" style=\"border:1px solid black\">
								<tr>
									<td style=\"width:'7mm'; border:1px solid black;\">NO</td>
									<td style=\"width:'20mm'; border:1px solid black;\">NRP</td>
									<td style=\"width:'40%'; border:1px solid black;\">N A M A </td>
									<td style=\"width:'6%'; border:1px solid black;\">IP</td>
									<td style=\"width:'15mm'; border:1px solid black;\">LAMA STUDI SEM)</td>
									<td style=\"width:'18mm'; border:1px solid black;\">PREDIKAT</td>				
									<td style=\"width:'18mm'; border:1px solid black;\">LULUSAN KE</td>	
								</tr>";
							
			$flag=1;	
			for ($j=1; $j<=$ctr; $j++)
				{
					$no=$no+1;
					if ($flag==0)
						{
								if ($ukurankertas=="A4")
									{	
										$tinggi = (290-$margintop-$marginbottom)."mm";
					$html=$html."<br>
					<table border='1' style=\"border:1px solid black;\" width='100%'>
						<tr>
							<td style=\"width:'100%'; height:'".$tinggi.".mm'; border:3px solid black;\">
								<table border='0'  width='100%'>
									<tr>
										<td style=\"width:'100%'; height:'".($tinggi-$marginbottom-($marginbottom/2)).".mm';\">";					
									}
								else if ($ukurankertas=="F4")
									{	
										$html=$html."<br><table border='1' style=\"border:1px solid black;\" width='100%'><tr><td style=\"width:'100%'; height:'860px'; border:3px solid black;\"><table border='0'  width='100%'><tr><td style=\"width:'100%'; height:'790px';\">";
									}

							
							$html=$html."<br>&nbsp;
							<h2 align=\"center\">
								DAFTAR PESERTA WISUDA KE-".$periodewisuda."<br>
								INSTITUT TEKNOLOGI SEPULUH NOPEMBER<br>
								Tanggal Lulus : <br>
								Tanggal Wisuda : <br>
							</h2>
							
							<pre>Fakultas         : <br>
							Jurusan          : <br>
							Program         : <br><br>
							</pre>
							<div align=\"center\">
							<table border='1' align=\"center\" style=\"border:1px solid black\">
								<tr>
									<td style=\"width:'7mm'; border:1px solid black;\">NO</td>
									<td style=\"width:'20mm'; border:1px solid black;\">NRP</td>
									<td style=\"width:'40%'; border:1px solid black;\">N A M A </td>
									<td style=\"width:'6%'; border:1px solid black;\">IP</td>
									<td style=\"width:'15mm'; border:1px solid black;\">LAMA STUDI SEM)</td>
									<td style=\"width:'18mm'; border:1px solid black;\">PREDIKAT</td>				
									<td style=\"width:'18mm'; border:1px solid black;\">LULUSAN KE</td>	
								</tr>";
							$flag=1;	
							//echo 'aaa';
						}
					$html=$html."				
					<tr>
							<td style=\"border:1px solid black;\">".$no."</td>
							<td style=\"border:1px solid black;\">".$nrptbl[$j]."</td>
							<td align=\"left\" style=\"border:1px solid black;\"> ".$namatbl[$j]."</td>
							<td style=\"border:1px solid black;\">".round($ipktbl[$j],2)."</td>
							<td style=\"border:1px solid black;\">".$lamastuditbl[$j]."</td>
							<td style=\"border:1px solid black;\">".$predikatkelulusantbl[$j]."</td>
							<td style=\"border:1px solid black;\">".$lulusanketbl[$j]."</td>
					</tr>";
							
					$ip=$ip+$ipktbl[$j];
					$iprata2=$ip/$no;
					$lamastudi=$lamastudi+$lamastuditbl[$j];
					$lamastudirata2=$lamastudi/$no;
							
					if ($valarr[1]!=$mhskojurtbl[$j])
								{
									$nolj=$nolj+1;
									$iplj=$iplj+$ipktbl[$j];
									$iprata2lj=$iplj/$nolj;
									$lamastudilj=$lamastudilj+$lamastuditbl[$j];
									$lamastudirata2lj=$lamastudilj/$nolj;
								}
				
					if (($no%60)==0)
						{
							$html=$html.'</table></div><br><br></td></tr><tr><td align="center"><h2>'.$halaman.'<br>Wisuda ITS ke-'.$periodewisuda.'</h2></td></tr></table></td></tr></table>';
							$pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
							$flag=0;
							$html='';
							$pdf->AddPage();
							$halaman=$halaman+1;
						}
				
				}
			$html=$html."</table></div><br><br>";
			
			$html=$html."&nbsp;IP Rata-rata : ".round($iprata2,2)."<br>";
			$html=$html."&nbsp;IP Rata-rata : IP Rata-rata<br>";
			$html=$html."&nbsp;Lama Studi Rata-rata : ".round($lamastudirata2,2)." bulan<br>";
			$html=$html."&nbsp;Lama Studi Rata-rata : Lama Stude bulan<br>";
			$html=$html."&nbsp;IP Rata-rata LJ : ".round($iprata2lj,2)."<br>";
			$html=$html."&nbsp;IP Rata-rata LJ : IP LJ<br>";
			$html=$html."&nbsp;Lama Studi Rata-rata LJ : Lama LJ bulan<br></td></tr>"; 
			$html=$html.'<tr><td align="center"><h2>'.$halaman.'<br>Wisuda ITS ke-'.$periodewisuda.'</h2></td></tr></table></td></tr></table>';
						
				
			$pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
						
						
			$halaman=$halaman+1;
					
			$html='';
			$pdf->AddPage();
					
			//$pdf->setPage($halaman, true);
			$ctr=0;
            $fak_jur = $this->Db_model->ambil_fakultas_jurusan($valarr[0],$urutandata,$periodewisuda);			
			foreach ($fak_jur->result_array() as $row)
            {	
				$ctr=$ctr+1;
				$nrpdata[$ctr]=$row['MA_Nrp'];
				$namadata[$ctr]=strtoupper($row['MW_ma_nama']);
				if (empty($row['MW_ma_AlamatOrtu']) || ($row['MW_ma_AlamatOrtu']==' ') || ($row['MW_ma_AlamatOrtu']=='') || ($row['MW_ma_AlamatOrtu']=='0'))
					{
						$alamatdata[$ctr]="-";
					}
				else
					{
						$alamatdata[$ctr]=strtoupper($row['MW_ma_AlamatOrtu'].' '.$row['MW_ma_AlamatOrtuKota']);
					}	
					
				//$date = $row['MW_ma_tgllahir'];
				//$tanggal = date('m/d/y', strtotime($date));
				$tgllahir[$ctr]=strtoupper($row['MW_ma_tmplahir'].', '.$row['MW_ma_tgllahir']);
								
				if (empty($row['MW_ma_telpOrtu']) || ($row['MW_ma_telpOrtu']==' ') || ($row['MW_ma_telpOrtu']=='') || ($row['MW_ma_telpOrtu']=='0'))
					{
						$telp[$ctr]="-";
					}
				else
					{
						$telp[$ctr]=$row['MW_ma_telpOrtu'];
					}	
				$foto[$ctr]=$row['MA_Photo'];
				$ortu[$ctr]=strtoupper($row['MW_ma_namaAyah']);
				$email[$ctr]=$row['MW_ma_Email'];
				
				$ctrhuruf=0;
				$cekbr=0;
				$ctrspasi2=0;
				$tempjudul2='';
				$tempjudul3='';
				
				$judulta[$ctr]=$row['MA_JudulTugasAkhir'].$row['MA_JudulTugasAkhir2'];
				$pembimbing1[$ctr]=$row['MA_Pembimbing1'];
				$pembimbing2[$ctr]=$row['Ma_Pembimbing2'];
								
				file_put_contents('../coba/inc/img/'.$nrpdata[$ctr].'.jpg', $foto[$ctr]);

			}
			//echo $ctr;
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
					if ($ukurankertas=="A4")
						{	
							$tinggi = (295-$margintop-$marginbottom);
							$html=$html."<br>
							<table border='1' style=\"border:1px solid black;\" width='100%'>
							<tr><td style=\"width:'100%'; height:'790px'; border:3px solid black;\"><table border='1' width='100%'><tr><td style=\"width:'100%'; height:'750px';\">";
							
						}
					else if ($ukurankertas=="F4")
						{	
							$html=$html."<br><table border='1' style=\"border:1px solid black;\" width='100%'><tr><td style=\"width:'100%'; height:'860px'; border:3px solid black;\"><table border='1' width='100%'><tr><td style=\"width:'100%'; height:'790px';\">";
						}

					$html=$html."<table >
							<tr >";
					
					$html=$html."<td style=\"width: 100mm;\"><br><br>";
					
					$jumdata=$jumdata+($jumkolom*2);
					$ctrawal=($jumkolom*2)-1;
					//echo "aa ".($jumdata-$ctrawal)."<br>";
					//echo "bb ".($jumdata-$jumkolom)."<br>";
					
					//echo ($jumdata-$ctrawal); 
					for ($i=($jumdata-$ctrawal); $i<=($jumdata-$jumkolom); $i++)
					{
						if ($i<=$ctr)
							{
								$html=$html.'
								<table width="100%" border="1" style=\"border:1px solid black;\" >
									<tr>
										<td width="2.2cm">tes</td>
										<td width="70%"height="3.5cm">
										<div >
											<b>'.$namadata[$i].'</b><br>
											'.$nrpdata[$i].'<br>
											'.$tgllahir[$i].'<br>
											ORTU: '.$ortu[$i].'<br>
											Email : '.$email[$i].'
											<br>Tlp:'.$telp[$i].'
										</div>
										</td>
									</tr>
								</table><br><br>
								<table border="1" style=\"border:1px solid black;\" >
									<tr >
									<td width="95%" height="27mm"><br>
									<i>Pembimbing 1 : </i>'.$pembimbing1[$i].'<br>
									<i>Pembimbing 1 : </i>'.$pembimbing2[$i].'</td>
									</tr>
								</table><br>';
							}	
					}
					$html=$html."</td>";

					$html=$html."<td style=\"width: 100mm;\"><br><br>";
					//echo "cc ".(($jumdata-$jumkolom)+1)."<br>";
					//echo "dd ".($jumdata)."<br>";
					
					
					for ($i=(($jumdata-$jumkolom)+1); $i<=$jumdata; $i++)
					{
						if ($i<=$ctr)
							{
								$html=$html.'
								<table width="100%" border="1" style=\"border:1px solid black;\" >
									<tr>
										<td width="2.2cm">tes	</td>
										<td width="70%"height="3.5cm">
										<div >
											<b>'.$namadata[$i].'</b><br>
											'.$nrpdata[$i].'<br>
											'.$tgllahir[$i].'<br>
											ORTU: '.$ortu[$i].'<br>
											'.$email[$i].'
											<br>Tlp:'.$telp[$i].'
										</div>
										</td>
									</tr>
								</table><br><br>
								<table border="1" style=\"border:1px solid black;\" >
									<tr >
									<td width="95%" height="27mm">
									<i>Pembimbing 1 : </i>'.$pembimbing1[$i].'<br>
									<i>Pembimbing 1 : </i>'.$pembimbing2[$i].'</td>
									</tr>
								</table><br>';
							}	
					}

					$html=$html."</td>";
					$html=$html."</tr></table></td></tr>";
					$html=$html.'<tr>
						<td align="center">
							<h2>
								'.$halaman.'<br>
								Wisuda ITS ke-'.$periodewisuda.'
							</h2>
						</td>
					</tr></table></td></tr></table>';
							
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