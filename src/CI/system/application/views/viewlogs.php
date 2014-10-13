<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CRISYS Electronic Health Records System</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="http://www.corpusvile.com/crisys/build/style.css" rel="stylesheet" type="text/css" />
    
    <script type="text/javascript">
	function validate(form)
	{
		with(form){
			
			if(username.value==null||title.value==""||username.value==" "){alert("Please enter all fields"); return false;}
            else if(password.value==null||password.value==""){alert("Please enter all fields"); return false;}
			else if(firstname.value==null||firstname.value==""){alert("Please enter all fields"); return false;}
			else if(lastname.value==null||lastname.value==""){alert("Please enter all fields"); return false;}
            else{return true;}
		
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
                  

                  
              </ul><!-- end top-nav -->
              <ul id="nav-left">
                  
              </ul>
          </div></div></div><!-- end .corners -->
          <div id="side_nav">

             
                
             
                
                <div id="sidebar_info">
				
                </div>
          </div>
          
      </div><!-- end header -->
      <div id="body_main"><div id="cap_main"></div>
          

          
          
          
          <!-- end left -->
          
        <div id="main">
              <h2>View Logs</h2>
         <?php     
		if($logs->result() == null){
			echo "There are no logs!";
		}
		else{	
			echo "<table><tr><td>Log ID</td><td>Affected User</td><td>Editing User</td><td>Date Of Action</td><td>Description</td></tr>";
			foreach($logs->result() as $row): ?>
        
              	<tr>
                  	<td><?=$row->ID?></td>
                    <td><?=$row->electronicHealthRecord?></td>
                    <td><?=$row->editingUser?></td>
                    <td><?=$row->dateOfAction?></td>
                	<td><?=$row->actionDescription?></td>
                </tr>

            <?php endforeach; 
			echo "</table>";
		}?>
               <br/><br/> 
                <a href="http://www.corpusvile.com/crisys/CI/index.php/admin/">Admin Home</a>
          </p>
        </div>
          
          
          
          
          <div id="footer"><div><div>
          
              Powered by <a href="http://www.corpusvile.com/crisys">CRISYS</a>
          </div></div></div><!-- end footer -->
      </div><!-- end body -->
  </div><!-- end wrapper -->
</body>
</html>
