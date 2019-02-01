		
			
<div class="navigation-bar dark">
    <div class="navigation-bar-content container">
        <a href="/" class="element"><span class="icon-grid-view"></span> SIM WISUDA <sup>2014</sup></a>
        <span class="element-divider"></span>
        <a class="element1 pull-menu" href="#"></a>
        <ul class="element-menu">
			<li>
				<a class="dropdown-toggle" href="#">
					<i class="icon-book"> </i>
					Buku Wisuda
				</a>
				<ul class="dropdown-menu " data-role="dropdown">
					<li><a href="<?echo base_url().'buku/';?>">Generate Buku Wisuda</a></li>
					<li><a href="<?echo base_url().'buku/data_buku';?>">Data Buku Wisuda</a></li>
					<li><a href="<?echo base_url().'buku/master_lulusan_ke';?>">Data Lulusan Ke</a></li>					
					
					<li class="divider"></li>
					<li><a href="<?echo base_url().'buku/upload_buku';?>">Upload Buku Wisuda</a></li>
				</ul>
			</li>           
        </ul>

		<div class="element place-right">
			<a class="dropdown-toggle" href="#">
				<span class="icon-cog"></span>
			</a>
			<ul class="dropdown-menu dark place-right" data-role="dropdown">
				<li><a href="<?echo base_url().'login/logout';?>">Logout</a></li>
			</ul>
		</div>
		<div class="no-tablet-portrait">
			<span class="element-divider place-right"></span>
			<button class="element image-button image-left place-right" onClick="location.href='<?echo base_url().'profil';?>'">
				Selamat Datang, <? echo $namauser;?>
			</button>
		</div>
	</div>
</div>