<html>	
<head>
	<?php $this->load->view('css_js');?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.js"></script>
	<title>Edit Data Buku Wisuda</title>
<head>

<body class="metro">	
	<!-- HEADER -->
	<header class="bg-dark" >
		<?php $this->load->view('header_baak');?>
	</header>
	
	<div class="grid">
		<div class="row">
			<div class="span3">
				<?php $this->load->view('sidebar_baak');?>
			</div>
			<div class="span10">
			<!-- content -->
			<?php echo form_open('buku/proses_lulusanke');?>
					<legend><p class="item-title">Update Data Lulusan Ke</p></legend>		
					<label class="span2">
						Kode Prodi<br><br>Nama Prodi<br><br>Lulusan Ke<br><br><button class="primary span2" align="left">Ubah Data</button>
						<br><br>
					</label>
					<div class="span2">
						<div class="input-control text" data-role="input-control">
							<span class="span6"><?php echo $kodeprodi;?></span>
							<input type="hidden" name="kodeprodi" value="<?php echo substr($kodeprodi,0,4).'%';?>">
						</div>
						<br><div class="input-control text" data-role="input-control">
							<span class="span6"><?php echo $nama_prodi;?></span>
							<input type="hidden" name="namaprodi" value="<?php echo $nama_prodi;?>">
						</div>
						<br>
						<div class="input-control text" data-role="input-control">
							<input type="text" class="span2" name='input_lulusan' value="<?php echo $lulusanke;?>">
							<button class="btn-clear" tabindex="-1" type="button"></button>
						</div>	
					</div>
							

			</form>	
			</div>	
		</div>
			
			
		
	</div>
	
	
	
</body>
</html>	