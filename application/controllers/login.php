<?php
class Login extends CI_Controller 
{
	
	public function index()
	{    
     	$username = $this->session->userdata('username');
     	if ($username === false) {
     		$view_data = array();
     		$view_data['alert'] = $this->session->flashdata('alert');
     		$this->load->view('login',$view_data);
     	}	
     	else {
     		redirect('home', 'refresh');
     	}		
	}
	
	//Appelé avec le formulaire de la view login
	public function connect() {
		
		echo "test";
		$this->load->model('user_model');
		echo "test load model";	
	
		$username = $this->session->userdata('username');
		if ($username === false) {
			$post_username = $this->input->post('username');
			$post_password = $this->input->post('password');
			
			
			$data_bdd = $this->user_model->get_user($post_username);
			$this->session->set_flashdata('alert', 'Cet utilisateur n\'existe pas.');
			
			foreach ($data_bdd as $user) {
				$this->session->flashdata('alert');
				if ($this->encrypt->decode($user->USER_PASSWORD) == $post_password) {
					$this->session->set_userdata('username',$post_username);
				}
				else{
					$this->session->set_flashdata('alert', 'Le mot de passe est incorrect.');
				}
			}			
		}
		redirect('login', 'refresh');
	}
	
	//Appelé depuis le lien de déconnexion
	public function disconnect() {
		$this->session->unset_userdata('username');
		redirect('login', 'refresh');
	}


	//Appelé à l'installation du logiciel
	public function create_admin() {
		$this->load->model('user_model');
		$this->user_model->add_user('John','Doe','admin','admin','john.doe@mail.com','ADMIN');
		redirect('login', 'refresh');
	}
}
