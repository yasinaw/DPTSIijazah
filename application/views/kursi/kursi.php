<html>
	<?php echo $this->load->view('css_js');?>
<head>
	<title>Generate Kursi Wisuda</title>
<head>
<body class="metro">	
<header class="bg-dark" >
	<?php echo $this->load->view('kursi/header_kursi');?>
</header>
<?php
	$this->load->helper('form');
	$cmbperiodewisuda='';
	if (!empty($_GET['periodewisuda']))
		{
			$cmbperiodewisuda=$_GET['periodewisuda'];
		}
	$ctr=0;
	foreach($data_jadwal->result() as $row) 
		{
			$ctr=$ctr+1;
			//$kode_jadwal[$ctr]=$row->jadwal_kode;
			$kode_jadwal[$ctr]=$row->PERIODEWISUDA;
			//$jadwal_wisuda_mulai[$ctr]=$row->jadwal_wisuda_mulai;
			$jadwal_wisuda_mulai[$ctr]='21/08/2013';
			//$jadwal_wisuda_selesai[$ctr]=$row->jadwal_wisuda_selesai;			
			$jadwal_wisuda_selesai[$ctr]='23/08/2013';			
		}
?>
	<br>
	<br>
	<br>
	<div id="menu" style="height:500px;width:1000px;float:left;position:absolute;margin-top:15px;margin-left:130px;">
<?php echo form_open(base_url().'kursiwisuda/pengaturan_kursi'); ?>   
	<br><br>           
	<table border='0'>
		<tr>
			<td  width='60%' align='center'><img src='../inc/logo_ITS.jpg' width='90%' height='60%'></td>
			<td>
				<h3>Periode Wisuda</h3>
				<!--select name='periodewisuda' onchange="window.location='mhs?periodewisuda='+this.value"-->
				<select name='periodewisuda'>
			<?PHP		
				$ctrtgl='';
				echo "<option value=''>Pilih Periode</option>";
				for ($i = 1; $i <= $ctr; $i++) 
					{
						if ($kode_jadwal[$i]==$cmbperiodewisuda)
							{
								if (!empty($cmbperiodewisuda)) { $ctrtgl=$i; }	
								echo "<option value='$kode_jadwal[$i]' selected>$kode_jadwal[$i]</option>";
							}
						else
							{
								echo "<option value='$kode_jadwal[$i]'>$kode_jadwal[$i]</option>";
							}
					}
			?>
				</select>
			<?php
				$tgl1='0000-00-00';
				$tgl2='0000-00-00';
				if (!empty($jadwal_wisuda_mulai[$ctrtgl]))
					{
						$tgl1 = date("Y-m-d",strtotime($jadwal_wisuda_mulai[$ctrtgl]));
					}	

				if (!empty($jadwal_wisuda_selesai[$ctrtgl]))
					{
						$tgl2 = date("Y-m-d",strtotime($jadwal_wisuda_selesai[$ctrtgl]));
					}
					
				$pecah1 = explode("-", $tgl1);
				$date1 = $pecah1[2];
				$month1 = $pecah1[1];
				$year1 = $pecah1[0];
			 
				$pecah2 = explode("-", $tgl2);
				$date2 = $pecah2[2];
				$month2 = $pecah2[1];
				$year2 =  $pecah2[0];
				$jd1 = GregorianToJD($month1, $date1, $year1);
				$jd2 = GregorianToJD($month2, $date2, $year2);
				$selisih = $jd2 - $jd1;
			?>
				<br>
				<!--h3>Tanggal Mulai Wisuda</h3>
				<input type='text' name='tglmulai' disabled value=<?PHP 
				/*	if (!empty($jadwal_wisuda_mulai[$ctrtgl])) { 
						echo "'".$jadwal_wisuda_mulai[$ctrtgl]."'"; 
					} ?>><br>
				<h3>Tanggal Selesai Wisuda</h3>
				<input type='text' name='tglselesai' disabled value=<?PHP if (!empty($jadwal_wisuda_selesai[$ctrtgl])) { echo "'".$jadwal_wisuda_selesai[$ctrtgl]."'"; }*/ ?>--><br>
				<h3>Jumlah Hari Wisuda</h3>
				<input type='text' name='jmlhari'><br>
				<h3>Jumlah Baris</h3>
				<input type='text' name='jmlbaris'><br><br>
				<button class="default bg-color-blue">Submit</button>
			<?php echo form_close();?>
			</td>
		</tr>		
	</table>	
	</div>	
</body>
</html>