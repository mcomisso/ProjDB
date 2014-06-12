<?php

class Ricerca extends CI_Controller{

	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		// LOAD LIBRARY form_validation
		$this->load->library('form_validation');
		
		// Form rules.
		$this->form_validation->set_rules('nome', 'nome', 'required|xss_check');
		
		if($this->form_validation->run() == FALSE)
		{
			// ERROR MANAGEMENT
			echo "Controlla i campi di ricerca";
		}
		else
		{
			// SUCCESS CASE
			$nameToSearch = $this->input->post('nome');
			$this->db->select('nome');
			$this->db->from('ricette');
			$this->db->like('nome', $nameToSearch);
			$searchResult = $this->db->get();
			$return = $searchResult->result();
			echo var_dump($return);
		}

		
	}
	
}