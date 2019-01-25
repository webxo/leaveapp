<?php
# Check for department of the viewing personnel
		//get staff name
		//get staff department
		//link staff to supervisors

        //After testing for department
        //This page gets leave application of staff based on department
        /*************************************************************************/

	include 'config/database.php';
	include 'leavefunction.php';

	checkSession();

	$cat = $_SESSION['staffdetails']['category'];
		
	if(isset($_GET['id']))
	{
		$id  = base64_decode($_GET['id']);
		//$unitprgid = getunitprgid($id);	//$unitprgid is the variable for unit or programs depending on the category of staff.

		try 
    	{
       			#Query to select leave details of the $this staff
        		$query = "SELECT st.fname, st.sname, s.dept, s.hod, l.staffid, l.leavetype, l.reason, l.startdate, l.enddate, l.leavestatus, l.appno, lt.tstaffid, lt.comment, lt.role, lt.transactionid, lt.recstartdate, lt.recenddate, lt.status, lt.timeviewed, lt.remarks, l.location
				  FROM stafflst AS s
                  INNER JOIN leaveapplication AS l
                  ON s.staffid = l.staffid
                  INNER JOIN stafflist AS st
                  ON s.staffid = st.staffid
                  INNER JOIN leavetransaction AS lt
                  ON l.appno = lt.appno
                  WHERE l.staffid = '$id' AND s.category = '$cat'
                  ORDER BY lt.timeviewed DESC";

        		  $stmt = $con->prepare($query);
        	      $stmt->execute();  

	    	      $num = $stmt->rowCount();
        
    	    }//end of try
    		catch(PDOException $e){
    		  echo "Error: " . $e->getMessage();
    	    }//end of catch
	}//end of id
			
	if(isset($_GET['hodid']))
	{
		$hodid = base64_decode($_GET['hodid']);
		$unitprgid = getunitprgid($hodid);	//$unitprgid is the variable for unit or programs depending on the category of staff.
	
		try 
    	{
       	#Query to select leave details of the $this staff
        	$query = "SELECT st.fname, st.sname, s.dept, s.hod, l.staffid, l.leavetype, l.reason, l.startdate, l.enddate, l.leavestatus, l.appno, lt.tstaffid, lt.comment, lt.role, lt.transactionid, lt.recstartdate, lt.recenddate, lt.status, lt.timeviewed, lt.remarks, l.location
				  FROM stafflst AS s
                  INNER JOIN leaveapplication AS l
                  ON s.staffid = l.staffid
                  INNER JOIN stafflist AS st
                  ON s.staffid = st.staffid
                  INNER JOIN leavetransaction AS lt
                  ON l.appno = lt.appno
                  WHERE l.staffid = '$hodid' AND s.category = '$cat'
                  ORDER BY lt.timeviewed DESC";

        	$stmt = $con->prepare($query);
        	$stmt->execute();  

	    	$num = $stmt->rowCount();
        
    	}//end of try
    	catch(PDOException $e){
    		 echo "Error: " . $e->getMessage();
    	}//end of catch
	}//end of hodid
	

	if(isset($_GET['deanid']))
	{
		$deanid = base64_decode($_GET['deanid']);
		//unitprgid($deanid);	//$unitprgid is the variable for unit or programs depending on the category of staff.

	try 
    	{
       	#Query to select leave details of the $this staff
        	$query = "SELECT st.fname, st.sname, s.dept, s.hod, l.staffid, l.leavetype, l.reason, l.startdate, l.enddate, l.leavestatus, l.appno, lt.tstaffid, lt.comment, lt.role, lt.transactionid, lt.recstartdate, lt.recenddate, lt.status, lt.timeviewed, lt.remarks, l.location
				  FROM stafflst AS s
                  INNER JOIN leaveapplication AS l
                  ON s.staffid = l.staffid
                  INNER JOIN stafflist AS st
                  ON s.staffid = st.staffid
                  INNER JOIN leavetransaction AS lt
                  ON l.appno = lt.appno
                  WHERE l.staffid = '$deanid' AND s.category = '$cat'
                  ORDER BY lt.timeviewed DESC";

        	$stmt = $con->prepare($query);
        	$stmt->execute();  

	    	$num = $stmt->rowCount();
        
    	}//end of try
    	catch(PDOException $e){
    		 echo "Error: " . $e->getMessage();
    	}//end of catch
	}//end of deanid

	if(isset($_GET['hrid']))
	{
			$hrid = base64_decode($_GET['hrid']);
			$unitprgid = getunitprgid($hrid);	//$unitprgid is the variable for unit or programs depending on the category of staff.
			
		try 
    	{
       		#Query to select leave details of the $this staff
        	$query = "SELECT st.fname, st.sname, s.dept, s.hod, l.staffid, l.leavetype, l.reason, l.startdate, l.enddate, l.leavestatus, l.appno, lt.tstaffid, lt.comment, lt.role, lt.transactionid, lt.recstartdate, lt.recenddate, lt.status, lt.timeviewed, lt.remarks
				  FROM stafflst AS s
                  INNER JOIN leaveapplication AS l
                  ON s.staffid = l.staffid
                  INNER JOIN stafflist AS st
                  ON s.staffid = st.staffid
                  INNER JOIN leavetransaction AS lt
                  ON l.appno = lt.appno
                  WHERE l.staffid = '$hrid'";

        	 	$stmt = $con->prepare($query);
        		$stmt->execute();  

	    		$num = $stmt->rowCount();
        
    	}//end of try
    	catch(PDOException $e){
    		 echo "Error: " . $e->getMessage();
    	}//end of catch

	}//end of hrid

	if(isset($_GET['regid']))
	{
		$regid = base64_decode($_GET['regid']);
		$unitprgid = getunitprgid($regid);	//$unitprgid is the variable for unit or programs depending on the category of staff.

		try 
    	{
       	#Query to select leave details of the $this staff
        	$query = "SELECT st.fname, st.sname, s.dept, s.hod, l.staffid, l.leavetype, l.reason, l.startdate, l.enddate, l.leavestatus, l.appno, lt.tstaffid, lt.comment, lt.role, lt.transactionid, lt.recstartdate, lt.recenddate, lt.status, lt.timeviewed, lt.remarks
				  FROM stafflst AS s
                  INNER JOIN leaveapplication AS l
                  ON s.staffid = l.staffid
                  INNER JOIN stafflist AS st
                  ON s.staffid = st.staffid
                  INNER JOIN leavetransaction AS lt
                  ON l.appno = lt.appno
                  WHERE l.staffid = '$regid'";

        	$stmt = $con->prepare($query);
        	$stmt->execute();  

	    	$num = $stmt->rowCount();
        
    	}//end of try
    	catch(PDOException $e){
    		 echo "Error: " . $e->getMessage();
    	}//end of catch
	}

		if(isset($_GET['vcid']))
		{
			$vcid = base64_decode($_GET['vcid']);
			$unitprgid = getunitprgid($vcid);	//$unitprgid is the variable for unit or programs depending on the category of staff.

			try 
    		{
       			#Query to select leave details of the $this staff
        		$query = "SELECT st.fname, st.sname, s.dept, s.hod, l.staffid, l.leavetype, l.reason, l.startdate, l.enddate, l.leavestatus, l.appno, lt.tstaffid, lt.comment, lt.role, lt.transactionid, lt.recstartdate, lt.recenddate, lt.status, lt.timeviewed, lt.remarks
				  FROM stafflst AS s
                  INNER JOIN leaveapplication AS l
                  ON s.staffid = l.staffid
                  INNER JOIN stafflist AS st
                  ON s.staffid = st.staffid
                  INNER JOIN leavetransaction AS lt
                  ON l.appno = lt.appno
                  WHERE l.staffid = '$vcid'";

        		$stmt = $con->prepare($query);
        		$stmt->execute();  

	    		$num = $stmt->rowCount();
        
    		}//end of try
    		catch(PDOException $e){
    		 echo "Error: " . $e->getMessage();
    		}//end of catch
		}

    //end of catch	
?>


<!DOCTYPE html>
<html>
<head>
	<title>View leave Page</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<body>
<div class="container">

		<div class="row hed">
			<div class="col-md-4"></div>
			<h3 style="text-align: center;">Application Status View</h3>
		</div>	
		<!-- End of title  -->
		
		
		<div class="row">
			<div class="col-md-1"></div>
            <table class="table-sm">
					<tr>
						<th> No</th>
						<th> Action Date</th><!--Transaction Date-->
						<th> Staff Name</th>
						<th> Role</th>
						<th> App No</th>
						<th> Leave Type</th>
						<th> Reason</th>
						<th> Start Date</th>
						<th> End Date</th>
						<th> Days</th>
						<th> Location</th>
						<th> Remark</th>
						<th> Status</th>
					</tr>

			<?php 
				if ($num > 0) { //if starts here
					$n = 1;
					
					while($row=$stmt->fetch(PDO::FETCH_ASSOC))         
		            {
		               //extract row this truns array keys into variables
		               //extract($row);
		               //create new row per record
		               echo "<tr>";
		                  echo "<td>".$n++."</td>";
		                  echo "<td>".date('j M, Y - h:i:s', strtotime($row['timeviewed']))."</td>";
		                  echo "<td>".getname($row['tstaffid'])."</td>";
		                  echo "<td>".$row['role']."</td>";
		                  echo "<td>".$row['appno']."</td>";
		                  echo "<td>".$row['leavetype']."</td>";
		                  echo "<td>".$row['reason']."</td>";
		                  echo "<td>".date('j M, Y', strtotime($row['recstartdate']))."</td>";
		                  echo "<td>".date('j M, Y', strtotime($row['recenddate']))."</td>";
		                  echo "<td>".numdays($row['recstartdate'], $row['recenddate'])."</td>";
		                  echo "<td>".$row['location']."</td>";
		                  echo "<td>".$row['remarks']."</td>";
		                  //echo "<td>".$row['tstaffid']."</td>";
		                  echo "<td>".$row['status']."</td>";
		                  
		                  /*
		                  $leavestatus = $row['status'];
		                  if ($leavestatus == 1) {
		                  	echo "<td>Submitted</td>";
		                  } elseif ($leavestatus == 0) {
		                  	echo "<td>Not recommended</td>";
		                  } else {
		                  	echo "<td>Recommended</td>";
		                  }
		                  */                

		                  //$startd = date('j F, Y', strtotime($row['startdate']));
		                  //echo "<td>".date('j M, Y', strtotime($row['timeviewed']))."</td>";
		                  /*
		                  echo "<td>";
		                      //view a single record
		                  echo "<a href='leavedash.php?id={$row['appno']}' class='btn btn-info btn-sm m-r-0em'>View</a>";
		                      //link to update record
		                  echo "</td>";
		                  */
		             }//end of while loop
                }//end of if statement for printing results into tables 
				else {
					echo "<tr>";
					echo "<td colspan=\"13\"> No application in progress yet.</td>";
					echo "</tr>";
				}
			?> 
			 
			</table>
		</div>
		<!-- End of table list
		<p style="text-align: center;"><b> Rec = Reccommended </b></p> -->
		<p> &nbsp; </p>
	<p style="text-align: right;">
			<button onclick="goBack()" class="btn btn-default">Back to dashboard</button>
	</p>
		
</div>

	<script src="js/jquery-slim.min.js"></script>
    <script src="../../dist/js/bootstrap.js"></script>
    <script>
		function goBack() {
  			window.history.back();
		}
	</script>
</body>
</html>