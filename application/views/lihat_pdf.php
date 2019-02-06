<html>	
<head>
	<?php $this->load->view('css_js');?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.js"></script>
	<!-- DATEPICKER -->
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/metro/metro-calendar.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/metro/metro-datepicker.js"></script>
	
	<title>Data Buku Wisuda</title>
<head>

<body class="metro">		
	<div class="grid">		
		<div class="row">
			<!-- HEADER -->
			<header class="bg-dark" >
				<?php $this->load->view('header_baak');?>
			</header>
			<!-- SIDEBAR -->
			<div class="span3">
				<?php $this->load->view('sidebar_baak');?>
			</div>
			<div class="span8">				
				<table class="table striped">
					<thead>
					<tr>
						<th class="text-center"><p class="item-title">Periode Wisuda</p></th>
						<th class="text-center"><p class="item-title">Hari</p></th>
						<th class="text-center"><p class="item-title">Nama File</p></th>
						<th class="text-center"><p class="item-title">Pilihan</p></th>
					</tr>
					</thead>
					
					<tbody> 	  
						<?php foreach($hasil as $row){ ?>
							<tr>
								<td align="center"><?php echo $row->periode ;?></td>
								<td align="center"><?php echo $row->hari;?></td>
								<td align="center"><?php echo $row->nama_file ;?></td>	
								<td align="center">
									<a href="<?php echo base_url().'/buku/unduh_buku/'.$row->periode.$row->hari; ?>"><i class="icon-download-2"></i>Unduh</a>
									<a href="<?php echo base_url().'/buku/edit_data_pdf/'.$row->periode.$row->hari; ?> "><i class="icon-pencil"></i>Edit</a>
									<a href="<?php echo base_url().'/buku/delete_data_buku/'.$row->periode.$row->hari; ?> "><i class="icon-remove"></i>Hapus</a>
								</td>
								
							</tr>
						<?php } ?>
					</tbody>
				</table>
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