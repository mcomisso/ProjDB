<?php

class Recipe extends CI_Controller{

	function __construct()
	{
		parent::__construct();
		$this->load->model('recipeModel', '', TRUE);
		$this->load->model('Ingredient', '', TRUE);
	}

	public function recipeList()
	{
		if(isset($this->session->userdata['logged_in']))
		{
			$this->load->helper('form');
			$this->load->library('form_validation');
			//Devo inviare alla pagina la lista delle ricette dell'utente.
			// Array di ricette.
			$session_data = $this->session->userdata('logged_in');
			$intID = intval($session_data['id']);
			$queryData = $this->recipeModel->getRecipes($intID);
			$passThis['forLoop'] = $queryData;
			$passThis['idselected'] = 'none';
			$this->load->view('listRecipes', $passThis);
		}
		else
		{
			redirect('home', 'refresh');
		}	
	}

	public function add()
	{
		if(isset($this->session->userdata['logged_in']))
		{
			$this->load->helper('form');
			$this->load->library('form_validation');
			$queryData = $this->Ingredient->getIngredients();
			$passThis['ingredientsdb'] = $queryData;
			$this->load->view('addRecipe', $passThis);
		}
		else
		{
			redirect('home', 'refresh');
		}	
		
	}
	
	public function search()
	{
		if(isset($this->session->userdata['logged_in']))
		{
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->load->view('searchRecipe');
		}
		else
		{
			redirect('home', 'refresh');
		}
	}
}