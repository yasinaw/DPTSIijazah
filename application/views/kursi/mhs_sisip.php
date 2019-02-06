<html>	
<head>
	<?php $this->load->view('css_js');?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.js"></script>
	<title>Edit Data Buku Wisuda</title>
<head>

<body class="metro">	
	<!-- HEADER -->
	<header class="bg-dark" >
		<?php $this->load->view('kursi/header_kursi');?>
	</header>
	
	<div class="grid">
		<div class="row">
			<div class="span3">
				<?php $this->load->view('kursi/sidebar_kursi');?>
			</div>
			<div class="span10">
			<!-- content -->
				<h1>
					<a href="javascript:history.back()"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
					Mahasiswa<small class="on-right">sisipan</small>
				</h1>
				<legend></legend>	
				<?php echo form_open(base_url().'kursiwisuda/carimhs');?>						
					<label class="span2">
						Masukkan NRP<br> 
						<br>						
					</label>
					<div class="span2">
						<div class="input-control text" data-role="input-control">
							<input type="text"  name='input_nrp'>
							<button class="btn-clear" tabindex="-1" type="button"></button>	
						</div>										
					</div><button class="primary span1" align="left">Cari</button>
				</form>	
			</div>
		<div class="row">
			<div class="span10">
			<br>
			<?php echo form_open(base_url().'kursiwisuda/sisip_mhs');?>
			<table>
				<tr>
					<td class="span3">&nbsp;NAMA</td>
					<td class="span3">
						<div class="input-control text bg-cyan" data-role="input-control">
							<span class="fg-white"><?php echo $nama; ?></span>
							<input type="hidden" name="input_nama" value="<?php echo $nama; ?>">
						</div>
					</td>
				</tr>
				<tr>
					<td><label>&nbsp;NRP</label></td>
					<td>
						<div class="input-control text bg-cyan" data-role="input-control">							
							<span class="fg-white">&nbsp;<?php echo $nrp;?></span>
							<input type="hidden" name="input_nrp" value="<?php echo $nrp;?>">
						</div>
					</td>
				</tr>
				<tr>
					<td>&nbsp;PERIODE WISUDA</td>
					<td>
						<div class="input-control text" data-role="input-control">							
							<span><?php echo $periode;?></span>
							<input type="hidden" name="input_periode" value="<?php echo $periode;?>">
						</div>
					</td>
				</tr>
				<tr>
					<td>&nbsp;PROSESI WISUDA</td>
					<td>
						<div class="span1 input-control text" data-role="input-control">	
							<input type="text" name='input_prosesi' value='<?php echo $prosesi;?>'>
							<button class="btn-clear" tabindex="-1" type="button"></button>
						</div>						
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<button class="primary span2" align="center">Ubah Data</button>			
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