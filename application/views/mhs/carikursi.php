<html>	
<head>
	<?php echo $this->load->view('css_js');?>
	<title>Cari Kursi Wisuda</title>
<head>

<body class="metro">	
	<!-- HEADER -->
	<header class="bg-dark" >
		<?php echo $this->load->view('mhs/header_mhs');?>
	</header>
	<center>
	<div class="grid">
		<div class="row">
			<div>
			<!-- content -->
			<h1>
                Cari<small class="on-right">posisi kursi wisuda</small>
            </h1>
			<?php echo form_open(base_url().'mahasiswa/posisikursi');?>
					<legend></legend>		
					
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
								<? if(isset($check_database)){
									echo '<p class="item-title fg-red">'.$check_database.'</p>';
								}?>
							</td>
						</tr>
					</table>
					
			</form>	
			</div>	
		</div>
		
			
		
	</div>
	</center>
	
	
</body>
</html>	