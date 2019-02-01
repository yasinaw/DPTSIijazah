<html>	
<head>
	<title>Login</title>
		
	<?php echo $this->load->view('css_js');?>
	
	<style type="text/css">
		#label { display:block;}
		#pending { border: 1px solid green;}
		#valid { border: 1px solid green;}
		#error { border: 1px solid red;}
		#validarium-error { color: red; font-weight: bold;}
	</style>
<head>
<body class="metro" >	
	<center>
		<div class="span9" style="padding-top:200px">
		<table class="table bordered">
			<tr>
				<td>
					<p class="header">
						<img src='<?echo base_url()?>/inc/logo_ITS.jpg' width='150px' height='100px'>
						SIM WISUDA <sup>2014</sup>
					</p>
                    <fieldset>
                        <legend><h2>Silahkan Login Untuk Masuk Ke Aplikasi</h2></legend>
                        
						<?php
							$attributes = array('id' => 'demo2');
							echo form_open('login', $attributes); 
						?>
						<!--form id="demo"-->
						<?php if(isset($check_database)){
							echo $check_database;
						}?>
						<!--label class="item-title">Username 							
						</label><?php echo form_error('username', '<div class="fg-red"><b>', '</b></div>'); ?>
						<div class="span4">
							<div class="input-control text" data-role="input-control">
								<p><input type="text" name="username"  placeholder="Input"></p>
								<button class="btn-clear" tabindex="-1" type="button"></button>
							</div>
                        </div-->
						<label class="item-title">Username 							
						</label><!--?php echo form_error('username', '<div class="fg-red"><b>', '</b></div>'); ?-->
						<div class="span4">	
							<p><div class="input-control text" data-role="input-control">
								<input type="text"  name='username'>
								<button class="btn-clear" tabindex="-1" type="button"></button>
								<br><?php echo form_error('username', '<div class="fg-red"><b>', '</b></div>'); ?>
							</div></p>
						</div>
						<label class="item-title">Password						
						</label><!--?php echo form_error('username', '<div class="fg-red"><b>', '</b></div>'); ?-->
						<div class="span4">	
							<p><div class="input-control password" data-role="input-control">
								<input type="password"  name='password'>
								<button class="btn-reveal" tabindex="-1" type="button"></button>
								<br><?php echo form_error('password', '<div class="fg-red"><b>', '</b></div>'); ?>
							</div></p>
						</div>
						
                        <!--label class="item-title">Password</label>
						<!--?php echo form_error('password', '<div class="fg-red"><b>', '</b></div>'); ?>
						<div class="span4">
							<div class="input-control password" data-role="input-control">
								<p><input type="password" name="password" placeholder="type password" autofocus=""><p>
								<button class="btn-reveal" tabindex="-1" type="button"></button>
							</div>
                        </div-->
						 
						<br>
                        <input type="submit" value="Login" class="button primary">	
						</form>						
                    </fieldset>
                
				</td>
			</tr>
		</table>
		</div>
	</center>
</body>
<script type="text/javascript">
		$('form#demo').validarium();
	</script>
</html>