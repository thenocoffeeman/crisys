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
             <?
$top = 205;
$patient = $spatient->row(); 
if($patient->role == 3) $role = "Agent w/ Full";
else if	($patient->role == 2) $role = "Agent w/ Read & Comment";
else if ($patient->role == 1) $role = "Agent w/ Read";

$sql = "SELECT * FROM Role WHERE RoleName = ?";
$query = $this->db->query($sql, array($role));
$permission = $query->row();
		 

echo "<br/><br/><br/>";
echo "<b style='color:black'>::Functions::</b><br/>";

if($permission->BrowseAgents == 1){
//Manage Agents
echo "<form method='post' action='http://www.corpusvile.com/crisys/CI/index.php/manageagents/agent'>";
echo "<input type='hidden' name='ehr' value='".$patient->ID."'/>";
echo "<input type='submit' value='Agents' style='width:90px'/>";
echo "</form>";
$top += 21;
}

if($permission->ConcealItem == 1){
//Manage Concealments
echo "<form method='post' action='http://www.corpusvile.com/crisys/CI/index.php/managecomcealments/agent'>";
echo "<input type='hidden' name='ehr' value='".$patient->ID."'/>";
echo "<input type='submit' value='Concealments' style='width:90px'/>";
echo "</form>";
$top += 21;
}

if($permission->AddDoctorAsPrimary == 1){
//Manage Primary Clinician
echo "<form method='post' action='http://www.corpusvile.com/crisys/CI/index.php/manageprimaryclinician/agent'>";
echo "<input type='hidden' name='ehr' value='".$patient->ID."'/>";
echo "<input type='submit' value='Clinicians' style='width:90px'/>";
echo "</form>";
$top += 21;
}

if($permission->CancelReferral == 1){
//Manage Referrals
echo "<form method='post' action='http://www.corpusvile.com/crisys/CI/index.php/managereferrals/agent'>";
echo "<input type='hidden' name='ehr' value='".$patient->ID."'/>";
echo "<input type='submit' value='Referrals' style='width:90px'/>";
echo "</form>";
$top += 21;
}

if($permission->AddCommentItem == 1){
//Add Comment
echo "<form method='post' action='http://www.corpusvile.com/crisys/CI/index.php/manageEHR/additem'>";
echo "<input type='hidden' name='ehr' value='".$patient->ID."'/>";
echo "<input type='hidden' name='agent' value='".$role."'/>";
echo "<input type='hidden' name='name' value='".$patient->FirstName." ".$patient->LastName."'/>";
echo "<input type='submit' value='Add Item' style='width:90px'/>";
echo "</form>";
$top += 21;
}

if($permission->SearchItemsInEHR == 1){
//Search EHR?>
<button value="Search" style="width: 90px; font-size:10px" onclick="openmenu('search')">Search</button>
<?
}
?>

 <div id="search" style="top:<?=$top?>px; left:100px;">
             <center>

             <form action="http://www.corpusvile.com/crisys/CI/index.php/manageEHR/EHRsearch" method="post">
            
            <input type="text" name="query"/> 
            <input type="hidden" name="searchme" value="<?=$patient->ID?>" />
            <SELECT name="search_option">
            	<OPTION value="author">By Author</OPTION>
                <OPTION value="itemtype">By Item Type</OPTION>
                <OPTION value="medicalarea">By Medical Area</OPTION>
            </SELECT>
            <input type="submit" value="Search <?=$patient->FirstName?> <?=$patient->LastName?>'s EHR"/>
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
        <p>
       	<h2>Sponsored Patient Information</h2><br />
      
        Information for: <?=$patient->FirstName?> <?=$patient->LastName?><br />
		EHR ID: <?=$patient->ID?><br />
		Your Access Level: 
		<? 
			if($patient->role == 1) echo "Read";
			else if($patient->role == 2) echo "Read/Comment";
			else if($patient->role == 3) echo "Full";
		
		?>
        <br />
		<h3>EHR Records:</h3>

        <?php 
		if($ehr->result() == null){
			echo "There are no items in this EHR!";
		}
		else{	
			echo "<table><tr><td>Item Type</td><td>Created On</td><td>Author</td><td>View Details</td><td>Concealment</td></tr>";
			foreach($ehr->result() as $row):
			
			$display = true;
			
			$sql = "SELECT * FROM Comment_Item WHERE ID = ?";
			$test = $this->db->query($sql, array($row->ID));
			$testrow = $test->row();
			if($testrow->commentedItem != null) $display=false;
			if($display){
			 ?>
        
              	<tr>
                
                <? $concealed = false;
					
					$sql = "SELECT * FROM Concealed_Item WHERE item = ?";
					$query = $this->db->query($sql, array($row->ID));
					foreach($query->result() as $block){
						if($block->blockedUser == $_SESSION['uid']){
							$concealed = true;
							$break;
						}
                	}
                	
					if(!$concealed){ ?>
                
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
                    <input type="hidden" name="ehr" value="<?=$row->EHRID?>"/>
                    <input type="hidden" name="itemtype" value="<?=$row->ItemType?>"/>
                    <input type="hidden" name="itemid" value="<?=$row->ID?>"/>
                    <input type="hidden" name="date" value="<?=$row->CreationTime?>"/>
                    <input type="hidden" name="author" value="<?=$author_name?>"/>
                    <input type="submit" value="Details"/>
                    </form>
                    </td>
                    <td>
                    <? if($patient->role == 3){?>
                    <form action="http://www.corpusvile.com/crisys/CI/index.php/manageitems/concealitem" method="post">
                    <input type="hidden" name="ehr" value="<?=$row->EHRID?>"/>
                    <input type="hidden" name="itemid" value="<?=$row->ID?>"/>
                    <input type="submit" value="Conceal"/>
                    <? }else{ ?>
                    Access Denied
                    <? } ?>
                    </form>
                    </td>
                </tr>

            <?php }} endforeach; 
			echo "</table>";
		}?>
        
        <br />
<br />

        

       
          </p>
        </div>
          
          
          
         
          <div id="footer"><div><div>
          
              Powered by <a href="http://www.corpusvile.com/crisys">CRISYS</a>
          </div></div></div><!-- end footer -->
      </div><!-- end body -->
  </div><!-- end wrapper -->
</body>
</html>
