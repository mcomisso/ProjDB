<?php

class ModifyPassword extends CI_Controller{
		
	function __construct()
	{
		parent::__construct();
		$this->load->model('user', '', TRUE);
	}
	
	//Automaticamente richiamata alla creazione del controller
	function index()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('oldPassword', 'oldPassword', 'required|xss_clean|callback_checkOldPassword');
		$this->form_validation->set_rules('newPassword', 'newPassword', 'required|xss_clean');
		$this->form_validation->set_rules('confirmNewPassword', 'confirmNewPassword', 'required|xss_clean|matches[newPassword]');
		
		if($this->form_validation->run() == FALSE)
		{
			echo "Controlla i campi inseriti";
		}	
		else
		{
			//Cambio password
			$hashedPassword = $this->input->post('newPassword');
			$this->user->changePassword($hashedPassword);
		}
	}
	
	function checkOldPassword($oldPassword)
	{
		$hashedPassword = $this->input->post('oldPassword');
	
		$result = $this->user->checkPassword($this->session->userdata['logged_in']['username'], $hashedPassword);
		return $result;
	}
	
	function deleteUser()
	{
		$userToDelete = $this->session->userdata['logged_in']['id'];
		$this->user->deleteMe($userToDelete);
		
		redirect('login', 'location');
	}
}