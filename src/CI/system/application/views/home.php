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
<? session_start();?>
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
        <?php 
			$sql = "SELECT * FROM User WHERE id = ?";

			$query = $this->db->query($sql, array($_SESSION['uid'])); 
			$row = $query->row_array();
		?>
                   
        <h2>Welcome, <?=$row['FirstName'];?> <?=$row['LastName'];?>!</h2>
        <br />
		<br />
        
        
        <?php
        //user is a patient
        if($_SESSION['p']==true){?>
        Your Electronic Health Record ID: 
         <?php
		
			$sql = "SELECT ElectronicHealthRecord FROM Patient WHERE id = ?";

			$query = $this->db->query($sql, array($_SESSION['uid'])); 
			$row = $query->row_array();
			$ehrID = $row['ElectronicHealthRecord'];
			echo $ehrID
			?>
        <br />
		Your primary clinician is: 
        <?php
		
			$sql = "SELECT PrimaryDoctor FROM Primary_Doctor WHERE electronicHealthRecord = ?";

			$query = $this->db->query($sql, array($ehrID)); 
			$row = $query->row_array();
			
			if($row == null){
				echo "None";
			}
			else{
				$docID = $row['PrimaryDoctor'];
				
				$sql = "SELECT * FROM User WHERE Id = ?";
				$query = $this->db->query($sql, array($docID)); 
				$row = $query->row_array();
				echo $row['FirstName']." ".$row['LastName'];
			}?>
			<br />
			<br />
			<br />
			<h1>Patient Quick Functions</h1>
			
			<?php
			$sql = "SELECT * FROM Role WHERE RoleName = ?";

            $query = $this->db->query($sql, array("Patient")); 
            $row = $query->row_array();

			if($row['SearchItemsInEHR'] == 1 && $row['BrowseItemsInEHR'] == 1){
			
			?>
			
			<form action="http://www.corpusvile.com/crisys/CI/index.php/manageEHR/EHRsearch" method="post">
            
            <input type="text" name="query"/> 
            <input type="hidden" name="searchme" value="<?=$_SESSION['uid']?>" />
            <SELECT name="search_option">
            	<OPTION value="author">By Author</OPTION>
                <OPTION value="itemtype">By Item Type</OPTION>
                <OPTION value="medicalarea">By Medical Area</OPTION>
            </SELECT>
            <input type="submit" value="Search My EHR"/>
            </form>
            <a href="http://www.corpusvile.com/crisys/CI/index.php/manageEHR/browseEHR">Browse My EHR</a>
			
			<? } ?>
			
		<? }

        //user is a clinician
        if($_SESSION['c']==true){?>    
        
        			<br />
			<br />
			<br />
			<h1>Clinician Quick Functions</h1>

			<form action="http://www.corpusvile.com/crisys/CI/index.php/managepatients/patientsearch" method="post"><input type="text" name="query" /> <input type="submit" value="Search My Patients"/></form>
            <a href="http://www.corpusvile.com/crisys/CI/index.php/managepatients/browsepatients">Browse My Patients</a>
			 
            
            <? } ?> 
            
            <br /><br />
            <hr />
            Messages:<br /><br />

            <? if($message == null || $message == "" || $message==" "){echo "No new messages..";}else{echo $message;}?>
            
            
          
          </p>
        </div>
          
          
          
         
          <div id="footer"><div><div>
          
              Powered by <a href="http://www.corpusvile.com/crisys">CRISYS</a>
          </div></div></div><!-- end footer -->
      </div><!-- end body -->
  </div><!-- end wrapper -->
</body>
</html>
