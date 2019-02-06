<html>	
<head>
	<?php $this->load->view('css_js');?>
	<title>Mahasiswa Sisipan</title>
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
			<div class="span12">
			<!-- content -->
				<h1>
                    <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
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
							<span class="fg-white"><?php echo $nama; ?></span>
						</div>
					</td>
				</tr>
				<tr>
					<td><label>&nbsp;NRP</label></td>
					<td>
						<div class="input-control text bg-cyan" data-role="input-control">							
							<span class="fg-white">&nbsp;<?php echo $nrp;?></span>
						</div>
					</td>
				</tr>
				<tr>
					<td>&nbsp;PERIODE WISUDA</td>
					<td>
						<div class="input-control text" data-role="input-control">							
							<span><?php echo $periode;?></span>
						</div>
					</td>
				</tr>
				<tr>
					<td>&nbsp;PROSESI WISUDA</td>
					<td>
						<div class="span1 input-control text" data-role="input-control">	
							<span><?php echo $prosesi;?></span>
							<button class="btn-clear" tabindex="-1" type="button"></button>
						</div>
					</td>
				</tr>
			</table>
			</form>	
			</div>
		</div>
			
		
		</div>
	</div>
	<?php
		
		echo $isi_status;
		if($isi_status=='berhasil'){
			$this->load->view('notif/berhasil_notif');
		}
	?>
	
	
</body>
</html>	