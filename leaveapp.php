<?php
	include 'config/database.php';
	include "leavefunction.php";
	//check for session
	checkSession();
?>

<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>Leave Application</title>
	  <!-- BEGIN META -->
		<meta charset="utf-8">
		
		<!-- END STYLESHEETS -->
	</head>
<body>
		<!-- BEGIN BASE-->
		<div id="base">

			<!-- BEGIN CONTENT-->
			<div id="content">
				<section>
					<div class="section-body contain-lg">
						<!-- BEGIN INTRO -->
<div class="container">
	<div class="row">
	</div>
						<div class="row">
							<div class="col-lg-8 col-lg-offset-2">

<?php
  	$databasedate = date('Y-m-d H:i:s');
		
 	if(isset($_POST['submit']))
 	{
 		extract($_POST);
 		$sdate = date('Y-m-d', strtotime($startdate));
 		$edate = date('Y-m-d', strtotime($enddate));
 		$appno = randomString(8);

 		//$con -> beginTransaction();
 		$con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


 		try{ //try begins here

 		$query = "INSERT INTO leaveapp (staffid,appno,leavetype,reason,country,city,location,leavephoneno,startdate,enddate,officer1,officer2,officer3,appstatus,datecreated,dateresumed,resumptionconfirm,daysrecommended,commencementdate,returndate,released) VALUES ('$staffid','$appno', '$leavetype', '$reason','$country', '$city', '$location', '$leavephoneno', '$sdate','$edate','$officer1','$officer2','$officer3', '1', '$databasedate', '0000-00-00 00:00:00', '0', '0', '0000-00-00', '0000-00-00', '0')";
		
		//$stmt = $con->prepare($query);
		$stmt = $con->prepare($query);
 		
 		if ($stmt->execute()){
 				$query1 = "INSERT INTO leavetrack (staffid) VALUE ('$staffid')";
 				$stmt1 = $con -> prepare($query1);
 					if ($stmt1->execute()) {
 						echo "Leave staffid submitted";
 					}
 					else{ echo "Staffid not submmited";}
 		 	echo "Leave application submitted";
 		 	header("location: leavestatus.php?id=$staffid");
 		 } else{
 		 	echo "Try again later";
 		 }//end of if for execute

 	}//try ends
 	catch(PDOExtension $e){
 		$e->getMessage();
 	}//catch ends here
 	
 }

?>
						<p><a href="welcome.php" class="btn btn-default">Back to dashboard</a></p>
								<h2 class="text-primary" style="font-family: garamond;">Leave Application</h2>
							</div>
						</div>

						<!-- BEGIN FORM WIZARD -->
					<form method="POST" action="leaveapp.php">
						<div class="row">
							<div class="col-lg-8 col-lg-offset-2">
								<div class="card">
									<div class="card-body ">
										<div id="rootwizard2" class="form-wizard form-wizard-horizontal">

										</div><!--end #rootwizard -->

										<div class="row">
											<input type="text" placeholder="Staff id" name="staffid">
											<br>
											<br>
												
											<label>Select Leave Category</label>
											<div class="col-sm-4">
												<select name="leavetype" class="form-control" required>
													<option value = ''></option>
													<option value = 'casual'>Casual</option>
													<option value = 'annual'>Annual</option>
													<option value = 'medical'>Medical</option>
													<option value = 'study'>Study</option>
													<option value = 'post_doc'>Post Doctoral</option>
														<?php

														?>
												</select>
											</div>
										</div>

										</br>
										<div class="row">
											<div class="col-sm-12">
												<textarea class="form-control" name="reason" rows="10" cols="40" placeholder="Reasons for Leave" required></textarea>
											</div>
										</div>
										</br>
										<div class="row">
											<div class="col-sm-4">
												<label>Select Country</label>
												<select id="country" name="country" class="form-control" placeholder = "Country" required>
													  <option value = ''>&nbsp;</option>
														<option value = 'nigeria'>Nigeria</option>
														<option value = 'outside nigeria'>Outside Nigeria</option>
														<?php

														?>
												</select>

											</div>
											<div class="col-sm-4">
												<label>City</label>
												<input type="text" name="city" id="city" class="form-control" required>
											</div>
											<div class="col-sm-4">
												<label>Location</label>
												<input type="text" name="location" id="location" class="form-control" required>
											</div>
										</div>
										</br>
										<div class="row">
											<div class="col-sm-4">
												<label>Phone Number while on Leave</label>
											</div>
												<div class="col-sm-8">
												<input type="text" class="form-control" name="leavephoneno"  required/>
											</div>
										</div>
										</br>
										<div class="form-group">
										<div class="row">


												<div class="col-sm-4">
														<label>Date of Leave Period</label>
												</div>
												<div class="col-sm-4">
													<input class="form-control" id="from" name="startdate"  placeholder="from" required/>
												</div>
												<div class="col-sm-4">
													<input class="form-control" id="to" name="enddate" placeholder="to" required/>
												</div>
											</div>
										</div>
										</br>
										<label>Officers To Act on Your Duty While Away</label>
										<div class="row">
											<div class="col-sm-4">
												<select name="officer1" class="form-control select2-list" required>
                          <option> Select officer </option>
													<option>Adewale</option>
                          <option>Oyewole</option>
													<?php foreach($staff as $sta){ ?>
													<option value="<?php echo $sta['idno']; ?>"><?php echo $sta['title'] ." ".$sta['fname'] ." ". $sta['sname'];  ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-sm-4">
												<select name="officer2" class="form-control select2-list" required>
													<option>-- select officer --</option>
                          <option> Dan </option>
                          <option> Danziba </option>
													<?php foreach($staff as $sta){ ?>
													<option value="<?php echo $sta['idno']; ?>"><?php echo $sta['title'] ." ".$sta['fname'] ." ". $sta['sname'];  ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-sm-4">
												<select name="officer3" class="form-control select2-list" required>
													<option>-- select officer --</option>
                          <option> Danno </option>
                          <option> Zimo </option>
													<?php foreach($staff as $sta){ ?>
													<option value="<?php echo $sta['idno']; ?>"><?php echo $sta['title'] ." ".$sta['fname'] ." ". $sta['sname'];  ?></option>
													<?php } ?>
												</select>
											</div>
										</div>

										</br>
										<div class="row">
                      <div class="col-md-4">
											<input  name="submit" type="submit"  value="submit"/>
										</div>
                  </div>


									</div><!--end .card-body -->
								</div><!--end .card -->
							</div><!--end .col -->
						</div><!--end .row -->
					</form>
						<!-- END FORM WIZARD -->
</div>
					</div><!--end .section-body -->
				</section>
			</div><!--end #content-->

		</div><!--end #base-->
		<!-- END BASE -->


			<!-- BEGIN JAVASCRIPT -->
		
	</body>
</html>
	<script>
	$(document).ready(function(){
			daterange('#from','#to');

			});
		function daterange(startdate,enddate) {
				//the date range stuff
					var dateFormat = "mm/dd/yy",
					from = $( startdate ).datepicker({
						defaultDate: "+1w",
						changeMonth: true,
						changeYear: true
					})
					.on( "change", function() {
						to.datepicker( "option", "minDate", getDate( this ) );
					}),
					to = $( enddate ).datepicker({
						defaultDate: "+1w",
						changeMonth: true,
						changeYear: true
					})
					.on( "change", function() {
						from.datepicker( "option", "maxDate", getDate( this ) );
					});
					function getDate( element ) {
						var date;
						try {
							date = $.datepicker.parseDate( dateFormat, element.value );
						} catch( error ) {
							date = null;
						}
						return date;
					}
					$('.dates').on('keyup', function(){
						if(/^\d{4}-((0\d)|(1[012]))-(([012]\d)|3[01])$/.test($(this).val()) == false){
							$(this).val('');
						}
					});
					$(startdate).on('change', function(){
						$(enddate).val('');
					});
				}
	</script>
