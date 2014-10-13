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
	
	function f() {
		inline_results();
		return false;	
	}
	
	function inline_results() { 
	var i  = document.getElementById('med_areas').selectedIndex; 
	var mvalue = document.getElementById('med_areas')[i].value;
	var j  = document.getElementById('patients').selectedIndex; 
	var pvalue = document.getElementById('patients')[j].value;
	
	document.some_form.patients.disabled=true;


		new Ajax.Updater ('results', 'http://www.corpusvile.com/crisys/CI/index.php/managereferrals/newreferralinfo', {method:'post', postBody:'med_area='+mvalue+'&pat_id='+pvalue});
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
        
        <h2>Create A Referral</h2>
		<br/>
		
		
   Select a patient:<br/>          
<form name="some_form" method="post" onsubmit = "return f()">
<SELECT name="patients" id="patients">

<?
foreach($patients->result() as $row){
	echo "<OPTION value='".$row->ID.="'>".$row->FirstName." ".$row->LastName."</OPTION>";
}
?>
</SELECT>


<hr/>
Select a medical area:<br/>
<SELECT name="med_areas" id="med_areas">
<?php foreach($medical_areas->result() as $row): ?>
            
            <option value="<?=$row->ID?>"><?=$row->Description?></option>
            
<?php endforeach; ?>
</SELECT>


<input type="submit" value="Select" />
</form>



<div id="results" style="display:none">

</div>



          
          </p>
        </div>
          
          
          
         
          <div id="footer"><div><div>
          
              Powered by <a href="http://www.corpusvile.com/crisys">CRISYS</a>
          </div></div></div><!-- end footer -->
      </div><!-- end body -->
  </div><!-- end wrapper -->
</body>
</html>
