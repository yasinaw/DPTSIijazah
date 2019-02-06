<html>	
<head>
	<?php $this->load->view('css_js');?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.js"></script>
	<title>Profil</title>
<head>

<body class="metro">	
	<!-- HEADER -->
	<header class="bg-dark" >
		<?php
			if($akses=='BUKU'){
				$this->load->view('header_baak');
			}
			else if($akses	=='KURSI'){
				$this->load->view('kursi/header_kursi');
			}
			else if($akses	=='ADMIN'){
				$this->load->view('admin/header_admin');
			}
			
		?>
	</header>
	
	<div class="grid">
		<div class="row">
			<div class="span3">
				<?php 
					if($akses=='BUKU'){
						$this->load->view('sidebar_baak');
					}
					else if($akses=='KURSI'){
						$this->load->view('kursi/sidebar_kursi');
					}
					
				?>
			</div>
			<div class="span12">
			<!-- content -->
				<h1>
                    <a href="javascript:history.back()"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Profil<small class="on-right"><?php echo $nama;?></small>
                </h1>
				<legend></legend>	
				
			</div>
		<div class="row">
			<div class="span12">
			<br>
			<?php echo form_open(base_url().'kursiwisuda/sisip_mhs');?>
			<table>
				<tr>
					<td class="span3">&nbsp;Username</td>
					<td class="span3">
						<div class="input-control text" data-role="input-control">
							<span><?php echo $username; ?></span>
							<input type="hidden" name="input_user" value="<?php echo $username; ?>">
						</div>
					</td>
				</tr>
				<tr>
					<td><label>&nbsp;Nama Pegguna</label></td>
					<td>
						<div class="input-control text" data-role="input-control">							
							<span><?php echo $nama;?></span>
							<input type="hidden" name="input_nrp" value="<?php echo $nama;?>">
						</div>
					</td>
				</tr>
				<tr>
					<td>&nbsp;Hak Akses</td>
					<td>
						<div class="input-control text" data-role="input-control">							
							<span><?php echo $akses;?></span>
							<input type="hidden" name="input_periode" value="<?php echo $akses;?>">
						</div>
					</td>
				</tr>
				
				<tr>
					<td></td>
					<td>
						<!--button class="primary span2" align="center">Edit Profil</button-->			
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