<?php

class Managecomcealments extends Controller {

	function Managecomcealments()
	{
		parent::Controller();	
	}
	
	function index()
	{
		session_start(); 
		
			if($_SESSION['loggedin'] == "true"){
				$sql = "SELECT * FROM Electrionic_Health_Record_Items E, Item I, Concealed_Item C WHERE E.EHRID = ? AND E.Item = I.ID AND I.ID = C.item";
				$data['concealments'] = $this->db->query($sql, array($_SESSION['uid']));
	
				$data['user'] = $_SESSION['uid'];
				
				$sql = "SELECT * FROM User WHERE ID = ?";				
				$query = $this->db->query($sql, array($_SESSION['uid']));
				$row = $query->row();
				$data['name'] = $row->FirstName." ".$row->LastName;
				$this->load->view('managecomcealments', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
	function agent()
	{
		session_start(); 
		
			if($_SESSION['loggedin'] == "true"){
				$sql = "SELECT * FROM Electrionic_Health_Record_Items E, Item I, Concealed_Item C WHERE E.EHRID = ? AND E.Item = I.ID AND I.ID = C.item";
				$data['concealments'] = $this->db->query($sql, array($_POST['ehr']));
				$data['user'] = $_POST['ehr'];
				
				$sql = "SELECT * FROM User WHERE ID = ?";				
				$query = $this->db->query($sql, array($_POST['ehr']));
				$row = $query->row();
				$data['name'] = $row->FirstName." ".$row->LastName;

				$this->load->view('managecomcealments', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
	function addconceal()
	{
		$checked = $_POST['conceal'];

		foreach($checked as $blockedUser) {
			
            $input = array(
			   'item' => $_POST['item'] ,
               'blockedUser' => $blockedUser ,
            );
			
			$this->db->insert('Concealed_Item', $input);
		}
		
		$data['message'] = "Item was successfully concealed!";
		$this->load->view('home', $data);
	}
	
	function cancelconcealment()
	{
		
		$sql = "DELETE FROM Concealed_Item WHERE item = ? AND blockedUser = ?";
		$this->db->query($sql, array($_POST['item'], $_POST['blockeduser']));
		
		$data['message'] = "Concealment was successfully cancelled!";
		$this->load->view('home', $data);
	}
}

/* End of file managecomcealments.php */
/* Location: ./system/application/controllers/managecomcealments.php */