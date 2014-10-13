<?php

class Manageclinician extends Controller {

	function Manageclinician()
	{
		parent::Controller();	
	}
	
	function index()
	{	
		session_start(); 
		$sql = "SELECT * FROM Medical_Areas M, Clinician_Medical_Areas C WHERE C.Clinician = ? AND C.MedicalArea = M.ID";
		$data['medical_areas'] = $this->db->query($sql, array($_SESSION['uid']));
		
		$sql = "SELECT ID, Description FROM Medical_Areas M";
		$data['other_areas'] = $this->db->query($sql);
		$this->load->view('clinicianprofile', $data);
	}
	
	function addmedicalarea()
	{
		session_start(); 
		$area = $_POST['medarea'];
		
		try{
			$input = array(
				   'Clinician' => $_SESSION['uid'] ,
				   'MedicalArea' => $area
				);
				
			$this->db->insert('Clinician_Medical_Areas', $input);
			
			//Add to log
				$gotdate = getdate();
				$now = $gotdate['year']."-".$gotdate['mon']."-".$gotdate['mday']." ".$gotdate['hours'].":".$gotdate['minutes'].":".$gotdate['seconds'];
				$input = array(
				   'electronicHealthRecord' =>  $_SESSION['uid'],
				   'editingUser' => $_SESSION['uid'] ,
				   'dateOfAction' => $now ,
				   'actionDescription' => "User#".$_SESSION['uid']." has added medical area #".$area
            	);

				$this->db->insert('Log', $input);
				
			$data['message'] = "Medical area has been added!";
			$this->load->view('home', $data);
		}catch(Exception $e){
			$data['message'] = "ERROR: You already specialize in that medical area!";
			$this->load->view('home', $data);
		}
		
	}
	
	function removemedicalarea()
	{
		session_start(); 
		$area = $_POST['medarea'];
		
		$sql = "DELETE FROM Clinician_Medical_Areas WHERE Clinician = ? AND MedicalArea = ?";
		$this->db->query($sql, array($_SESSION['uid'], $area));
		
					//Add to log
				$gotdate = getdate();
				$now = $gotdate['year']."-".$gotdate['mon']."-".$gotdate['mday']." ".$gotdate['hours'].":".$gotdate['minutes'].":".$gotdate['seconds'];
				$input = array(
				   'electronicHealthRecord' =>  $_SESSION['uid'],
				   'editingUser' => $_SESSION['uid'] ,
				   'dateOfAction' => $now ,
				   'actionDescription' => "User#".$_SESSION['uid']." has removed medical area #".$area
            	);

				$this->db->insert('Log', $input);
		
		$data['message'] = "Medical area has been removed!";
		$this->load->view('home', $data);
	}
}

/* End of file manageclinician.php */
/* Location: ./system/application/controllers/manageclinician.php */