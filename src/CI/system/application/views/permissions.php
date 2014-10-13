 
				<? $position = 265;
				  //patient access
				 	if($_SESSION['p'] == "true"){
						
				 ?>
                  
				  <li>&nbsp;&nbsp;<a href="#" onmouseover="openmenu(1)" onmouseout="closemenu(1)">Patient</a>&nbsp;&nbsp;</li>
                  <div class="menu" id="1" style="top:12px; left:<?=$position?>px;" onmouseover="openmenu(1)" onmouseout="closemenu(1)">
				  <?php 
				  $position += 55;
						//Manage EHR
						$sql = "SELECT SearchItemsInEHR, BrowseItemsInEHR FROM Role WHERE RoleName = ?";

                        $query = $this->db->query($sql, array("Patient")); 
                        $row = $query->row_array();
                     
					 foreach($row as $attr):
					 	if($attr == 1){
					 ?>
            			<a href="http://www.corpusvile.com/crisys/CI/index.php/manageEHR" style="color:#000000">Manage EHR</a><br/>  
						<?php break;    			
           			 } 
						 endforeach; 
						 
						 //Manage Agents
						$sql = "SELECT SearchAgents, BrowseAgents, AppointAgent, RevokeAgent, RevokeCreatedAgent, EditAgentPrivileges FROM Role WHERE RoleName = ?";

                        $query = $this->db->query($sql, array("Patient")); 
                        $row = $query->row_array();
                     
					 foreach($row as $attr):
					 	if($attr == 1){
					 ?>
            			<a href="http://www.corpusvile.com/crisys/CI/index.php/manageagents" style="color:#000000">Manage Agents</a><br/>      					<?php break;
						} 
						 endforeach; 
						
						 //Manage Sponsered Patients
						$sql = "SELECT SearchSponsoredPatients, BrowseSponsoredPatients FROM Role WHERE RoleName = ?";

                        $query = $this->db->query($sql, array("Patient")); 
                        $row = $query->row_array();
                     
					 foreach($row as $attr):
					 	if($attr == 1){
					 ?>
            			<a href="http://www.corpusvile.com/crisys/CI/index.php/managesponseredpatients" style="color:#000000">Manage Sponsored Patients</a><br/>      					<?php break;
						} 
						 endforeach; 
						 
						  //Manage Patients
						$sql = "SELECT SearchPatients, BrowsePatients FROM Role WHERE RoleName = ?";

                        $query = $this->db->query($sql, array("Patient")); 
                        $row = $query->row_array();
                     
					 foreach($row as $attr):
					 	if($attr == 1){
					 ?>
            			<a href="http://www.corpusvile.com/crisys/CI/index.php/managepatients" style="color:#000000">Manage Patients</a><br/>      					<?php break;
						} 
						 endforeach; 
					
						 
						  //Manage Concealments
						$sql = "SELECT ConcealItem, CancelItemConcealment FROM Role WHERE RoleName = ?";

                        $query = $this->db->query($sql, array("Patient")); 
                        $row = $query->row_array();
                     
					 foreach($row as $attr):
					 	if($attr == 1){
					 ?>
            			<a href="http://www.corpusvile.com/crisys/CI/index.php/managecomcealments" style="color:#000000">Manage Concealments</a><br/>      					<?php break;
						} 
						 endforeach; 
						 
						  //Manage Primary Clinician
						$sql = "SELECT SetDotctorAsPrimary, RemoveDoctorAsPrimary, AddDoctorAsPrimary, RevokeDoctorAsPrimary FROM Role WHERE RoleName = ?";

                        $query = $this->db->query($sql, array("Patient")); 
                        $row = $query->row_array();
                     
					 foreach($row as $attr):
					 	if($attr == 1){
					 ?>
            			<a href="http://www.corpusvile.com/crisys/CI/index.php/manageprimaryclinician" style="color:#000000">Manage Clinicians</a><br/>      					<?php break;
						} 
						 endforeach; 
						 
						  //Manage Referrals
						$sql = "SELECT CancelReferral, CancelCreatedReferral FROM Role WHERE RoleName = ?";

                        $query = $this->db->query($sql, array("Patient")); 
                        $row = $query->row_array();
                     
					 foreach($row as $attr):
					 	if($attr == 1){
					 ?>
            			<a href="http://www.corpusvile.com/crisys/CI/index.php/managereferrals" style="color:#000000">Manage Referrals</a><br/>      					<?php break;
						} 
						 endforeach; 
						 
						 //Create Referrals
						$sql = "SELECT CreateReferral FROM Role WHERE RoleName = ?";

                        $query = $this->db->query($sql, array("Patient")); 
                        $row = $query->row_array();
                     
					 foreach($row as $attr):
					 	if($attr == 1){
					 ?>
            			<a href="http://www.corpusvile.com/crisys/CI/index.php/createreferrals" style="color:#000000">Create A Referral</a><br/>      					<?php break;
						} 
						 endforeach; 
						
                      
                        ?>
                  		
                        </div>
                        
                  <? 
				  }
				  //Clinician access 
				  if($_SESSION['c'] == "true"){ 
                  
                  ?> 
                  <li>|&nbsp;&nbsp;<a href="#" onmouseover="openmenu(2)" onmouseout="closemenu(2)">Clinician</a>&nbsp;&nbsp;</li>
                  <div class="menu" id="2" style="top:12px; left:<?=$position?>px;" onmouseover="openmenu(2)" onmouseout="closemenu(2)">
                  <a href="http://www.corpusvile.com/crisys/CI/index.php/manageclinician" style="color:#000000">Manage Profile</a><br/>
                  
 <?php 
 					$position += 55;
						/*Manage EHR
						$sql = "SELECT SearchItemsInEHR, BrowseItemsInEHR FROM Role WHERE RoleName = ?";

                        $query = $this->db->query($sql, array("Clinician")); 
                        $row = $query->row_array();
                     
					 foreach($row as $attr):
					 	if($attr == 1){
					 ?>
            			<a href="http://www.corpusvile.com/crisys/CI/index.php/manageEHR" style="color:#000000">Manage EHR</a><br/>  
						<?php break;    			
           			 } 
						 endforeach; */
						 
						 //Manage Agents
						$sql = "SELECT AppointAgent, RevokeAgent FROM Role WHERE RoleName = ?";

                        $query = $this->db->query($sql, array("Clinician")); 
                        $row = $query->row_array();
                     
					 foreach($row as $attr):
					 	if($attr == 1){
					 ?>
            			<a href="http://www.corpusvile.com/crisys/CI/index.php/manageagents/clinician" style="color:#000000">Manage Agents</a><br/>      					<?php break;
						} 
						 endforeach; 
						
						 //Manage Sponsered Patients
						$sql = "SELECT SearchSponsoredPatients, BrowseSponsoredPatients FROM Role WHERE RoleName = ?";

                        $query = $this->db->query($sql, array("Clinician")); 
                        $row = $query->row_array();
                     
					 foreach($row as $attr):
					 	if($attr == 1){
					 ?>
            			<a href="http://www.corpusvile.com/crisys/CI/index.php/managesponseredpatients" style="color:#000000">Sponsored Patients</a><br/>      					<?php break;
						} 
						 endforeach; 
						 
						  //Manage Patients
						$sql = "SELECT SearchPatients, BrowsePatients FROM Role WHERE RoleName = ?";

                        $query = $this->db->query($sql, array("Clinician")); 
                        $row = $query->row_array();
                     
					 foreach($row as $attr):
					 	if($attr == 1){
					 ?>
            			<a href="http://www.corpusvile.com/crisys/CI/index.php/managepatients" style="color:#000000">Manage Patients</a><br/>      					<?php break;
						} 
						 endforeach; 
					
						 
						  //Manage Concealments
						$sql = "SELECT ConcealItem, CancelItemConcealment FROM Role WHERE RoleName = ?";

                        $query = $this->db->query($sql, array("Clinician")); 
                        $row = $query->row_array();
                     
					 foreach($row as $attr):
					 	if($attr == 1){
					 ?>
            			<a href="http://www.corpusvile.com/crisys/CI/index.php/managecomcealments" style="color:#000000">Manage Concealments</a><br/>      					<?php break;
						} 
						 endforeach; 
						 
						  //Manage Primary Clinician
						$sql = "SELECT SetDotctorAsPrimary, RemoveDoctorAsPrimary, AddDoctorAsPrimary, RevokeDoctorAsPrimary FROM Role WHERE RoleName = ?";

                        $query = $this->db->query($sql, array("Clinician")); 
                        $row = $query->row_array();
                     
					 foreach($row as $attr):
					 	if($attr == 1){
					 ?>
            			<a href="http://www.corpusvile.com/crisys/CI/index.php/manageprimaryclinician" style="color:#000000">Manage Clinicians</a><br/>      					<?php break;
						} 
						 endforeach; 
						 
						  //Manage Referrals
						$sql = "SELECT CancelReferral, CancelCreatedReferral FROM Role WHERE RoleName = ?";

                        $query = $this->db->query($sql, array("Clinician")); 
                        $row = $query->row_array();
                     
					 foreach($row as $attr):
					 	if($attr == 1){
					 ?>
            			<a href="http://www.corpusvile.com/crisys/CI/index.php/managereferrals/clinician" style="color:#000000">Manage Referrals</a><br/>      					<?php break;
						} 
						 endforeach;
						 
						 						 //Create Referrals
						$sql = "SELECT CreateReferral FROM Role WHERE RoleName = ?";

                        $query = $this->db->query($sql, array("Clinician")); 
                        $row = $query->row_array();
                     
					 foreach($row as $attr):
					 	if($attr == 1){
					 ?>
            			<a href="http://www.corpusvile.com/crisys/CI/index.php/managereferrals/newreferral" style="color:#000000">Create A Referral</a><br/>      					<?php break;
						} 
						 endforeach;  
                      
                        ?>
                  		
                        </div>
                        
                  <? 
				  }
				  
				   //Agent access 
				  if($_SESSION['a'] == "true"){ 
                    
                 
				  ?>
                  <li>|&nbsp;&nbsp;<a href="#" onmouseover="openmenu(3)" onmouseout="closemenu(3)">Agent</a>&nbsp;&nbsp;</li>
                  <div class="menu" id="3" style="top:12px; left:<?=$position?>px;" onmouseover="openmenu(3)" onmouseout="closemenu(3)">
                  <a href="http://www.corpusvile.com/crisys/CI/index.php/managesponseredpatients" style="color:#000000">Sponsored Patients</a><br/>
                  </div>
                  
 <?php 
 					
                  $position += 55;
					
				}
                  //Admin access 
				  if($_SESSION['admin'] == "true"){ 

				  ?>
                  <li>|&nbsp;&nbsp;<a href="#" onmouseover="openmenu(4)" onmouseout="closemenu(4)">Admin</a>&nbsp;&nbsp;</li>
                  <div class="menu" id="4" style="top:12px; left:<?=$position?>px;" onmouseover="openmenu(4)" onmouseout="closemenu(4)">
                  <a href="http://www.corpusvile.com/crisys/CI/index.php/admin/" style="color:#000000">Admin Home</a><br/>
                  </div>
                  
 <?php 
 					
                  $position += 55;
					
				}?>
                
                <li>|&nbsp;&nbsp; <a href="http://www.corpusvile.com/crisys/CI/index.php/home">Home</a>&nbsp;&nbsp;</li>
