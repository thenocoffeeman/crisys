<?php

class ManageEHR extends Controller {

	function ManageEHR()
	{
		parent::Controller();	
	}
	
	function index()
	{
		session_start(); 
		
			if($_SESSION['loggedin'] == "true"){
			$sql = "SELECT * FROM Item I, Electrionic_Health_Record_Items E WHERE E.EHRID = ? AND E.Item = I.ID ORDER BY I.ID DESC";
			$data['items'] = $this->db->query($sql, array($_SESSION['uid']));
				$this->load->view('manageEHR', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
	function browseEHR()
	{
		session_start(); 

		if($_SESSION['loggedin'] == "true"){
		
			$sql = "SELECT * FROM Item I, Electrionic_Health_Record_Items E WHERE E.EHRID = ? AND E.Item = I.ID ORDER BY I.ID DESC";
			$data['items'] = $this->db->query($sql, array($_SESSION['uid']));
			$this->load->view('browseEHR', $data);
		}
		else{
			$this->load->view('mustbeloggedin');
		}
	}
	
	function EHRsearch()
	{
			session_start();
			$ehr = $_POST['searchme'];
			$searchtext = $_POST['query'];
			if($_POST['clinicianviewing'] != null){
				$data['clinicianviewing'] = true;
			}
			else{
				$data['clinicianviewing'] = false;
			}
			$data['search'] = $searchtext;
			$data['no_results'] =  "Your search for - <b>".$searchtext."</b> - did not match any items.<br/><br/>Suggestions:<ul><li>Make sure all words are spelled correctly.</li><li>Try different keywords.</li><li>Try more general keywords.</li></ul>";
		
			if($_SESSION['loggedin'] == "true"){
			
				if($_POST['search_option'] == "author"){

					$sql = "SELECT * FROM User U, Item I, Electrionic_Health_Record_Items E WHERE (U.FirstName LIKE '%' ? '%' OR U.LastName LIKE '%' ? '%') AND U.ID = I.Author AND I.ID = E.item AND E.EHRID = ?";
					$data['search_results'] = $this->db->query($sql, array($searchtext, $searchtext, $ehr));
		
				}
				else if($_POST['search_option'] == "itemtype"){
				
					$sql = "SELECT I.ID,ItemType,Author,CreationTime,EHRID,Item,Description FROM Item I, Electrionic_Health_Record_Items E, Item_Types T WHERE (T.Description LIKE '%' ? '%') AND T.ID = I.ItemType AND I.ID = E.item AND E.EHRID = ?";
					$data['search_results'] = $this->db->query($sql, array($searchtext, $ehr));
				
				}
				if($_POST['search_option'] == "medicalarea"){
				
					$sql = "SELECT * FROM Medical_Areas A, Item_Medical_Areas M, Item I, Electrionic_Health_Record_Items E WHERE (A.Description LIKE '%' ? '%') AND A.ID = M.MedicalArea AND M.ItemID = I.ID AND I.ID = E.Item AND E.EHRID = ?";
					$data['search_results'] = $this->db->query($sql, array($searchtext, $ehr));
				
				}
			
				$this->load->view('EHRsearchresults', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
	function viewehr()
	{
		session_start(); 

		if($_SESSION['loggedin'] == "true"){
		
			$data['primary'] = false;
		
			$sql = "SELECT * FROM User WHERE ID = ? ORDER BY ID DESC";
			$data['patient'] = $this->db->query($sql, array($_POST['id']));
			$sql = "SELECT * FROM Item I, Electrionic_Health_Record_Items E WHERE E.EHRID = ? AND E.Item = I.ID ORDER BY I.ID DESC";
			$data['items'] = $this->db->query($sql, array($_POST['id']));
			$sql = "SELECT * FROM Primary_Doctor WHERE primaryDoctor = ? AND electronicHealthRecord = ?";
			$query = $this->db->query($sql, array($_SESSION['uid'], $_POST['id']));
			if($query->result() != null){
				$data['primary'] = true;
			}

			$this->load->view('displayEHR', $data);
		}
		else{
			$this->load->view('mustbeloggedin');
		}
	}
	
	function additem()
	{
			session_start(); 
		
			if($_SESSION['loggedin'] == "true"){			
				
				$data['ehrid'] = $_POST['ehr'];
				$data['name'] = $_POST['name'];
				
				$data['observedqty'] = $this->db->get("Observed_Quantitity_Type"); 
				
				
				if($_SESSION['uid'] == $_POST['ehr']){
					$sql = "SELECT AddQuantitativeObservationItem, AddQualitativeObservationItem, AddCommentItem, AddTreatmentItem, AddDiagnosisItem FROM Role WHERE RoleName = ?";
					$query = $this->db->query($sql, array("Patient"));
					$row = $query->row();
					$data['permissions'] = $row;
				}
				else if($_POST['agent']!=null){
					if($_POST['agent'] == "Agent w/ Full"){
						$sql = "SELECT AddQuantitativeObservationItem, AddQualitativeObservationItem, AddCommentItem, AddTreatmentItem, AddDiagnosisItem FROM Role WHERE RoleName = ?";
						$query = $this->db->query($sql, array("Agent w/ Full"));
						$row = $query->row();
						$data['permissions'] = $row;
					}
					else if($_POST['agent'] == "Agent w/ Read & Comment"){
						$sql = "SELECT AddQuantitativeObservationItem, AddQualitativeObservationItem, AddCommentItem, AddTreatmentItem, AddDiagnosisItem FROM Role WHERE RoleName = ?";
						$query = $this->db->query($sql, array("Agent w/ Read & Comment"));
						$row = $query->row();
						$data['permissions'] = $row;
					}
				
				}
				else{
					$sql = "SELECT AddQuantitativeObservationItem, AddQualitativeObservationItem, AddCommentItem, AddTreatmentItem, AddDiagnosisItem FROM Role WHERE RoleName = ?";
					$query = $this->db->query($sql, array("Clinician"));
					$row = $query->row();
					$data['permissions'] = $row;
				}
				
	 
				$this->load->view('additem', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
	
	function insertnewitem()
	{
	include("global_variables.php");
	session_start(); 
		
	if($_SESSION['loggedin'] == "true"){
		$type = $_POST['itemtype'];
		$gotdate = getdate();
		
		$now = $gotdate['year']."-".$gotdate['mon']."-".$gotdate['mday']." ".$gotdate['hours'].":".$gotdate['minutes'].":".$gotdate['seconds'];
		
		if($type == "Quantitative Observation"){
		
			$input = array(
               'ItemType' => $QUAN_OB ,
               'Author' => $_POST['ObserverID'] ,
               'CreationTime' => $now
            );
			
			$this->db->insert('Item', $input);
			
			$sql = "SELECT * FROM Item WHERE CreationTime = ?";
			$query = $this->db->query($sql, array($now));
			$row = $query->row_array();
			$id = $row['ID'];
			
			$input = array(
               'EHRID' => $_POST['ehr'] ,
               'Item' => $id
            );
			
			$this->db->insert('Electrionic_Health_Record_Items', $input);
			
			
			$checked = $_POST['med_area'];

			foreach($checked as $area) {
			
				$input = array(
				   'ItemID' => $id ,
				   'MedicalArea' => $area ,
				);
				
				$this->db->insert('Item_Medical_Areas', $input);
			}
			
			
			$input = array(
			   'ID' => $id,
               'Observer' => $_POST['ObserverID'] ,
               'ObservedQuantity' => $_POST['ObservedQuantity'] ,
               'Value' => $_POST['Value'] ,
			   'Unit' => $_POST['Unit']
            );

		$this->db->insert('Quantitative_Observation_Item', $input);
		
		//Add to log
		$input = array(
               'electronicHealthRecord' =>  $_POST['ehr'],
               'editingUser' => $_POST['ObserverID'] ,
               'dateOfAction' => $now ,
			   'actionDescription' => "A Quantitative Observation has been successfully added to EHR#".$_POST['ehr']." by user#".$_POST['ObserverID']."."
            );

		$this->db->insert('Log', $input);
		
		
		$data['message'] = "Quantitative Observation has been successfully added to the EHR!";
		$this->load->view('home', $data);

		
		}
		else if($type == "Qualitative Observation"){
		
				$input = array(
               'ItemType' => $QUAL_OB ,
               'Author' => $_POST['ObserverID'] ,
               'CreationTime' => $now
            );
			
			$this->db->insert('Item', $input);
			
			$sql = "SELECT * FROM Item WHERE CreationTime = ?";
			$query = $this->db->query($sql, array($now));
			$row = $query->row_array();
			$id = $row['ID'];
			
			$input = array(
               'EHRID' => $_POST['ehr'] ,
               'Item' => $id
            );
			
			$this->db->insert('Electrionic_Health_Record_Items', $input);
			
						$checked = $_POST['med_area'];

			foreach($checked as $area) {
			
				$input = array(
				   'ItemID' => $id ,
				   'MedicalArea' => $area ,
				);
				
				$this->db->insert('Item_Medical_Areas', $input);
			}


			$input = array(
			   'ID' => $id,
               'Observer' => $_POST['ObserverID'] ,
               'ObservationTime' => $now ,
               'Description' => $_POST['Description']
            );

		$this->db->insert('Qualitative_Observation_Item', $input);
		
		//Add to log
		$input = array(
               'electronicHealthRecord' =>  $_POST['ehr'],
               'editingUser' => $_POST['ObserverID'] ,
               'dateOfAction' => $now ,
			   'actionDescription' => "A Qualitative Observation has been successfully added to EHR#".$_POST['ehr']." by user#".$_POST['ObserverID']."."
            );

		$this->db->insert('Log', $input);
		
		$data['message'] = "Qualitative Observation has been successfully added to the EHR!";
		$this->load->view('home', $data);
		
		}
		else if($type == "Diagnosis"){
						
			   $input = array(
               'ItemType' => $DIAGNOSIS ,
               'Author' => $_POST['ObserverID'] ,
               'CreationTime' => $now
            );
			
			$this->db->insert('Item', $input);
			
			$sql = "SELECT * FROM Item WHERE CreationTime = ?";
			$query = $this->db->query($sql, array($now));
			$row = $query->row_array();
			$id = $row['ID'];
			
			$input = array(
               'EHRID' => $_POST['ehr'] ,
               'Item' => $id
            );
			
			$this->db->insert('Electrionic_Health_Record_Items', $input);
			
			$checked = $_POST['med_area'];

			foreach($checked as $area) {
			
				$input = array(
				   'ItemID' => $id ,
				   'MedicalArea' => $area ,
				);
				
				$this->db->insert('Item_Medical_Areas', $input);
			}

			$input = array(
			   'ID' => $id,
               'Description' => $_POST['Description']
            );

		$this->db->insert('Diagnosis_Item', $input);
		
		//Add to log
		$input = array(
               'electronicHealthRecord' =>  $_POST['ehr'],
               'editingUser' => $_POST['ObserverID'] ,
               'dateOfAction' => $now ,
			   'actionDescription' => "A Diagnosis has been successfully added to EHR#".$_POST['ehr']." by user#".$_POST['ObserverID']."."
            );

		$this->db->insert('Log', $input);
		
		$data['message'] = "Diagnosis has been successfully added to the EHR!";
		$this->load->view('home', $data);
		
		}
		else if($type == "Treatment"){
		
				$input = array(
               'ItemType' => $TREATMENT ,
               'Author' => $_POST['ObserverID'] ,
               'CreationTime' => $now
            );
			
			$this->db->insert('Item', $input);
			
			$sql = "SELECT * FROM Item WHERE CreationTime = ?";
			$query = $this->db->query($sql, array($now));
			$row = $query->row_array();
			$id = $row['ID'];
			
			$input = array(
               'EHRID' => $_POST['ehr'] ,
               'Item' => $id
            );
			
			$this->db->insert('Electrionic_Health_Record_Items', $input);
			
			$checked = $_POST['med_area'];

			foreach($checked as $area) {
			
				$input = array(
				   'ItemID' => $id ,
				   'MedicalArea' => $area ,
				);
				
				$this->db->insert('Item_Medical_Areas', $input);
			}


			$input = array(
			   'ID' => $id,
			   'startDate' => $_POST['theDate'],
			   'endDate' => $_POST['theDate2'],
               'Description' => $_POST['Description']
            );

		$this->db->insert('Treatment_Item', $input);
		
		//Add to log
		$input = array(
               'electronicHealthRecord' =>  $_POST['ehr'],
               'editingUser' => $_POST['ObserverID'] ,
               'dateOfAction' => $now ,
			   'actionDescription' => "A Treatment has been successfully added to EHR#".$_POST['ehr']." by user#".$_POST['ObserverID']."."
            );

		$this->db->insert('Log', $input);
		
		$data['message'] = "Treatment has been successfully added to the EHR!";
		$this->load->view('home', $data);
		
		}
		
		else if($type == "Comment"){
						
			   $input = array(
               'ItemType' => $COMMENT ,
               'Author' => $_POST['ObserverID'] ,
               'CreationTime' => $now
            );
			
			$this->db->insert('Item', $input);
			
			$sql = "SELECT * FROM Item WHERE CreationTime = ?";
			$query = $this->db->query($sql, array($now));
			$row = $query->row_array();
			$id = $row['ID'];
			
			$input = array(
               'EHRID' => $_POST['ehr'] ,
               'Item' => $id
            );
			
			$this->db->insert('Electrionic_Health_Record_Items', $input);
			
			$checked = $_POST['med_area'];

			foreach($checked as $area) {
			
				$input = array(
				   'ItemID' => $id ,
				   'MedicalArea' => $area ,
				);
				
				$this->db->insert('Item_Medical_Areas', $input);
			}


			$input = array(
			   'ID' => $id,
               'Description' => $_POST['Description']
            );

		$this->db->insert('Comment_Item', $input);
		
		//Add to log
		$input = array(
               'electronicHealthRecord' =>  $_POST['ehr'],
               'editingUser' => $_POST['ObserverID'] ,
               'dateOfAction' => $now ,
			   'actionDescription' => "A Comment (independent) has been successfully added to EHR#".$_POST['ehr']." by user#".$_POST['ObserverID']."."
            );

		$this->db->insert('Log', $input);
		
		$data['message'] = "Comment has been successfully added to the EHR!";
		$this->load->view('home', $data);
		
		}
	}
	}
}

/* End of file manageEHR.php */
/* Location: ./system/application/controllers/manageEHR.php */