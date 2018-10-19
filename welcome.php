<?php
include "leavefunction.php";
//check for session
checkSession();

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
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to apply for your leave.</h1>
    </div>
    <p>
        <a href="passwordreset.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>

    <p>
        <a href="leaveapp.php" class="btn btn-info">Apply for leave</a>
        <a href="leavestatus.php" class="btn btn-success">Check your application status</a>
    </p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>View list of Staffs that have applied for leave</p>
    <p>
        <a href="hodlistview.php" class="btn btn-default">HOD</a>
        <a href="deanlistview.php" class="btn btn-default">Director OR Dean</a>
        <a href="hrlistview.php" class="btn btn-default">Establishement HR</a>
        <a href="reglistview.php" class="btn btn-default">Registrar</a>
        <a href="vclistview.php" class="btn btn-default">VC list</a>
        
    </p>
</body>
</html>