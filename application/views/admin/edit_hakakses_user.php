<html>	
<head>
	<?php $this->load->view('css_js');?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.js"></script>
	<title>Edit Data Pengguna</title>
<head>

<body class="metro">	
	<!-- HEADER -->
	<header class="bg-dark" >
		<?php $this->load->view('admin/header_admin');?>
	</header>
	
	<div class="grid">
		<div class="row">
			<div class="span3">
				<!--?php// echo $this->load->view('sidebar_baak'); ?-->
			</div>
			<div class="span10">
			<!-- content -->
			<?php echo form_open('admin/update_pengguna');?>
				<h1>
                    <a href="javascript:history.back()"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Edit<small class="on-right">data pengguna</small>
                </h1>
				<legend></legend>
					<label class="span2">
						Username<br><br>Nama Pengguna<br><br>Hak Akses
					</label>
					<div class="span3">
						<div class="input-control text" data-role="input-control">
							<input type="text" value="<?php echo $username;?>" disabled >
							<input type="hidden" name='input_username' value="<?php echo $username;?>">
							<button class="btn-clear" tabindex="-1" type="button"></button>
						</div>
						<br>
						<div class="input-control text" data-role="input-control">
							<input type="text" class="span3" value="<?php echo $nama;?>" disabled>
							<input type="hidden" name='input_nama' value="<?php echo $nama;?>">
							<button class="btn-clear" tabindex="-1" type="button"></button>
						</div>				
						<br>
						<div class="input-control select span3">
							<select name="combo_akses">
								<option value="">-- Pilih Hak Akses --</option>
								<option value="BUKU">Buku Wisuda</option>
								<option value="KURSI">Kursi Wisuda</option>
								<option value="ADMIN">Admin</option>
							</select>
						</div>					
						<button class="primary span2" align="left" style="margin-left:80">Ubah Data</button>
					</div>
					<?php echo form_error('combo_akses', '<br><br><br><br><div class="fg-red"><strong><small>', '</small></strong></div>'); ?>
			</form>	
			</div>	
		</div>
			
			
		
	</div>
	
	
	
</body>
</html>	