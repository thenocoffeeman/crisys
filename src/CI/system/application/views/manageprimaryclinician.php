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
	
	function validate(form)
	{
		with(form)
		{
			if(confirm.checked){
				return true;
			}
			else{
				alert("You must read and select the confirmation before completing this action!");
				return false;
			}
		}
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
       	<h2>Manage Clinicians for <?=$name?></h2>
        <br />
        <?php 
		if($primary == "none"){
			echo "You currently have no primary clinician. Please appoint a clinician as your primary clinician.<br/><br/>";
			
			
			$sql = "SELECT * FROM User U, Clinician C WHERE U.ID = C.ID and U.ID <> ?";

			$query = $this->db->query($sql, array($user)); 
			echo "<form method='post' action='http://www.corpusvile.com/crisys/CI/index.php/manageprimaryclinician/addprimary' onsubmit='return validate(this)'>";	
			echo "Available Clinicians: ";		
			echo "<SELECT name='doc'>"	;
 			foreach($query->result() as $row):
				echo "<OPTION value='".$row->ID."'>".$row->FirstName." ".$row->LastName."</OPTION>";	
			endforeach; 
			echo "</SELECT>";
			echo "<br/><br/>";
			echo "<input type='radio' name='confirm'/> ";
			echo "By checking here I aknowledge that I am setting the above clinician as my primary clinician and therefore grant him full access to my information.";
			echo "<br/><br/>";
			echo "<input type='hidden' name='user' value='".$user."'/>";
			echo "<input type='submit' value='Set Primary Clinician'/>";
			echo "</form>";
			
			
			
		}
		else{	
			foreach($primary->result() as $row): ?>
            
            Your primary clinician is: <?=$row->FirstName?> <?=$row->LastName?><br />
            
            <?php endforeach; ?>
		
        
        Use the form below to remove this clinician as your primary clinician.<br />
        <br />

        <form action="http://www.corpusvile.com/crisys/CI/index.php/manageprimaryclinician/removeprimary" method="post" onsubmit="return validate(this)">
        <input type="radio" name="confirm" /> I am aware that by clicking the button below I will remove <?=$row->FirstName?> <?=$row->LastName?> as my primary clinician.
        <br /><br />
        <input type='hidden' name='user' value='<?=$user?>'/>
        <input type="submit" value="Remove Primary Clinician" />
        
        </form>
        
        <? } ?>
        
        <hr/>
        
        <h3>Other Treating Clinicians:</h3>
        
        <?
		if($other_clinicians->result() == null){
			echo "There are no other clinicians that have consent to treat you.";
		}
		else{
			echo "<table>";
			foreach($other_clinicians->result() as $row){
				$sql = "SELECT * FROM User WHERE Id = ?";
				$query = $this->db->query($sql, array($row->clinician)); 
				$row2 = $query->row();
				
				echo "<tr><td style='border:none'>".$row2->FirstName." ".$row2->LastName;
				echo "</td><td style='border:none'><form method='post' action='http://www.corpusvile.com/crisys/CI/index.php/manageprimaryclinician/removeconsent'>";
				echo "<input type='hidden' name='remove' value='".$row2->ID."'/>";
				echo "<input type='hidden' name='user' value='".$user."'/>";
				echo "<input type='submit' value='Revoke Consent'/>";
				echo "</form></td></tr>";
				
			}
			echo "</table>";
		}
		
		
		
		?>
        
        <hr/>
		<h3>Grant Consent To Treatment:</h3>
        <?
				$sql = "SELECT * FROM Clinician C, User U WHERE C.ID = U.ID AND C.ID <> ?";
				$query = $this->db->query($sql, array($user));
				
				echo "<form method='post' action='http://www.corpusvile.com/crisys/CI/index.php/manageprimaryclinician/grantconsent'>";
				echo "<SELECT name='add'>";
				foreach($query->result() as $row){
					$sql = "SELECT * FROM Treating_Clinicians T WHERE T.clinician = ? AND T.electronicHealthRecord = ?";
					$query2 = $this->db->query($sql, array($row->ID, $user));
					
					if($query2->result() == null){
						echo "<OPTION value='".$row->ID."'>".$row->FirstName." ".$row->LastName."</OPTION>";
					}
				} 
				echo "</SELECT>";
				echo "<input type='hidden' name='user' value='".$user."'/>";
				echo "<input type='submit' value='Grant Consent'/></form>";
		?>
		
          
          </p>
        </div>
          
          
          
         
          <div id="footer"><div><div>
          
              Powered by <a href="http://www.corpusvile.com/crisys">CRISYS</a>
          </div></div></div><!-- end footer -->
      </div><!-- end body -->
  </div><!-- end wrapper -->
</body>
</html>
