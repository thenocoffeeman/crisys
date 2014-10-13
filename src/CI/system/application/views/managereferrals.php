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
        <p>
       	 <h2>Manage Referrals for <?=$name?></h2>
         <br/>
         This page will display a listing of all current and past referrals made for you.<br/>
         To cancel a referral simply click the "Cancel Referral" button for the desired referral.
         <br/>
         <br/>
    	 <h3>Referrals:</h3>
         <?php 
		if($referrals->result() == null){
			echo "You currently have no referrals!";
		}
		else{	
			echo "<table><tr><td>Referring Clinician</td><td>Referred Clinician</td><td>Created On</td><td>Action</td></tr>";
			foreach($referrals->result() as $row): ?>
            <tr>
            
            	<?
				$sql = "SELECT * FROM User WHERE ID = ?";
				$referer = $this->db->query($sql, array($row->referringClinician));
				$row2 = $referer->row();
				$sql = "SELECT * FROM User WHERE ID = ?";
				$refered = $this->db->query($sql, array($row->referredClinician));
				$row3 = $refered->row();
				?>
                
            <td><?=$row2->FirstName?> <?=$row2->LastName?></td>
            <td><?=$row3->FirstName?> <?=$row3->LastName?></td>
            <td><?=$row->creationTime?></td>

            <form action="http://www.corpusvile.com/crisys/CI/index.php/managereferrals/cancelreferral" method="post">
            <td><input type="hidden" name="referral_id" value="<?=$row->ID?>" />
            <input type="submit" value="Cancel Referral"/></td>
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
