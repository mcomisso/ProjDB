<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="<? echo base_url();?>/style/register.css"/>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>javascript/md5.js"></script>

		<script>
		
			// FORM Check and confirmation
		 	$(document).ready(function(){			 	
			 	$('#password').on("blur", function(){
			 		var hashed = CryptoJS.MD5(CryptoJS.MD5(CryptoJS.MD5($('#password').val())));
			 		$('#password').val(hashed);
			 	});
			 	
			 	$('#password').on("submit", function(){
			 		var hashed = CryptoJS.MD5(CryptoJS.MD5(CryptoJS.MD5($('#password').val())));
			 		$('#password').val(hashed);
			 	});
			 				 	
			 	$('#passConf').on("blur", function(){
				 	var hashed = CryptoJS.MD5(CryptoJS.MD5(CryptoJS.MD5($('#passConf').val())));
				 	$('#passConf').val(hashed);
			 	});
			 	
			 	$('#passConf').on("submit", function(){
				 	var hashed = CryptoJS.MD5(CryptoJS.MD5(CryptoJS.MD5($('#passConf').val())));
				 	$('#passConf').val(hashed);
			 	});
		 	});
	 	</script>

	</head>
	
	<body>
		<div id="tag">
			<div id="grim"></div>
		<?php echo validation_errors(); ?>
		<?php echo form_open('doRegistration');?>
		
<!--		<label for="email">Email</label> -->
		<input class="inserimento" type="email" name="email" id="email" placeholder="E-mail"/> <br/>

<!--		<label for="username">Username</label> -->
		<input class="inserimento" type="username" name="username" id="username" placeholder="Username"/> <br/>

<!-- 		<label for="password">Password</label> -->
		<input class="inserimento" type="password" name="password" id="password" placeholder="Password"/> <br/>
		
<!--		<label for="passConf">Confirm Password</label> -->
		<input class="inserimento" type="password" name="passConf" id="passConf" placeholder="Conferma Password"/>
		
		<input type="submit" name="submit" id="sub" value="Registrami"/>
		<?php echo form_close(); ?>
		</div>
	</body>
</html>