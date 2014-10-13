<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CRISYS Electronic Health Records System</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="http://www.corpusvile.com/crisys/build/style.css" rel="stylesheet" type="text/css" />
    
    <script type="text/javascript">
	function openmenu(id)
	{
		ddmenuitem = document.getElementById(id);
		ddmenuitem.style.visibility = 'visible';
	
	}
	
	function closemenu(id)
	{
		ddmenuitem = document.getElementById(id);
		ddmenuitem.style.visibility = 'hidden';
	}
	</script>
</head>

<body>
  <div id="wrapper">
      <div id="header">
          <div class="tr"><div class="br"><div class="bl">
              <h1><img src="http://www.corpusvile.com/crisys/build/images/head.png"/></h1>
              <ul id="nav-top">
                  <li><a href="http://www.corpusvile.com/crisys">Information</a>  &nbsp;&nbsp;|&nbsp;&nbsp;</li>
                  <li><a href="mailto:jc.farrell@hotmail.com?subject=crisys">Support</a> &nbsp;&nbsp;|&nbsp;&nbsp;</li>
                  <li><a href="http://www.corpusvile.com/crisys/CI/index.php/logout">Logout</a> &nbsp;&nbsp;||&nbsp;&nbsp;</li>
                  <li>Permissions:</a></li>
                 <?php include 'permissions.php';?>
              </ul><!-- end top-nav -->
              <ul id="nav-left">
                  
              </ul>
          </div></div></div><!-- end .corners -->
          <div id="side_nav">
          
<? foreach($patient->result() as $row):
        $fname = $row->FirstName;
		$lname = $row->LastName;
		$id = $row->ID;
 endforeach; ?>
             
                  <div id="options">
          <b style="color:#000000; font-weight:bold; size:18px;">&nbsp;&nbsp;::Functions::</b>
          <br />

          <button value="Search" style="width: 75px; font-size:10px" onclick="openmenu('search')">Search</button>

          <form action="http://www.corpusvile.com/crisys/CI/index.php/manageEHR/additem" method="post">
          <input type="hidden" name="ehr" value="<?=$id?>"/>
          <input type="hidden" name="name" value="<?=$fname?> <?=$lname?>"/>
          <input type="submit" value="Add Item" style="width: 75px" />
          </form>
          
          </div>
             
             <div id="search">
             <center>

             <form action="http://www.corpusvile.com/crisys/CI/index.php/manageEHR/EHRsearch" method="post">
            
            <input type="text" name="query"/> 
            <input type="hidden" name="searchme" value="<?=$id?>" />
            <input type="hidden" name="clinicianviewing" value="true"/>
            <SELECT name="search_option">
            	<OPTION value="author">By Author</OPTION>
                <OPTION value="itemtype">By Item Type</OPTION>
                <OPTION value="medicalarea">By Medical Area</OPTION>
            </SELECT>
            <input type="submit" value="Search <?=$fname?> <?=$lname?>'s EHR"/>
            </form><br />
            <br />
			<b style="color:#000000;">[<a href="#" onclick="closemenu('search')" style="color:#000000;">click to close</a>]</b>
            </center>
             </div>
                
                <div id="sidebar_info">
				You are currently logged in as:<br />
				<b><?php echo $_SESSION['user'];?></b><br />
<br />
<a href="http://www.corpusvile.com/crisys/CI/index.php/logout">Click here</a> to log out.<br />
                </div>
          </div>
          
      </div><!-- end header -->
      <div id="body_main"><div id="cap_main"></div>
          

          
          
          
          <!-- end left -->
          
        <div id="main">
        <h2>Details for <?=$fname?> <?=$lname?>'s EHR, EHR#<?=$id?></h2>
		<br/>
		<?php 
		if($items->result() == null){
			echo "There are currently no items in ".$fname."'s EHR!";
		}
		else if($primary){	
			echo "<table><tr><td>Item Type</td><td>Created On</td><td>Author</td><td>View Details</td></tr>";
			foreach($items->result() as $row): ?>

                	<? 
					$concealed = false;
					
					$sql = "SELECT * FROM Concealed_Item WHERE item = ?";
					$query = $this->db->query($sql, array($row->ID));
					foreach($query->result() as $block){
						if($block->blockedUser == $_SESSION['uid']){
							$concealed = true;
							$break;
						}
                	}
                	
					if(!$concealed){ 
					
					 $display = true;
			
					$sql = "SELECT * FROM Comment_Item WHERE ID = ?";
					$test = $this->db->query($sql, array($row->ID));
					$testrow = $test->row();
					if($testrow->commentedItem != null) $display=false;
					if($display){
					
					
					?>
                    <tr>
					<? $sql = "SELECT Description FROM Item_Types WHERE ID = ?";
					$query = $this->db->query($sql, array($row->ItemType));
					$row2 = $query->row_array();
					$description = $row2['Description']; ?>
                	<td><?=$description?></td>
                    <td><?=$row->CreationTime?></td>
                	<? $sql = "SELECT * FROM User WHERE ID = ?";
					$query = $this->db->query($sql, array($row->Author));
					$row3 = $query->row_array();
					$author_name = $row3['FirstName']." ".$row3['LastName']; ?>
                    <td><?=$author_name?></td>
                    <td>
                    <form action="http://www.corpusvile.com/crisys/CI/index.php/manageitems/itemdetails" method="post">
                    <input type="hidden" name="ehr" value="<?=$id?>"/>
                    <input type="hidden" name="itemtype" value="<?=$row->ItemType?>"/>
                    <input type="hidden" name="itemid" value="<?=$row->ID?>"/>
                    <input type="hidden" name="date" value="<?=$row->CreationTime?>"/>
                    <input type="hidden" name="author" value="<?=$author_name?>"/>
                    <input type="submit" value="Details"/>
                    </form>
                    </td>
                </tr>
                

            <?php } }endforeach; 
			echo "</table>";
			}
			else{
			echo "<table><tr><td>Item Type</td><td>Created On</td><td>Author</td><td>View Details</td></tr>";
			foreach($items->result() as $row): ?>

                	<? 
					$concealed = false;
					
					$sql = "SELECT * FROM Concealed_Item WHERE item = ?";
					$query = $this->db->query($sql, array($row->ID));
					foreach($query->result() as $block){
						if($block->blockedUser == $_SESSION['uid']){
							$concealed = true;
							$break;
						}
                	}
                	
					if(!$concealed){ 
					
					 $display = true;
			
					$sql = "SELECT * FROM Comment_Item WHERE ID = ?";
					$test = $this->db->query($sql, array($row->ID));
					$testrow = $test->row();
					if($testrow->commentedItem != null) $display=false;
					if($display){
					
					 $goodarea = false;
					 
					$sql = "SELECT * FROM Item_Medical_Areas WHERE ItemID = ?";
					$test = $this->db->query($sql, array($row->ID));
					$sql2 = "SELECT * FROM Clinician_Medical_Areas WHERE Clinician = ?";
					$test2 = $this->db->query($sql2, array($_SESSION['uid']));
					foreach($test->result() as $trow){
						foreach($test2->result() as $trow2){
							if($trow2->MedicalArea ==  $trow->MedicalArea){
								$goodarea = true;
							}
						}
					}
					
					if($goodarea){
					
					
					?>
                    <tr>
					<? $sql = "SELECT Description FROM Item_Types WHERE ID = ?";
					$query = $this->db->query($sql, array($row->ItemType));
					$row2 = $query->row_array();
					$description = $row2['Description']; ?>
                	<td><?=$description?></td>
                    <td><?=$row->CreationTime?></td>
                	<? $sql = "SELECT * FROM User WHERE ID = ?";
					$query = $this->db->query($sql, array($row->Author));
					$row3 = $query->row_array();
					$author_name = $row3['FirstName']." ".$row3['LastName']; ?>
                    <td><?=$author_name?></td>
                    <td>
                    <form action="http://www.corpusvile.com/crisys/CI/index.php/manageitems/itemdetails" method="post">
                    <input type="hidden" name="ehr" value="<?=$id?>"/>
                    <input type="hidden" name="itemtype" value="<?=$row->ItemType?>"/>
                    <input type="hidden" name="itemid" value="<?=$row->ID?>"/>
                    <input type="hidden" name="date" value="<?=$row->CreationTime?>"/>
                    <input type="hidden" name="author" value="<?=$author_name?>"/>
                    <input type="submit" value="Details"/>
                    </form>
                    </td>
                </tr>
                

            <?php } } }endforeach; 
			echo "</table>";
			
		}?>
         

          
          </p>
        </div>
          
          
          
         
          <div id="footer"><div><div>
          
              Powered by <a href="http://www.corpusvile.com/crisys">CRISYS</a>
          </div></div></div><!-- end footer -->
      </div><!-- end body -->
  </div><!-- end wrapper -->
</body>
</html>
