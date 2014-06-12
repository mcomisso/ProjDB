 <!DOCTYPE html>
<html>
<?php
	$sessionData = $this->session->all_userdata();
?>
	<head>
		<link rel="stylesheet" href="<? echo base_url();?>/style/add.css"/>
		 <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		 <script>
		 	var jsonarray = "test";
		 	var listOfingredients = new Array();
		 	
		 	function ingrediente(id,nome,quantita)
		 	{
				this.id=id;
				this.nome=nome;
				this.quantita=quantita;
			}
			
			$(document).ready(function (){
			
			$(window).keydown(function(event){
				if(event.keyCode == 13) 
				{
					event.preventDefault();
					return false;
				}
			});
			
				$('#sub').show();
				
				$('#showIngredientModule').on("click", function(){
					if($('#harray').val()!=''){
						//listOfingredients = JSON.stringify(listOfingredients);
					}
					$('#showIngredientModule').hide();
					$('#go').fadeIn();
					$('#sub').fadeOut();
				});
			
				$('#quantity').on("focus", function(){
					if ($('#quantity').val() == "Quantita" || $('#quantity').val() == 'inserire nuovo ingrediente')
						$('#quantity').val("");
				});
				
				$('#quantity').on("blur", function(){
					if ($('#quantity').val() == "")
						$('#quantity').val("Quantita");
				});
				
				$('#ingredientSelector').on("change", function(){
					if($("option:selected", ingredientSelector).val() == 'newing'){
						$('#quantity').val('inserire nuovo ingrediente');
						$('#agging').text('salva');
					}
					else{
						$('#quantity').val('Quantita');
						$('#agging').text('aggiungi');	
					} 
				});
				
				
				$('#ingredientAdded').on("change", function(){
					var destination = document.getElementById("ingredientSelector");
					
					
					len = $('select#ingredientAdded option').length;
					var i=0;
					var textorigin
					while(i<len){
						var qn = $('#ingredientAdded option').eq(i).text().split(': ');
					 	if (qn.length == 1){
						 	textorigin = qn[0];
					 	}
				 		
				 		else
				 			textorigin = qn[1];
					 	i++;
					 };
					 
					valorigin = $('select#ingredientAdded option').val()
					
					
					$('#ingredientSelector option[value="newing"]').prop('selected', true);
					$("option:selected", ingredientSelector).val(valorigin);
					$("option:selected", ingredientSelector).text(textorigin);
					
					option = document.createElement("option");
					option.text = 'Crea un nuovo ingrediente';
					option.value = 'newing';
					option.className='opt';
					destination.appendChild(option);
					$("option:selected", ingredientAdded).remove();
					
				});
				
				
				/*
				passaggio da database a lista temporanea
				salvo nel campo text la stringa quantità + nome ingrediente
				sono divese da spazio qundi devo separare dopo
				salvo nel campo value l'id dell'ingrediente
				*/
			 	$('#agging').click(function(){
			 		if($('#agging').text()=='aggiungi'){
				 		if($("option:selected", ingredientSelector).text() == '')
				 			return;
					 	//var original = document.getElementById("ingredientSelector");
					 	var destination = document.getElementById("ingredientAdded");
					 	var textorigin =$('#quantity').val();
					 	if (textorigin == "Quantita")
					 		textorigin = '';
					 		else textorigin += ': ';
					 	textorigin += $("option:selected", ingredientSelector).text();
					 	var valorigin = $("option:selected", ingredientSelector).val();
					 	option = document.createElement("option");
					 	option.text=textorigin;
					 	option.value= valorigin;
					 	//destination.appendChild(option);
					 	//alert(''+textorigin+' '+valorigin);
						option.className='opt';
					 	destination.appendChild(option);
					 	$("option:selected", ingredientSelector).remove();
					 	$('#quantity').val("Quantita");
					 	
					 	//var temp = $("option:selected", ingredientSelector).attr("class");
					 	//alert(''+temp);
				 	}
				 	else {//crea nuovo ingrediente
					 	$('#ingredientSelector option[value="newing"]').prop('selected', true);
					 	var ning = $('#quantity').val();//nome ingrediente da campo quantità
					 	//controlla se ingrediente presente ingredientAdded
					 	len = $('select#ingredientAdded option').length;
					 	var i=0;
					 	while(i<len){
					 		var qn = $('#ingredientAdded option').eq(i).text().split(': ');
					 		var quantita;
					 		var nome;
					 		if (qn.length == 1)
				 				nome = qn[0];
				 			else
				 				nome = qn[1];
				 			if (nome==ning){
					 			alert('Ingrediente presente nella ricetta');
					 			return;
				 			};
					 		i++;
					 	};
					 	//controlla se ingrediente presente in ingredientSelector
					 	len = $('select#ingredientSelector option').length;
					 	var i=0;
					 	while(i<len){
					 		var nome = $('#ingredientSelector option').eq(i).text();
				 			if (nome==ning){
					 			alert('Ingrediente presente nel database');
					 			return;
				 			};
					 		i++;
					 	};
					 	
					 	
					 	$("option:selected", ingredientSelector).val(ning);
					 	$("option:selected", ingredientSelector).text(ning);
					 	var original = document.getElementById("ingredientSelector");
					 	option = document.createElement("option");
					 	option.text = 'Crea un nuovo ingrediente';
					 	option.value = 'newing';
					 	option.className='opt';
					 	original.appendChild(option);
					 	
					 	$('#quantity').val('Quantita');
						$('#agging').text('aggiungi');
				 	}
			 	});
			 	
			 	/*
			 	salvataggio lista temporanea in array
			 	se id==nome vuol dire che l'ingrediente non è salvato in database 
			 	*/
			 	$('#finito').click(function(){
				 	$('#go').fadeOut();
				 	$('#sub').show();
					$('#showIngredientModule').fadeIn();
				 	var origin = document.getElementById("ingredientAdded");
				 	len = $('select#ingredientAdded option').length;
				 	var i = 0;
				 	while(i<len){
				 		var id = $('#ingredientAdded option').eq(i).val();
				 		var qn = $('#ingredientAdded option').eq(i).text().split(': ');
				 		var quantita
				 		var nome
				 		if (qn.length == 1){
				 			quantita = 0;
				 			nome = qn[0];
				 		}
				 		else{
				 			quantita = qn[0];
				 			nome = qn[1];
				 		}
				 		var temp = new ingrediente(id,nome,quantita);
				 		
				 		listOfingredients.push(temp);
					 	i++;
				 	}
				 	jsonarray = JSON.stringify(listOfingredients);
				 	/*
				 	$.post('<?php echo base_url() . 'index.php/insertRecipe/ingredients'?>',
						{jarray:jsonarray});
						*/
					$('#harray').val(jsonarray);
					return;
				 	//alert('quantita: '+listOfingredients[0].quantita +' id: '+listOfingredients[0].id +' nome: '+ listOfingredients[0].nome );
			 	});
			 });
		</script>
		
		 <!--
		<script>
			var listOfingredients = new Array();
					
			function deleteIngredient(callerID){
				// Controllo l'index
				deleteID = listOfingredients.indexOf(callerID);
			
				// Cancello dall'array l'id
				listOfingredients.splice(deleteID);
			// HTML removal with jQuery	
				$('#'+callerID).remove();
				$('#name'+callerID).remove();
			}
			
			function checkArray()
			{
				if(listOfingredients.length() == 0)
					$('#sub').show();
			}
			
			$(document).ready(function(){
				$('#ingredientName').on("click", function(){
					if($(this).val() == "Ingrediente")
						$(this).val("");
				});
				$('#quantity').on("click", function(){
					if($(this).val() == "Quantita\'")
						$(this).val("");
				});
			
				// Aggiungi  un ingrediente -> 
				$('#addIngredient').on("click", function(){
					// Nasconde il tasto "Salva Ricetta" (l'user deve prima salvare gli ingredienti, poi la ricetta)
					$('#sub').hide();
					// inserisco all'interno
					listOfingredients.push($('#ingredientName').val());
					$('#insertField').append("<p id='name" + $('#ingredientName').val() + "'>" + $('#ingredientName').val()+"</p>");
					$('#insertField').append('<button id="' + $('#ingredientName').val() + '"' + ' onclick="deleteIngredient(this.id)">Elimina</button><br/>');
					$('#ingredientName').val("");
				});
				// Tasto Reset ingredienti inseriti -> cancella tutti gli ingredienti precedentemente inseriti
				$('#resetIngredients').on("click", function(){
					$('#insertField').html('<label for="ingredientName">Nome Ingrediente</label><input type="text" name="ingredientName" id="ingredientName"/>');
					listOfingredients = [];
				});
				
				// Tasto Mostra modulo ingredienti -> permette di inserire ingredienti
				$('#showIngredientModule').on("click", function(){
					$('#showIngredientModule').hide();
					$('#ingredientDiv').show();
				});
				
			});

		</script>
-->
	</head>
<body id="body">
	<div id="up">
		<div id="grim"></div>
    	<a href="../">
			<button id="logout">GoBack</button>
		</a>
	</div>

	
	<div id="tag">
	<div id="recipeDiv">
	<?php echo validation_errors(); ?>
	<?php echo form_open('insertRecipe');?>

	<label for="nome" class="label">Nome</label>
	<input type="text" name="nome" id="nome" class="inserimento" value="<?php echo set_value('nome');?>"/>
	
	<label for="tipo" class="label">Tipo</label>
	<?php //TIPO DI PIATTO
		$optionsTipo = array(
			'antipasto' => 'Antipasto',
			'primo' => 'Primo',
			'secondo' => 'Secondo',
			'contorno' => 'Contorno',
			'dolce' => 'Dolce'
			);
		$additional = 'class="inserimento"';
		echo form_dropdown('tipo', $optionsTipo, set_value('tipo', 'primo'), $additional);
	?>
	
	<label for="difficolta" class="label">Difficolt&agrave</label>
	<?php // DIFFICOLTA
		$options = array(
			'facile' => 'Facile',
			'medio' => 'Medio',
			'difficile' => 'Difficile');
			
		echo form_dropdown('difficolta', $options, set_value('difficolta', 'medio'), $additional);
	?>
	
	
	<label for="vegetariano" class="label">Vegetariano</label>
    <?php 
		$data = array(
			'name'        => 'vegetariano',
			'class'       => 'inserimento',
			'value'       => 'vegetariano',
			'checked'     =>  set_value('vegetariano', FALSE),
		);
		echo form_checkbox($data); echo "<br/>" ?>
	
		
	<label for="abbinamenti" class="label">Abbinamenti</label>
	<input type="text" name="abbinamenti" id="abbinamenti" class="inserimento" value="<?php echo set_value('abbinamenti');?>"/>
	
	<label for="persone" class="label">Numero di Persone</label>
	<input type="text" name="persone" id="persone" class="inserimento" value="<?php echo set_value('persone', '4');?>">
		
	<label for="tempo" class="label">Tempo</label>
	<input type="number" name="tempo" id="tempo" class="inserimento" value="<?php echo set_value('tempo', '20'); ?>">
	
	<label for="descrizione" class="label">Descrizione</label>
	<textarea  type="text" name="descrizione" id="descrizione" class="inserimento text" ><?php echo set_value('descrizione');?></textarea>
		
	<label for="note" class="label">Note</label>
	<textarea  type="text" name="note" id="note" class="inserimento text"><?php echo set_value('note');?></textarea>
	
	<input type="text" name="harray" id="harray" value="<?php echo set_value('harray', '');?>">
		
	<input type="submit" id="sub" name="submit" value="Salva Ricetta"/>
	<?php echo form_close(); ?>

	</div>
	
	<!-- INSERIMENTO INGREDIENTI. -->
	<div id="ingredientDiv">
		<!--
		<div id="insertField">
			<label for="ingredientName">Nome Ingrediente</label><br/>
			<?php echo form_open('addRecipe/ingredients');?>
			<input type="text" name="ingredientName" id="ingredientName" value="Ingrediente"/>
			<input type="text" name="quantity" id="quantity" value="Quantita'"/>
			<button id="addIngredient" value="add" style="height: auto; width: auto;">Add</button>

			
			<input type="submit" id="ingredientsSend" name="ingredientsSend"/>
		</div>
		<button id="resetIngredients" value="resetIngredients">Reset</button>
		</div>
		-->
		
	<button name="showIngredientModule" id="showIngredientModule" class="ingbut">Inserisci ingredienti</button>
		<div id="go">
			<?php 
			if(is_array($ingredientsdb) && count($ingredientsdb)>0 )
				{
					echo "<select id=ingredientSelector name=ingredientSelector class=listsel size=10>";
						foreach ($ingredientsdb as $result=>$ingredient)
						{
							echo '<option class="opt" value='.$ingredient['id'].'>'.$ingredient['nome']."</option>";
						}
						echo '<option class="opt" value="newing">Crea un nuovo ingrediente</option>';
						echo "</select>";
				}
				else
				{
					echo "<select id=ingredientSelector name=ingredientSelector class=listsel size=10>";
					echo '<option class="opt" value="newing">Crea un nuovo ingrediente</option>';
					echo "</select>";
				}
			?>
			
			<input id="quantity" name="quantita" value="Quantita" class="inserimento"></input>
			
			<button type="button" id="agging" class="ingbut"> aggiungi </button>
			
			<select id="ingredientAdded" name="ingredientAdded" class="listsel" size="10"></select>
			
			<button type="button" id="finito" class="ingbut"> finito </button>
		</div>
	</div>
	</div>
</body>

</html>