<html>	
<head>
	<?php $this->load->view('css_js');?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.js"></script>
	
	<title>Data Pengguna</title>
<head>

<body class="metro">		
	<div class="grid">		
		<div class="row">
			<!-- HEADER -->
			<header class="bg-dark" >
				<?php $this->load->view('admin/header_admin');?>
			</header>
			<!-- SIDEBAR -->
			<div class="span3">
				<?php //echo $this->load->view('admin/sidebar_admin');?>
			</div>
			<div class="span8">		
				<h1>
                    <a href="javascript:history.back()"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Daftar<small class="on-right">pengguna</small>
                </h1>
				<legend></legend>
				<table class="table striped">
					<thead>
					<tr>
						<th class="text-center"><p class="item-title">Username</p></th>
						<th class="text-center"><p class="item-title">Nama Pengguna</p></th>
						<th class="text-center"><p class="item-title">Hak Akses</p></th>
						<th class="text-center"><p class="item-title">Pilihan</p></th>
					</tr>
					</thead>
					
					<tbody> 	  
						<?php foreach($hasil as $row){ ?>
							<tr>
								<td align="center"><?php echo $row->username ;?></td>
								<td align="center"><?php echo $row->nama_user;?></td>
								<td align="center"><?php echo $row->hak_akses ;?></td>	
								<td align="center">
									<a href="<?php echo base_url().'admin/edit_pengguna/'.$row->username; ?> "><i class="icon-pencil"></i>Edit</a>
									<a href="<?php echo base_url().'admin/hapus_pengguna/'.$row->username; ?> "><i class="icon-remove"></i>Hapus</a>
								</td>
								
							</tr>
						<?php } ?>
					</tbody>
				</table>
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