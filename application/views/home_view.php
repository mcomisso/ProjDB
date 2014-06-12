<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="<? echo base_url();?>/style/home.css"/>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<title>Home</title>
		
	</head>
	
	<body>
	<script>
		$(document).ready(function(){
			var url = document.URL;
			if (url != '<?php echo base_url() . 'index.php/'?>')
				window.location.replace('<?php echo base_url() . 'index.php/'?>');
			});
	</script>
		<a href="home/user">
			<button id="usersettings" name="usersettings">Impostazioni di <?php echo $this->session->userdata['logged_in']['username'];?></button>
		</a>
	<div id="up">
		<div id="grim"></div>
    	<a href="home/logout">
			<button id="logout">Logout, <?php echo $this->session->userdata['logged_in']['username']; ?></button>
		</a>
	</div>
	
	<a href="recipe/recipeList">
		<button id="lista" class="bottoni"> Lista ricette </button>
	</a>
	<a href="recipe/add">
		<button id="aggiungi" class="bottoni"> Aggiungi ricetta </button>
	</a>
	<a href="recipe/search">
		<button id="ricerca" class="bottoni"> Ricerca ricetta </button>
	</a>

	</body>
</html>