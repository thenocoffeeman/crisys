<?php

class Error extends Controller {

	function Error()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$this->load->view('error');
	}
}

/* End of file error.php */
/* Location: ./system/application/controllers/error.php */