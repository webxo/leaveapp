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

  checksession();

  echo $_SESSION['category'];
  $cat = $_SESSION['category'];

?>
<!DOCTYPE html>
<html>
<head>
  <title>View leave Page</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
<body>
<div class="container">
    <div class="row hed" >
      <div class="col-md-3"></div>
      <h3 class="h3">
      Pending Leave Application For
      <?php 
              if (isHod($_SESSION['loginid'])) {
                  echo getdept($_SESSION['loginid'])." Department";
              } 
              
              elseif (isdean($_SESSION['loginid'])) 
              {
                echo getkol($_SESSION['loginid']);
              }//end of if statement 
          
          ?> 
        </h3>
    </div>  
    <!-- End of title  -->
    
    <div class="row">
      <div class="col-md-3"></div>
          <table class="table-sm ">
       
<?php 

  if(isset($_GET['hodid']))

  {
      $hodid = base64_decode($_GET['hodid']);
      $unitprgid = getunitprgid($hodid);  //$unitprgid is the variable for unit or programs depending on the category of staff.

    try 
      {
        #Query to select leave details of the $this staff
          $query = "SELECT lt.timeviewed, l.staffid, lt.appno, l.leavetype, l.reason, l.startdate, l.enddate, l.location, lt.remarks, lt.status, st.coldirid, st.hod, st.dean, st.dept
          FROM leavetransaction AS lt
          INNER JOIN leaveapplication AS l
          ON lt.appno = l.appno
          INNER JOIN stafflst AS st
          ON st.staffid = l.staffid
          WHERE st.unitprgid = '$unitprgid' 
          AND st.staffid != '$hodid' 
          AND lt.status = 'SUBMITTED'
          AND st.category = '$cat'
          ORDER BY lt.timeviewed DESC";

        $stmt = $con->prepare($query);
        $stmt->execute();  

        $num = $stmt->rowCount();
        
    }//end of try
    catch(PDOException $e){
         echo "Error: " . $e->getMessage();
     }//end of catch

     #Table begins below

          echo "<tr>";
            echo "<th> No</th>";
            echo "<th> Action Date</th>";
            echo "<th> Staff Name</th>";
            echo "<th> Appno</th>";
            echo "<th> Leave Type</th>";
            echo "<th> Reason</th>";
            echo "<th> Start Date</th>";
            echo "<th> End Date</th>";
            echo "<th> Days</th>";
            echo "<th> Location</th>";
            echo "<th> Remarks</th>";
            echo  "<th> Status</th>";
            echo "<th> Action</th>";
         echo "</tr>";
 
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
                      echo "<td>".getname($row['staffid'])."</td>";
                      echo "<td>".$row['appno']."</td>";
                      echo "<td>".$row['leavetype']."</td>";
                      echo "<td>".$row['reason']."</td>";
                      echo "<td>".date('j M, Y', strtotime($row['startdate']))."</td>";
                      echo "<td>".date('j M, Y', strtotime($row['enddate']))."</td>";
                      echo "<td>".numdays($row['startdate'], $row['enddate'])."</td>";
                      echo "<td>".$row['location']."</td>";
                      echo "<td>".$row['remarks']."</td>";
                      echo "<td>".$row['status']."</td>";
                      
                      echo "<td>";
                          //view a single record
                      $appno = $row['appno'];
                      echo '<a href="leavedash.php?appno='.base64_encode($appno).'" class="btn btn-sm m-r-0em">Review</a>';
                          //link to update record
                      echo "</td>";
                  echo "</tr>";
                 }//end of while loop
                }//end of if statement for printing results into tables 
        else {
          echo "<tr>";
                    echo "<td colspan=\"13\"> No Staff Applied for leave yet</td>";
          echo "</tr>";
        }
      
       
     echo "</table>";
    echo "</div>";
  
 }//end of if HOD id is set


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 #Dean or Director section

  if(isset($_GET['deanid']))
  {
    $deanid = base64_decode($_GET['deanid']);
    $coldirid = getcolid($deanid);  //$unitprgid is the variable for unit or programs depending on the category of staff.
      //echo $coldeanid;
    try 
      {
        #Query to select leave details of the $this staff
          $query ="SELECT lt.timeviewed, l.staffid, lt.appno, l.leavetype, l.reason, l.startdate, l.enddate, l.location, lt.remarks, lt.status, st.coldirid, st.hod,st.dean, st.dept
          FROM leavetransaction AS lt
          INNER JOIN leaveapplication AS l
          ON lt.appno = l.appno
          INNER JOIN stafflst AS st
          ON st.staffid = l.staffid
          WHERE st.coldirid = '$coldirid' 
          AND st.staffid != '$deanid' 
          AND st.category = '$cat'
          AND lt.status = 'RECOMMENDED' 
          ORDER BY lt.appno DESC
          ORDER BY lt.timeviewed DESC";


        $stmt = $con->prepare($query);
        $stmt->execute();  

        $num = $stmt->rowCount();
        
       }//end of try
       catch(PDOException $e){
       echo "Error: " . $e->getMessage();
       }//end of catch

       #Table begins below

          echo "<tr>";
            echo "<th> No</th>";
            echo "<th> Action Date</th>";
            echo "<th> Staff Name</th>";
            echo "<th> Dept</th>";
            echo "<th> Appno</th>";
            echo "<th> Leave Type</th>";
            echo "<th> Reason</th>";
            echo "<th> Start Date</th>";
            echo "<th> End Date</th>";
            echo "<th> Days</th>";
            echo "<th> Location</th>";
            echo "<th> Remarks</th>";
            echo  "<th> Status</th>";
            echo "<th> Action</th>";
         echo "</tr>";
 
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
                      echo "<td>".getname($row['staffid'])."</td>";
                      echo "<td>".$row['dept']."</td>";
                      echo "<td>".$row['appno']."</td>";
                      echo "<td>".$row['leavetype']."</td>";
                      echo "<td>".$row['reason']."</td>";
                      echo "<td>".date('j M, Y', strtotime($row['startdate']))."</td>";
                      echo "<td>".date('j M, Y', strtotime($row['enddate']))."</td>";
                      echo "<td>".numdays($row['startdate'], $row['enddate'])."</td>";
                      echo "<td>".$row['location']."</td>";
                      echo "<td>".$row['remarks']."</td>";
                      echo "<td>".$row['status']."</td>";
                      
                      echo "<td>";
                          //view a single record
                      $appno = $row['appno'];
                      echo '<a href="leavedash.php?appno='.base64_encode($appno).'" class="btn btn-sm m-r-0em">Review</a>';
                          //link to update record
                      echo "</td>";
                  echo "</tr>";
                 }//end of while loop
                }//end of if statement for printing results into tables 
        else {
          echo "<tr>";
                    echo "<td colspan=\"14\"> No Staff Applied for leave yet</td>";
          echo "</tr>";
        }
      
       
     echo "</table>";
    echo "</div>";

  
  } ////end of if Dean id is set

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  if(isset($_GET['hrid']))
  {
    $hrid = base64_decode($_GET['hrid']);
    $unitprgid = getunitprgid($hrid); //$unitprgid is the variable for unit or programs depending on the category of staff.
  
    try 
    {
        #Query to select leave details of the $this staff
          $query = "SELECT st.fname, st.sname, s.dept, s.hod, l.staffid, l.leavetype, l.leavestatus, l.appno
            FROM stafflst AS s
                    INNER JOIN leaveapplication AS l
                    ON s.staffid = l.staffid
                    INNER JOIN stafflist AS st
                    ON s.staffid = st.staffid
                    WHERE s.coldeanid = '$coldeanid'
                    AND s.staffid != '$hrid'
                    ORDER BY lt.timeviewed DESC";

        $stmt = $con->prepare($query);
        $stmt->execute();  

      $num = $stmt->rowCount();
        
      }//end of try
      catch(PDOException $e){
         echo "Error: " . $e->getMessage();
        }//end of catch   
  }//end of hrid

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  #
  if(isset($_GET['regid']))
  {
    $regid = base64_decode($_GET['regid']);
    $unitprgid = getunitprgid($regid);  //$unitprgid is the variable for unit or programs depending on the category of staff.
    
    try 
    {
        #Query to select leave details of the $this staff
          $query = "SELECT st.fname, st.sname, s.dept, s.hod, l.staffid, l.leavetype, l.leavestatus, l.appno
            FROM stafflst AS s
                    INNER JOIN leaveapplication AS l
                    ON s.staffid = l.staffid
                    INNER JOIN stafflist AS st
                    ON s.staffid = st.staffid
                    WHERE s.coldeanid = '$coldeanid'
                    AND s.staffid != '$regid'";

        $stmt = $con->prepare($query);
        $stmt->execute();  

      $num = $stmt->rowCount();
        
      }//end of try
      catch(PDOException $e){
         echo "Error: " . $e->getMessage();
        }//end of catch
  }//end of regid

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
  if(isset($_GET['vcid']))
  {
    $vcid = base64_decode($_GET['vcid']);
    $unitprgid = getunitprgid($vcid); //$unitprgid is the variable for unit or programs depending on the category of staff.
    
    try 
    {
        #Query to select leave details of the $this staff
          $query = "SELECT st.fname, st.sname, s.dept, s.hod, l.staffid, l.leavetype, l.leavestatus, l.appno
            FROM stafflst AS s
                    INNER JOIN leaveapplication AS l
                    ON s.staffid = l.staffid
                    INNER JOIN stafflist AS st
                    ON s.staffid = st.staffid
                    WHERE s.coldeanid = '$coldeanid'
                    AND s.staffid != '$vcid'";

        $stmt = $con->prepare($query);
        $stmt->execute();  

      $num = $stmt->rowCount();
        
      }//end of try
      catch(PDOException $e){
         echo "Error: " . $e->getMessage();
        }//end of catch
  }//end of vcid      
  
?>


    <!-- End of table list -->
    <div>&nbsp;</div>
    <div>&nbsp;</div>
    <div>&nbsp;</div>

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