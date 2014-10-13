<?php

class Manageagents extends Controller {

	function Manageagents()
	{
		parent::Controller();	
	}
	
	function index()
	{
		session_start(); 
		
			if($_SESSION['loggedin'] == "true"){
				$sql = "SELECT * FROM Appointed_Agents A, User U WHERE A.electronicHealthRecord = ? AND A.agent = U.ID";
				$data['agents'] = $this->db->query($sql, array($_SESSION['uid']));
				
				$sql = "SELECT * FROM User WHERE ID <> ?";
				$data['users'] = $this->db->query($sql, array($_SESSION['uid']));
				$data['user'] = $_SESSION['uid'];
				

				$sql = "SELECT * FROM User WHERE ID = ?";				
				$query = $this->db->query($sql, array($_SESSION['uid']));
				$row = $query->row();
				$data['name'] = $row->FirstName." ".$row->LastName;
				
				$this->load->view('manageagents', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
	function clinician()
	{
			session_start(); 
			if($_SESSION['loggedin'] == "true"){
				$sql = "SELECT * FROM Primary_Doctor WHERE primaryDoctor = ?";
				$primary = $this->db->query($sql, array($_SESSION['uid']));
				
				$data['body'] = "<h3>Your Primary Patients:</h3><br/>";
				$data['body'] .= "Select one of your primary patients below and click \"Manage Agents\" to manage the agents for that user.<br/><br/>";
				if($primary->result() == null){
					$data['body'] .= "You have no primary patients.";
				}
				else{
					$data['body'] .= "<form method='post' action='http://www.corpusvile.com/crisys/CI/index.php/manageagents/clinicianview'>";
					$data['body'] .= "<SELECT name='ehr'>";
					
					foreach($primary->result() as $row){
						$sql = "SELECT * FROM User WHERE ID = ?";
						$primary = $this->db->query($sql, array($row->electronicHealthRecord));
						$patient = $primary->row();

						$data['body'] .= "<OPTION value='".$patient->ID."'>";
						$data['body'] .= $patient->FirstName." ".$patient->LastName." (".$patient->Username.")";
						$data['body'] .= "</OPTION>";
					}
					$data['body'] .= "</SELECT><br/><br/>";
					$data['body'] .= "<input type='submit' value='Mange Agents'>";
					$data['body'] .= "</form>";
				}
				
				$this->load->view('clinicianagents', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
	function clinicianview()
	{
			session_start(); 
		
			if($_SESSION['loggedin'] == "true"){
				$sql = "SELECT * FROM Appointed_Agents A, User U WHERE A.electronicHealthRecord = ? AND A.agent = U.ID";
				$data['agents'] = $this->db->query($sql, array($_POST['ehr']));
				
				$sql = "SELECT * FROM User WHERE ID <> ?";
				$data['users'] = $this->db->query($sql, array($_POST['ehr']));
				$data['user'] = $_POST['ehr'];
				
				
				$sql = "SELECT * FROM User WHERE ID = ?";				
				$query = $this->db->query($sql, array($_POST['ehr']));
				$row = $query->row();
				$data['name'] = $row->FirstName." ".$row->LastName;
				$data['clinicianviewing'] = true;
				
				$this->load->view('manageagents', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
	function agent()
	{
			session_start(); 
		
			if($_SESSION['loggedin'] == "true"){
				$sql = "SELECT * FROM Appointed_Agents A, User U WHERE A.electronicHealthRecord = ? AND A.agent = U.ID";
				$data['agents'] = $this->db->query($sql, array($_POST['ehr']));
				
				$sql = "SELECT * FROM User WHERE ID <> ?";
				$data['users'] = $this->db->query($sql, array($_POST['ehr']));
				$data['user'] = $_POST['ehr'];
				
				
				$sql = "SELECT * FROM User WHERE ID = ?";				
				$query = $this->db->query($sql, array($_POST['ehr']));
				$row = $query->row();
				$data['name'] = $row->FirstName." ".$row->LastName;
				
				$this->load->view('manageagents', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
	function findagent()
	{
		session_start();
		$user=$_POST['user'];
		echo"<form method='post' action='http://www.corpusvile.com/crisys/CI/index.php/manageagents/addagent'>";
		
		
		if($_POST['method'] == "browse"){
			$sql = "SELECT * FROM User WHERE ID <> ?"; 
			$users = $this->db->query($sql, array($user));

			echo "Browse All Available Users:<br/><SELECT name='usertoadd'>";
			foreach($users->result() as $row){
				$sql2 = "SELECT * FROM Appointed_Agents WHERE electronicHealthRecord = ? AND agent = ?"; 
				$agents = $this->db->query($sql2, array($user, $row->ID));

						if($agents->result() == null){
							$output .= "<OPTION value='".$row->ID."'>".$row->FirstName." ".$row->LastName." (".$row->Username.")</OPTION>";
						}
					
				}
			echo $output;
			echo"</SELECT><br/><br/>";
		
		}
		else if($_POST['method'] == "search"){
			
			$sql = "SELECT * FROM User WHERE (FirstName LIKE '%' ? '%' OR LastName LIKE '%' ? '%') AND ID <> ?"; 
			$users = $this->db->query($sql, array($_POST['search'], $_POST['search'], $user));
			
			if($users->result()==null){
				echo "There are no users matching the phrase \"".$_POST['search']."\". Please try again.<br/><br/>";
			}
			else{
				echo "All Available Users Matching \"".$_POST['search']."\":<br/><SELECT name='usertoadd'>";
				foreach($users->result() as $row){
				
					$sql2 = "SELECT * FROM Appointed_Agents WHERE electronicHealthRecord = ? AND agent = ?"; 
					$agents = $this->db->query($sql2, array($user, $row->ID));
					if($agents->result() == null){
						$output .= "<OPTION value='".$row->ID."'>".$row->FirstName." ".$row->LastName." (".$row->Username.")</OPTION>";
					}
				}
				echo $output;
				echo"</SELECT><br/><br/>";
				}
		}
		echo"Choose Access Level: ";
		echo"<SELECT name='accesslevel'>";
		echo"<OPTION value='1'>Read</OPTION><OPTION value='2'>Read/Comment</OPTION><OPTION value='3'>Full</OPTION>";
		echo"</SELECT>";
		echo"<br/><br/>";
		echo"<input type='hidden' name='user' value='".$user."'/>";
		echo"<input type='submit' value='Add Agent'/>";
		echo"</form>";
		
	}
	
	function addagent()
	{
		session_start();
		$user = $_POST['user'];
		
		$input = array(
               'agent' => $_POST['usertoadd'] ,
               'electronicHealthRecord' => $user ,
               'role' => $_POST['accesslevel']  ,
			   'author' => $_SESSION['uid']
            );
			
		$this->db->insert('Appointed_Agents', $input);
		
		//Add to log
				$gotdate = getdate();
				$now = $gotdate['year']."-".$gotdate['mon']."-".$gotdate['mday']." ".$gotdate['hours'].":".$gotdate['minutes'].":".$gotdate['seconds'];
				$input = array(
				   'electronicHealthRecord' =>  $user,
				   'editingUser' => $_SESSION['uid'] ,
				   'dateOfAction' => $now ,
				   'actionDescription' => "User#".$_SESSION['uid']." has added User#".$_POST['usertoadd']." as an agent for User#".$user
            	);

				$this->db->insert('Log', $input);
			
		$data['message'] = "Agent has been successfully added!";
		$this->load->view('home', $data);
	}
	
	function removeagent()
	{
		session_start();
		$user = $_POST['user'];

		$sql = "DELETE FROM Appointed_Agents WHERE electronicHealthRecord = ? AND agent = ?";
		$this->db->query($sql, array($user, $_POST['agentid'])); 
		
		//Add to log
				$gotdate = getdate();
				$now = $gotdate['year']."-".$gotdate['mon']."-".$gotdate['mday']." ".$gotdate['hours'].":".$gotdate['minutes'].":".$gotdate['seconds'];
				$input = array(
				   'electronicHealthRecord' =>  $user,
				   'editingUser' => $_SESSION['uid'] ,
				   'dateOfAction' => $now ,
				   'actionDescription' => "User#".$_SESSION['uid']." has removed User#".$_POST['agentid']." as an agent for User#".$user
            	);

				$this->db->insert('Log', $input);
		
		$data['message'] = "Agent has been successfully removed!";
		$this->load->view('home', $data);
	}
}

/* End of file manageagents.php */
/* Location: ./system/application/controllers/manageagents.php */