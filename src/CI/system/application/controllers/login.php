<?php

class Login extends Controller {

	function Login()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$username = $_POST['username'];
		$password = sha1($_POST['password']);

		$sql = "SELECT * FROM User WHERE Username=? AND password=?";
		$login = $this->db->query($sql, array($username, $password));

		if ($login->result() != null) {
			
			foreach ($login->result_array() as $row)
			{
			$uid = $row['ID']; //get the users ID for further queires
			
			session_start(); 
			$_SESSION['loggedin'] = true; //sets a flag that a user is logged in
			$_SESSION['user'] = $username; //stores the logged in user's username so we know who it is
			$_SESSION['uid'] = $uid; //stores the user's id
			$_SESSION['fname'] = $row['FirstName']; //stores the user's first name
			$_SESSION['lname'] = $row['LastName']; //stores the user's last name
			
			$data['message'] = "You have been successfully logged in!";
			}

			//set permissions
			$sqlstr = mysql_query("SELECT * FROM Patient WHERE Id='$uid'");
			if (mysql_numrows($sqlstr) != 0) {
				$_SESSION['p'] = true; //user is a patient
			}
			else{
				$_SESSION['p'] = false;
			}
			$sqlstr = mysql_query("SELECT * FROM Clinician WHERE Id='$uid'");
			if (mysql_numrows($sqlstr) != 0) {
				$_SESSION['c'] = true; //user is a clinician
			}
			else{
				$_SESSION['c'] = false;
			}
			$sqlstr = mysql_query("SELECT * FROM Appointed_Agents WHERE agent='$uid'");
			if (mysql_numrows($sqlstr) != 0) {
				$_SESSION['a'] = true; //user is an agent
			}
			else{
				$_SESSION['a'] = false;
			}
			$sqlstr = mysql_query("SELECT * FROM Administrator WHERE ID='$uid'");
			if (mysql_numrows($sqlstr) != 0) {
				$_SESSION['admin'] = true; //user is an admin
			}
			else{
				$_SESSION['admin'] = false;
			}
			
	
			$this->load->view('home', $data); //login successfull, forward to homepage
		}
		else{
		$this->load->view('error'); //login failed, forward to error page
		}
	
	}
}

/* End of file login.php */
/* Location: ./system/application/controllers/login.php */