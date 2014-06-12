<?php

session_start();

class Home extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
//			echo(var_dump($session_data));
			$data['username'] = $session_data['username'];
			$data['id'] = $session_data['id'];
			$this->load->view('home_view', $data);
		}
		else
		{
			redirect('login', 'refresh');
		}
	}
	
	function user()
	{
		if(isset($this->session->userdata['logged_in']))
		{
			$this->load->helper('form');
			$this->load->view('userSettings');
		}
		else
		{
			redirect('home', 'refresh');
		}
	}

	function logout()
	{
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('home', 'refresh');
	}
}