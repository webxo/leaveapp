<?php
include 'config/database.php';
include "leavefunction.php";
//check for session
checkSession();

print_r($_SESSION['staffdetails']);

$staffid = $_SESSION["staffdetails"]['staffid'];
$hodid = $_SESSION["staffdetails"]['hod'];
$cat = $_SESSION["staffdetails"]['category'];
$deanid = $_SESSION["staffdetails"]['dean'];


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
    The query below is to find if a staff has been released so as to allow the resume work button to be activated. If the query is false then the button will not be activated for the staff.
*/
            $query = "SELECT releaseddate, resumed, resumeddate
                        FROM approvedleaves
                        WHERE staffid = '$staffid'";
              
            $stmt = $con->prepare($query);
            $stmt->execute();

            $num = $stmt->rowCount();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $resumed = $row['resumeddate'];

            echo $resumed. "<br>"

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h3><b><?php //echo getname(htmlspecialchars($_SESSION["loginid"])); ?></b>Leave Application Dashboard</h3>
    </div>
    <?php 
        if(isset($_GET['id']))
            $id = base64_decode($_GET['id']);
              {

    ?>
<div class="container">
    <div class="row">
        <div class="col-md-7">
            <h3>Personal Leave Tab</h3>
              <p><a href="leaveapp.php" class="btn btn-default">Make New Application</a></p>

        <?php 
                echo '<p><a href="leavestatus.php?id='.base64_encode($id).'" class="btn btn-default">View Application Status</a></p>'; 
                

                    if ($num > 0 ) {
                        echo ' <p><a href="resume.php?id='.base64_encode($id).'" class="btn btn-default">Resume Work</a></p>'; 
                        
                    }//the query to check if released date of staff exist
            ?>
        </div>

        <div class="col-md-3">
            <h3>Official Leave Tab</h3>
        <?php 
                 if ($hodid == $id) {
                    echo "HOD";                       
                    echo '<p> <a href="leaveview.php?id='.base64_encode($id).'" class="btn btn-default">View Pending Applications</a></p>';
                    echo '<p> <a href="viewresumedstaff.php?id='.base64_encode($id).'" class="btn btn-default">View Resumed Staff</a></p>';
                }
                if ($deanid == $id) {
                    echo "DEAN";
                    echo ' <p><a href="leaveview.php?id='.base64_encode($id).'" class="btn btn-default">View Pending Applications</a></p>';
                }
                if ($_SESSION['staffdetails']['hro'] == $id) {
                     echo '<p> <a href="leaveview.php?id='.base64_encode($id).'" class="btn btn-default">View Pending Applications</a></p>';
                     echo '<p> <a href="approvedleaveview.php?id='.base64_encode($id).'" class="btn btn-default">View Approved Leave</a></p>';
                     echo '<p> <a href="releasedleaveview.php?id='.base64_encode($id).'" class="btn btn-default">View Released Leave</a></p>';
                     echo ' <a href="staffresumed.php?id='.base64_encode($id).'" class="btn btn-default">View Resumed Staff</a>';
                }
                if ($_SESSION['staffdetails']['rego'] == $id) {
                    echo '<p> <a href="leaveview.php?id='.base64_encode($id).'" class="btn btn-default">View Pending Applications</a></p>';
                }
                if ($_SESSION['staffdetails']['vco'] == $id) {
                    echo ' <p><a href="leaveview.php?id='.base64_encode($id).'" class="btn btn-default">View Pending Applications</a></p>';
                }
        ?>
        </div>
    </div><!--end of row-->
    <div class="row"> 
        <p> <a href="logout.php" class="btn btn-default">Sign Out</a> </p>
    </div>
</div>
<?php }// end of if isset get id?>
  
 
</body>
</html>