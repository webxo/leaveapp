<?php
include "leavefunction.php";
//check for session
checkSession();

print_r($_SESSION['staffdetails']);

  
$hodid = $_SESSION["staffdetails"]['hod'];
$cat = $_SESSION["staffdetails"]['category'];
$deanid = $_SESSION["staffdetails"]['dean'];


   
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
    <p>
        <a href="leaveapp.php" class="btn btn-default">Make New Application</a>
        
    
        <?php 

            if(isset($_GET['id']))
                $id = base64_decode($_GET['id']);
            {

                echo '<a href="leavestatus.php?id='.base64_encode($id).'" class="btn btn-default">View Application Status</a>'; 

                if ($hodid == $id) {
                    echo "HOD";                       
                    echo ' <a href="leaveview.php?id='.base64_encode($id).'" class="btn btn-default">View Pending Applications</a>';
                }
                if ($deanid == $id) {
                    echo "DEAN";
                    echo ' <a href="leaveview.php?id='.base64_encode($id).'" class="btn btn-default">View Pending Applications</a>';
                }
                if ($_SESSION['staffdetails']['hro'] == $id) {
                     echo ' <a href="leaveview.php?hrid='.base64_encode($id).'" class="btn btn-default">View Pending Applications</a>';
                }
                if ($_SESSION['staffdetails']['rego'] == $id) {
                    echo ' <a href="leaveview.php?hrid='.base64_encode($id).'" class="btn btn-default">View Pending Applications</a>';
                }
                if ($_SESSION['staffdetails']['vco'] == $id) {
                    echo ' <a href="leaveview.php?hrid='.base64_encode($id).'" class="btn btn-default">View Pending Applications</a>';
                }


            }//end of if $_GET
        
        ?>
    </p>

    <p> <a href="logout.php" class="btn btn-default">Sign Out</a> </p>      

</body>
</html>