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
                  <li>Permissions:</a></li>
                 <?php include 'permissions.php';?>

                  
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
              <h2>Administrator Home</h2>
              
              <h3>Add New User</h3>
              <table style="border-width:none;border-color:#000000;border-style:none;">
              <tr style="border-width:none;border-color:#000000;border-style:none;"><td style="border-width:none;border-color:#000000;border-style:none;">
              <table>
              <form action="http://www.corpusvile.com/crisys/CI/index.php/admin/adduser" method="post" onsubmit="return validate(this);" >
              <tr><td>Username: </td><td><input type="text" name="username" /></td></tr>
        	  <tr><td>Password: </td><td><input type="text" name="password" /></td></tr>
              <tr><td>First Name: </td><td><input type="text" name="firstname" /></td></tr>
              <tr><td>Last Name: </td><td><input type="text" name="lastname" /></td></tr>
              <tr><td>Patient: </td><td><input type="radio" name="patient" /></td></tr>
              <tr><td>Clinician: </td><td><input type="radio" name="clinician" /></td></tr>
              <tr><td>Administrator: </td><td><input type="radio" name="admin" /></td></tr>
              <tr><td style="border-width:none;border-color:#000000;border-style:none;"></td><td><input type="submit" value="Add User"/><input type="reset" value="Reset"/></td></tr>
              
              </table>
              
              </form>
			</td><td>
            <select>
            <option>All Users</option>
            <?php 
			$query = $this->db->get('User');
			foreach($query->result() as $row): ?>
            
            <option><?=$row->Username?></option>
            
            <?php endforeach; ?>
            
            </select>
            </td>
            </tr>
            </table>
            
            <br/>
            <center>
            <table>
            <tr><td>Messages</td></tr>
            <tr><td><? if($message == null || $message == "" || $message==" "){echo "None..";}else{echo $message;}?></td></tr>
            </table>
            </center>
            <a href="http://www.corpusvile.com/crisys/CI/index.php/admin/viewlogs">View Logs</a>
          
          </p>
        </div>
          
          
          
          
          <div id="footer"><div><div>
          
              Powered by <a href="http://www.corpusvile.com/crisys">CRISYS</a>
          </div></div></div><!-- end footer -->
      </div><!-- end body -->
  </div><!-- end wrapper -->
</body>
</html>
