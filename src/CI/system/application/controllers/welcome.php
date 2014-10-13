<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
	}
	
	function index()
	{
		session_start(); 
		
		try {
			if($_SESSION['loggedin'] != null && $_SESSION['loggedin'] == "true"){
				$this->load->view('home');
			}
			else{
				$this->load->view('welcome_message');
			}
		} catch (Exception $e) {
			$this->load->view('welcome_message');
		}
		
		

	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */