<?php 
	include 'config/database.php';
	include "leavefunction.php";
	//check for session
	checkSession();

	//staff id from session();
	$staffid = $_GET['id'];

	$name = getname($staffid) ? getname($staffid) : "Michael GRoss" ;

	$sql = "SELECT leaveapp.staffid, appno, leavetype, hodrec, deandirrec, hrrec, registrarrec, vcrec, appstatus
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
	$appstatus = $row['appstatus'];
	$hodrec = $row['hodrec'];
	$deandirrec = $row['deandirrec'];
	$hrrec = $row['hrrec'];
	$registrarrec = $row['registrarrec'];
	$vcrec = $row['vcrec'];	 
           
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
		<div class="row"> </div>
	
		<div class="row">
						
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
					<p><?php echo $appstatus; ?></p>
				<div class="row">
					<div class="col-md-4">
						<h4> Leave Status</h4>
					</div>
						
					<div class="col-md-8">
						<?php 
							if ($appstatus == 1) { ?>
 								<strong><p class="pend"> Application for leave is in progress</p></strong>

						<?php }  elseif ( $appstatus == 2 ) {?>
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
									if ($hodrec == 1) {
										echo 'class = "pend"';
									}elseif ($hodrec == 0) {
										echo 'class = "deny"';
									} else{
										echo 'class = "approve"'; 
									}
								?> >
								<strong>
									<?php if ($hodrec == 1) {
										echo "Application is in Progress";
									}elseif ($hodrec == 0) {
										echo "Application is denied";
									} else{
										echo "Application is approved"; 
									} ?>
									
								</strong>
					 </td>
				</tr>

				<tr>
					<td>2</td>
					<td>Dean</td>
					<td>Boyle James</td>
					<td> 14 Oct 2009  5: 30pm</td>
					<td> 15 Oct 2009  4: 30am</td>
					<td <?php 
									if ($deandirrec == 1) {
										echo 'class = "pend"';
									}elseif ($deandirrec == 0) {
										echo 'class = "deny"';
									} else{
										echo 'class = "approve"'; 
									}
								?> >
								<strong>
									<?php if ($deandirrec == 1) {
										echo "Application is in Progress";
									}elseif ($deandirrec == 0) {
										echo "Application is denied";
									} else{
										echo "Application is approved"; 
									} ?>
									
								</strong>
					 </td>
				</tr>

				<tr>
					<td>3</td>
					<td>HR</td>
					<td>Logbon Joy</td>
					<td> 12 Dec 2009  5: 30pm</td>
					<td> 15 Dec 2009  4: 30am</td>
					<td <?php 
									if ($deandirrec == 1) {
										echo 'class = "pend"';
									}elseif ($deandirrec == 0) {
										echo 'class = "deny"';
									} else{
										echo 'class = "approve"'; 
									}
								?> >
								<strong>
									<?php if ($deandirrec == 1) {
										echo "Application is in Progress";
									}elseif ($deandirrec == 0) {
										echo "Application is denied";
									} else{
										echo "Application is approved"; 
									} ?>
									
								</strong>
					 </td>
				</tr>

				<tr>
					<td>4</td>
					<td>Registrar</td>
					<td>Mathew Johnson</td>
					<td> 12 Dec 2009  5: 30pm</td>
					<td> 15 Dec 2009  4: 30am</td>
					<td <?php 
									if ($deandirrec == 1) {
										echo 'class = "pend"';
									}elseif ($deandirrec == 0) {
										echo 'class = "deny"';
									} else{
										echo 'class = "approve"'; 
									}
								?> >
								<strong>
									<?php if ($deandirrec == 1) {
										echo "Application is in Progress";
									}elseif ($deandirrec == 0) {
										echo "Application is denied";
									} else{
										echo "Application is approved"; 
									} ?>
									
								</strong>
					 </td>
				</tr>
			</table>
		</div>
			</div>
				<div class="col-md-2">
					<p><a href="welcome.php" class="btn btn-default">Back to dashboard</a></p>
				</div>
			</div>
			
		</div>
	</div> 
			
</div>
</div>

	<script src="js/jquery-slim.min.js"></script>
    <script src="../../dist/js/bootstrap.js"></script>
</body>
</html>