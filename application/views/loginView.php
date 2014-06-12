<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title?></title>
		<link rel="stylesheet" href="<? echo base_url();?>/style/login.css"/>
		 <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		 <script type="text/javascript" src="<?php echo base_url();?>javascript/md5.js"></script>
		 
		 <script>
		 	$(document).ready(function(){
			 	$('#password').on("blur", function(){
			 		var hashed = CryptoJS.MD5(CryptoJS.MD5(CryptoJS.MD5($('#password').val())));
			 		$('#password').val(hashed);
			 	});
			 	
			 	$('#password').on("submit", function(){
			 		var hashed = CryptoJS.MD5(CryptoJS.MD5(CryptoJS.MD5($('#password').val())));
			 		$('#password').val(hashed);
			 	});
		 	});
		 </script>
	</head>

	<body>
		<?php echo validation_errors(); ?>
		<div id="tag">
		<div id="grim"></div>
		<?php echo form_open('verifyLogin');?>
		
		<input type="username" class="inserimento" id="username" placeholder="Username" name="username" size="30"/> <br/>
		
		<input type="password" class="inserimento" id="password" placeholder="Password" name="password" size="20"/> <br/>

		<script>
		$(document).ready(function(){
			var url = document.URL;
			if (url != '<?php echo base_url() . 'index.php/'?>')
				window.location.replace('<?php echo base_url() . 'index.php/'?>');
			});
		</script>
	    <nav>
			<ul class="bottoni">
				<li id="li1">
					<a href="register">
						<button type="button" id="reg" class="bottoni" > Registrami </button>
					</a>
				</li>
				<li id="li2">
					<input type="submit" id="sub" name="submit" class="bottoni" value="Login"/>
				</li>
			</ul>
		</nav>
		<?php echo form_close(); ?>
		</div>
   	</body>
</html>
