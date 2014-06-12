<!DOCTYPE html>
<html>
<?php
	$sessionData = $this->session->all_userdata();
?>
	<head>
		<title>Lista ricette</title>
		<link rel="stylesheet" href="<? echo base_url();?>/style/list.css"/>
		
		<!-- jQuery include -->
		 <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		 <script>
		 	function handleRadio(myRadio) {
				if(myRadio.value == 1){
				ClearOptionsFast('recipeSelector');
					var ricette = <?php echo(json_encode($forLoop));?>;
					for(var r in ricette){
						var destination = document.getElementById("recipeSelector");
						option = document.createElement("option");
						option.text = ricette[r]['nome'];
						option.value = ricette[r]['id'];
						option.className='opt';
						destination.appendChild(option);
						destination.onchange = function(){
							var selectedRecipe = $(this).val();	
							populate(selectedRecipe);	
							populateIngredient(selectedRecipe);

						};
					}
				};
				if(myRadio.value == 2){
					ClearOptionsFast('recipeSelector');
					var userID =<?php echo intval($this-> session-> userdata['logged_in']['id']); ?>;
					$.post('<?php echo base_url() . 'index.php/ajax/sendOrderedTemp'?>',
					{userID:userID}, function(result){
						//console.log(result);
						var ricette = jQuery.parseJSON(result);
						for(var r in ricette){
							var destination = document.getElementById("recipeSelector");
							option = document.createElement("option");
							option.text = ricette[r]['nome'];
							option.value = ricette[r]['id'];
							option.className='opt';
							destination.appendChild(option);
							destination.onchange = function(){
								var selectedRecipe = $(this).val();	
								populate(selectedRecipe);	
								populateIngredient(selectedRecipe);

							};
						}	
					});
				};
				if(myRadio.value == 3){
					ClearOptionsFast('recipeSelector');
					var userID =<?php echo intval($this-> session-> userdata['logged_in']['id']); ?>;
					$.post('<?php echo base_url() . 'index.php/ajax/sendOrderedDiff'?>',
					{userID:userID}, function(result){
						//console.log(result);
						var ricette = jQuery.parseJSON(result);
						for(var r in ricette){
							var destination = document.getElementById("recipeSelector");
							option = document.createElement("option");
							option.text = ricette[r]['nome'];
							option.value = ricette[r]['id'];
							option.className='opt';
							destination.appendChild(option);
							destination.onchange = function(){
								var selectedRecipe = $(this).val();	
								populate(selectedRecipe);	
								populateIngredient(selectedRecipe);

							};
						}	
					});
				};
				/*
			    alert('Old value: ' + currentValue);
			    alert('New value: ' + myRadio.value);
			    currentValue = myRadio.value;
			    */
			}
		 
			function ClearOptionsFast(id)
			{
				var selectObj = document.getElementById(id);
				var selectParentNode = selectObj.parentNode;
				var newSelectObj = selectObj.cloneNode(false); // Make a shallow copy
				selectParentNode.replaceChild(newSelectObj, selectObj);
				return newSelectObj;
			}
			function populate(id){
				$.post('<?php echo base_url() . 'index.php/ajax/sendInformationOfSelectedRecipe'?>',
					{id:id}, function(result){
						var ricetta = jQuery.parseJSON(result);
						$('#id').val(ricetta['id']);
						$('#nome').val(ricetta['nome']);
						$('#tipo').val(ricetta['tipo']);
						if(ricetta['vegetariano']=='t')
							$('#vegetariano').prop('checked', true);
						if(ricetta['vegetariano']=='f')
							$('#vegetariano').prop('checked', false);
						$('#difficolta').val(ricetta['difficolta']);
						$('#abbinamenti').val(ricetta['abbinamenti']);
						$('#persone').val(ricetta['num_persone']);
						$('#tempo').val(ricetta['tempo']);
						$('#descrizione').val(ricetta['descrizione']);
						$('#note').val(ricetta['note']);
						//alert(ricetta['ingredienti'][0]['nome']);
						
						$('listaing').prop('readonly', true);
						$('#nome').prop('readonly', true);
						$('#tipo').prop('disabled', true);
						$('#difficolta').prop('disabled', true);
						
						$('#vegetariano').prop('disabled', true);
						$('#abbinamenti').prop('readonly', true);
						$('#persone').prop('readonly', true);
						$('#tempo').prop('readonly', true);
						$('#descrizione').prop('readonly', true);
						$('#note').prop('readonly', true);
						
						$('#preparazione').fadeIn();
					});
			};
					
			function populateIngredient(id){
				ClearOptionsFast('listaing');
				//listaing
				$.post('<?php echo base_url() . 'index.php/ajax/sendIngredientOfSelectedRecipe'?>',
					{id:id}, function(result){
						var ingredienti = jQuery.parseJSON(result);
						for(var i in ingredienti){
							var destination = document.getElementById("listaing");
							option = document.createElement("option");
							option.text = ingredienti[i]['quantita'] +": " + ingredienti[i]['nome'];
							option.value = ingredienti[i]['id'];
							option.className='opt';
							destination.appendChild(option);
						}	
				});
				};
	
				
				$(document).ready(function (){
				
					idtemp = $('#id').val();
					if(idtemp!='none'){
						len = $('select#recipeSelector option').length;
						var i=0;
						while(i<len){
					 		var id = $('#recipeSelector option').eq(i).val();
				 			if (idtemp==id){
				 				$('#preparazione').show();
				 				var salva = document.getElementById ( "sub" ) ;
				 				salva.style.visibility = 'visible';
				 				populateIngredient(idtemp);
				 				$('.inserimento').css('color','black');
				 				$('#nome').css('color','#3B8686');
				 				$('#nome').prop('readonly', true);
				 				$('#recipeSelector option').eq(i).prop('selected', true);
				 				$('#edit').hide();
				 				$('#elimina').text('Annulla');
				 				return;
				 			};
				 			i++;
				 		};
				 	};
					
					$('#elimina').on("click", function(){
						id = $("option:selected", recipeSelector).val();
						$.post('<?php echo base_url() . 'index.php/ajax/deleteRecipe'?>',
					{id:id}, function(result){
						alert(result);
						});
					});
					
					$('#edit').on("click", function(){
						if($('#edit').text()=='Edita Ricetta'){
							$('listaing').prop('readonly', true);
							$('#nome').prop('readonly', true);
							$('#tipo').prop('disabled', false);
							$('#difficolta').prop('disabled', false);
							
							$('#vegetariano').prop('disabled', false);
							$('#abbinamenti').prop('readonly', false);
							$('#persone').prop('readonly', false);
							$('#tempo').prop('readonly', false);
							$('#descrizione').prop('readonly', false);
							$('#note').prop('readonly', false);
							
							$('.inserimento').css('color','black');
							$('#nome').css('color','#3B8686');
							
							var salva = document.getElementById ( "sub" ) ;
							salva.style.visibility = 'visible';
							$('#elimina').hide();
							$('#edit').hide();
							
						}
						else{
							$('listaing').prop('readonly', true);
							$('#nome').prop('disabled', true);
							$('#tipo').prop('disabled', true);
							$('#difficolta').prop('disabled', true);
							
							$('#vegetariano').prop('disabled', true);
							$('#abbinamenti').prop('readonly', true);
							$('#persone').prop('readonly', true);
							$('#tempo').prop('readonly', true);
							$('#descrizione').prop('readonly', true);
							$('#note').prop('readonly', true);
							
							$('.inserimento').css('color','#3B8686');
							selectedRecipe = $("option:selected", recipeSelector).val();
							populate(selectedRecipe);
							
							var salva = document.getElementById ( "sub" ) ;
							salva.style.visibility = 'hidden';
							$('#elimina').fadeIn();
							$('#edit').text('Edita Ricetta');
						}
					});
				
					$('#recipeSelector').on("change", function(){
						var selectedRecipe = $(this).val();	
						populate(selectedRecipe);	
						populateIngredient(selectedRecipe);
					});
			});			
		</script>
	</head>
	<body>
    <div id="up">
		<div id="grim"></div>
    	<a href="../">
			<button id="logout">GoBack</button>
		</a>
	</div>
    	<div id="tag">
		
		<!-- <?php echo '<label class="tohide" id="idreturn">'.$idselected.'</label>'?> -->
			<?php
				// Controllo che l'array inviato sia effettivamente popolato da ricette.
				if(is_array($forLoop) && count($forLoop) > 0)
				{
					echo "<select id=recipeSelector name=recipeSelector size=20> ";
					$dispari = true;
					foreach ($forLoop as $result=>$recipe)
					{
						echo '<option class=opt value='.$recipe['id'].'>'.$recipe['nome']."</option>";
					}
					echo "</select>";
				}
				else
				{
					echo "<p>Sembra che non ci sia ancora nessuna ricetta inserita. <a href=\"add\">Aggiungine una.</a></p>";
				}
				?>
		
		<span id="preparazione" style="display:none;">
			<span id="dati">
				<?php echo validation_errors(); ?>
				<?php echo form_open('editrecipe');?>
				
				<input type="text" name="id" id="id" class="tohide" value="<?php echo set_value('id',$idselected);?>"/>
				
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
					$additional = 'class="inserimento" id=tipo';
					echo form_dropdown('tipo', $optionsTipo, 'value=dolce', $additional);
				?>
				
				<label for="difficolta" class="label">Difficolt&agrave</label>
				<?php // DIFFICOLTA
					$options = array(
						'facile' => 'Facile',
						'medio' => 'Medio',
						'difficile' => 'Difficile');
					$additional2= $additional = 'class="inserimento" id=difficolta';
					echo form_dropdown('difficolta', $options, set_value('difficolta'), $additional2);
				?>
				
				
				<label for="vegetariano" class="label">Vegetariano</label>
			    <?php 
					$data = array(
						'id'		  => 'vegetariano',
						'name'        => 'vegetariano',
						'class'       => 'inserimento',
						'value'       => 'vegetariano',
						'checked'     =>  set_value('vegetariano'),
					);
					echo form_checkbox($data); echo "<br/>" ?>
				
						
				<label for="abbinamenti" class="label">Abbinamenti</label>
				<input type="text" name="abbinamenti" id="abbinamenti" class="inserimento" value="<?php echo set_value('abbinamenti');?>"/>
				
				<label for="persone" class="label">Numero di Persone</label>
				<input type="text" name="persone" id="persone" class="inserimento" value="<?php echo set_value('persone');?>">
					
				<label for="tempo" class="label">Tempo</label>
				<input type="text" name="tempo" id="tempo" class="inserimento" value="<?php echo set_value('tempo'); ?>">
				
				<label for="descrizione" class="label">Descrizione</label>
				<textarea  type="text" name="descrizione" id="descrizione" class="inserimento text"> <?php echo set_value('descrizione');?> </textarea>
					
				<label for="note" class="label">Note</label>
				<textarea  type="text" name="note" id="note" class="inserimento text"><?php echo set_value('note');?></textarea>
				
				<input type="text" class="tohide" name="harray" id="harray" value="<?php echo set_value('harray');?>" readonly="TRUE">			
				<input type="submit" id="sub" name="submit" class="pulsanti" value="Salva Ricetta"/>
				<?php echo form_close(); ?>
			
			</span>
			
			<span id="ingdiv">
				<label id="ingredienti" class="label">Ingredienti:</label>
				<select id="listaing" name="listaing" class="listsel" size="5"></select>
				<div id="bottoni">
					<button type = "button" class="pulsanti" id="edit" name="edit">Edita Ricetta</button>
					<button type = "button" class="pulsanti" id="elimina" name="elimina">Elimina Ricetta</button>
					<!--
					<?php echo form_open('editrecipe');?>
					<input type="submit" name="submit" class="pulsanti" value="Salva Ricetta"/>
					<?php echo form_close(); ?>
					-->
				</div>
			</span>
			
		</span> <!-- chiudo preparazione--> 
		<div id="radio">
			<form name=myform>
				<legend>Ordinamento:</legend>
				<input type="radio" name=myradio onclick="handleRadio(this);" value="1">Nome
				<input type="radio" name=myradio onclick="handleRadio(this);" value="2">Tempo
				<input type="radio" name=myradio onclick="handleRadio(this);" value="3">Difficolt&agrave
			</form>
		</div>
	</div><!--chiudo tag-->
	</body>
</html>