<?php

class User extends CI_Model{
	
	public function login($username, $password)
	{
		$this->db->select('id, username, password');
		$this->db->from('utenti');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		if($query -> num_rows() == 1)
		{
			return $query -> result();
		}
		else
		{
			return false;
		}
	}
	
	public function checkPassword($username, $password)
	{
		echo "Model: checkpassword<br/>";
		echo $username;
		echo "<br/>";
		echo $password;
		echo "<br/>";
		$this->db->select('username, password');
		$this->db->from('utenti');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		if($query -> num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function changePassword($password)
	{
		$this->db->where('id', $this->session->userdata['logged_in']['id']);
		
		$updateData = array(
			'password' => $password
		);
		
		$this->db->update('utenti', $updateData);
		echo "Password cambiata con successo!";
		redirect('home', 'refresh');
	}
	
	public function deleteMe($myself)
	{
		$this->db->where('id', $myself);
		$this->db->delete('utenti');
		$this->session->sess_destroy();
		return TRUE;
	}
	
}