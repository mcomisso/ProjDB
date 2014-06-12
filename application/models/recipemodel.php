<?php

class RecipeModel extends CI_Model{
	
	// Visualizzazione delle ricette dell'utente
	function getRecipes($user)
	{
		$sql = "SELECT id, nome FROM ricette_da_id(?)";
		$query = $this->db->query($sql, $user);
		return $query->result_array();
	}
	
	function getRecipes_temp($user)
	{
		$sql = "SELECT id, nome FROM ricette_da_id_temp(?)";
		$query = $this->db->query($sql, $user);
		return $query->result_array();
	}
	
	function getRecipes_diff($user)
	{
		$sql = "SELECT * FROM ricette_da_id(?)";
		$query = $this->db->query($sql, $user);
		return $query->result_array();
	}
	
	// ACTIVE query
	function getSelectedRecipe($id)
	{
		$this->db->select('id, nome, tipo, vegetariano, difficolta, descrizione, note, abbinamenti, num_persone, tempo');
		$this->db->where('id', $id);
		$this->db->where('owner', intval($this->session->userdata['logged_in']['id']));
		$query = $this->db->get('ricette');
		
		return $query->result_array();
	}
	
	// Funzione di ricerca ricetta
	function searchRecipe($nameSearch, $typeOrder)
	{
	
		if($typeOrder == '')
		{
			$this->db->select('nome, id, tipo');
			$this->db->where('owner', $this->session->userdata['logged_in']['id']);
			
			$this->db->like('nome', $nameSearch, 'both');
			$searchResult = $this->db->get('ricette');
			
			return $searchResult->result_array();
		}
		else
		{
			// SELEZIONO SOLO IL TIPO SELEZIONATO
			$this->db->select('nome, id, tipo');
			$this->db->where('tipo', $typeOrder);
			$this->db->where('owner', $this->session->userdata['logged_in']['id']);
			
			$this->db->like('nome', $nameSearch, 'both');
			$searchResult = $this->db->get('ricette');

			return $searchResult->result_array();
		}
	}
	
	function searchIngredient($ingredient, $typeOrder)
	{
		if($typeOrder == '')
		{
			$sql="SELECT DISTINCT ricette.*
			FROM ricette
			JOIN ricetta_ha_ingredienti ON ricetta_ha_ingredienti.id_ricetta = ricette.id
			JOIN ingredienti ON ingredienti.id = ricetta_ha_ingredienti.id_ingrediente
			WHERE owner = ".$this->session->userdata['logged_in']['id']." AND ingredienti.nome LIKE '%".$ingredient."%'";
		}

		else
		{
			$sql="SELECT DISTINCT ricette.*
			FROM ricette
			JOIN ricetta_ha_ingredienti ON ricetta_ha_ingredienti.id_ricetta = ricette.id
			JOIN ingredienti ON ingredienti.id = ricetta_ha_ingredienti.id_ingrediente
			WHERE tipo = '".$typeOrder."'  AND owner = ".$this->session->userdata['logged_in']['id']." AND ingredienti.nome LIKE '%".$ingredient."%'";	
		}

		$searchResult = $this->db->query($sql);
		return $searchResult->result_array();
	}
	
	function insertRecipe($newRecipe){
		$this->db->insert('ricette', $newRecipe);
		$id = $this->db->insert_id();
		return $id;
		//redirect('home', 'refresh');
	}
	
	function updateRecipe($id, $newRecipe){
		/*
		$this->db->call_function('update_ricetta', $newRecipe['tipo'], $newRecipe['vegetariano'], $newRecipe['difficolta'], $newRecipe['descrizione'], $newRecipe['note'], $newRecipe['num_persone'], $newRecipe['tempo'], $newRecipe['id']);
		*/
		/*
		$sql = "SELECT * FROM update_ricetta(?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$query = $this->db->query($sql, $newRecipe['tipo'], $newRecipe['vegetariano'], $newRecipe['difficolta'], $newRecipe['descrizione'], $newRecipe['note'], $newRecipe['num_persone'], $newRecipe['tempo'], $newRecipe['id']);
		*//*

		$where = "id ="+$id;
		$str = $this->db->update_string('ricette', $newRecipe, $where); 
		$id = $this->db->query($str);
*/

		$this->db->where('id', $id);
		$this->db->update('ricette', $newRecipe); 
	}

	function deleteRecipe($id){
		$this->db->delete('ricette', array('id' => $id)); 
	}
	
}