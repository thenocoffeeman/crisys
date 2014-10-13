<?php

class Admin extends Controller {

	function Admin()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$this->load->view('admin');
	}
	
	function adduser()
	{
		$username = $_POST['username'];
		$password = sha1($_POST['password']);
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		
		
		$sql = "INSERT INTO User (Username, Password, FirstName, LastName) VALUES(?,?,?,?)";
		$this->db->query($sql, array($username, $password, $firstname, $lastname)); 
		
		
		$sql = "SELECT * FROM User WHERE Username = ?";
		$query = $this->db->query($sql, array($username)); 
		$row = $query->row_array();
		$ID = $row['ID'];
		
		$c = "false";
		$p = "false";
		$a = "false";
		
		if($_POST['patient'] != null){
			$sql = "INSERT INTO Electronic_Health_Record (ID) VALUES(?)";
			$this->db->query($sql, array($ID));
			$sql = "INSERT INTO Patient (ID, electronicHealthRecord) VALUES(?, ?)";
			$this->db->query($sql, array($ID, $ID));
			$p = "true";	
		}
		if($_POST['clinician'] != null){
			$sql = "INSERT INTO Clinician (ID) VALUES(?)";
			$this->db->query($sql, array($ID));
			$c = "true";
		}
		if($_POST['admin'] != null){
			$sql = "INSERT INTO Administrator (ID) VALUES(?)";
			$this->db->query($sql, array($ID));
			$a = "true";
		}
		
		//Add to log
		session_start(); 
		$gotdate = getdate();
		$now = $gotdate['year']."-".$gotdate['mon']."-".$gotdate['mday']." ".$gotdate['hours'].":".$gotdate['minutes'].":".$gotdate['seconds'];
		$input = array(
               'electronicHealthRecord' =>  $ID,
               'editingUser' => $_SESSION['uid'] ,
               'dateOfAction' => $now ,
			   'actionDescription' => "A new user has been added to the system. This is user#".$ID.". Permissions: Patient = ".$p.", Clinician = ".$c.", Admin = ".$a
            );

		$this->db->insert('Log', $input);
				
				

        $data['message'] = "User has been added to the system"; 
	 
		$this->load->view('admin', $data);
	}
	
	function adminlogin()
	{
		$this->load->view('adminlogin'); //login successfull, forward to homepage
	}
	
	function admincheck()
	{
		$username = $_POST['username'];
		$password = sha1($_POST['password']);

		$host = "localhost"; //database location
		$user = "corpusv1_user"; //database username
		$pass = "adminadmin"; //database password
		$db_name = "corpusv1_crisys"; //database name

		//database connection
		$link = mysql_connect($host, $user, $pass);
		mysql_select_db($db_name);


		$sqlstr = mysql_query("SELECT * FROM User WHERE Username='$username' AND
             password='$password'");
		if (mysql_numrows($sqlstr) != 0) {

			$row = mysql_fetch_array($sqlstr);
			$uid = $row['ID'];
			$sqlstr2 = mysql_query("SELECT * FROM Administrator WHERE ID='$uid'");
			if(mysql_numrows($sqlstr2) != 0){
			
			session_start(); 
			$_SESSION['loggedin'] = true; //sets a flag that a user is logged in
			$_SESSION['user'] = $username; //stores the logged in user's username so we know who it is
			$_SESSION['uid'] = $uid; //stores the user's id
			$this->load->view('admin'); //login successfull, forward to homepage
			}
			else{
				$this->load->view('error'); //login failed, forward to error page
				}
		}
		else{
		$this->load->view('error'); //login failed, forward to error page
		}
	
	}
	
	function viewlogs()
	{
		$data['logs'] = $this->db->get('Log');
		$this->load->view('viewlogs', $data);
	}
}

/* End of file admin.php */
/* Location: ./system/application/controllers/admin.php */