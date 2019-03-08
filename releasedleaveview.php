<?php
# Check for department of the viewing personnel
    //get staff name
    //get staff department
    //link staff to supervisors

        //After testing for department
        //This page gets approved leave application of staff
        /*************************************************************************/

  include 'config/database.php';
  include 'leavefunction.php';

  checksession();

//  echo $_SESSION['category'];
  $staffid = $_SESSION['staffdetails']['staffid'];
  $dept = $_SESSION['staffdetails']['dept'];
  $kol = $_SESSION['staffdetails']['kol'];
  $cat = $_SESSION['staffdetails']['category'];
  $hodid = $_SESSION['staffdetails']['hod'];
  $deanid = $_SESSION['staffdetails']['dean'];
  $hro = $_SESSION['staffdetails']['hro'];
  $rego = $_SESSION['staffdetails']['rego'];
  $vco = $_SESSION['staffdetails']['vco'];
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
      <div class="col-md-5"></div>
      <h3 class="h3">
      
      <?php 
         echo "Released Leave";
      ?> 
        </h3>
    </div>  
    <!-- End of title  -->
</div>
    
<div class="container">
    <div class="row">
      <div class="col-md-3"></div>
          <table class="table-sm ">
       
<?php 

if(isset($_GET['id']))
{
  $id = base64_decode($_GET['id']);  
    
     try 
      {
        #Query to select leave details of the $this staff
          $query ="SELECT st.fname, st.sname, st.dept, al.staffid, al.appno, al.leavetype, al.apstartdate, al.apenddate, al.location, al.phone, al.releaseddate, al.resumeddate
                    FROM approvedleaves AS al
                    INNER JOIN stafflst AS st
                    ON st.staffid = al.staffid        
                    ORDER BY al.appno DESC";


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
            echo "<th> Staff Name</th>";
            echo "<th> Dept</th>";
            echo "<th> Appno</th>";
            echo "<th> Leave Type</th>";
            echo "<th> Start Date</th>";
            echo "<th> End Date</th>";
            echo "<th> Days</th>";
            echo "<th> Location</th>";
            echo  "<th> Phone</th>";
            echo  "<th> Release Date</th>";
            //echo  "<th> Resumption Date</th>";
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
                      //echo "<td>".date('j M, Y - h:i:s', strtotime($row['timeviewed']))."</td>";
                      echo "<td>".getname($row['staffid'])."</td>";
                      echo "<td>".$row['dept']."</td>";
                      echo "<td>".$row['appno']."</td>";
                      echo "<td>".$row['leavetype']."</td>";
                     // echo "<td>".$row['reason']."</td>";
                      echo "<td>".date('j M, Y', strtotime($row['apstartdate']))."</td>";
                      echo "<td>".date('j M, Y', strtotime($row['apenddate']))."</td>";
                      echo "<td>".numdays($row['apstartdate'], $row['apenddate'])."</td>";
                      echo "<td>".$row['location']."</td>";
                      echo "<td>".$row['phone']."</td>";
                      echo "<td>".$row['releaseddate']."</td>";
                      //echo "<td>".$row['resumeddate']."</td>";
                      //echo "<td>".$row['status']."</td>";
                      
                      echo "<td>";
                          //view a single record
                      $appno = $row['appno'];
                      echo '<a href="releasedleavedash.php?appno='.base64_encode($appno).'" class="btn btn-sm m-r-0em">View Details</a>';
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
  }       
       
?>


    <!-- End of table list -->
    <div>&nbsp;</div>

  <p style="text-align: right;">
    <button>
          <a style="font-size: 14px;" href="leavedashboard.php?id= <?php echo base64_encode($_SESSION['staffdetails']['staffid']); ?>">Dashboard</a>
        </button>
      <!-- <button onclick="goBack()" class="btn btn-default">Back to dashboard</button> -->
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