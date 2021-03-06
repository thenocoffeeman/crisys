<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CRISYS Electronic Health Records System</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="http://www.corpusvile.com/crisys/build/style.css" rel="stylesheet" type="text/css" />
            <? session_start(); ?>
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
        <h2>Clinician Profile</h2>
		<br/>

		Clinician #<?=$_SESSION['uid']?><br />
        Username: <?=$_SESSION['user']?><br />
		First Name: <?=$_SESSION['fname']?><br />
        Last Name: <?=$_SESSION['lname']?><br />
                
         <br />
        <hr/>
        <br />
        <h3>Medical Areas:</h3><br />
        <form method="post" action="http://www.corpusvile.com/crisys/CI/index.php/manageclinician/removemedicalarea">
        <table>
        <tr>
        <td style="border:none;">
        Current:
        </td>
        <td style="border:none;">
        <SELECT name="medarea">
        <?php foreach($medical_areas->result() as $row): ?>
            
            <option value="<?=$row->ID?>"><?=$row->Description?></option>
            
        <?php endforeach; ?>
        </SELECT>
        </td>
        </tr>
        <tr>
        <td style="border:none;"></td>
        <td style="border:none;">
		<input type="submit" value="Remove"/>
		</td>
        </tr>
        </table>
        <br/>
		</form>
		<form method="post" action="http://www.corpusvile.com/crisys/CI/index.php/manageclinician/addmedicalarea">
        <table>
        <tr>
        <td style="border:none;">
        All:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
        <td style="border:none;">
        <SELECT name="medarea">
        <?php foreach($other_areas->result() as $row2): ?>
            
            <option value="<?=$row2->ID?>"><?=$row2->Description?></option>
            
        <?php endforeach; ?>
        </SELECT>
		</td>
        </tr>
        <tr>
        <td style="border:none;"></td>
        <td style="border:none;">
		<input type="submit" value="Add"/>
		</td>
        </tr>
		</table>
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
