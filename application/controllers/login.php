<?php 
class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index(){
		$this->load->helper('form');
		$this->load->library('form_validation');
	
		$data['title'] = 'Effettua il login';
		
//		echo var_dump($this->session->userdata('logged_in'));
		if($this->session->userdata('logged_in'))
		{
			$this->load->view('home_view');	
		}
		else
		{
			$this->load->view('loginView', $data);
		}
	}	
}