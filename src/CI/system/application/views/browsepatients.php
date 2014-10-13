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
        
        <h2>Browse <? echo $_SESSION['user'] ?>'s Patients</h2>
		<br/>
		<?php 
		if($patients->result() == null){
			echo "You currently have no patients!";
		}
		else{	
			echo "<table>";
			echo "<tr><td>Name</td><td>Username</td><td>Action</td><td>Primary</td></tr>";
			foreach($patients->result() as $row): 
			
			$sql = "SELECT * FROM Primary_Doctor WHERE electronicHealthRecord = ?";
			$query = $this->db->query($sql, array($row->ID));
			$trow = $query->row();
			if($trow->primaryDoctor == $_SESSION['uid']){
				$primary = "Yes";
				$color = "Green";
			}
			else{
				$primary = "No";
				$color = "Red";
			}
			
			?>
            <form action="http://www.corpusvile.com/crisys/CI/index.php/manageEHR/viewehr" method="post">
            <tr><td><?=$row->FirstName?> <?=$row->LastName?></td><td><?=$row->Username?></td><td><input type="hidden" name="id" value="<?=$row->ID?>" /><input type="submit" value="View EHR"/></td><td style="color:<?=$color?>"><?=$primary?></td>
            </form>
           </tr>
            
            
            <?php endforeach; 
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
