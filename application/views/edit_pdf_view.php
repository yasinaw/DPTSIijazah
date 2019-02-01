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
			<div class="span10">
			<!-- content -->
			<?php echo form_open_multipart(base_url().'buku/proses_update_buku');?>
					<legend><p class="item-title">Update Data</p></legend>		
					<label class="span2">
						Periode Wisuda<br><br>Hari Ke<br><br>Nama File<br><br>Pilih File yang Akan Diunggah
						<br><br><button class="primary span2" align="left">Ubah Data</button>
					</label>
					<div class="span1">
						<div class="input-control text" data-role="input-control">
							<input type="text"  name='input_periode' value="<?php echo $periode;?>" >
							<input type="hidden" name='periode_awal' value="<?php echo $periode;?>">
							<button class="btn-clear" tabindex="-1" type="button"></button>
						</div>
						<br>
						<div class="input-control text" data-role="input-control">
							<input type="text" class="span1" name='input_hari' value="<?php echo $hari;?>" >
							<input type="hidden" name='hari_awal' value="<?php echo $hari;?>">
							<button class="btn-clear" tabindex="-1" type="button"></button>
						</div>				
						<br>
						<div class="input-control text" data-role="input-control">
							<span class="span6"><?php echo $nama_file;?></span>
						</div>						
						<div class="span5">
							<input type="file" name="userfile" size="20" />
						</div>
					</div>
			</form>	
			</div>	
		</div>
			
			
		
	</div>
	<?php
		if($isi_status=='error'){
			$this->load->view('js_notif');
		}
	?>
	
	
</body>
</html>	