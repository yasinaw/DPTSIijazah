<html>
	<link href="<?php echo base_url();?>assets/css/metro-bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/metro-bootstrap-responsive.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/docs.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/js/prettify/prettify.css" rel="stylesheet">

    <!-- Load JavaScript Libraries -->
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery/jquery.widget.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/prettify/prettify.js"></script>

    <!-- Metro UI CSS JavaScript plugins -->
    
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/load-metro.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/metro/metro-loader.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/metro.min.js"></script>

    <!-- Local JavaScript -->
    
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/docs.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/github.info.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/hitua.js"></script>


<head>
	<title>Login</title>
<head>
<body class="metro">	
	<center>
		<div class="span9" style="padding-top:200px">
		<table class="table bordered">
			<tr>
				<td>
				<form>
                    <fieldset>
                        <legend><h1>Halaman Login</h1></legend>
                        <label class="item-title">Username</label>
						<div class="span4">
							<div class="input-control text" data-role="input-control">
								<input type="text" placeholder="Input">
								<button class="btn-clear" tabindex="-1" type="button"></button>
							</div>
                        </div>
                        <label class="item-title">Password</label>
						<div class="span4">
							<div class="input-control password" data-role="input-control">
								<input type="password" placeholder="type password" autofocus="">
								<button class="btn-reveal" tabindex="-1" type="button"></button>
							</div>
                        </div>
                        <input type="submit" value="Login" class="button primary">
                    </fieldset>
                </form>
				</td>
			</tr>
		</table>
		</div>
	</center>
</body>
</html>