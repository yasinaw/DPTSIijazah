<html>	
<head>
	<?php $this->load->view('css_js');?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.js"></script>
	<title>Cari Mahasiswa</title>
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
			<div class="span12">
			<!-- content -->
			<?php echo form_open(base_url().'kursiwisuda/carimhs');?>
					<legend><p class="item-title">Cari Posisi Kursi Wisuda</p></legend>		
					
					<table>
					    <tr>
							<td class="span2">Masukkan NRP</td>
							<td>
							<div class="span2">	
								<p><div class="input-control text" data-role="input-control">
									<input type="text" class="span2" name='input_nrp'>
									<button class="btn-clear" tabindex="-1" type="button"></button>
									<br><?php echo form_error('input_nrp', '<div class="span3 fg-red"><strong><small>', '</small></strong></div>'); ?>									
								</div></p>
							</div>						
							</td>
							<td align="left">
								&nbsp;<button class="primary span1" align="left">Cari</button>
							</td>
						</tr>
						<tr>
							<td class="span2"></td>
							<td colspan="2">
								<?php if(isset($check_database)){
									echo '<p class="item-title fg-red">'.$check_database.'</p>';
								}?>
							</td>
						</tr>
					</table>
					
			</form>	
			</div>	
		</div>
	</div>
</body>

</html>	