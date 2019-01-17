<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config/database.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $fname = $_POST['fname'];
    $sname = $_POST['sname'];

    $sql = "SELECT idno, fname, sname FROM userz WHERE fname = :fname";

    $stmt = $con -> prepare($sql);
    $stmt->bindParam(":fname", $fname, PDO::PARAM_STR);

    try{
        $stmt -> execute();

        $row = $stmt -> fetch();
        if ($sname == $row['sname']) {
            session_start();
                            
           // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $row['idno'];
            $_SESSION["username"] = $row['fname'];                            
                            
           // Redirect user to welcome page
            header("location: welcome.php");
            //echo "User Present";
        } else {
            echo "User not Present";
        }
    }  catch(PDOException $e){ $e->getMessage();}

}
 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php //echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="fname" class="form-control" >
                <span class="help-block"><?php// echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php //echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="sname" class="form-control">
                <span class="help-block"><?php //echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>