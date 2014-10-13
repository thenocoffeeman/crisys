<?php

class Manageprimaryclinician extends Controller {

	function Manageprimaryclinician()
	{
		parent::Controller();	
	}
	
	function index()
	{
		session_start(); 
		
			if($_SESSION['loggedin'] == "true"){
				$sql = "SELECT PrimaryDoctor FROM Primary_Doctor WHERE electronicHealthRecord = ?";
	
				$query = $this->db->query($sql, array($_SESSION['uid'])); 
				$row = $query->row_array();
				
				if($row == null){
					$data['primary'] = "none";
				}
				else{
					$docID = $row['PrimaryDoctor'];
					
					$sql = "SELECT * FROM User WHERE Id = ?";
					$data['primary'] = $this->db->query($sql, array($docID)); 
				}
				
				$sql = "SELECT * FROM Treating_Clinicians WHERE electronicHealthRecord = ? AND clinician <> ?";
				$data['other_clinicians'] = $this->db->query($sql, array($_SESSION['uid'], $docID)); 
				$data['user'] = $_SESSION['uid'];
				
				$sql = "SELECT * FROM User WHERE ID = ?";				
				$query = $this->db->query($sql, array($_SESSION['uid']));
				$row = $query->row();
				$data['name'] = $row->FirstName." ".$row->LastName;
				
				
				$this->load->view('manageprimaryclinician', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
	function agent()
	{
		session_start(); 
		
			if($_SESSION['loggedin'] == "true"){
				$sql = "SELECT PrimaryDoctor FROM Primary_Doctor WHERE electronicHealthRecord = ?";
	
				$query = $this->db->query($sql, array($_POST['ehr'])); 
				$row = $query->row_array();
				
				if($row == null){
					$data['primary'] = "none";
				}
				else{
					$docID = $row['PrimaryDoctor'];
					
					$sql = "SELECT * FROM User WHERE Id = ?";
					$data['primary'] = $this->db->query($sql, array($docID)); 
				}
				
				$sql = "SELECT * FROM Treating_Clinicians WHERE electronicHealthRecord = ? AND clinician <> ?";
				$data['other_clinicians'] = $this->db->query($sql, array($_POST['ehr'], $docID)); 
				$data['user'] = $_POST['ehr'];
				
				$sql = "SELECT * FROM User WHERE ID = ?";				
				$query = $this->db->query($sql, array($_POST['ehr']));
				$row = $query->row();
				$data['name'] = $row->FirstName." ".$row->LastName;
				
				
				$this->load->view('manageprimaryclinician', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
	function removeprimary()
	{
		session_start(); 
		$user = $_POST['user'];
		
			if($_SESSION['loggedin'] == "true"){
				$sql = "DELETE FROM Primary_Doctor WHERE electronicHealthRecord = ?";
	
				$this->db->query($sql, array($user)); 
				
				//Add to log
				$gotdate = getdate();
				$now = $gotdate['year']."-".$gotdate['mon']."-".$gotdate['mday']." ".$gotdate['hours'].":".$gotdate['minutes'].":".$gotdate['seconds'];
				$input = array(
				   'electronicHealthRecord' =>  $user,
				   'editingUser' => $_SESSION['uid'] ,
				   'dateOfAction' => $now ,
				   'actionDescription' => "User#".$user." has removed his primary clinician (Action performed by User#".$_SESSION['uid'].")"
            	);

				$this->db->insert('Log', $input);
				
				$data['message'] = "Your primary clinician has been successfully removed!";
				$this->load->view('home', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
	function addprimary()
	{
		session_start(); 
		$user = $_POST['user'];
		
			if($_SESSION['loggedin'] == "true"){
				$sql = "INSERT INTO Primary_Doctor (electronicHealthRecord, primaryDoctor) VALUES(? , ?) ";
				$this->db->query($sql, array($user, $_POST['doc'] )); 
				
				$sql = "SELECT * FROM Treating_Clinicians WHERE electronicHealthRecord = ? AND clinician = ?";
				$data_test = $this->db->query($sql, array($user, $_POST['doc'] ));
				
				if($data_test->result() == null){
					$sql = "INSERT INTO Treating_Clinicians (electronicHealthRecord, clinician) VALUES(? , ?) ";
					$this->db->query($sql, array($user, $_POST['doc'] ));
				}
				
				//Add to log
				$gotdate = getdate();
				$now = $gotdate['year']."-".$gotdate['mon']."-".$gotdate['mday']." ".$gotdate['hours'].":".$gotdate['minutes'].":".$gotdate['seconds'];
				$input = array(
				   'electronicHealthRecord' =>  $user,
				   'editingUser' => $_SESSION['uid'] ,
				   'dateOfAction' => $now ,
				   'actionDescription' => "User#".$_SESSION['uid']." has added a primary clinician (Action performed by User#".$_SESSION['uid'].")"
            	);

				$this->db->insert('Log', $input);
				
				$data['message'] = "You're primary clinician has been sucessfully added!";
				$this->load->view('home', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
	function removeconsent()
	{
		session_start();
		$user = $_POST['user'];
		
		$sql = "DELETE FROM Treating_Clinicians WHERE electronicHealthRecord = ? AND clinician = ?";
		$this->db->query($sql, array($user, $_POST['remove'] )); 
		
		$data['message'] = "Consent was successfully revoked!";
		$this->load->view('home', $data);
		
		//Add to log
				$gotdate = getdate();
				$now = $gotdate['year']."-".$gotdate['mon']."-".$gotdate['mday']." ".$gotdate['hours'].":".$gotdate['minutes'].":".$gotdate['seconds'];
				$input = array(
				   'electronicHealthRecord' =>  $user,
				   'editingUser' => $_SESSION['uid'] ,
				   'dateOfAction' => $now ,
				   'actionDescription' => "User#".$_SESSION['uid']." has removed consent of treatment to Clinician#".$_POST['add'].". This action was preformed by User#".$user
            	);

				$this->db->insert('Log', $input);
		
	}
	function grantconsent()
	{
			session_start();
			$user = $_POST['user'];
			$input = array(
				   'electronicHealthRecord' =>  $user,
				   'clinician' => $_POST['add'] ,
            	);

			$this->db->insert('Treating_Clinicians', $input);
			
		//Add to log
				$gotdate = getdate();
				$now = $gotdate['year']."-".$gotdate['mon']."-".$gotdate['mday']." ".$gotdate['hours'].":".$gotdate['minutes'].":".$gotdate['seconds'];
				$input = array(
				   'electronicHealthRecord' =>  $user,
				   'editingUser' => $_SESSION['uid'] ,
				   'dateOfAction' => $now ,
				   'actionDescription' => "User#".$_SESSION['uid']." has granted consent of treatment to Clinician#".$_POST['add'].". This action was preformed by User#".$user
            	);

				$this->db->insert('Log', $input);	
			
		$data['message'] = "Consent was successfully added!";
		$this->load->view('home', $data);
	}
}

/* End of file manageprimaryclinician.php */
/* Location: ./system/application/controllers/manageprimaryclinician.php */