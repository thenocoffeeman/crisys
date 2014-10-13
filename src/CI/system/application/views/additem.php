<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CRISYS Electronic Health Records System</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
	<link href="http://www.corpusvile.com/crisys/build/style.css" rel="stylesheet" type="text/css" />
    <link type="text/css" rel="stylesheet" href="http://www.corpusvile.com/crisys/build/calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
	<SCRIPT type="text/javascript" src="http://www.corpusvile.com/crisys/build/calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
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
	
	function displayItemFields()
	{
		var dropdownIndex = document.getElementById('itemtype').selectedIndex;
		var selected = document.getElementById('itemtype')[dropdownIndex].value;
		div = document.getElementById(selected);
		div.style.visibility = 'visible';
		document.getElementById('itemselect').disabled=true;
		document.getElementById('itemtype').disabled=true;
		return false;
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
       	<h2>Add An Item To EHR #<? echo $ehrid?> for <? echo $name?></h2>
        <br/>
        Select Item Type:
        <form onsubmit = "return displayItemFields()">
        <SELECT id="itemtype">
        <? 
		if($permissions->AddQuantitativeObservationItem==1){?><OPTION value="Quantitative Observation">Quantitative Observation</OPTION><? }
		if($permissions->AddQualitativeObservationItem==1){?><OPTION value="Qualitative Observation">Qualitative Observation</OPTION><? }
		if($permissions->AddCommentItem==1){?><OPTION value="Comment">Comment</OPTION><? }
		if($permissions->AddTreatmentItem==1){?><OPTION value="Treatment">Treatment</OPTION><? }
		if($permissions->AddDiagnosisItem==1){?><OPTION value="Diagnosis">Diagnosis</OPTION><? }
		?>
        
            
        
        </SELECT>
        <input type = "submit" value = "Select" id="itemselect"/>
        </form>
        <hr/>
        <br/>
        <div>
        <div id="Quantitative Observation" style="visibility:hidden; position:absolute; top:275px; height:275px; width:575px;overflow:auto;">
        <h3>Quantitative Observation</h3><br/>
        <form action="http://www.corpusvile.com/crisys/CI/index.php/manageEHR/insertnewitem" method="post">
        <input type="hidden" name="itemtype" value="Quantitative Observation"/>
        <input type="hidden" name="ehr" value="<?=$ehrid?>"/>
        <table>
        <tr><td>Observer:</td><td><input type="text" value="<?=$_SESSION['fname']?> <?=$_SESSION['lname']?>" disabled="disabled"/></td></tr>
        <input type="hidden" name="ObserverID" value="<?=$_SESSION['uid']?>"/>
        <tr><td>ObservedQuantity:</td><td>
        <SELECT name="ObservedQuantity">
        <?php foreach($observedqty->result() as $row): ?>
        <OPTION value="<?=$row->ID?>"><?=$row->Description?></OPTION>   
        <?php endforeach; ?>
        </SELECT>
        
        </td></tr>
        <tr><td>Value:</td><td><input type="text" name="Value"/></td></tr>
        <tr><td>Unit:</td><td><input type="text" name="Unit"/></td></tr>
        </table>
        <br/>Select all medical areas that apply for this item.<br/><br/>
        <?
			$query = $this->db->get('Medical_Areas');
			foreach($query->result() as $row){
				echo "<input type='checkbox' name='med_area[]' value='".$row->ID."'/>".$row->Description."<br/>  ";
			}
			
		?>
        <br /><br/>
        <input type="submit" value="Add Item"/>
        </form>
        </div>
        <div id="Qualitative Observation" style="visibility:hidden; position:absolute; top:275px; height:275px; width:575px;overflow:auto;">
        <h3>Qualitative Observation</h3><br/>
        <form action="http://www.corpusvile.com/crisys/CI/index.php/manageEHR/insertnewitem" method="post">
        <input type="hidden" name="itemtype" value="Qualitative Observation"/>
        <input type="hidden" name="ehr" value="<?=$ehrid?>"/>
        <input type="hidden" name="ObserverID" value="<?=$_SESSION['uid']?>"/>
        <table>
        <tr><td>Observer:</td><td><input type="text" value="<?=$_SESSION['fname']?> <?=$_SESSION['lname']?>" disabled="disabled"/></td></tr>
        <input type="hidden" name="ObserverID" value="<?=$_SESSION['uid']?>"/>
        <tr><td>Description:</td><td><textarea cols="45" rows="10" name="Description"></textarea></td></tr>

        </table>
       <br/>Select all medical areas that apply for this item.<br/><br/>
        <?
			$query = $this->db->get('Medical_Areas');
			foreach($query->result() as $row){
				echo "<input type='checkbox' name='med_area[]' value='".$row->ID."'/>".$row->Description."<br/>  ";
			}
			
		?>
        
        <br /><br/>
        <input type="submit" value="Add Item"/>
        </form>
        </div>
      
        <div id="Diagnosis" style="visibility:hidden; position:absolute; top:275px; height:275px; width:575px;overflow:auto;">
        <h3>Diagnosis</h3><br/>
        <form action="http://www.corpusvile.com/crisys/CI/index.php/manageEHR/insertnewitem" method="post">
        <input type="hidden" name="itemtype" value="Diagnosis"/>
        <input type="hidden" name="ehr" value="<?=$ehrid?>"/>
        <input type="hidden" name="ObserverID" value="<?=$_SESSION['uid']?>"/>
        <table>
     
        <tr><td>Description:</td><td><textarea cols="45" rows="10" name="Description"></textarea></td></tr>

        </table>
        <br/>Select all medical areas that apply for this item.<br/><br/>
        <?
			$query = $this->db->get('Medical_Areas');
			foreach($query->result() as $row){
				echo "<input type='checkbox' name='med_area[]' value='".$row->ID."'/>".$row->Description."<br/>  ";
			}
			
		?>
        <br /><br/>
        <input type="submit" value="Add Item"/>
        </form>
        </div>
        <div id="Treatment" style="visibility:hidden; position:absolute; top:275px; height:275px; width:575px;overflow:auto;">
        <h3>Treatment</h3><br/>
        <form action="http://www.corpusvile.com/crisys/CI/index.php/manageEHR/insertnewitem" method="post">
        <input type="hidden" name="itemtype" value="Treatment"/>
        <input type="hidden" name="ehr" value="<?=$ehrid?>"/>
        <input type="hidden" name="ObserverID" value="<?=$_SESSION['uid']?>"/>
        <table>
        <tr><td>Start Date:</td><td><input type="text" value="2009/01/01" readonly name="theDate"><input type="button" value="Cal" onclick="displayCalendar(document.forms[4].theDate,'yyyy/mm/dd',this)"></td></tr>
        <tr><td>End Date:</td><td><input type="text" value="2009/01/01" readonly name="theDate2"><input type="button" value="Cal" onclick="displayCalendar(document.forms[4].theDate2,'yyyy/mm/dd',this)"></td></tr>
        <tr><td>Description:</td><td><textarea cols="45" rows="6" name="Description"></textarea></td></tr>
        </table>
       <br/>Select all medical areas that apply for this item.<br/><br/>
        <?
			$query = $this->db->get('Medical_Areas');
			foreach($query->result() as $row){
				echo "<input type='checkbox' name='med_area[]' value='".$row->ID."'/>".$row->Description."<br/>  ";
			}
			
		?>
        <br /><br/>
        <input type="submit" value="Add Item"/>
        </form>
        </div>
        <div id="Comment" style="visibility:hidden; position:absolute; top:275px; height:275px; width:575px;overflow:auto;">
        <h3>Comment</h3><br/>
        <form action="http://www.corpusvile.com/crisys/CI/index.php/manageEHR/insertnewitem" method="post">
        <input type="hidden" name="itemtype" value="Comment"/>
        <input type="hidden" name="ehr" value="<?=$ehrid?>"/>
        <input type="hidden" name="ObserverID" value="<?=$_SESSION['uid']?>"/>
        <table>
        <tr><td>Description:</td><td><textarea cols="45" rows="10" name="Description"></textarea></td></tr>
        </table>
        <br/>Select primary medical area for item. Additional areas may be added by viewing the item details after it is created.
       <br/>Select all medical areas that apply for this item.<br/><br/>
        <?
			$query = $this->db->get('Medical_Areas');
			foreach($query->result() as $row){
				echo "<input type='checkbox' name='med_area[]' value='".$row->ID."'/>".$row->Description."<br/>  ";
			}
			
		?>
        <br /><br/>
        <input type="submit" value="Add Item"/>
        </form>
        
        </div>
        
          
          </p>
        </div>
          </div>
          
         
          <div id="footer"><div><div>
          
              Powered by <a href="http://www.corpusvile.com/crisys">CRISYS</a>
          </div></div></div><!-- end footer -->
      </div><!-- end body -->
  </div><!-- end wrapper -->
</body>
</html>
