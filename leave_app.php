
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
			<p class="para_1">This page contains the status of your application. Each approval will be updated 
			below. Check this page always to know the status of your aplication</p>
		</div>
	
		<div class="row">
			<div class="col-md-2">
				<a href="leave_app.php">Leave Application Form</a><br>
				<a href="officersview.php">Leave Application Status View by Senior Staff</a><br>
				<a href="officerslist.php">Leave Application List</a><br>
				<a href="leavestatus.php">Leave Application Status </a>
			</div>
	<form  class="form-group"> <!-- Form Begins Here -->
			<div class="col-md-8">
				<div class="bor_der">
				<div class="row">
						<h3 class="col-md-6">Name</h3>
						<h4 class="col-md-6"> Akomoled Moses</h4>
				</div>
				
				<div class="row">
						<h3 class="col-md-6"> Leave Type</h3>
						<h4 class="col-md-6"> Annual</h4>
				</div>
				
				<div class="row">
						<h3 class="col-md-6"> Leave Start Date</h3>
						<h4 class="col-md-6"> 12/12/2019</h4>
				</div>

				<div class="row">
						<h3 class="col-md-6"> Leave Start Date</h3>
						<h4 class="col-md-6"> 12/12/2019</h4>
				</div>
			
				<div class="row">
						<h3 class="col-md-6">Recommendation</h3>
						<textarea class="col-md-5 class="form-control"" name="recc" rows="5" cols="30"></textarea>
				</div>

				<hr>

				<div class="row">
						<h3 class="col-md-6">Comment</h3>
						<select name="comment" class="col-md-6 form-control">
							<option value="deny"> Deny </option>
							<option value="approve"> Approve </option>
						</select>
				</div>

				<hr>

				<div class="row">
					<div class="col-md-4"></div>
						<button class="col-md-4 btn btn-info"> Submit </button>
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
			<div class="row appr-status">
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
			</div>
			
		</div>
	

	<script src="js/jquery-slim.min.js"></script>
    <script src="../../dist/js/bootstrap.js"></script>
</body>
</html>