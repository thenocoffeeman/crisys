<?php

class Managereferrals extends Controller {

	function Managereferrals()
	{
		parent::Controller();	
	}
	
	function index()
	{
		session_start(); 
		
			if($_SESSION['loggedin'] == "true"){
				$sql = "SELECT * FROM Referral WHERE electronicHealthRecord = ? AND cancelled <> 1";
				$data['referrals'] = $this->db->query($sql, array($_SESSION['uid']));
				$data['user'] = $_SESSION['uid'];
				
				$sql = "SELECT * FROM User WHERE ID = ?";				
				$query = $this->db->query($sql, array($_SESSION['uid']));
				$row = $query->row();
				$data['name'] = $row->FirstName." ".$row->LastName;
				
				$this->load->view('managereferrals', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
	function agent()
	{
		session_start(); 
		
			if($_SESSION['loggedin'] == "true"){
				$sql = "SELECT * FROM Referral WHERE electronicHealthRecord = ? AND cancelled <> 1";
				$data['referrals'] = $this->db->query($sql, array($_POST['ehr']));
				$data['user'] = $_POST['ehr'];
				
				$sql = "SELECT * FROM User WHERE ID = ?";				
				$query = $this->db->query($sql, array($_POST['ehr']));
				$row = $query->row();
				$data['name'] = $row->FirstName." ".$row->LastName;
				
				$this->load->view('managereferrals', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
	function clinician()
	{
		session_start();
		if($_SESSION['loggedin'] == "true"){
				$sql = "SELECT * FROM Referral WHERE referringClinician = ? AND cancelled <> 1";
				$data['referrals'] = $this->db->query($sql, array($_SESSION['uid']));
				$this->load->view('managereferrals', $data);
		}
		else{
			$this->load->view('mustbeloggedin');
		}
	}
	
	function newreferral()
	{
		session_start(); 
		
			if($_SESSION['loggedin'] == "true"){
			
				$sql = "SELECT * FROM Treating_Clinicians T, Electronic_Health_Record E, User P WHERE T.Clinician = ? AND T.ElectronicHealthRecord = E.Id AND E.Id = P.Id";
				$data['patients'] = $this->db->query($sql, array($_SESSION['uid']));
				
				$data['medical_areas'] = $this->db->get('Medical_Areas');
				
				
				$this->load->view('referraloptions', $data);
				}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
	function newreferralinfo()
	{
		session_start();
		$med_id = $this->input->post('med_area');
		$pat_id = $this->input->post('pat_id');
		
		$sql = "SELECT * FROM Clinician C, Clinician_Medical_Areas A, User U WHERE C.ID = A.Clinician AND A.MedicalArea = ? AND U.ID=C.ID";
		$query = $this->db->query($sql, array($med_id));
		if($query->num_rows>0){
			echo "<form action='http://www.corpusvile.com/crisys/CI/index.php/managereferrals/createreferral' method='post'>";
			
			
			echo "<input type='hidden' name='electronicHealthRecord' value='".$pat_id."'/>";
			echo "<input type='hidden' name='referringClinician' value='".$_SESSION['uid']."'/>";
			echo "<input type='hidden' name='author' value='".$_SESSION['uid']."'/>";
			
			
			echo "<br/>Select the clinician you wish to make a referral to:";
			foreach($query->result() as $row){
				echo "<br/><input type='radio' name='referredClinician' value='".$row->ID."'/>";
				echo $row->FirstName." ".$row->LastName;
			}
			
			echo "<br/><br/><input type='submit' value='Create Referral' />";
		}
		else{
			echo "<br/>There are currently no doctors specializing in that field.";
		}
		
	}
	
	function createreferral()
	{
		session_start();
		
		$gotdate = getdate();
		$now = $gotdate['year']."-".$gotdate['mon']."-".$gotdate['mday']." ".$gotdate['hours'].":".$gotdate['minutes'].":".$gotdate['seconds'];
		
		$input = array(
			   'electronicHealthRecord' => $_POST['electronicHealthRecord'] ,
               'referringClinician' => $_POST['referringClinician'] ,
               'referredClinician' => $_POST['referredClinician'] ,
               'author' => $_POST['author'] ,
			   'creationTime' => $now
            );

		$this->db->insert('Referral', $input);
		
		
		
		$sql = "SELECT * FROM Treating_Clinicians WHERE electronicHealthRecord = ? AND clinician = ?";
		$data_test = $this->db->query($sql, array($_POST['electronicHealthRecord'], $_POST['referredClinician'] ));
				
		if($data_test->result() == null){
		
				$input = array(
					   'electronicHealthRecord' => $_POST['electronicHealthRecord'] ,
					   'clinician' => $_POST['referredClinician'] ,
					);
		
				$this->db->insert('Treating_Clinicians', $input);
		}
		
		
		//Add to log
				$gotdate = getdate();
				$now = $gotdate['year']."-".$gotdate['mon']."-".$gotdate['mday']." ".$gotdate['hours'].":".$gotdate['minutes'].":".$gotdate['seconds'];
				$input = array(
				   'electronicHealthRecord' =>  $_POST['electronicHealthRecord'],
				   'editingUser' => $_SESSION['uid'] ,
				   'dateOfAction' => $now ,
				   'actionDescription' => "User#".$_SESSION['uid']." has created a referral for User#".$_POST['electronicHealthRecord']."to see Clinician#".$_POST['referredClinician']
            	);

				$this->db->insert('Log', $input);
		
		
		$data['message'] = "Referral has been successfully created!";
		$this->load->view('home', $data);
		
	}
	
	function cancelreferral()
	{
		session_start();
		$cancel = $_POST['referral_id'];
		
		$sql = "UPDATE Referral SET cancelled = 1, cancelledBy = ? WHERE ID = ?";
		$data_test = $this->db->query($sql, array($_SESSION['uid'], $cancel));
		
		//Add to log
				$gotdate = getdate();
				$now = $gotdate['year']."-".$gotdate['mon']."-".$gotdate['mday']." ".$gotdate['hours'].":".$gotdate['minutes'].":".$gotdate['seconds'];
				$input = array(
				   'electronicHealthRecord' =>  $_POST['referral_id'],
				   'editingUser' => $_SESSION['uid'] ,
				   'dateOfAction' => $now ,
				   'actionDescription' => "User#".$_SESSION['uid']." has created a referral#".$_POST['referral_id']
            	);

				$this->db->insert('Log', $input);
		
		$data['message'] = "Referral has been successfully cancelled!";
		$this->load->view('home', $data);
	}
}

/* End of file managereferrals.php */
/* Location: ./system/application/controllers/managereferrals.php */