<div class="navigation-bar dark">
    <div class="navigation-bar-content container">
        <a href="/" class="element"><span class="icon-grid-view"></span> METRO UI CSS <sup>2.0</sup></a>
        <span class="element-divider"></span>
        <a class="element1 pull-menu" href="#"></a>
        <ul class="element-menu">
            <li>
                <a href="<?php echo base_url().'admin/list_pengguna';?>">Daftar Pengguna</a>               
            </li>
			<li>
                <a  href="#"></a>               
            </li>
           
        </ul>

		<div class="element place-right">
			<a class="dropdown-toggle" href="#">
				<span class="icon-cog"></span>
			</a>
			<ul class="dropdown-menu dark place-right" data-role="dropdown">
				<li><a href="<?php echo base_url().'login/logout';?>">Logout</a></li>
			</ul>
		</div>
		<div class="no-tablet-portrait">
			<span class="element-divider place-right"></span>
			<button class="element image-button image-left place-right" onClick="location.href='<?echo base_url().'profil';?>'">
				Selamat Datang, <?php echo $namauser;?>
			</button>
		</div>
	</div>
</div>