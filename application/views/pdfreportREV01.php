<?PHP
	/*foreach ($data_prodi as $key => $value) 
		{
            $fak_jur = $this->Db_model->ambil_fakultas_jurusan($value);
            foreach ($fak_jur->result_array() as $row)
            {
				echo $row['mhs_nrp']."<br>";
			}
		}
									
	*/
	/*$ctr=0;
	echo $data_prodijurusan[1]."<br>";
	foreach($data_jurusan->result() as $row) 
		{
			$ctr=$ctr+1;
			$nama_jurusan[$ctr]=$row->JU_Nama;
			echo $nama_jurusan[$ctr]."<br>";
		}*/
	
	//require_once('/coba/inc/tcpdf/tcpdf.php');
	tcpdf();
	$this->load->helper('url');
	/*$pdf = new TCPDF("P", "mm","A4", true, 'UTF-8', false);
	$pdf->AddPage();

	$html="<table >
	<tr >
	<td style=\"width: 50mm;\">
	Kolom 1
	</td>
	<td style=\"width: 100mm;\">
	Kolom 2
	</td>
	</tr></table>";

	$pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
	$pdf->Output("coba","I");*/
	
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
					$html=$html."<br><table border='1' style=\"border:1px solid black;\" width='100%'><tr><td style=\"width:'100%'; height:'750px'; border:3px solid black;\">";
				}
			else if ($ukurankertas=="F4")
				{	
					$html=$html."<br><table border='1' style=\"border:1px solid black;\" width='100%'><tr><td style=\"width:'100%'; height:'860px'; border:3px solid black;\">";
				}

			$html=$html."<br><br>&nbsp;<table border='1' style=\"border:1px solid black;\"><tr><td style=\"width:'25px'; border:1px solid black;\">No</td><td style=\"width:'70px'; border:1px solid black;\">Nrp</td><td style=\"width:'240px'; border:1px solid black;\">Nama</td><td style=\"width:'40px'; border:1px solid black;\">Jenis Kelamin</td><td style=\"width:'40px'; border:1px solid black;\">IPK</td><td style=\"width:'40px'; border:1px solid black;\">Lama Studi</td><td style=\"width:'40px'; border:1px solid black;\">Predikat</td></tr>";
    
			$valarr = explode("-", $value); 	
	  	    $fak_jur = $this->Db_model->ambil_fakultas_jurusan($valarr[0],$urutandata);
	        foreach ($fak_jur->result_array() as $row)
            {
				$no=$no+1;
				$html=$html."<tr><td style=\"border:1px solid black;\">".$no."</td><td style=\"border:1px solid black;\">".$row['mhs_nrp']."</td><td style=\"border:1px solid black;\">".$row['mhs_nama']."</td><td style=\"border:1px solid black;\">".$row['mhs_kelamin']."</td><td style=\"border:1px solid black;\">".$row['mhs_ipk']."</td><td style=\"border:1px solid black;\">".$row['mhs_lama_studi']."</td><td style=\"border:1px solid black;\">".$row['MA_IDPredikatKelulusan']."</td></tr>";
				$ip=$ip+$row['mhs_ipk'];
				$iprata2=$ip/$no;
				$lamastudi=$lamastudi+$row['mhs_lama_studi'];
				$lamastudirata2=$lamastudi/$no;
				
				if ($valarr[1]!=$row['mhs_kojur'])
					{
						$nolj=$nolj+1;
						$iplj=$iplj+$row['mhs_ipk'];
						$iprata2lj=$iplj/$nolj;
						$lamastudilj=$lamastudilj+$row['mhs_lama_studi'];
						$lamastudirata2lj=$lamastudilj/$nolj;
					}
			}

			$html=$html."</table><br><br>";	
			$html=$html."&nbsp;IP Rata-rata : ".$iprata2."<br>";
			$html=$html."&nbsp;Lama Studi Rata-rata : ".$lamastudirata2." bulan<br>";
			$html=$html."&nbsp;IP Rata-rata LJ : ".$iprata2lj."<br>";
			$html=$html."&nbsp;Lama Studi Rata-rata LJ : ".$lamastudirata2lj." bulan<br></td></tr></table>";
			
	
			$pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
			
			
			$halaman=$halaman+1;
			
			$html='';
			$pdf->AddPage();
			//$pdf->setPage($halaman, true);
			$ctr=0;
            $fak_jur = $this->Db_model->ambil_fakultas_jurusan($valarr[0],$urutandata);			
			foreach ($fak_jur->result_array() as $row)
            {	
				$ctr=$ctr+1;
				$nrpdata[$ctr]=$row['MA_Nrp'];
				$namadata[$ctr]=$row['MA_Nama'];
				if (empty($row['MA_AlamatSby']) || ($row['MA_AlamatSby']==' ') || ($row['MA_AlamatSby']=='') || ($row['MA_AlamatSby']=='0'))
					{
						$alamatdata[$ctr]="-";
					}
				else
					{
						$alamatdata[$ctr]=$row['MA_AlamatSby'];
					}	
				$tgllahir[$ctr]=$row['MA_TglLahir'];
				if (empty($row['MA_TelpMhs']) || ($row['MA_TelpMhs']==' ') || ($row['MA_TelpMhs']=='') || ($row['MA_TelpMhs']=='0'))
					{
						$telp[$ctr]="-";
					}
				else
					{
						$telp[$ctr]=$row['MA_TelpMhs'];
					}	
				$foto[$ctr]=$row['MA_Photo'];
				
				$ctrhuruf=0;
				$cekbr=0;
				$tempjudul2='';
				$tempjudul3='';
				$tempjudul1=$row['MA_JudulTugasAkhir'].$row['MA_JudulTugasAkhir2'];
				for ($x=0; $x<=strlen($tempjudul1); $x++)
					{
						$ctrhuruf=$ctrhuruf+1;
						if ($ctrhuruf<50)
							{
								$tempjudul2=$tempjudul2.substr($tempjudul1,$x,1);
							}
						else
							{
								$cekbr=$cekbr+1;
								if ((substr($tempjudul1,$x,1)==' ')||(substr($tempjudul1,$x,1)==''))
									{
										$tempjudul2=$tempjudul2.substr($tempjudul1,$x,1)."<br>";
									}
								else
									{
										$tempjudul2=$tempjudul2.substr($tempjudul1,$x,1)."-<br>";
									}
								$ctrhuruf=0;
							}
						
					}
				
				$judulta[$ctr]=strtoupper(substr($tempjudul2,0,1)).strtolower(substr($tempjudul2,1,strlen($tempjudul2)));
				$pembimbing1[$ctr]=$row['mhs_pembimbing_ta_1'];
				if ($cekbr==1)
					{	$pembimbing2[$ctr]=$row['mhs_pembimbing_ta_2']."<br><br><br><br>";	}
				else if ($cekbr==2)
					{	$pembimbing2[$ctr]=$row['mhs_pembimbing_ta_2']."<br><br><br>";	}
				else if ($cekbr==3)
					{	$pembimbing2[$ctr]=$row['mhs_pembimbing_ta_2']."<br><br>";	}
				else if ($cekbr==4)
					{	$pembimbing2[$ctr]=$row['mhs_pembimbing_ta_2']."<br>";	}
				
				
				
				
				file_put_contents('../coba/inc/img/'.$nrpdata[$ctr].'.jpg', $foto[$ctr]);

			}
			//echo $ctr;
			$jumkolom=5;
			if ($ukurankertas=="A4")
				{	$jumkolom=4;	}
			else if ($ukurankertas=="F4")
				{	$jumkolom=5;	}

			$jumhalaman=ceil(($ctr/($jumkolom*2)));
			$jumdata=0;
			$ctrawal=0;
			
			for ($j=1; $j<=$jumhalaman; $j++)
				{
					if ($j>1)
					  { $pdf->AddPage(); }
					if ($ukurankertas=="A4")
						{	
							$html=$html."<br><table border='1' style=\"border:1px solid black;\" width='100%'><tr><td style=\"width:'100%'; height:'750px'; border:3px solid black;\">";
						}
					else if ($ukurankertas=="F4")
						{	
							$html=$html."<br><table border='1' style=\"border:1px solid black;\" width='100%'><tr><td style=\"width:'100%'; height:'860px'; border:3px solid black;\">";
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
								//header('Content-type:image');
								$html=$html.'<table><tr><td width="30%"><img src="/coba/inc/img/'.$nrpdata[$i].'.jpg" width="75" height="75" /></td><td width="70%"><b>'.$namadata[$i].'</b><br>'.$nrpdata[$i].'<br>'.$alamatdata[$i].'<br>'.$tgllahir[$i].'<br>'.$telp[$i].'</td></tr></table><br><table><tr><td width="80%">'.$judulta[$i].'<br><i>Pembimbing 1 : </i>'.$pembimbing1[$i].'<br><i>Pembimbing 2 : </i>'.$pembimbing2[$i].'</td></tr></table><br><br>';
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
								$html=$html.'<table><tr><td width="30%"><img src="/coba/inc/img/'.$nrpdata[$i].'.jpg" width="75" height="75" /></td><td width="70%"><b>'.$namadata[$i].'</b><br>'.$nrpdata[$i].'<br>'.$alamatdata[$i].'<br>'.$tgllahir[$i].'<br>'.$telp[$i].'</td></tr></table><br><table><tr><td width="80%">'.$judulta[$i].'<br><i>Pembimbing 1 : </i>'.$pembimbing1[$i].'<br><i>Pembimbing 2 : </i>'.$pembimbing2[$i].'</td></tr></table><br><br>';
							}	
					}

					$html=$html."</td>";
					$html=$html."</tr></table></td></tr></table>";	
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