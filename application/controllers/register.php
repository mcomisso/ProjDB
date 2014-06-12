<?php

class Register extends CI_Controller{
	
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
		// Librerie di utility, caricate all'invocazione del controller.
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// Carica la vista contenente l'html della pagina
		$this->load->view('registration');
	}
}