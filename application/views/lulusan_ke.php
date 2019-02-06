<html>
	<link rel="stylesheet" type="text/css" href="/coba/inc/Metro-UI-CSS-master/css/metro-bootstrap.css">
    
<head>
	<?php $this->load->view('css_js');?>
	<title>Data Lulusan Ke</title>
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
					<th class="text-center"><p class="item-title">Kode Prodi</p></th>
					<th class="text-center"><p class="item-title">Nama Prodi</p></th>
					<th class="text-center"><p class="item-title">Lulusan Ke</p></th>
					<th class="text-center"><p class="item-title">Pilihan</p></th>
				</tr>
				</thead>
				
				<tbody> 	  
					<?php foreach($hasil as $row){ ?>
						<tr>
							<td align="center"><?php echo $row->KODEPRODI ;?></td>
							<td align="center"><?php echo $row->NAMAPRODI;?></td>
							<td align="center"><?php echo $row->lulusan_ke ;?></td>	
							<td align="center"><a href="<?php echo base_url().'/buku/edit_lulusanke/'.$row->KODEPRODI; ?> "><i class="icon-pencil"></i>Edit</a></td>
						</tr>
					<?php } ?>
				</tbody>
				
				<tfoot></tfoot>
			<table>
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