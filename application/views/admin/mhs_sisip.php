<html>	
<head>
	<?php echo $this->load->view('css_js');?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.js"></script>
	<title>Edit Data Buku Wisuda</title>
<head>

<body class="metro">	
	<!-- HEADER -->
	<header class="bg-dark" >
		<?php echo $this->load->view('header_baak');?>
	</header>
	
	<div class="grid">
		<div class="row">
			<div class="span3">
				<?php echo $this->load->view('sidebar_baak');?>
			</div>
			<div class="span12">
			<!-- content -->
				<legend><p class="item-title">Mahasiswa Sisipan</p></legend>	
				<?php echo form_open(base_url().'buku/carimhs');?>						
					<label class="span2">
						Masukkan NRP<br> 
						<br>
						
					</label>
					<div class="span2">
						<div class="input-control text" data-role="input-control">
							<input type="text"  name='input_nrp'>
							<button class="btn-clear" tabindex="-1" type="button"></button>	
						</div>				
						
					</div>	<button class="primary span1" align="left">Cari</button>
				</form>	
			</div>
		<div class="row">
			<div class="span12">
			<br>
			<?php echo form_open(base_url().'kursiwisuda/sisip_mhs');?>
			<table>
				<tr>
					<td class="span3">&nbsp;NAMA</td>
					<td class="span3">
						<div class="input-control text bg-cyan" data-role="input-control">
							<span class="fg-white"><?echo $nama; ?></span>
							<input type="hidden" name="input_nama" value="<?echo $nama; ?>">
						</div>
					</td>
				</tr>
				<tr>
					<td><label>&nbsp;NRP</label></td>
					<td>
						<div class="input-control text bg-cyan" data-role="input-control">							
							<span class="fg-white">&nbsp;<?echo $nrp;?></span>
							<input type="hidden" name="input_nrp" value="<?echo $nrp;?>">
						</div>
					</td>
				</tr>
				<tr>
					<td>&nbsp;PERIODE WISUDA</td>
					<td>
						<div class="input-control text" data-role="input-control">							
							<span><?echo $periode;?></span>
							<input type="hidden" name="input_periode" value="<?echo $periode;?>">
						</div>
					</td>
				</tr>
				<tr>
					<td>&nbsp;PROSESI WISUDA</td>
					<td>
						<div class="span1 input-control text" data-role="input-control">	
							<input type="text" name='input_prosesi' value='<?echo $prosesi;?>'>
							<button class="btn-clear" tabindex="-1" type="button"></button>
						</div>
					</td>
				</tr>
			</table>
			</form>	
			</div>
		</div>
			
		
	</div>
	<?php
		if($isi_status=='berhasil'){
			$this->load->view('notif/berhasil_notif');
		}
	?>
	
	
</body>
</html>	