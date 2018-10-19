<?php
include 'config/database.php';
include 'leavefunction.php';
		
if (isset($_GET['id']))
	{
		$staffid = $_GET['id'];
		$hrid = "cu/13/100";

		$name = getname($staffid);
		
		# Check for department
		/*$querydept = "SELECT unit 
						FROM pdata 
						WHERE hodid = ?";

		$stmt = $con->prepare($querydept);
		$stmt->bindParam(1, $hodid);
		$stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);*/

        //test for the department


        //After testing for department
        /*************************************************************************/
    try {
    	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $qryh = "SELECT leavetype, reason, startdate, enddate, hodrec, hodcom
				FROM leavetrack
				JOIN leaveapp ON leavetrack.staffid = leaveapp.staffid
				WHERE leavetrack.staffid = '$staffid'
				LIMIT 0,1"; 
		$stmth = $con->prepare($qryh);
		$stmth->bindParam(1, $staffid);
		$stmth->execute();

		$row=$stmth->fetch(PDO::FETCH_ASSOC);
	
		
		$leavetype = $row['leavetype'];
		$reason = $row['reason'];
		$startd = date('j F, Y', strtotime($row['startdate']));
		$endd = date('j F, Y', strtotime($row['enddate']));

		//$date = date('j F, Y', strtotime($row['date']));
		
    }//end of try
    catch(PDOException $e){
    	 echo "Error: " . $e->getMessage();
    }//end of catch

}//End of GET

//Begin update of leavetrack below
 if(isset($_POST['submit']))
 {
 	

 	$com = htmlspecialchars(strip_tags($_POST['comm']));
	$rec = htmlspecialchars(strip_tags($_POST['rec']));
	$hrdate = date('Y-m-d');
	//echo $com."<br>";
	//echo $rec;

	try{

        $qryu = "UPDATE leavetrack
                 SET hrcom=:com, hrrec=:rec, hrid=:hrid, hrdate =:hrdate
                 WHERE staffid = :staffid";

        // prepare query for excecution
        $stmtu = $con->prepare($qryu);

        // bind the parameters
        $stmtu->bindParam(':hrid', $hrid);
        $stmtu->bindParam(':com', $com);
        $stmtu->bindParam(':rec', $rec);
        $stmtu->bindParam(':hrdate', $hrdate);
        $stmtu->bindParam(':staffid', $staffid);

        // Execute the query
        if($stmtu->execute()){
            echo "<div class='alert alert-success'>Recommendation submited.</div>";
        }else{
            echo "<div class='alert alert-danger'>Unable to give recommendations at the moment. Please try again</div>";
        }

    }

    // show errors
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }

 }//end of update
?>

<!DOCTYPE html>
<html>
<head>
	<title>Leave Status Page</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<div class="container">
		<div class="row hed" >
			<h1 class="h1">Leave Application Status Action Page</h1>
		</div>	
		<!-- End of title  -->
		<div class="row">
			<!-- <p class="para_1">This page contains the status of your application. Each approval will be updated 
			below. Check this page always to know the status of your aplication</p> -->
		</div>
	
		<div class="row">
			<div class="col-md-2">
				<!-- <a href="leave_app.php">Leave Application Form</a><br>
				<a href="officersview.php">Leave Application Status View by Senior Staff</a><br>
				<a href="officerslist.php">Leave Application List</a><br>
				<a href="leavestatus.php">Leave Application Status </a> -->
			</div>
			<div class="col-md-8">
				<div class="bor_der">
				<div class="row">
						<h6 class="col-md-6">Name</h6>
						<h6 class="col-md-6">
							<?php echo $name ?>
						</h6>
				</div>
				
				<div class="row">
						<h6 class="col-md-6"> Leave Type</h6>
						<h6 class="col-md-6">
							<?php echo $leavetype; ?>
						</h6>
				</div>
				
				<div class="row">
						<h6 class="col-md-6"> Leave Start Date</h6>
						<h6 class="col-md-6"> <?php echo $startd; ?></h6>
				</div>

				<div class="row">
						<h6 class="col-md-6"> Leave End Date</h6>
						<h6 class="col-md-6"> <?php echo $endd ?></h6>
				</div>
			<form  class="form-group" action="" method="post">
				<div class="row">
						<h3 class="col-md-6">Comment</h3>
						<textarea class="col-md-5 class="form-control"" name="comm" rows="5" cols="30" required="Comment"></textarea>
				</div>

				<hr>

				<div class="row">
						<h3 class="col-md-6">Recommendation</h3>
						<select name="rec" class="col-md-6 form-control" required="Recommendation">
							<option value=""> Recommendation </option>
							<option value="0"> Deny </option>
							<option value="2"> Approve </option>
						</select>
				</div>

				<hr>

				<div class="row">
					<div class="col-md-6">
						<a href='hrlist.php' class="btn btn-default">Back to Lists of staff</a>
					</div>
					<div class="col-md-6">
						<button class="col-md-4 btn btn-info" name="submit"> Submit </button>
					</div>
					
			</form>
				<!-- New row to keep Leave Status profile -->
				

			</div>
			<div class="col-md-2">
				<!-- Nothing goes here -->
			</div>
	</div>
	</div> <!-- End of Border design 	 -->
			<!-- Display Approval Message -->
			
			
</div>
	

	<script src="js/jquery-slim.min.js"></script>
    <script src="../../dist/js/bootstrap.js"></script>
</body>
</html>