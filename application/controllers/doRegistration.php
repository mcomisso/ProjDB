<?php

class DoRegistration extends CI_Controller{
	
	// Costruttore, invoca il modello "user" per caricare le operazioni aventi come oggetto gli utenti sul database.
	function __construct()
	{
		parent::__construct();
		$this->load->model('user', '', TRUE);
	}
	
	function index()
	{
		$this->load->library('form_validation');
		
		
		$this->form_validation->set_rules('email', 'email', 'required|xss_clean|valid_email');
		$this->form_validation->set_rules('password', 'password', 'required|xss_clean|matches[passConf]');
		$this->form_validation->set_rules('passConf', 'passConf', 'required|xss_clean');
		$this->form_validation->set_rules('username', 'username', 'required|xss_clean|is_unique[utenti.username]');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('registration');
		}
		else
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$email = $this->input->post('email');
			$data = array(
				'username' => $username,
				'email' => $email,
				'password' => $password);

			$this->db->insert('utenti', $data);
			echo "<p>Registrazione effettuata con successo</p>";
			redirect('home', 'refresh');
		}
	}
}