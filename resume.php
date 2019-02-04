<?php

/*
Developer: Ekunkoya Isaiah
Site:      ekunkoya.com.ng
Script:    Insert data into transaction table
File:      leavetrack.php
For every appno entrying this file, the transactionid increases by 1.
*/

// $staffid = implode(',', array_map(function($el){ return $el['idno']; }, get_user($_SESSION['loginid']))) ?implode(',', array_map(function($el){ return $el['idno']; }, get_user($_SESSION['loginid']))) : $_GET[''];


include('config/database.php');
include('leavefunction.php');

checkSession();
$staffid = $_SESSION['staffdetails']['staffid'];

$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/*
echo $_SESSION['loginid']."<br>";

if(isdean($_SESSION['loginid'])){
  echo "DEAN";
}

if(isHod($_SESSION['loginid'])){
  echo "HOD";
}
*/

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
          		//$loginid = $_SESSION['loginid'];

          		$qry = "SELECT staffid, sname, fname FROM stafflst";
  				    $stmt = $con->prepare($qry);
	       			$stmt->execute();

				      //$staff = $stmt->fetch(PDO::FETCH_ASSOC);
			?>

      <div class="form-group">
        <label class="col-sm-3 control-label" for="textinput">Resumption Option</label>
         <div class="col-sm-9">
           <?php          
            	$select = '<select name="officer1" id="officer1" class="form-control" required>';
            		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            			$result[] = $row; 
                $select .= '<option value = "'.$row['staffid'].'">'.$row['sname'].' '.$row['fname'].'</option>';
                     }//end of while statement 
              	$select .= '</select>';
              	echo $select;
                       
          ?>
			</div>
  </div>
     
</fieldset>
      </form>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="pull-right">
                <a class="btn btn-default" href='leavedashboard.php?id= <?php echo base64_encode($_SESSION['staffdetails']['staffid']); ?>'>Cancel</a>
                 <button type="submit" class="btn" id="apply">Submit</button>
              </div>
            </div>
          </div>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->


<script type="text/javascript">
  
  $(function(){

  //$( "#sdate" ).datepicker( "input", "dateFormat", "d-M-yy");
    $("#edate").change(function(ev){

      ev.preventDefault();

      var sdate = $("#sdate").val();
      var edate = $("#edate").val();

      $.ajax({
        type: "POST",
        url: "datediff.php",
        data: {
            sdate:sdate,
            edate:edate
        },
        dataType: "text",
            success: function(res) {
                //alert(data);
                //$("#message").html(data);
                
                $("#datedif").addClass("adiff");
                $('p#datedif').html(res);
              },
            error: function(data) {
                $("#message").html(data);
                $("p").addClass("alert alert-danger");
            },
      });
    
      //alert("The text has been changed.");
    
    });
    
  $("#apply").on('click', function(e){
    
    e.preventDefault();

    var leavetype = $("#leavetype").val();
    var reason = $("#reason").val();
    var sdate = $("#sdate").val();
    var edate = $("#edate").val();
    var location = $("#location").val();
    var phone = $('#phone').val();
    var officer1 = $("#officer1").val();
    var officer2 = $("#officer2").val();
    var officer3 = $("#officer3").val();

    var staffid = $('#staffid').val();

    //hurl = 'redrect.php';
	if ((leavetype == '') || (reason == '') || (sdate == '') || (edate == '') || (location == '') || (phone == '') || (officer1 == '') || (officer2 == '') || (officer3 == ''))
		 {
				alert("All fields are required.");
			}
else {
        
// AJAX code to send data to php file.
    $.ajax({
            type: "POST",
            url:   "leavein.php",
            data: {
              leavetype:leavetype,
              reason:reason,
              sdate:sdate,
              edate:edate,
              location:location,
              phone:phone,
              officer1:officer1,
              officer2:officer2,
              officer3:officer3
            },
            dataType: "text",
            success: function(response) {
            	if (response == 'SUCCESS') {
            		alert("Application Successful. You will be redirected to Dashboard");
            		window.location.replace("leavedashboard.php?id="+btoa(staffid));
            	}

            	if (response == 'ERROR') {
            		alert("Try Again");
            	}

            	if (response == 'EMPTY FORM') {
            		alert("One part of the form is not filled");
            	}

              if (response == 'DATABASE ERROR') {
                alert("Try again later");
              }
            },
            error: function(data) {
                $("#message").html(data);
                $("p").addClass("alert alert-danger");
            },
        });
	}//end of if else

  });

  
});
</script>

</body>
</html>