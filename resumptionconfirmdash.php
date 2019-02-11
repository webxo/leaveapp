<?php

  include 'config/database.php';
  include 'leavefunction.php';

  checksession();

  $staffid = $_SESSION['staffdetails']['staffid'];
  $dept = $_SESSION['staffdetails']['dept'];
  $kol = $_SESSION['staffdetails']['kol'];
  $cat = $_SESSION['staffdetails']['category'];
  $hodid = $_SESSION['staffdetails']['hod'];
  $deanid = $_SESSION['staffdetails']['dean'];
  $hro = $_SESSION['staffdetails']['hro'];
  $rego = $_SESSION['staffdetails']['rego'];
  $vco = $_SESSION['staffdetails']['vco'];

  $appno  = base64_decode($_GET['appno']); //? base64_decode($_GET['appno']): header("Location:logout.php") ;

try {

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        #Query to select leave details of the $this staff
        $queryleave = "SELECT *
          FROM stafflst AS s
          INNER JOIN leaveapplication AS l
                  ON s.staffid = l.staffid
                  INNER JOIN stafflist AS st
                  ON s.staffid = st.staffid
                  INNER JOIN leavetransaction AS lt
                  ON l.appno = lt.appno
                  INNER JOIN approvedleaves AS ap
                  ON ap.staffid = s.staffid
                  WHERE l.appno = $appno
                  AND s.category = '$cat'
                  AND ap.resumeddate = ''
                  ORDER BY lt.timeviewed DESC
                  LIMIT 1";

        $stmtleave = $con->prepare($queryleave);
        $stmtleave->execute();
        
        $num = $stmtleave->rowCount();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
        
  }//end of try
    catch(PDOException $e){
         echo "Error: " . $e->getMessage();
    }//end of catch      

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Leave Application Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <style>
      .content {
      width: 1500px;
      margin: auto;
    }
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 100%}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 90%;
    }
    
   table {
    width: 50px;
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
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 1500px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
  </style>
</head>
<body>
<div class="content">
<?php
  if ($num > 0) { 
        while($staffdet = $stmtleave->fetch(PDO::FETCH_ASSOC))
        {
    ?>
<div class="container-fluid">
<div class="row">
<div class="col-md-8">
        <h3>Applicant Details</h3>
  <table class="table table-bordered table-condensed">
    <tr>
      <th>Staff Name</th>
      <th>Post</th>
      <th>Category</th>
      <th>Unit/Program</th>
      <th>Department</th>
      <th>College/Directorate</th>
    </tr>
    <tr>
      <td>
        <?php echo getname($staffdet['staffid']);  ?>
      </td>
      <td>
        <?php echo $staffdet['post']; ?>
      </td>
      <td>
        <?php 
          $staffcat = $staffdet['category'];
          echo $staffdet['category'];  
        ?>
      </td>
      <td>
        <?php echo $staffdet['unitprg'];  ?>
      </td>
      <td>
        <?php echo $staffdet['dept'];  ?>
      </td>
      <td>
        <?php echo $staffdet['kol'];  ?>
      </td>    
   </tr>
 </table>
      
</div>
</div>
</div>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
<!------------------------------------------------New Content---------------------------------------------------------------------------------------------->
<h4 class="card-title"><b>Application Details</b></h4>

               <table class="table table-bordered table-condensed">
                      <tbody>                        
                         <tr>
                            <td>Leave Type:</td>
                            <td><?php echo $staffdet['leavetype']; ?></td>
                         </tr>

                         <tr>
                            <td>Applied Start Date:</td>
                              <td>
                                   <?php
                                     $stdate = date_create($staffdet['startdate']);
                                     echo date_format($stdate, "d-M-Y");
                                   ?>         
                              </td>
                          </tr>
                          
                          <tr>
                            <td>Applied End Date</td>
                            <td>
                               <?php
                                  $eddate = date_create($staffdet['enddate']);
                                  echo date_format($eddate, "d-M-Y");                                                
                               ?>    
                            </td>
                          </tr> 
                          
                          <tr>
                           <td> Days </td>
                           <td> <?php echo numdays($staffdet['startdate'], $staffdet['enddate']); ?> </td>
                          </tr>
                                    
                                    <tr>
                                        <td>Reason:</td>
                                        <td><?php echo $staffdet['reason']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Phone number:</td>
                                        <td><?php echo $staffdet['phone']; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Officers to handover to : </b></td>
                                    </tr>
                                    <tr>
                                        <td>Officer 1:</td>
                                        <td><?php echo getname($staffdet['officer1']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Officer 2:</td>
                                        <td><?php echo getname($staffdet['officer2']); ?></td>
                                    </tr>
                                     <tr>
                                        <td>Officer 3:</td>
                                        <td><?php echo getname($staffdet['officer3']); ?></td>
                                    </tr>                                   
                                  </tbody>
                            </table>

<h4><b>Leave History for Current Year</b></h4>
<table class="table table-bordered table-condensed">
  <tr>
    <th style="width: 50%;">Casual leave days taken</th>
    <td>4</td>
    <th>Number to be deducted</th>
    <td>4</td>
  </tr>

  <tr>
    <th>Totals Days Recommended for Annual Leave</th>
    <td>4</td>
    <th>Leave Days Entitled</th>
    <td>4</td>
  </tr>
</table>

<!---------------------------------------------------------------------------------------------------------------------------------------------------->
</div><!---End of Side bar--->
<!----------------------------------------------------------------------------------------------------------------------------------------------->
<div class="col-sm-5">
       <h4 id="title"><b>Resumption Confirmation Form</b></h4>       

      <hr style="margin: 0px 0 0px;">
      

    <table class="table table-condensed">  
    <tr>
      <td>Resumption Date</td>
        <?php $dayresumed = date_create($staffdet['timeviewed']);  ?>
      <td><input type="text" class="form-control" name="rdate" id="rdate" value = "<?php echo date_format($dayresumed, "d-M-Y"); ?>" disabled></td>
    </tr> 
    <td>Remarks</td>
        
      <td><textarea class="form-control" id="remarks" rows="2" cols="80" required></textarea></td>
    </tr> 
      <tr>
      
      <td>
        <?php echo '<input type="hidden" id="appno" value="'.$staffdet['appno'].'">'; ?>
        <?php echo '<input type="hidden" id="role" value="Applicant">'; ?>
        <?php echo '<input type="hidden" id="stage" value="1">'; ?>
        <?php echo '<input type="hidden" id="reco" value="Resumed">'; ?>
        <?php echo '<input type="hidden" id="sdate" value="'.$staffdet['recstartdate'].'">'; ?>
        <?php echo '<input type="hidden" id="edate" value="'.$staffdet['recenddate'].'">'; ?>
        <?php echo '<input type="hidden" id="staffid" value="'.$staffid.'">'; ?>
      </td>
      <td>
        <button id="btn-save" class="btn">Confirm</button>
        <button id="btn-notconfirmed" class="btn">Not Confirmed</button>
        <button>
          <a style="font-size: 14px;" href="leavedashboard.php?id= <?php echo base64_encode($_SESSION['staffdetails']['staffid']); ?>">Cancel</a>
        </button>
      </td>
      </tr>
  </table>  
</div>
</div>

  <?php  } // end of while loop 
       }//end of if statement
       else
       {
        echo "Staff Resumed Already";
       }
  ?>
<div id="message"></div>
  
</div>
</div><!--End of div content-->
 <script type="text/javascript">

    $(document).ready(function(){
     
      $('#btn-save').click(function(){
        alert('button clicked');
           
        var appno = $('#appno').val();
        var staffid = $('#staffid').val();
        var sdate = $('#sdate').val();
        var edate = $('#edate').val();
        var remarks = $('#remarks').val();
        var reco = $('#reco').val();
        var role = $('#role').val();
        var stage = $('#stage').val();
        var rdate = $('#rdate').val();

        var encappno = window.btoa(staffid);

        var url = "leavedashboard.php?id="+encappno;            

          if (rdate == '')
          {
                alert("Date cannot be blank");
           }
       //alert(reason + edate + sdate + reco);
         $('#message').load('resumptionconfirmation.php', {
                appno: appno,
                staffid:staffid,
                sdate: sdate,
                edate: edate,
                remarks: remarks,
                reco: reco,
                role: role,
                stage: stage,
                rdate: rdate
            }, 
          function(){
          //alert("Date Saved");
               $(location).attr('href', url);
           });
        });
    });

</script>
</body>
</html>