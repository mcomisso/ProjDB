<?php

class Ajax extends CI_Controller{

	function __construct()
	{
		parent::__construct();
		$this->load->model('recipeModel', '', TRUE);
		$this->load->library('form_validation');
		$this->load->model('Ingredient', '', TRUE);
	}
	
	function sendOrderedTemp(){
		$result = $this->recipeModel->getRecipes_temp($_POST['userID']);
		echo (json_encode($result));
	}
	function sendOrderedDiff(){
		$result = $this->recipeModel->getRecipes_diff($_POST['userID']);
		echo (json_encode($result));
	}

	function sendInformationOfSelectedRecipe()
	{	
		//echo var_dump($_POST);
		$result = $this->recipeModel->getSelectedRecipe($_POST['id']);

		//echo $tipo, $vegetariano, $difficolta, $descrizione, $note, $abbinamenti, $num_persone, $tempo;
		
		$ricetta = array();
		$ricetta['id'] = $result[0]['id'];
		$ricetta['nome'] = $result[0]['nome'];
		$ricetta['tipo'] = $result[0]['tipo'];
		$ricetta['vegetariano'] = $result[0]['vegetariano'];
		$ricetta['difficolta'] = $result[0]['difficolta'];
		$ricetta['abbinamenti'] = $result[0]['abbinamenti'];
		$ricetta['num_persone'] = $result[0]['num_persone'];
		$ricetta['tempo'] = $result[0]['tempo'];
		$ricetta['descrizione'] = $result[0]['descrizione'];
		$ricetta['note'] = $result[0]['note'];
		
		echo (json_encode($ricetta));
		
		//var_dump($encoded);
		//echo $output_string;
	}
	function sendIngredientOfSelectedRecipe()
	{
		$result = $this->recipeModel->getSelectedRecipe($_POST['id']);
		$ing = $this->Ingredient->getRecipeIngredients($result[0]['id']);
		echo (json_encode($ing));
	}
	
	function deleteRecipe(){
		$this->recipeModel->deleteRecipe($_POST['id']);
		redirect('home','refresh');
	}
	
	function search()
	{
		// Form rules.
		$this->form_validation->set_rules('nome', 'nome', 'xss_check');
		
		if($this->form_validation->run() == FALSE)
		{
			// ERROR MANAGEMENT
			echo "Controlla i campi di ricerca";
		}
		else
		{
			if($this->input->post('selected') == "ricette")
			{
				// SUCCESS CASE
				$notCodedResults = $this->recipeModel->searchRecipe($this->input->post('nome'), $this->input->post('tipo'));
			}
			else
			{
				$notCodedResults = $this->recipeModel->searchIngredient($this->input->post('nome'), $this->input->post('tipo'));
			}
			
			//var_dump($notCodedResults);
				
			foreach ($notCodedResults as $res=>$result)
			{
				echo "<br/>";
				echo '<a class="linkRecipe" id="'.$result['id'].'">'.$result['nome']."</a>";
			}
		}
	// search function end
	}
	
// Controller end
}