<!DOCTYPE html>
<html>
	<head>
	<!-- CSS & jQuery && jQuery UI && CryptoJS -->
		<link rel="stylesheet" href="<? echo base_url();?>/style/usersettings.css"/>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>javascript/md5.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		
		<script>
		
			// VECCHIA PASSWORD -> HASH E VALUE PER CONTROLLO
		 	$(document).ready(function(){
		 			 	
			 	$('#oldPassword').on("blur", function(){
			 		var hashed = CryptoJS.MD5(CryptoJS.MD5(CryptoJS.MD5($('#oldPassword').val())));
			 		$('#oldPassword').val(hashed);
			 	});
			 	
			 	$('#newPassword').on("blur", function(){
		 			var newHashed = CryptoJS.MD5(CryptoJS.MD5(CryptoJS.MD5($('#newPassword').val())));
		 			$('#newPassword').val(newHashed);
			 	});
			 	
			 	$('#confirmNewPassword').on("blur", function(){
 		 			var confHashed = CryptoJS.MD5(CryptoJS.MD5(CryptoJS.MD5($('#confirmNewPassword').val())));
		 			$('#confirmNewPassword').val(confHashed);
			 	});
			 	
			 	$('#deleteUser').on("click", function(){
				 	$('#dialog-confirm').dialog(
				 	{resizable: false,
					 	height: 140,
					 	modal: true,
					 	buttons: {
						 	"Conferma": function() {
							 	$(this).dialog("close");
							 	$.post('<?php echo base_url() . 'index.php/modifyPassword/deleteUser'?>')
							 	.done(function(){
								 	window.location.replace("<?php echo base_url();?>");
							 	});
						 	},
						 	Cancel: function()
						 	{
							 	$(this).dialog("close");
						 	}
					 	}
				 	});
			 	});
			 	
		 	});
		</script>

		<title>Impostazioni <?php echo $this->session->userdata['logged_in']['username']; ?></title>
	</head>
	
	<body>
		<div id="up">
			<div id="grim"></div>
			<a href="../">
				<button id="logout">Back</button>
			</a>
		</div>
	

	
		<?php echo validation_errors(); ?>
	
	<div id="centralForm">
	<h1>Reimposta Password</h1>
		<?php echo form_open('modifyPassword');?>
		<!-- <label for="oldPassword">Password precedente</label> -->
		<input class="inserimento" type="password" name="oldPassword" id="oldPassword" placeholder="Password"/><br/>

<!--		<label for="newPassword">Nuova password</label> -->
		<input class="inserimento" type="password" name="newPassword" id="newPassword" placeholder="Nuova Password"/><br/>
		
<!--		<label for="confirmNewPassword">Conferma nuova password</label> -->
		<input class="inserimento" type="password" name="confirmNewPassword" id="confirmNewPassword" placeholder="Conferma Nuova Password"/><br/>
		
		<input class="bottoni" type="submit" value="Cambia password">
		<?php echo form_close();?>
	</div>
		<button id="deleteUser">Cancellami!</button>
		
		<div id="dialog-confirm" title="Eliminare l'utente?" style="display: none;">
			<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>Non sar&agrave pi&ugrave possibile recuperare i propri dati e le proprie ricette. Continuare?</p>
		</div>
	</body>
</html>