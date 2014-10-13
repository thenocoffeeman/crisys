<?php

class Home extends Controller {

	function Home()
	{
		parent::Controller();	
	}
	
	function index()
	{
		session_start(); 

		if($_SESSION['loggedin'] == "true"){
			$this->load->view('home');
		}
		else{
			$this->load->view('mustbeloggedin');
		}
	}
}

/* End of file home.php */
/* Location: ./system/application/controllers/home.php */