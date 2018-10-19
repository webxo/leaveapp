<?php

	

	include 'config/database.php';

	
		$hodid = "cu/05/89";
		$staffid = "cu18166";

		# Check for department
		$querydept = "SELECT unit 
						FROM pdata 
						WHERE hodid = ?";

		$stmt = $con->prepare($querydept);
		$stmt->bindParam(1, $hodid);
		$stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //test for the department



        //After testing for department
        /*************************************************************************/
    try {
        $queryleave = "SELECT pdata.staffid, staffname, appno, leavetype, appstatus
        				FROM pdata 
        				JOIN leaveapp 
        				ON pdata.staffid = leaveapp.staffid";
		$stmtleave = $con->prepare($queryleave);
		$stmtleave->bindParam(1, $hodid);
		$stmtleave->execute();
        
        $num = $stmtleave->rowCount();
        
    }//end of try
    catch(PDOException $e){
    	 echo "Error: " . $e->getMessage();
    }//end of catch
        
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Leave Status Page</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<body>
<div class="container">
		<div class="row hed" >
			<h1 class="h1">Staff Leave Application View </h1>
		</div>	
		<!-- End of title  -->
		
		
		<div class="row">
			<table class="table table-bordered">
					<tr>
						<th> No</th>
						<th> StaffID</th>
						<th> Staff Name</th>
						<th> Leave type</th>
						<th> Status</th>
						<th> Action</th>
					</tr>

			<?php 
				if ($num > 0) { //if starts here
					$n = 1;
					
					while($row=$stmtleave->fetch(PDO::FETCH_ASSOC))
		             {
		               //extract row this truns array keys into variables
		               extract($row);
		               //create new row per record
		               echo "<tr>";
		                  echo "<td>".$n++."</td>";
		                  echo "<td>{$staffid}</td>";
		                  echo "<td>{$staffname}</td>";
		                  echo "<td>{$leavetype}</td>";
		                  echo "<td>{$appstatus}</td>";
		                  echo "<td>";
		                      //view a single record
		                  echo "<a href='officersview.php?id={$staffid}' class='btn btn-info m-r-1em'>View</a>";
		                      //link to update record
		                  echo "</td>";
		             }//end of while loop
                }//end of if statement for printing results into tables 
				else {
					echo "<tr>";
					echo "<td colspan=\"6\"> No Staff Applied for leave yet</td>";
					echo "</tr>";
				}
			?> 
			 
				
			</table>
		</div>
		<!-- End of table list -->
</div>

	<script src="js/jquery-slim.min.js"></script>
    <script src="../../dist/js/bootstrap.js"></script>
</body>
</html>