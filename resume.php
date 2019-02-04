<?php
/*
Developer: Ekunkoya Isaiah
Site:      ekunkoya.com.ng
Script:    Insert data into transaction table
File:      leavetrack.php
For every appno entrying this file, the transactionid increases by 1.
*/

include('config/database.php');
include('leavefunction.php');

checkSession();
$staffid = $_SESSION['staffdetails']['staffid'];

$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
<!DOCTYPE html>
<html>
<head>
<title></title>

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <!--  <link rel="stylesheet" href="/resources/demos/style.css"> -->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous">
</script>

<!------ Include the above in your HEAD tag ---------->
<style type="text/css">
  #space{
    padding-top: 100px;
  }

.adiff {
  position: absolute;
  top: 237px;
  right: -90px;
  width: 100px;
  height: 40px;
  padding: 3px;
  margin-left: 10px;  
}

.dialog{
	display: none;
}
</style>

</head>
<body>

<div></div>
  <div id="space" class="row">
    <div class="col-md-6 col-md-offset-2">
      <form class="form-horizontal" role="form" action="" method="POST">
        <fieldset>

          <!-- Form Name -->
          <legend>Duty Resumption Form</legend>
      <div>
        <p id="message">    </p>
         <input type="hidden" id="staffid" name="staffId" value="<?php echo $staffid; ?>">
      </div>        

      <?php
          if(isset($_POST['submit']))
            {
              if($_POST['resume'] == 'Resumed')
              {
                  echo "Resume";

                  $resumeddate = date('Y-m-d H:i:s');
                  $resumed = 1;

                  $qry1 = "UPDATE approvedleaves 
                            SET resumeddate = :resumeddate, resumed =:resumed
                              WHERE staffid = :staffid";

                  // prepare query for excecution
                  $stmt1 = $con->prepare($qry1);     

                  // bind the parameters
                  $stmt1->bindParam(':resumeddate', $resumeddate);
                  $stmt1->bindParam(':resumed', $resumed);
                  $stmt1->bindParam(':staffid', $staffid);
    
                  if($stmt1->execute());
                  {
                    header("location: leavedashboard.php?id=".base64_encode($staffid));
                      //$message = "<br> Query Submitted";
                      //echo $message;
                  }
              }
              else
              {
                echo "Not yet Resumed";
              }
   
           }//end of if isset
			?>

      <div class="form-group">
        <label class="col-sm-3 control-label" for="textinput">Resumption Option</label>
         <div class="col-sm-9">

          <label class="radio-inline"><input type="radio" name="resume" value="Resumed" checked>Resumed</label>
          <label class="radio-inline"><input type="radio" name="resume" value="Not Yet Resumed">Not Yet Resumed</label>         
			</div>
  </div>
</fieldset>
       <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="pull-right">
                <a class="btn btn-default" href='leavedashboard.php?id= <?php echo base64_encode($_SESSION['staffdetails']['staffid']); ?>'>Cancel</a>
                 <button type="submit" name ="submit" class="btn">Submit</button>
              </div>
            </div>
          </div>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
</form>

</body>
</html>