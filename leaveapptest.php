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
$level = $_SESSION['staffdetails']['level'];

//$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      //officer query
        $qry = "SELECT staffid, sname, fname FROM stafflst";
        $stmt = $con->prepare($qry);
        $stmt->execute();
       //$staff = $stmt->fetch(PDO::FETCH_ASSOC);
 /////////////////////////////////////////////////////////////////////////////////       
        #leavetype query
        $ltypeqry = "SELECT sn,type FROM leavetypes";
        $stmt1 = $con->prepare($ltypeqry);
        $stmt1->execute();

?>
<!DOCTYPE html>
<head>
<title>Leave Application Form</title>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <!-- <script src="js/jquery.js"></script>
  <script src="js/bootstrap.js"></script>
  <link rel="stylesheet" href="css/bootstrap.min.css"> -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  
  <script src="js/datepicker.js"></script>

<!-------------------------------------------------Include the above in your HEAD tag--------------------------------------------------------------->
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

<div id="dataModal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Message</h4>  
                </div>  
                <div class="modal-body" id="leavedetail">  
                  <p>Days not Permissible</p>
                </div>  
                <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>

<div>
  <?php
      echo "Level = ".$level."<br>";
      //echo " Allowed leave days of level = ".leavedays($level);
      //echo "Leave days in the Session = ".(int)casualleavedaysgone($staffid, '2018/2019');
  ?>
</div>

<div id="space" class="row">
    <div class="col-md-6 col-md-offset-2">
      <form class="form-horizontal" role="form" action="" method="POST">
        <fieldset>

          <!-- Form Name -->
          <legend>Leave Application Form</legend>
      <div>
        <!-- <p id="message">    </p> -->
         <input type="hidden" id="staffid" name="staffId" value="<?php echo $staffid; ?>">
      </div>
          <!-- Leave Category-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Leave Category</label>
            <div class="col-sm-9">
          <?php 
            
                $select = '<select name="leavetype" id="leavetype" class="form-control" required>';
                $select .= '<option value = "">Select Leave Type</option>';

                while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                  //$result[] = $row; 
                $select .= '<option value = "'.$row1['type'].'">'.ucfirst($row1['type']).'</option>';
                     }//end of while statement 
                $select .= '</select>';
                echo $select;                     
          ?>
            </div>
          </div>


          <!-- Date Entry-->
          <div class="form-group">
                <label class="col-sm-3 control-label" for="textinput" id="da1">Days Entitled</label>
                <div class="col-sm-1">
                   <input type="text" class="form-control" name="da" id="da" disabled>
                </div>

                <label class="col-sm-3 control-label" for="textinput" id="dg1">Days Already Taken</label>
                <div class="col-sm-1">
                   <input type="text" class="form-control" name="dg" id="dg" disabled>
                </div>

                <label class="col-sm-3 control-label" for="textinput" id="dp1">Days Permissible</label>
                <div class="col-sm-1">
                   <input type="text" class="form-control" name="dp" id="dp" disabled>
                </div>

          </div>

          <div class="form-group">
            <div class="col-sm-3"></div>
            <div class="col-sm-9" id = "message" ></div>
          </div>
          
          
          <!-- Date Entry-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Proposed Start Date</label>
            <div class="col-sm-2">
              <input type="text" class="form-control" name="sdate" id="sdate" required>
            </div>

            <label class="col-sm-3 control-label" for="textinput">Proposed End Date</label>
            <div class="col-sm-2">
              <input type="text" class="form-control edate" name="edate" id="edate" required>
            </div>
            <label class="col-sm-2 control-label" id="datedif2"></label>
            <!-- <p class = "col-sm-2" id="datedif"> </p> -->
          </div>

          <div class="form-group">
            <div class="col-sm-3"></div>
            <div class="col-sm-9" id = "datedif" ></div>
          </div>

          <!-- Reason for Leave-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Reason For Leave</label>
            <div class="col-sm-9">
              <textarea class="form-control input-sm" name="reason" id="reason" rows="3" cols="40" placeholder="Reasons for Leave" required></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Destination Address</label>
            <div class="col-sm-9">
              <input type="text" class="form-control input-sm" name="location" id="location">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Phone Number <br><small>While on Leave</small></label>
            <div class="col-sm-6">
              <input type="text" class="form-control input-sm" name="phone" id="phone">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Officer 1</label>
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
     
<div class="form-group">
    <label class="col-sm-3 control-label" for="textinput">Officer 2</label>
            <div class="col-sm-9">
				<select name="officer2" id="officer2" class="form-control" required>

			<?php
                 foreach ($result as $staff)    
			{
             echo  '<option value = "'.$staff['staffid'].'">'.$staff['sname'].' '.$staff['fname'].'</option>';
      }
            ?>
              	</select>                             
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Officer 3</label>
            <div class="col-sm-9">
              <select name="officer3" id="officer3" class="form-control" required>
    <?php
                 foreach ($result as $staff)    
			
			{ 
                echo  '<option value = "'.$staff['staffid'].'">'.$staff['sname'].' '.$staff['fname'].'</option>';
            }
    ?>
                        
              </select>
            </div>
          </div>
    </fieldset>
      </form>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="pull-right">
                
                <a class="btn btn-md btn-default" href='leavedashboard.php?id= <?php echo base64_encode($_SESSION['staffdetails']['staffid']); ?>'>Cancel</a>
                 <button type="submit" class="btn btn-md" id="apply">Submit</button>
              </div>
            </div>
          </div>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->

 
</body>


<script type="text/javascript">
$(function(){

  $(".sedate").change(function(ev){

      ev.preventDefault();

      var sdate = $("#sdate").val();
      var edate = $("#edate").val();
      var leavetype = $("#leavetype").val();

      if (leavetype == "" || sdate == "") {
        alert("Check if leave category or start date is not empty");
      }

      $.ajax({
        type: "POST",
        url: "datedif.php",
        data: {
            sdate:sdate,
            edate:edate
        },
        dataType: "text",
            success: function(res) {
                $("#datedif3").html(res);
              },
            error: function(data) {
                $("#message").html(res);
                $("p").addClass("alert alert-danger");
            },
      });
    
      //alert("The text has been changed.");
    
    });
    

    $('select#leavetype').change(function(e){
        var leavetype = $(this).val();
        var staffid = $('#staffid').val();

        //clear initial values entered from form
        $('#sdate').val("");
        $('#edate').val("");

        if((leavetype == 'conference') || (leavetype == 'postdoc') || (leavetype == 'sabatical') || (leavetype == 'leave of absence') || (leavetype == 'research') || (leavetype == 'maternity') || (leavetype == 'study') || (leavetype == 'medical'))
            {
              window.location.replace("leaveapp.php?ltype="+btoa(leavetype));
              //window.location.replace("leavedashboard.php?id="+btoa(staffid));
            }
            
        
       // $( "#reason" ).prop( "disabled", true );
       if((leavetype == 'casual') || (leavetype == 'annual'))
        {
                  
            $( "#reason" ).prop( "disabled", false );//enables the form fields
            $( "#sdate" ).prop( "disabled", false);
            $( "#edate" ).prop( "disabled", false );
            $( "#location" ).prop( "disabled", false );
            $( "#phone" ).prop( "disabled", false );
            $( "#officer1" ).prop( "disabled",false );
            $( "#officer2" ).prop( "disabled", false );
            $( "#officer3" ).prop( "disabled", false );
            $( "#apply" ).prop( "disabled", false );

        $.ajax({
          type: "POST",
          url: "leavedays.php",
          datatype: "text",
          data: {leavetype:leavetype, staffid:staffid},
          success: function(outp){
            console.log(outp);
              var res = outp.split('|');
              var da = res[0];
              var dg = res[1];
              var dp = res[2];
              $('#dp').val(dp);
              $('#da').val(da);
              $('#dg').val(dg);
             // $('#message').html(dp);
              //$("#message").css({"border-left": "10px solid grey", "background-color": "lightgrey", "border-radius": "5px"});
          },
        });
      }//end of else
    });

  //$( "#sdate" ).datepicker( "input", "dateFormat", "d-M-yy");
    $("#edate").change(function(ev){

      //ev.preventDefault();

      var sdate = $("#sdate").val();
      var edate = $("#edate").val();
      var leavetype = $("#leavetype").val();

      if (leavetype == "" || sdate == "") {
         alert("Check if leave category or start date is not empty");
      }

            $.ajax({
                type: "POST",
                url: "datediff.php",
                data: {
                    sdate:sdate,
                    edate:edate,
                    leavetype: leavetype
                },
                dataType: "json",
                success: function(result) {
                  //console.log(result);
                    if(result.status == 'err')
                    {
                      alert(result.reason);

                        $( "#reason" ).prop( "disabled", true );//disables the form fields
                        $( "#location" ).prop( "disabled", true );
                        $( "#phone" ).prop( "disabled", true );
                        $( "#officer1" ).prop( "disabled", true );
                        $( "#officer2" ).prop( "disabled", true );
                        $( "#officer3" ).prop( "disabled", true );
                        $( "#apply" ).prop( "disabled", true );
                    }
                    if(result.status == 'neg')
                    {
                        alert(result.reason);

                        $( "#reason" ).prop( "disabled", true );//disables the form fields
                        $( "#location" ).prop( "disabled", true );
                        $( "#phone" ).prop( "disabled", true );
                        $( "#officer1" ).prop( "disabled", true );
                        $( "#officer2" ).prop( "disabled", true );
                        $( "#officer3" ).prop( "disabled", true );
                        $( "#apply" ).prop( "disabled", true );
                    }

                    if(result.status == 'ok'){
                      var ndays ="Days : " + result.daysapplied;
                       $('#datedif2').html(ndays);
                       //$("#datedif").css({"border-left": "5px solid grey", "background-color": "lightgrey", "border-radius": "5px"});

                          $( "#reason" ).prop( "disabled", false );//enables the form fields
                          $( "#location" ).prop( "disabled", false );
                          $( "#phone" ).prop( "disabled", false );
                          $( "#officer1" ).prop( "disabled",false );
                          $( "#officer2" ).prop( "disabled", false );
                          $( "#officer3" ).prop( "disabled", false );
                          $( "#apply" ).prop( "disabled", false );
                    }
                  },
                error: function(data) {
                    $("#message").html(data);
                    $("p").addClass("alert alert-danger");
                },
            });
           
      //alert("The text has been changed.");
    });
    
  $("#apply").on('click', function(e){

    $('#apply').html("Loading....");
    
    //e.preventDefault();

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
    $('#apply').html("Submit");
	}
  else {
        
//AJAX code to send data to php file.
    $.ajax({
            method: "POST",
            url:   "test2.php",
            datatype: "text",
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
            success: function(response) {
              console.log(response);
                if ((response == 'CASUAL SUCCESS') || (response == 'ANNUAL SUCCESS'))  {
                  alert("Application Successful. You will be redirected to Dashboard");
                  $('#apply').html("Successful");
                  window.location.replace("leavedashboard.php?id="+btoa(staffid));
                }

                if (response == 'CASUAL FAIL') {
                  alert("Try Again");
                  $('#apply').html("Submit");
                }

                if (response == 'EMPTY FORM') {
                  alert("One part of the form is not filled");
                  $('#apply').html("Submit");
                }

                if (response == 'DBASE ERROR') {
                  alert("Try again later");
                  $('#apply').html("Submit");
                }
                if (response == 'BEYOND LIMIT') 
                {
                  //alert("Beyond Limit");  
                  $('#leavedetail').html("<p>Leave Days Chosen is beyond the allowed limit</p>");  
                  $('#dataModal').modal("show"); 
                  $('#apply').html("Submit");
                }
            },
            error: function(){
              alert("error");
            }
        });
	  }//end of if else
  });
  
});
</script>
</html>