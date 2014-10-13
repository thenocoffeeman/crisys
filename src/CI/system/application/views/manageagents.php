<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CRISYS Electronic Health Records System</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="http://www.corpusvile.com/crisys/build/style.css" rel="stylesheet" type="text/css" />
    
    <script src="http://www.corpusvile.com/crisys/CI/javascript/prototype.js" type="text/javascript"></script>
	<script src="http://www.corpusvile.com/crisys/CI/javascript/effects.js" type="text/javascript"></script>
    <script src="http://www.corpusvile.com/crisys/CI/javascript/control.js" type="text/javascript"></script>
    <script type="text/javascript">
	function f(form) {
		inline_results(form);
		return false;	
	}
	
	function inline_results(form) { 
		with(form){
			var meth = method.value;
			var s = searchme.value;
			var u = user.value;
		}
	
		new Ajax.Updater ('results', 'http://www.corpusvile.com/crisys/CI/index.php/manageagents/findagent', {method:'post', postBody:'method='+meth+'&search='+s+'&user='+u});
		new Effect.Appear('results');



	}
	
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
       	<h2>Manage Agents for <?=$name?></h2>
        <br/>
        <?
						
		if ($clinicianviewing != null && $clinicianviewing == true){
			$access = false;
			$sql = "SELECT AppointAgent FROM Role WHERE RoleName = ?";
			$query = $this->db->query($sql, array("Clinician")); 
            $arow = $query->row_array();
			foreach($arow as $attr):
					if($attr == 1){
							$access = true;
							break;
						} 
			endforeach;
		}
		else{
			$access = true;
		} 
				
		if($access){
		?>
        <h3>Add A New Agent:</h3>
        <form name="some_form" method="post" onsubmit = "return f(this)">
        <input type="hidden" name="method" value="search"/>
        <input type="hidden" name="user" value="<?=$user?>"/>
        <input type="text" name="searchme"/> <input type="submit" value="Search"/><br />
        </form>
		(Agent search is based on the user's first and last name)<br />
        <form name="some_form" method="post" onsubmit = "return f(this)">
        <input type="hidden" name="method" value="browse"/>
        <input type="hidden" name="searchme" value="null"/>
        <input type="hidden" name="user" value="<?=$user?>"/>
        <input type="submit" value="Browse Users"/>
        </form>
        <? } ?>
<br />
<div id="results" style="display:none">

</div>
        <hr/>
		<h3>Current Agents:</h3>
         To remove a user as one of your agents, simply click "Remove Agent" for the desired user.<br /><br />

         <?
		
		if($agents->result() == null){
			echo "You currently have no agents.";
		}
		else{
			echo "<table>";
			echo "<tr><td>Name</td><td>Username</td><td>Access Level</td><td>Action</td></tr>";
			foreach($agents->result() as $row){
			
			if ($clinicianviewing != null && $clinicianviewing == true){
			
				$sql = "SELECT author FROM Appointed_Agents WHERE agent = ? AND electronicHealthRecord = ?";
				$query = $this->db->query($sql, array($row->agent, $user));
				$trow = $query->row();
				if($trow->author == $_SESSION['uid']){
			
					echo "<tr><td>";
					echo $row->FirstName." ".$row->LastName."</td><td>";
					echo $row->Username."</td><td>";
					if($row->role == 1) echo "Read";
					else if($row->role == 2) echo "Read/Comment";
					else if($row->role == 3) echo "Full";
					else echo "Invalid";
					echo "</td><td>";
					echo "<form method='post' action='http://www.corpusvile.com/crisys/CI/index.php/manageagents/removeagent'>";
					echo "<input type='hidden' name='agentid' value='".$row->ID."'/>";
					echo "<input type='hidden' name='user' value='".$user."'/>";
					echo "<input type='submit' value='Remove Agent'/>";
					echo "</form>";
					echo "</td></tr>";
				}
			}
			else{
				echo "<tr><td>";
				echo $row->FirstName." ".$row->LastName."</td><td>";
				echo $row->Username."</td><td>";
				if($row->role == 1) echo "Read";
				else if($row->role == 2) echo "Read/Comment";
				else if($row->role == 3) echo "Full";
				else echo "Invalid";
				echo "</td><td>";
				echo "<form method='post' action='http://www.corpusvile.com/crisys/CI/index.php/manageagents/removeagent'>";
				echo "<input type='hidden' name='agentid' value='".$row->ID."'/>";
				echo "<input type='hidden' name='user' value='".$user."'/>";
				echo "<input type='submit' value='Remove Agent'/>";
				echo "</form>";
				echo "</td></tr>";
				}
			}
			echo "</table>";
		}
		
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
