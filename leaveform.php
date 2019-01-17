<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script> -->
<!-- <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
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
</style>

<div></div>
  <div id="space" class="row">
    <div class="col-md-6 col-md-offset-2">
      <form class="form-horizontal" role="form" action="" method="POST">
        <fieldset>

          <!-- Form Name -->
          <legend>Leave Update</legend>
      <div>
        <p id="message"></p>
      </div>
          <!-- Staff Name-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Staff Name</label>
            <div class="col-sm-9">
             <input type="text" placeholder="Staff Name" class="form-control">
            </div>
          </div>

          <!-- Reason for Leave-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Leave Reason</label>
            <div class="col-sm-9">
              <textarea class="form-control" name="reason" id="reason" rows="5" cols="40" placeholder="Reasons for Leave" required></textarea>
            </div>
          </div>
          
          <!-- Leave Type-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Leave Type</label>
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

            <!-- Comment-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Comment</label>
            <div class="col-sm-9">
              <textarea class="form-control" name="reason" id="reason" rows="5" cols="40" placeholder="Comment here" required></textarea>
            </div>
          </div>

            <!--Recommendation-->
               <div class="form-group">
            <label class="col-sm-3 control-label" for="textinput">Recommendation</label>
            <div class="col-sm-9">
              <select name="recommendation" class="form-control" required>
                          <option value = ''></option>
                          <option value = 'Approved'>Approved</option>
              </select>
            </div>
          </div>
    </fieldset>
      </form>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="pull-right">
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="submit" class="btn btn-primary" id="apply">Send</button>
              </div>
            </div>
          </div>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->


<script type="text/javascript">
  $(function(){
  $("#apply").on('click', function(){
          
    var leavetype = $("#leavetype").val();
    var reason = $("#reason").val();
    var sdate = $("#sdate").val();
    var edate = $("#edate").val();
    var officer1 = $("#officer1").val();
    var officer2 = $("#officer2").val();
    var officer3 = $("#officer3").val();
    
    
// AJAX code to send data to php file.
        $.ajax({
            type: "POST",
            url:   "leavein.php",
            data: {
              leavetype:leavetype,
              reason:reason,
              sdate:sdate,
              edate:edate,
              officer1:officer1,
              officer2:officer2,
              officer3:officer3
            },
            dataType: "text",
            success: function(response) {
                //alert(data);
                //$("#message").html(data);
                $("p").addClass("alert alert-success");
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

  