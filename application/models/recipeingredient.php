<?php

class recipeingredient extends CI_Model{

	function linkrecipeing($idarraying,$idrecipe){
		foreach ($idarraying as $iding=>$qing){
			$ingrediente = $iding;
			$quantita = $qing;
			$this->db->set('id_ricetta', $idrecipe);
			$this->db->set('id_ingrediente', $ingrediente);
			$this->db->set('quantita', $quantita);
			$this->db->insert('ricetta_ha_ingredienti');
			//$id = $this->db->insert_id();
		}
	}
}