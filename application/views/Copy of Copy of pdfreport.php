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
	$pdf = new TCPDF("P", "mm","A4", true, 'UTF-8', false);
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
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$pdf->SetMargins($marginleft, $margintop, $marginright);
	$pdf->SetAutoPageBreak(TRUE, $marginbottom);
	$pdf->SetFont('helvetica', '', 9);
	$pdf->setFontSubsetting(false);
	
	$halaman=0;
	foreach ($data_prodi as $key => $value) 
		{
			$halaman=$halaman+1;
			$pdf->AddPage();
			$pdf->setPage($halaman, true);
	
			$no=0;	
			$ip=0;
			$lamastudi=0;
			$html="Wisuda ke ".$periodewisuda;
			$html=$html."<br><br><table border='1' style=\"border:1px solid black;\"><tr><td style=\"width:'25px'; border:1px solid black;\">No</td><td style=\"width:'70px'; border:1px solid black;\">Nrp</td><td style=\"width:'240px'; border:1px solid black;\">Nama</td><td style=\"width:'40px'; border:1px solid black;\">Jenis Kelamin</td><td style=\"width:'40px'; border:1px solid black;\">IPK</td><td style=\"width:'40px'; border:1px solid black;\">Lama Studi</td></tr>";
    
	  	    $fak_jur = $this->Db_model->ambil_fakultas_jurusan($value);
	        foreach ($fak_jur->result_array() as $row)
            {
				$no=$no+1;
				$html=$html."<tr><td style=\"border:1px solid black;\">".$no."</td><td style=\"border:1px solid black;\">".$row['mhs_nrp']."</td><td style=\"border:1px solid black;\">".$row['mhs_nama']."</td><td style=\"border:1px solid black;\">".$row['mhs_kelamin']."</td><td style=\"border:1px solid black;\">".$row['mhs_ipk']."</td><td style=\"border:1px solid black;\">".$row['mhs_lama_studi']."</td></tr>";
				$ip=$ip+$row['mhs_ipk'];
				$iprata2=$ip/$no;
				$lamastudi=$lamastudi+$row['mhs_lama_studi'];
				$lamastudirata2=$lamastudi/$no;
			}

			$html=$html."</table><br><br>";	
			$html=$html."IP Rata-rata : ".$iprata2."<br>";
			$html=$html."Lama Studi Rata-rata : ".$lamastudirata2."<br>";
			
	
			$pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
			
			$halaman=$halaman+1;
			
			$html='';
			$pdf->AddPage();
			$pdf->setPage($halaman, true);
			$html="<table >
					<tr >";
			$ctr=0;
            $fak_jur = $this->Db_model->ambil_fakultas_jurusan($value);			
			foreach ($fak_jur->result_array() as $row)
            {	
				$ctr=$ctr+1;
				$nrpdata[$ctr]=$row['MA_Nrp'];
				$namadata[$ctr]=$row['MA_Nama'];
				$alamatdata[$ctr]=$row['MA_AlamatSby'];		
				$foto[$ctr]=$row['MA_Photo'];
			}
			$html=$html."<td style=\"width: 100mm;\">";
			for ($i=1; $i<=$ctr; $i++)
			{
				if ($i<=5)
					{
						//header('Content-type:image');
						$html=$html."<img src='/coba/inc/img/2408100041.jpg' height='50' width='50'><br>".$nrpdata[$i]."<br>".$namadata[$i]."<br>".$alamatdata[$i]."<br><br>";
					}	
			}
			$html=$html."</td>";

			$html=$html."<td style=\"width: 100mm;\">";
			
			for ($i=1; $i<=$ctr; $i++)
			{
				if ($i>5)
					{
						$html=$html."<img src='/coba/inc/img/2408100041.jpg' height='50' width='50'><br>".$nrpdata[$i]."<br>".$namadata[$i]."<br>".$alamatdata[$i]."<br><br>";
					}	
			}

			$html=$html."</td>";
			$html=$html."</tr></table>";	
			//$pdf->writeHTML($html,true, false, true, false, '');
			
$pdf->writeHTML($html, true, 0, true, 0);
			$html='';

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