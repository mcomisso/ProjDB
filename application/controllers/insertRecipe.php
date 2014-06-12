<?php
class InsertRecipe extends CI_Controller{
	
	function __construct()
	{
		parent::__construct();
		// Carico il modello per le ricette
		$this->load->model('recipemodel', '', TRUE);
		$this->load->model('Ingredient', '', TRUE);
		$this->load->model('recipeingredient', '', TRUE);
	}
	
	function ingredients($ingredienti)
	{
		$arrayid = array();
		$arraying = json_decode($ingredienti,true);
		$len = count($arraying);
		foreach ($arraying as $ingrediente){
			$id = $ingrediente["id"];
			$nome = $ingrediente["nome"];
			$quantita = $ingrediente["quantita"];
			if ($id == $nome){
				$exist = $this->Ingredient->getSelectedIngredient($nome);
				//echo (count($exist));
				if((count($exist))==0){ //inserisce e ottiene id
					$id = $this->Ingredient->setIngredient($nome);
					}
				else {//ottiene id
					$id = $exist[0]["id"];
				}
			}
			$arrayid[$id] = $quantita;
		};
		return $arrayid;
	}
	
	function checkunique($nome){
		$owner = $this->session->userdata['logged_in']['id'];
		$sql = "SELECT id FROM ricette WHERE owner=". $owner." AND nome='".$nome."'";
		$query = $this->db->query($sql);
		if($query->num_rows() >0){
			return FALSE;
			}
		else {
			return TRUE;
		}
	}
	
	function index()
	{
		$this->load->library('form_validation');
		
		// NOT NULL = NOME DIFFICOLTA OWNER TEMPO
		// PARAMS: ID NOME TIPO VEGETARIANO DIFFICOLTA NOTE DESCRIZIONE ABBINAMENTI OWNER FOTO NUM_PERSONE
		// TEMPO
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->form_validation->set_rules('nome', 'nome', 'required|xss_clean|callback_checkunique');
		$this->form_validation->set_rules('difficolta', 'difficolta', 'required|xss_clean');
		$this->form_validation->set_rules('tempo', 'tempo', 'required|xss_clean|numeric');
		
		$this->form_validation->set_message('checkunique', 'Nome inserito gi&agrave in uso');
		$this->form_validation->set_message('required', 'Il campo %s &egrave obbligatorio');
		$this->form_validation->set_message('numeric', 'Il campo %s ammette solamente numeri');
		
		$this->form_validation->set_rules('tipo', 'tipo', 'xss_clean');
		$this->form_validation->set_rules('vegetariano', 'vegetariano', 'xss_clean');
		$this->form_validation->set_rules('abbinamenti', 'abbinamenti', 'xss_clean');
		
		$this->form_validation->set_rules('persone', 'persone', 'xss_clean|numeric');
		$this->form_validation->set_rules('descrizione', 'descrizione', 'xss_clean');
		$this->form_validation->set_rules('note', 'note', 'xss_clean');
		$this->form_validation->set_rules('harray', 'harray', 'xss_clean');
		
		if($this->form_validation->run() == FALSE)
		{
			$queryData = $this->Ingredient->getIngredients();
			$passThis['ingredientsdb'] = $queryData;
			$this->load->view('addRecipe', $passThis);
		}
		else
		{
			$nome = $this->input->post('nome');
			$difficolta = $this->input->post('difficolta');
			$owner = $this->session->userdata['logged_in']['id'];
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
//			echo var_dump($vegetariano);
			
			$newRecipe = array(
				'nome' => $nome,
				'difficolta' => $difficolta,
				'owner' => $owner,
				'abbinamenti' => $abbinamenti,
				'tipo' => $tipo,
				'vegetariano' => $vegetariano,
				'note' => $note,
				'descrizione' => $descrizione,
				'num_persone' => intval($num_persione),
				'tempo' => intval($tempo)
				);
			
			$ingredienti = $this->input->post('harray');
			$idarraying = $this->ingredients($ingredienti);
			
			$idrecipe = $this->recipemodel->insertRecipe($newRecipe);
			
			$this->recipeingredient->linkrecipeing($idarraying,$idrecipe);
			redirect('home', 'refresh');
		}
	}
	

}