<?php

/*
Developer: Ekunkoya Isaiah
Site:      ekunkoya.com.ng
Script:    Insert data into transaction table
File:      leavetrack.php
For every appno entrying this file, the transactionid increases by 1.
*/

// $staffid = implode(',', array_map(function($el){ return $el['idno']; }, get_user($_SESSION['loginid']))) ?implode(',', array_map(function($el){ return $el['idno']; }, get_user($_SESSION['loginid']))) : $_GET[''];


//include('config/database.php');
include('leavefunction.php');

checkSession();

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


<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
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
</style>

<div></div>
  <div id="space" class="row">
    <div class="col-md-6 col-md-offset-2">
      <form class="form-horizontal" role="form" action="" method="POST">
        <fieldset>

          <!-- Form Name -->
          <legend>Leave Application Form</legend>
      <div>
        <p id="message">
            <?php 
                if (isset($_GET['formreturn']))
                {
                      echo "Form cannot be empty";
                  }
            ?>

        </p>
      </div>
          <!-- Leave Category-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Leave Category</label>
            <div class="col-sm-9">
              <select name="leavetype" class="form-control" id="leavetype" required>
                          <option value = ''></option>
                          <option value = 'casual'>Casual</option>
                          <option value = 'annual'>Annual</option>
                          <option value = 'medical'>Medical</option>
                          <option value = 'study'>Study</option>
                          <option value = 'post_doc'>Post Doctoral</option>
              </select>
            </div>
          </div>

          <!-- Reason for Leave-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Reason For Leave</label>
            <div class="col-sm-9">
              <textarea class="form-control" name="reason" id="reason" rows="5" cols="40" placeholder="Reasons for Leave" required></textarea>
            </div>
          </div>
          
          <!-- Date Entry-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Start Date</label>
            <div class="col-sm-3">
              <input type="date" class="form-control" name="sdate" id="sdate" required>
            </div>

            <label class="col-sm-3 control-label" for="textinput">End Date</label>
            <div class="col-sm-3">
              <input type="date" class="form-control" name="edate" id="edate" required>
            </div>
            <p id="datedif"> </p>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Phone Number <br><small>While on Leave</small></label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="phone" id="phone">
            </div>
          </div>


          <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Officer 1</label>
            <div class="col-sm-9">
              <select name="officer1" id="officer1" class="form-control" required>
                          <option value = 'Jimoh'>Jimoh</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Officer 2</label>
            <div class="col-sm-9">
              <select name="officer2" id="officer2" class="form-control" required>
                          <option value = ''></option>
                          <option value = 'Ade'>Ade</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Officer 3</label>
            <div class="col-sm-9">
              <select name="officer3" id="officer3" class="form-control" required>
                          <option value = ''></option>
                          <option value = 'Jaja'>Jaja</option>
              </select>
            </div>
          </div>
    </fieldset>
      </form>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="pull-right">
                <button class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-default" id="apply">Submit</button>
              </div>
            </div>
          </div>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->


<script type="text/javascript">
  $(function(){

  //$( "#sdate" ).datepicker( "input", "dateFormat", "d-M-yy");
    $("#edate").change(function(){

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
            success: function(response) {
                //alert(data);
                //$("#message").html(data);
                $("#datedif").addClass("adiff");
                $('p#datedif').html(response);
              },
            error: function(data) {
                $("#message").html(data);
                $("p").addClass("alert alert-danger");
            },
      });
    
      //alert("The text has been changed.");
    
    });
    
  $("#apply").on('click', function(){
          
    var leavetype = $("#leavetype").val();
    var reason = $("#reason").val();
    var sdate = $("#sdate").val();
    var edate = $("#edate").val();
    var phone = $('#phone').val();
    var officer1 = $("#officer1").val();
    var officer2 = $("#officer2").val();
    var officer3 = $("#officer3").val();

    //var encappno = window.btoa(appno);

    //var url = "leavestatus.php?="+encappno;
    
    
// AJAX code to send data to php file.
    $.ajax({
            type: "POST",
            url:   "leavein.php",
            data: {
              leavetype:leavetype,
              reason:reason,
              sdate:sdate,
              edate:edate,
              phone:phone,
              officer1:officer1,
              officer2:officer2,
              officer3:officer3
            },
            dataType: "text",
            success: function(response) {
                //alert(data);
                //$("#message").html(data);
                alert("Application Successful");
                $("p").addClass("alert alert-default");
                $('#message').html(response);
              },
            error: function(data) {
                $("#message").html(data);
                $("p").addClass("alert alert-danger");
            },
        });
  });
  
});
</script>