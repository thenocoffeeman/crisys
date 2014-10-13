<?php

class Managesponseredpatients extends Controller {

	function Managesponseredpatients()
	{
		parent::Controller();	
	}
	
	function index()
	{
		session_start(); 
		
			if($_SESSION['loggedin'] == "true"){
				
				$sql = "SELECT * FROM Appointed_Agents A, User U WHERE A.agent = ? AND A.electronicHealthRecord = U.ID";
				$data['spatients'] = $this->db->query($sql, array($_SESSION['uid']));
				$this->load->view('managesponseredpatients', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
	function viewpatient()
	{
		session_start(); 
		if($_SESSION['loggedin'] == "true"){
				
				$sql = "SELECT * FROM Appointed_Agents A, User U WHERE A.agent = ? AND A.electronicHealthRecord = ? AND A.electronicHealthRecord = U.ID";
				$data['spatient'] = $this->db->query($sql, array($_SESSION['uid'], $_POST['patient']));
				$sql = "SELECT * FROM Item I, Electrionic_Health_Record_Items E WHERE E.EHRID = ? AND E.Item = I.ID AND I.Author <> ? ORDER BY I.ID DESC";
				$data['ehr'] = $this->db->query($sql, array($_POST['patient'], $_POST['patient']));
				$this->load->view('sponsoredpatientinfo', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
}

/* End of file managesponseredpatients.php */
/* Location: ./system/application/controllers/managesponseredpatients.php */