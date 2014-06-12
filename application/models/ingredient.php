<?php

class Ingredient extends CI_Model{
	
	// Visualizzazione delle ricette dell'utente
	function getIngredients()
	{
		$sql = "SELECT * FROM ingredienti ORDER BY nome";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	// ACTIVE query
	function getSelectedIngredient($ingredientName)
	{
		$this->db->select('id, nome');
		$this->db->where('nome', $ingredientName);
		$query = $this->db->get('ingredienti');
		
		return $query->result_array();
	}
	
	function setIngredient($newIngredient){
		$this->db->set('nome', $newIngredient);
		$this->db->insert('ingredienti');
		$id = $this->db->insert_id();
		return $id;
	}
	
	function getRecipeIngredients($idrecipe){
		
		$sql = "SELECT  i.id, i.nome, ri.quantita FROM ricetta_ha_ingredienti ri, ricette r, ingredienti i  WHERE r.id=".$idrecipe." AND r.id=ri.id_ricetta AND ri.id_ingrediente=i.id ORDER BY nome";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}