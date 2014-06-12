<!DOCTYPE html>
<html>
	<head>
		<!-- jQuery include -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<title>Ricerca</title>
		<!-- CSS -->
		<link rel="stylesheet" href="<? echo base_url();?>/style/search.css"/>
	</head>
	<body>
	<div id="up">
		<div id="grim"></div>
    	<a href="../">
			<button id="logout">GoBack</button>
		</a>
	</div>
		<?php echo validation_errors(); ?>
		
		<script>
		$(document).ready(function(){
			
			$(window).keydown(function(event){
				if(event.keyCode == 13) 
				{
					event.preventDefault();
					return false;
				}
			});
			
			alert("la ricerca &egrave case-sensitive ('Pollo' != 'pollo'), ma trova anche mezze parole. (esempio: 'dor' -> pomoDORo)");
			$('#nome').submit(function(){
				return false;
			});
			
			$('#ricercaRicetta').on("click", function(event){
			
				event.preventDefault();
				
				// Get value of search item				
				var nomeRicercato = $('#nome').val();
				var tipoRicercato = $("#tipo").val();
				var radioSelezionato = $('input[name="selectors"]:checked').val();
				// Metodo ajax per recupero dei risultati della ricerca
				// Nome = nome ricetta da cercare
				// Tipo = Primo, Secondo, etc
				$.post('<?php echo base_url() . 'index.php/ajax/search'?>', 
				{
					nome: nomeRicercato,
					tipo: tipoRicercato,
					selected: radioSelezionato
				})
				.done(function(data) {
					$('#results').html(data);
					
					// Setto l'elemento appena aggiunto (I risultati della ricerca)
					// in modo che possano essere cliccabili per visualizzarne i dettagli
					$(".linkRecipe").on("click", function(event)
					{
						event.preventDefault();
						// Get Recipe Details
						$.post('<?php echo base_url() . 'index.php/ajax/sendInformationOfSelectedRecipe'?>',
						{id:$(this).attr("id")})
						.done(function(data){
							var ricetta = jQuery.parseJSON(data);
							
							$('#recipeDetails').html(
								'<div id="ricettaSelezionata">' +
								"Tipo di pietanza: " + ricetta.tipo + '<br/>' +
								"vegetariano? " + ricetta.vegetariano + '<br/>' +
								"Difficolt&agrave: " +ricetta.difficolta + '<br/>' +
								"Abbinamenti: " + ricetta.abbinamenti + '<br/>' +
								"Numero di persone: " + ricetta.num_persone + '<br/>' +
								"Tempo: " + ricetta.tempo + '<br/>' +
								"Descrizione: " + ricetta.descrizione + '<br/>' +
								"Note: " + ricetta.note + '<br/>' +
								'</div>'
								);
							$('#containerForSelectedRecipe').show();
						});
					});
					// FINE ultima modifica
				}, "html");

				// show the div
				$('#containerForResults').show();
				return false;
			});
			return false;
		});
		
		// GESTIONE CAMBIO RICERCA : Ricette o ingredienti
				
	</script>
	
	<div id="containerWhite">
	
	<div id="searchSelector">
		<input type="radio" class="selectors" name="selectors" value="ricette" id="Ricette" checked="checked"/>Ricette
		<input type="radio" class="selectors" name="selectors" value="ingredienti" id="Ingredienti"/>Ingredienti
	</div>
	<!-- Search Form -->
		<?php 
			$attributi = array('id' => 'searchForm', 'style' => 'float:left;');
			echo form_open('ajax/search', $attributi);
		?>
		<label for="Nome">Nome</label>
		<input type="text" name="nome" id="nome" placeholder="Cerca..." style=""/>
		<?php //TIPO DI PIATTO
			$optionsTipo = array(
				'' => '---',
				'antipasto' => 'Antipasto',
				'primo' => 'Primo',
				'secondo' => 'Secondo',
				'contorno' => 'Contorno',
				'dolce' => 'Dolce'
				);
			$additional = 'id="tipo"';
			echo form_dropdown('tipo', $optionsTipo, '', $additional);
		?>
		 <br/>
<!--		<input type="submit" name="sub" id="submit"/> -->
		<?php echo form_close(); ?>
		<button id="ricercaRicetta" name="ricercaRicetta" style="background-color: #dead00; width: 50px;">Cerca</button>
	<!-- Search Form Close -->
		<br/>
	<div id="ajaxThingsContainer" style="">	
		<div id="containerForResults" style="display: none; float:left; width: 400px; height: 600px;">
			<h4>Risultati:</h4>
			<div id="results"><!-- QUI VERRANNO ESPOSTI I RISULTATI OTTENUTI DALLA QUERY IN AJAX --></div>
		</div>
		<div id="containerForSelectedRecipe" style="display: none;">
			<h4>Ricetta selezionata:</h4>
			<div id="recipeDetails">
			<!-- QUI VERRÀ ESPOSTA LA RICETTA IN DETTAGLIO --></div>
		</div>
	</div>
	</div>
	</body>
</html>