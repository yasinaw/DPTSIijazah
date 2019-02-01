<html>
<head>
	<?php echo $this->load->view('css_js');?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/metro/metro-input-control.js"></script>
	<title>Upload Buku Wisuda</title>
<head>
<body class="metro">
	<!-- HEADER -->
	<header class="bg-dark" >
		<?php echo $this->load->view('header_baak');?>
	</header>
	<table class="table bordered">
		<tr>			
			<td class="span3">
			<!-- SIDEBAR -->
				<?php echo $this->load->view('sidebar_baak');?>
			</td>
			<!-- CONTENT -->
			<td>
				<?php echo form_open_multipart('/buku/upload_bukuwisuda');?>
					<fieldset>
						<legend><p class="item-title">Pilih File yang Akan Diunggah</p></legend>		
						<div class="span5">
							<input type="file" name="userfile" size="20" />
						</div>
						<div class='input-control text' data-role='input-control' >							
							<p>
								Periode Wisuda <input type='text' name='periode' style='width:1.2cm'> 
								Hari Ke <input type='text' name='hari' style='width:1.2cm'>
							</p> 
						</div>
						<br>
						<input type="submit" value="Upload File" class="button primary">
					</fieldset>	
				</form>
			</td>
		</tr>
	</table>
	<?php
		if($isi_status=='error'){
			$this->load->view('js_notif');
		}
	?>
	

	
</body>
</html>