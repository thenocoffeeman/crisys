<?php

class Managepatients extends Controller {

	function Managepatients()
	{
		parent::Controller();	
	}
	
	function index()
	{
		session_start(); 
		
			if($_SESSION['loggedin'] == "true"){
			
				$sql = "SELECT * FROM Treating_Clinicians T, Electronic_Health_Record E, User P WHERE T.Clinician = ? AND T.ElectronicHealthRecord = E.Id AND E.Id = P.Id";
				$data['patients'] = $this->db->query($sql, array($_SESSION['uid']));
				
				$this->load->view('managepatients', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
		function patientsearch()
	{
		session_start(); 
		
			if($_SESSION['loggedin'] == "true"){
			
				$searchtext = $_POST['query'];
				
				$sql = "SELECT * FROM User U, Treating_Clinicians T WHERE (U.FirstName LIKE '%' ? '%' OR U.LastName LIKE '%' ? '%') AND T.electronicHealthRecord = U.ID AND T.clinician = ?";
				$data['search_results'] = $this->db->query($sql, array($searchtext, $searchtext, $_SESSION['uid']));
				$data['no_results'] =  "Your search for - <b>".$searchtext."</b> - did not match any patients.<br/><br/>Suggestions:<ul><li>Make sure all words are spelled correctly.</li><li>Try different keywords.</li><li>Try more general keywords.</li></ul>";
                    
			
				$this->load->view('patientsearchresults', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
	function browsepatients()
	{
		session_start(); 

		if($_SESSION['loggedin'] == "true" && $_SESSION['c'] == "true"){
		
			$sql = "SELECT * FROM Treating_Clinicians T, Electronic_Health_Record E, User P WHERE T.Clinician = ? AND T.ElectronicHealthRecord = E.Id AND E.Id = P.Id";
			$data['patients'] = $this->db->query($sql, array($_SESSION['uid']));
			$this->load->view('browsepatients', $data);
		}
		else{
			$this->load->view('mustbeloggedin');
		}
	}
}

/* End of file managepatients.php */
/* Location: ./system/application/controllers/managepatients.php */