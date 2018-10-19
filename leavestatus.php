<?php 
	include_once("config/database.php");

	//staff id from session();
	$staffid = "cu18156";
	$name = "Lora Miley";

	$sql = "SELECT leaveapp.staffid, leaveapp.appno, leaveapp.leavetype, leavetrack.hodcom, leavetrack.deancom, leavetrack.deancom, leavetrack.hrcom, leavetrack.registrarcom
		FROM leaveapp
		INNER JOIN leavetrack ON leaveapp.staffid = leavetrack.staffid
		WHERE leaveapp.staffid = '".$staffid."'
		LIMIT 0,1 ";

	 $stmt = $con->prepare($sql);
	 //print_r($stmt);
	 $stmt->bindParam(1, $staff_id);
	 $stmt->execute();

	 $row = $stmt->fetch(PDO::FETCH_ASSOC);
	 $num = $stmt->rowCount();
		
	$leavetype = $row['leavetype'];
	$appno = $row['appno'];
	$hodcom = $row['hodcom'];
	$deancom = $row['deancom'];
	$hrcom = $row['hrcom'];
	$registrarcom = $row['registrarcom'];	 




           
?>
<!DOCTYPE html>
<html>
<head>
	<title>Leave Status Page</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>

<div class="content">
	<div class="container-fluid">
		<div class="row hed" >
			<h1 class="h1">Leave Application Status Page</h1>
		</div>	
		<!-- End of title  -->
		<div class="row">
			<!-- <p class="para_1">This page contains the status of your application. Each approval will be updated 
			below. Check this page always to know the status of your aplication</p> -->
		</div>
	
		<div class="row">
			<!-- <div class="col-md-2">
				<a href="leave_app.php">Leave Application Form</a><br>
				<a href="officersview.php">Leave Application Status View by Senior Staff</a><br>
				<a href="officerslist.php">Leave Application List</a><br>
				<a href="leavestatus.php">Leave Application Status </a>
			</div> -->
			
			<div class="col-md-8">
				<div class="bor_der">
				<div class="row">
						<h4 class="col-md-6">Name</h4>
						<h6 class="col-md-6"><?php echo $name; ?></h6>
				</div>
				<div class="row">
					<h4 class="col-md-6">Staff id</h4>
					<h6 class="col-md-6"><?php echo $staffid; ?></h6>
				</div>
				<div class="row">
						<h4 class="col-md-6"> Application Number</h4>
						<h6 class="col-md-6"><?php echo $appno; ?> </h6>
				</div>
				<div class="row">
						<h4 class="col-md-6"> Leave Type</h4>
						<h6 class="col-md-6"> <?php echo $leavetype; ?></h6>
					</div>
				<div class="row">
					<div class="col-md-4">
						<h4> Leave Status</h4>
					</div>
						
					<div class="col-md-8">
						<?php 
							if ($registrarcom == "pending" || $hrcom == "pending" || $hodcom == "pending" || $deancom == "pending") { ?>
 								<strong><p class="pend"> Application for leave is in progress</p></strong>

						<?php }  elseif ( $registrarcom == "approved" ) {?>
								<strong><p class="approve"> Application for leave is aprroved</p></strong>
						<?php } else { ?>
								<strong><p class="deny"> Application for leave is Denied</p></strong>
								
						<?php } ?>
					</div>
 				</div>
			<div class="row">
			<table class="table table-bordered">
					<tr>
						<th> No</th>
						<th> Designation</th>
						<th> Name</th>
						<th> Date Gotten</th>
						<th> Date Attended To</th>
						<th> Status</th>
						
					</tr>
				<tr>
					<td>1</td>
					<td>HOD</td>
					<td>Ayo Lawl</td>
					<td> 12 Dec 2009  5: 30pm</td>
					<td> 15 Dec  2009  4: 30am</td>
					<td <?php 
									if ($hodcom == "pending") {
										echo 'class = "pend"';
									}elseif ($hodcom == "denied") {
										echo 'class = "deny"';
									} else{
										echo 'class = "approve"'; 
									}
								?> >
								<strong><?php echo $hodcom; ?></strong>
					 </td>
				</tr>

				<tr>
					<td>2</td>
					<td>Dean</td>
					<td>Boyle James</td>
					<td> 14 Oct 2009  5: 30pm</td>
					<td> 15 Oct 2009  4: 30am</td>
					<td <?php 
									if ($hodcom == "pending") {
										echo 'class = "pend"';
									}elseif ($hodcom == "denied") {
										echo 'class = "deny"';
									} else{
										echo 'class = "approve"'; 
									}
								?> >
								<strong><?php echo $deancom; ?></strong>
					 </td>
				</tr>

				<tr>
					<td>3</td>
					<td>HR</td>
					<td>Logbon Joy</td>
					<td> 12 Dec 2009  5: 30pm</td>
					<td> 15 Dec 2009  4: 30am</td>
					<td <?php 
									if ($hodcom == "pending") {
										echo 'class = "pend"';
									}elseif ($hodcom == "denied") {
										echo 'class = "deny"';
									} else{
										echo 'class = "approve"'; 
									}
								?> >
								<strong><?php echo $hodcom; ?></strong>
					 </td>
				</tr>

				<tr>
					<td>4</td>
					<td>Registrar</td>
					<td>Mathew Johnson</td>
					<td> 12 Dec 2009  5: 30pm</td>
					<td> 15 Dec 2009  4: 30am</td>
					<td <?php 
									if ($hodcom == "pending") {
										echo 'class = "pend"';
									}elseif ($hodcom == "denied") {
										echo 'class = "deny"';
									} else{
										echo 'class = "approve"'; 
									}
								?> >
								<strong><?php echo $registrarcom; ?></strong>
					 </td>
				</tr>
			</table>
		</div>
				<!-- New row to keep Leave Status profile -->
			<!-- <div class="row">
				<div class="col-md-6">
					<h4>Leave Application Status</h4>
				</div>
				<div class="col-md-6">
						<ul style="list-style-type:none">
							<li>
								<strong>HOD :</strong> 
								<strong <?php 
									if ($hodcom == "pending") {
										echo 'class = "pend"';
									}elseif ($hodcom == "denied") {
										echo 'class = "deny"';
									} else{
										echo 'class = "approve"'; 
									}
								?> >

								<?php echo $hodcom; ?>
									
								</strong>
							</li>
							<li>
								<strong>Dean :</strong> 
								<strong	<?php 
									if ($hodcom == "pending") {
										echo 'class = "pend"';
									}elseif ($hodcom == "denied") {
										echo 'class = "deny"';
									} else{
										echo 'class = "approve"'; 
									}
								?> >
								<?php echo $deancom; ?></strong>
							</li>
							<li>
								<strong>HR:</strong>
								<strong <?php 
									if ($hodcom == "pending") {
										echo 'class = "pend"';
									}elseif ($hodcom == "denied") {
										echo 'class = "deny"';
									} else{
										echo 'class = "approve"'; 
									}
								?> >
								<?php echo $hrcom; ?> </strong>
							</li> 
							<li>
								<strong>Registar :</strong>
								<strong <?php 
									if ($hodcom == "pending") {
										echo 'class = "pend"';
									}elseif ($hodcom == "denied") {
										echo 'class = "deny"';
									} else{
										echo 'class = "approve"'; 
									}
								?> > 
								<?php echo $registrarcom; ?></strong>
							</li>
							
						</ul>
					</div> -->
			</div>

			</div>
			<div class="col-md-2">
				<!-- Nothing goes here -->
			</div>
	</div>
	</div> <!-- End of Border design 	 -->
			<!-- Display Approval Message -->

			<!-- <div class="row appr-status">
				<div class="col-md-6">
					<div class="alert alert-success">
						<strong> Application for leave is approved</strong>
					</div>
				</div>
				<div class="col-md-6">
					<div class="alert alert-danger">
						<strong> Application for leave is Denied. You may reapply again</strong>
					</div>
				</div>
			</div> -->
			
		</div>
</div>

	<script src="js/jquery-slim.min.js"></script>
    <script src="../../dist/js/bootstrap.js"></script>
</body>
</html>