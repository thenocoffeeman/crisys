<?php

class Manageitems extends Controller {

	function Manageitems()
	{
		parent::Controller();	
	}
	
	function index()
	{

	}

	function itemdetails()
	{	
			session_start(); 
			if($_SESSION['loggedin'] == true){
				
				$ehr = $_POST['ehr'];
				$type = $_POST['itemtype'];
				$itemid = $_POST['itemid'];
				$date = $_POST['date'];
				$author = $_POST['author'];
				
				if($type == 1){
					$data['title'] = "<h3>Qualititative Observation</h3>";
					
					$query = $this->db->get_where('Qualitative_Observation_Item', array('ID' => $itemid));
					foreach ($query->result() as $row){
					$data['body'] = "Item ID: ";
					$data['body'] .= $row->ID."<br/>";
					$data['body'] .= "Observer: ";
					$data['body'] .= $author."<br/>";
					$data['body'] .= "Description: ";
					$data['body'] .= $row->Description."<br/>";
					$data['body'] .= "Created On: ";
					$data['body'] .= $date."<br/>";
					
					
					$data['body'] .= "<br/>Listed Medical Areas:<br/>";
					$sql = "SELECT * FROM Item_Medical_Areas I, Medical_Areas A WHERE I.ItemID = ? AND I.MedicalArea = A.ID";
					$query2 = $this->db->query($sql, array($itemid));
					$data['body'] .= "<ul>";
						foreach ($query2->result() as $row2){
							$data['body'] .= "<li>".$row2->Description."</li>";
						}
					$data['body'] .= "</ul>";
					if($_SESSION['uid'] != $ehr){
					$data['body'] .= "<br/><br/>";
					
					
					}
					}
				}
				
				else if($type == 2){
					$data['title'] = "<h3>Diagnosis</h3>";
					
					$query = $this->db->get_where('Diagnosis_Item', array('ID' => $itemid));
					foreach ($query->result() as $row){
					$data['body'] = "Item ID: ";
					$data['body'] .= $row->ID."<br/>";
					$data['body'] .= "Observer: ";
					$data['body'] .= $author."<br/>";
					$data['body'] .= "Description: ";
					$data['body'] .= $row->description."<br/>";
					$data['body'] .= "Created On: ";
					$data['body'] .= $date."<br/>";
					
					$data['body'] .= "<br/>Listed Medical Areas:<br/>";
					$sql = "SELECT * FROM Item_Medical_Areas I, Medical_Areas A WHERE I.ItemID = ? AND I.MedicalArea = A.ID";
					$query2 = $this->db->query($sql, array($itemid));
					$data['body'] .= "<ul>";
						foreach ($query2->result() as $row2){
							$data['body'] .= "<li>".$row2->Description."</li>";
						}
					$data['body'] .= "</ul>";

					}
					
				}
				else if($type == 3){
					$data['title'] = "<h3>Treatment</h3>";
					
					$query = $this->db->get_where('Treatment_Item', array('ID' => $itemid));
					foreach ($query->result() as $row){
					$data['body'] = "Item ID: ";
					$data['body'] .= $row->ID."<br/>";
					$data['body'] .= "Observer: ";
					$data['body'] .= $author."<br/>";
					$data['body'] .= "Start Date: ";
					$data['body'] .= $row->startDate."<br/>";
					$data['body'] .= "End Date: ";
					$data['body'] .= $row->endDate."<br/>";
					$data['body'] .= "Description: ";
					$data['body'] .= $row->description."<br/>";
					$data['body'] .= "Created On: ";
					$data['body'] .= $date."<br/>";
					
					$data['body'] .= "<br/>Listed Medical Areas:<br/>";
					$sql = "SELECT * FROM Item_Medical_Areas I, Medical_Areas A WHERE I.ItemID = ? AND I.MedicalArea = A.ID";
					$query2 = $this->db->query($sql, array($itemid));
					$data['body'] .= "<ul>";
						foreach ($query2->result() as $row2){
							$data['body'] .= "<li>".$row2->Description."</li>";
						}
					$data['body'] .= "</ul>";
					

					}
					
				}
				else if($type == 4){
					$data['title'] = "<h3>Comment</h3>";
					
					$query = $this->db->get_where('Comment_Item', array('ID' => $itemid));
					foreach ($query->result() as $row){
					$data['body'] = "Item ID: ";
					$data['body'] .= $row->ID."<br/>";
					$data['body'] .= "Observer: ";
					$data['body'] .= $author."<br/>";
					$data['body'] .= "Description: ";
					$data['body'] .= $row->description."<br/>";
					$data['body'] .= "Created On: ";
					$data['body'] .= $date."<br/>";
					
					$data['body'] .= "<br/>Listed Medical Areas:<br/>";
					$sql = "SELECT * FROM Item_Medical_Areas I, Medical_Areas A WHERE I.ItemID = ? AND I.MedicalArea = A.ID";
					$query2 = $this->db->query($sql, array($itemid));
					$data['body'] .= "<ul>";
						foreach ($query2->result() as $row2){
							$data['body'] .= "<li>".$row2->Description."</li>";
						}
					$data['body'] .= "</ul>";

					}
					
				}
				else if($type == 5){
				
					$data['title'] = "<h3>Quantitative Observation</h3>";
					$query = $this->db->get_where('Quantitative_Observation_Item', array('ID' => $itemid));
					foreach ($query->result() as $row){
					$query2 = $this->db->get_where('Observed_Quantitity_Type', array('ID' => $row->ObservedQuantity));
					foreach ($query2->result() as $row2){
					$ObservedQuantity = $row2->Description;
					}
					$data['body'] = "Item ID: ";
					$data['body'] .= $row->ID."<br/>";
					$data['body'] .= "Observer: ";
					$data['body'] .= $author."<br/>";
					$data['body'] .= "Observed Quantity: ";
					$data['body'] .= $ObservedQuantity."<br/>";
					$data['body'] .= "Value: ";
					$data['body'] .= $row->Value."<br/>";
					$data['body'] .= "Unit: ";
					$data['body'] .= $row->Unit."<br/>";
					$data['body'] .= "Created On: ";
					$data['body'] .= $date."<br/>";
					
					$data['body'] .= "<br/>Listed Medical Areas:<br/>";
					$sql = "SELECT * FROM Item_Medical_Areas I, Medical_Areas A WHERE I.ItemID = ? AND I.MedicalArea = A.ID";
					$query2 = $this->db->query($sql, array($itemid));
					$data['body'] .= "<ul>";
						foreach ($query2->result() as $row2){
							$data['body'] .= "<li>".$row2->Description."</li>";
						}
					$data['body'] .= "</ul>";

					}
				}
				
					$data['body'] .= "<br /><br/>";
					$data['body'] .= "<h3>Comments:</h3>";
					$sql = "SELECT * FROM Comment_Item WHERE commentedItem = ? ORDER BY ID DESC";
					$query = $this->db->query($sql, array($row->ID));
					if($query->result() == null){
						$data['body'] .= "This item has no comments.";
					}
					else{
						foreach ($query->result() as $row){
							$data['body'] .= $row->description;
							$query = $this->db->get_where('Item', array('ID' => $row->ID));
							$author_row = $query->row();
							$query = $this->db->get_where('User', array('ID' => $author_row->Author));
							$name_row = $query->row();
							$commenter = $name_row->FirstName." ".$name_row->LastName;
							$data['body'] .= "<br/><i>Written by: ".$commenter."</i> at ".$author_row->CreationTime."<br/><br/>";
						}
					}
				
					$data['body'] .= "<br /><hr/><br/>";
					$data['body'] .= "<form action='http://www.corpusvile.com/crisys/CI/index.php/manageitems/addcomment' method='post'>";
					$data['body'] .= "<input type='hidden' name='itemid' value='".$itemid."'/><input type='hidden' name='ehr' value='".$ehr."'/><input type='hidden' name='date' value='".$date."'/>";
					$data['body'] .= "<textarea name='comment' rows=4 cols=30></textarea><br/>";
					
					
					$sql = "SELECT * FROM Appointed_Agents WHERE agent = ? AND electronicHealthRecord = ?";
					$query = $this->db->query($sql, array($_SESSION['uid'], $ehr));
					
					$access = $query->row();
					if($access->role !=null && $access->role < 2){
						$data['body'] .= "You do not have access to comment.";
					}
					else{
						$data['body'] .= "<input type='submit' value='Add Comment'/></form>";
					}
				
				$this->load->view('displayitem', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	
	}
	
	function addcomment()
	{
	 		include("global_variables.php");
			session_start();
			$gotdate = getdate();
		
			$now = $gotdate['year']."-".$gotdate['mon']."-".$gotdate['mday']." ".$gotdate['hours'].":".$gotdate['minutes'].":".$gotdate['seconds'];
			   
			   
			   $input = array(
               'ItemType' => $COMMENT ,
               'Author' => $_SESSION['uid'] ,
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


			$input = array(
			   'ID' => $id,
               'Description' => $_POST['comment'],
			   'commentedItem' => $_POST['itemid']
            );

			$this->db->insert('Comment_Item', $input);
		
			//Add to log
			$input = array(
				   'electronicHealthRecord' =>  $_POST['ehr'],
				   'editingUser' => $_SESSION['uid'] ,
				   'dateOfAction' => $now ,
				   'actionDescription' => "A Comment (independent) has been successfully added to EHR#".$_POST['ehr']." by user#".$_SESSION['uid']."."
				);
	
			$this->db->insert('Log', $input);
		
			$data['message'] = "Comment has been successfully added to the item!";
			$this->load->view('home', $data);
	}
	
	function concealitem()
	{
			session_start(); 
			if($_SESSION['loggedin'] == true){
			
				$ehr = $_POST['ehr'];
				$data['item'] = $_POST['itemid'];
				
				$sql = "SELECT * FROM Item WHERE ID = ?";
				$query = $this->db->query($sql, array($_POST['itemid']));
				$author_row = $query->row();
				$data['author'] = $author_row->Author;
				
				$sql = "SELECT * FROM Treating_Clinicians WHERE electronicHealthRecord = ?";
				$data['clinicians'] = $this->db->query($sql, array($ehr));
				
				$sql = "SELECT * FROM Appointed_Agents WHERE electronicHealthRecord = ?";
				$data['agents'] = $this->db->query($sql, array($ehr));
				
				$this->load->view('concealoptions', $data);
			}
			else{
				$this->load->view('mustbeloggedin');
			}
	}
}

/* End of file manageitems.php */
/* Location: ./system/application/controllers/manageitems.php */