<html>
<head>
	<title>Cetak Buku Wisuda</title>
<head>
	<?php echo $this->load->view('css_js');?>
	
	<!-- DATEPICKER -->
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/metro/metro-calendar.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/metro/metro-datepicker.js"></script>
		
	<!-- TAB -->
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/metro/metro-tab-control.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>


<script>
		var penambah = 0;    
		var tempas = 0;
		function tambah_jurusan(as) 
		{
			    var a = document.getElementById('tabel_fakultas'+as);
                var b = a.innerHTML;
                var d = document.getElementById('combo_prodi'+as);
				var str = d.value;
				var words = new Array();
				words = str.split('-');
		        
				if (tempas!=as)
					{
						tempas=as;
						penambah=0;
					}
				penambah++;				
				//window.alert(penambah);
				var c = "<tbody><tr><td><input type=\"hidden\" name=\"input_hidden["+penambah+"]\" value=\""+words[0]+"-"+words[3]+"\">" + words[1] + "</td><td>"+words[2]+"</td><td><input type=\"button\" class='button danger' value=\"Delete\" onclick=\"hapus_jurusan(this, "+as+")\"></td></tr></tbody>";
                a.innerHTML = b + c;
        }
		
		//function tambah_fakultas(as) 
		//{
		//	    var a = document.getElementById('tabel_fakultas'+as);
        //        var b = a.innerHTML;
        //        var d = document.getElementById('combo_fakultas'+as);
		//		var str = d.value;
		//		var words = new Array();
		//		words = str.split('-');
		//        
		//		if (tempas!=as)
		//			{
		//				tempas=as;
		//				penambah=0;
		//			}
		//		penambah++;				
		//		//window.alert(penambah);
		//		var c = "<tbody><tr><td><input type=\"hidden\" name=\"input_hidden["+penambah+"]\" value=\""+words[0]+"\">"A"</td><td>"+words[1]+"</td><td><input type=\"button\" class='button danger' value=\"Delete\" onclick=\"hapus_jurusan(this, "+as+")\"></td></tr></tbody>";
        //        a.innerHTML = b + c;
        //}
		
		function hapus_jurusan(r, as) 
		{
                var i = r.parentNode.parentNode.rowIndex;

                var x;
                var r = confirm("Anda Yakin ?");
                if (r == true)
                {
                    x = document.getElementById('tabel_jurusan'+as).deleteRow(i);
                    penambah--;
                }
                else
                {
                    x = "You pressed Cancel!";
                }
        }
		
		

</script>		

<body class="metro">
<div class="grid">		
	<div class="row">
		<!-- HEADER -->
		<header class="bg-dark" >
			<?php echo $this->load->view('header_baak');?>
		</header>
		<!-- SIDEBAR -->
		<div class="span3">
			<?php echo $this->load->view('sidebar_baak');?>
		</div>
		
<?PHP
	$this->load->helper('form');
	//echo "<br><center>";
	//echo "<ul id='nav'>";	
	echo"<div class='span10'>
		<div class='tab-control' data-effect='fade' data-role='tab-control'>
			<ul class='tabs'>
		";
	for ($i=1; $i<=$n; $i++)
	{
		if($i==1){
			echo'<li class="active"><a href="#_page_1">Periode Wisuda : '.$pr.' Hari ke : '.$i.'</a></li>';
		}
		else{
			echo'<li><a href="#_page_'.$i.'">Periode Wisuda : '.$pr.' Hari ke : '.$i.'</a></li>';
		}
		
	}
	echo "</ul>
	<div class='frames'>";
	
	
	for ($i=1; $i<=$n; $i++)
	{	
		echo'
				<div class="frame" id="_page_'.$i.'">
			';
				
		echo "			
		<form method=POST action='generate_buku_pdf?buku=".$i."' id='register-form' novalidate='novalidate' target='_blank'>";
			"<table width='70%' border='1'>	
				<tr>
					<td>
		";
			echo "
			<h3>&nbsp;Periode Wisuda : ".$pr."</h3><input type='hidden' name='periodewisuda' value='".$pr."'>
			<h3>&nbsp;Hari Ke : ".$i."</h3>
				<div class='span11'>
				<table>
					<tr>
						<td style='width:4cm'><p>Margin Left</p></td>
						<td>
							<div class='input-control text' data-role='input-control' >
								<p><input type='text' name='marginleft' style='width:1.2cm' value='17'> mm</p> 
								";
								echo form_error('marginkiri')  ;
			echo"
							</div>
						</td>
					</tr>
					
					<tr>
		<td style='width:4cm'><p>Margin Right</p></td>
		<td>
			<div class='input-control text' data-role='input-control' >
				<p><input type='text' name='marginright' style='width:1.2cm' value='45'> mm</p> 
			</div>
		</td>
	</tr>
	<tr>
		<td style='width:4cm'><p>Margin Top</td>
		<td>
			<div class='input-control text' data-role='input-control' >
				<p><input type='text' name='margintop' style='width:1.2cm' value='14'> mm</p> 
			</div>
		</td>
	</tr>
	<tr>
		<td style='width:4cm'><p>Margin Bottom</td>
		<td>
			<div class='input-control text' data-role='input-control' >
				<p><input type='text' name='marginbottom' style='width:1.2cm' value='79'> mm</p> 
			</div>
		</td>
	</tr>
	<tr>
		<td style='width:4cm'><p>Ukuran Kertas</td>
		<td>
			<div class='span2'>
				<div class='input-control select'>
					<select name='ukuran'>
						<option value='A4'>A4</option>	
						<option value='F4'>F4</option>
						<option value='ITS PAPER'>ITS PAPER</option>	
					</select>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td style='width:4cm'><p>Urut Berdasarkan</p></td>
		<td>			
				<div class='input-control select'>
				<div class='span2'>
					<select name='urutan'>
						<option value='NRP'>NRP</option>		
						<option value='IPK'>IPK</option>		
					</select>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td style='width:6cm'><p>Jumlah Data Per Kolom</p></td>
		<td>
			<div class='input-control text' data-role='input-control' >
				<p><input type='text' name='jumlah_data' value='3' style='width:1.2cm'></p> 
			</div>
		</td>
	</tr>
	<tr>
		<td style='width:6cm'><p>Tgl</p></td>
		<td>
			<div class='span3'>
            <div class='input-control text' data-role='datepicker'  data-format='d mmmm yyyy' data-effect='fade'>
                <input type='text' name='tanggal'>
                <button class='btn-date'></button>
            </div>
		</div>
		</td>
	</tr>	
	<tr>
	<td style='width:6cm'><p>Update Data Lulusan</p></td>
	<td>
		<div class='input-control switch'>
			<label>
				<input type='checkbox' name='cek_update' value='yes'/>
				<span class='check'></span>
			</label>
		</div>
	</td>
	</tr>
	";
		
	$ctr=0;
	foreach($data_fakultas as $row) 
	{
		$ctr=$ctr+1;
		$id_fakultas[$ctr]=$row->FA_ID;
		$nama_fakultas[$ctr]=$row->FA_Nama;
	}
	
	echo "
	<tr>
		<td style='width:4cm'><p>Pilih Fakultas</p></td>
		<td>		
			<div class='input-control select'>
			<div class='span4'>
				<select name='namafakultas".$i."' id='combo_fakultas".$i."'>
				
	";
	for ($j = 1; $j <= $ctr; $j++) 
	{
		echo "
		<option value='$id_fakultas[$j]'>$nama_fakultas[$j]</option>";
	}
	echo "		</select>				
			</div>
			</div>
		</td>
		<td>
			&nbsp;<button type='button' class='button info' onclick=tambah_jurusan(".$i.") id='tambah_fakultas'>Tambah</button>
		</td>
	</tr>
	</table>
	<br><br>";	
	
	foreach($data_prodi as $row) 
	{
		$ctr=$ctr+1;
		$nama_prodi[$ctr]=$row->PS_Nama;
		$nama_fakultas[$ctr]=$row->FA_Nama;
		$tempfaid=$row->PS_FA_ID;
		$tempjuid=$row->PS_JU_ID;
		$tempid=$row->PS_ID;
		$kode_prodi[$ctr]=$tempfaid.$tempjuid.substr($tempid,0,2);
		$mhs_kojur[$ctr]=$tempfaid.$tempjuid.$tempid;
	}	
	echo "
	<tr>
		<td style='width:4cm'><p>Pilih Prodi</p></td>
		<td>		
			<div class='input-control select'>
			<div class='span4'>
				<select name='namaprodi".$i."' id='combo_prodi".$i."'>
				
	";
	for ($j = 1; $j <= $ctr; $j++) 
	{
		echo "
		<option value='$kode_prodi[$j]-$nama_prodi[$j]-$nama_fakultas[$j]-$mhs_kojur[$j]'>$nama_prodi[$j]</option>";
	}
	echo "		</select>				
			</div>
			</div>
		</td>
		<td>
			&nbsp;<button type='button' class='button info' onclick=tambah_jurusan(".$i.") id='tambah_prodi'>Tambah</button>
		</td>
	</tr>
	</table>
	<br><br>";	

	
			echo "
			<table id='tabel_fakultas".$i."' class='table hovered'>
			<thead>
				<tr>
				<th >Program Studi</th>
				<th >Fakultas</th>
				<th style='width:100px'>Pilihan</th>
			</tr>
			<thead>
			</table><br>"; 
			echo "<button class='default bg-color-blue'>Submit</button>";
		echo "		</td>
			</tr>
		  </table><br>";
		echo "
			</div>
		</form>"; 	
		echo "</div>";		
	}
	echo	"
	</div></div></div></div>";	
?>
	
</body>
</html>	