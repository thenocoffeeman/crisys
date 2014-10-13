<?php

class Logout extends Controller {

	function Logout()
	{
		parent::Controller();	
	}
	
	function index()
	{
		session_start(); 
		$_SESSION['loggedin']=false; 
		$_SESSION['user']=null;
		$_SESSION['uid'] = null; 
		$_SESSION['fname'] = null; 
		$_SESSION['lname'] = null; 
		$_SESSION['p'] = false;
		$_SESSION['c'] = false;
		$_SESSION['a'] = false;
		$_SESSION['admin'] = false;
		$this->load->view('welcome_message');
	}
}

/* End of file logout.php */
/* Location: ./system/application/controllers/logout.php */