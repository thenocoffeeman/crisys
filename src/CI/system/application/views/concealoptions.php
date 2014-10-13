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
        <h2>Concealment Options</h2>
		<br/>

        Please select all users that you want to conceal item #<?=$item?> from:<br />
       	<form method="post" action="http://www.corpusvile.com/crisys/CI/index.php/managecomcealments/addconceal">
        <input type="hidden" name="item" value="<?=$item?>"/>
       	<?php 
        if($agents->result() == null && $clinicians->result() == null){
			echo "You have no one to conceal items from!";
		}
		else{
		
		echo "<table>";
		foreach($clinicians->result() as $row): 
		
				$sql = "SELECT * FROM User WHERE ID = ?";
				$query = $this->db->query($sql, array($row->clinician));
				$row2 = $query->row();
				
				$sql3 = "SELECT * FROM Concealed_Item WHERE item = ? AND blockedUser = ?";
				$query3 = $this->db->query($sql3, array($item, $row->clinician));
				
				if($row->clinician != $author && $query3->result() == null){
		?>

        	<tr><td style="border:none"><input type="checkbox" name="conceal[]" value="<?=$row->clinician?>"/> <?=$row2->FirstName?> <?=$row2->LastName?></td></tr>
		
		<?php } endforeach; 
        foreach($agents->result() as $row): 
		
				$sql = "SELECT * FROM User WHERE ID = ?";
				$query = $this->db->query($sql, array($row->agent));
				$row2 = $query->row();
				
				$sql3 = "SELECT * FROM Concealed_Item WHERE item = ? AND blockedUser = ?";
				$query3 = $this->db->query($sql3, array($item, $row->agent));
				
				if($row->agent != $author && $query3->result() == null){
		?>

        	<tr><td style="border:none"><input type="checkbox" name="conceal[]" value="<?=$row->agent?>"/> <?=$row2->FirstName?> <?=$row2->LastName?></td></tr>
		
		<?php } endforeach; 
		}
		?>
        </table>
        <br />

        <input type="submit" value="Submit Concealments" />
        </form>

          
          </p>
        </div>
          
          
          
         
          <div id="footer"><div><div>
          
              Powered by <a href="http://www.corpusvile.com/crisys">CRISYS</a>
          </div></div></div><!-- end footer -->
      </div><!-- end body -->
  </div><!-- end wrapper -->
</body>
</html>
