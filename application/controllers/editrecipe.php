<?php
class editrecipe extends CI_Controller{
	
	function __construct()
	{
		parent::__construct();
		// Carico il modello per le ricette
		$this->load->model('recipeModel', '', TRUE);
		$this->load->model('Ingredient', '', TRUE);
		$this->load->model('recipeingredient', '', TRUE);
	}
		
	function index()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->form_validation->set_rules('nome', 'nome', 'required|xss_clean');
		$this->form_validation->set_rules('difficolta', 'difficolta', 'required|xss_clean');
		$this->form_validation->set_rules('tempo', 'tempo', 'required|xss_clean|numeric');
		
		$this->form_validation->set_message('checkunique', 'Nome inserito gi&agrave in uso');
		$this->form_validation->set_message('required', 'Il campo %s &egrave obbligatorio');
		$this->form_validation->set_message('numeric', 'Il campo %s ammette solamente numeri');
		
		$this->form_validation->set_rules('id', 'id', 'xss_clean');
		$this->form_validation->set_rules('tipo', 'tipo', 'xss_clean');
		$this->form_validation->set_rules('vegetariano', 'vegetariano', 'xss_clean');
		$this->form_validation->set_rules('abbinamenti', 'abbinamenti', 'xss_clean');
		$this->form_validation->set_rules('persone', 'persone', 'xss_clean|numeric');
		$this->form_validation->set_rules('descrizione', 'descrizione', 'xss_clean');
		$this->form_validation->set_rules('note', 'note', 'xss_clean');
		$this->form_validation->set_rules('harray', 'harray', 'xss_clean');
		
		if($this->form_validation->run() == FALSE)
		{
			$session_data = $this->session->userdata('logged_in');
			$intID = intval($session_data['id']);
			$queryData = $this->recipeModel->getRecipes($intID);
			$passThis['forLoop'] = $queryData;
			$passThis['idselected']= $this->input->post('id');
			$this->load->view('listRecipes', $passThis);
		}
		else
		{
			//$nome = $this->input->post('nome');
			$id = $this->input->post('id');
			$difficolta = $this->input->post('difficolta');
			//$owner = $this->session->userdata['logged_in']['id'];
			$tipo = $this->input->post('tipo');
			$note = $this->input->post('note');
			$descrizione = $this->input->post('descrizione');
			$abbinamenti = $this->input->post('abbinamenti');
			$num_persione = $this->input->post('persone');
			$tempo = $this->input->post('tempo');
			
//			echo var_dump($_POST['vegetariano']);
			if(isset($_POST['vegetariano']) && $_POST['vegetariano'] == 'vegetariano')
			{
				$vegetariano = "true";
			}
			else
			{
				$vegetariano = "false";
			}
			
			$newRecipe = array(
				'tipo' => $tipo,
				'vegetariano' => $vegetariano,
				'difficolta' => $difficolta,
				'descrizione' => $descrizione,
				'note' => $note,
				'abbinamenti' => $abbinamenti,
				'num_persone' => $num_persione,
				'tempo' => $tempo,
				);
			 
			$this->recipeModel->updateRecipe($id, $newRecipe);
			
			redirect('home', 'refresh');
		}
	}
}
?>