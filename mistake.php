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
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  #A QUICK QUERY TO CHECK IF A SUPERVISOR HAS ACTED ON AN APPLICATION
    $chkqry = "SELECT * FROM leavetransaction 
                WHERE appno LIKE '$appno' 
                AND tstaffid LIKE '$staffid' ORDER BY `sn` ASC";

        $chkstmt = $con->prepare($chkqry);
        $chkstmt->execute();
        
        $chkqrynum = $chkstmt->rowCount();
        $datenum = $chkstmt->rowCount();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        #Query to select leave details of the $this staff
        $queryleave = "SELECT staffid, leavetype, startdate, enddate, phone, reason, officer1, officer2, officer3
                       FROM leaveapplication
                       WHERE appno = $appno";

        $stmtleave = $con->prepare($queryleave);
        $stmtleave->execute();
        
        $num = $stmtleave->rowCount();
        
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        #Query to select leave progress of staff
        $trqry = "SELECT *
                  FROM leavetransaction
                  WHERE appno = $appno 
                  AND transactionid > 1
                  ORDER BY transactionid ASC";

        $stmtr = $con->prepare($trqry);
        $stmtr->execute();
        
        $numtr = $stmtr->rowCount();  

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        #Query for recommendations 
        /*
          Testing each staff id to know which role each staff is to play.
        */

            if(($staffid == $hodid) || ($staffid == $deanid))
            {
                $recqry = "SELECT recctitle, reccgroup
                            FROM leaverecommendations
                            WHERE reccgroup = 1";              
            } 
            else if ($staffid == $rego) 
            {
              $recqry = "SELECT recctitle, reccgroup
                            FROM leaverecommendations
                            WHERE reccgroup = 1 
                            OR  reccgroup = 2";            
            }
            else if ($staffid == $hro) 
            {
              $recqry = "SELECT recctitle, reccgroup
                            FROM leaverecommendations
                            WHERE reccgroup = 3
                            OR  reccgroup = 1";              
            }
            else if ($staffid == $vco) 
            {
              $recqry = "SELECT recctitle, reccgroup
                            FROM leaverecommendations
                            WHERE reccgroup = 2";             
            }



            $recstmt = $con->prepare($recqry);
            $recstmt->execute();
            
            $recnum = $recstmt->rowCount(); 
        
        
    }//end of try
    catch(PDOException $e){
         echo "Error: " . $e->getMessage();
    }//end of catch      

?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="css/leavedash.css">

</head>
<body>


<div class="sidenav container-fluid">

  <h3 class="card-title">Application Details</h3>

  <?php
              if ($num > 0) { //if starts here
                    
                    while($row=$stmtleave->fetch(PDO::FETCH_ASSOC))
                     {
                       //extract row this truns array keys into variables
                      $row1 [] = $row;
                       extract($row);

  ?>

  
                        <table class="table table-sm table-borderless table-responsive">
                        <tbody>
                          <tr>
                            <td>Staff Name:</td>
                              <td>
                                  <?php 
                                      echo getname($row['staffid']); //getname() is a function for getting name of staff from the database
                                  ?>
                              </td>
                          </tr>
                        
                         <tr>
                            <td>Leave Type:</td>
                            <td><?php echo $row['leavetype']; ?></td>
                         </tr>

                         <tr>
                            <td>Applied Start Date:</td>
                              <td>
                                            <?php
                                                $stdate = date_create($row['startdate']);
                                                echo date_format($stdate, "d-M-Y");
                                            ?>
                                            
                              </td>
                          </tr>
                          
                                    <tr>
                                        <td>Applied End Date</td>
                                        <td>
                                            <?php
                                                $eddate = date_create($row['enddate']);
                                                echo date_format($eddate, "d-M-Y");                                                
                                            ?>    
                                         </td>
                                    </tr> 
                                    <tr>
                                        <td> Days </td>
                                        <td> <?php echo numdays($row['startdate'], $row['enddate']); ?> </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Reason:</td>
                                        <td><?php echo $row['reason']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Phone number:</td>
                                        <td><?php echo $row['phone']; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Officers to handover to : </b></td>
                                    </tr>
                                    <tr>
                                        <td>Officer 1:</td>
                                        <td><?php echo getname($row['officer1']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Officer 2:</td>
                                        <td><?php echo getname($row['officer2']); ?></td>
                                    </tr>
                                     <tr>
                                        <td>Officer 3:</td>
                                        <td><?php echo getname($row['officer3']); ?></td>
                                    </tr>                                   
                                    <tr>
                                      <td>                                       
                                        <a style="font-size: 14px;"  href="leavedashboard.php?id= <?php echo base64_encode($_SESSION['staffdetails']['staffid']); ?>">
                                          Cancel
                                        </a>
                                      </td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php  } // end of while loop 
                            }//end of if statement
                            else {
                                echo "No Active Leave Application";
                            }
                        ?>
</div>

<div class="main">
<div class="container">
  
    <h4 id="title">Recommendations/Approvals</h4>
    <div id="show-form">
    <div id="error"></div>
 
  <?php
       if ($numtr > 0) { //if starts here                 
              while($rowtr=$stmtr->fetch(PDO::FETCH_ASSOC))
                 {
                    //extract row this truns array keys into variables
    ?>               
    
    <h5>
        <span class="sub-title">
          <b><?php echo $rowtr['role']; ?></b>
        </span>
    </h5>
    <div class="row">
       <p class="col-sm-6">Applied Start Date: 
        <span class="boder border-l">
            <?php
                $resdate = date_create($rowtr['recstartdate']);
                echo date_format($resdate, "d-M-Y");
            ?>
        </span>
        </p> 
       <p class="col-sm-6 boder-p">Applied Start Date: 
            <span class="boder border-r">
                <?php
                   $recedate = date_create($rowtr['recenddate']);
                   echo date_format($recedate, "d-M-Y");
                ?>
            </span>
        </p> 
    </div>

     <div class="row m-b-0em">
       <p class="col-sm-3">Days: </p> 
       <p class="col-sm-9 boder">
        <?php
            echo numdays($rowtr['recstartdate'], $rowtr['recenddate']);
        ?>
        </p> 
    </div>

    <div class="row m-b-0em">
       <p class="col-sm-3">Comment: </p> 
       <p class="col-sm-9 boder">
        <?php
            echo $rowtr['remarks'];
        ?>
        </p> 
    </div>
    
   

    <div class="row m-b-0em">
       <p class="col-md-3">Recommendation: </p> 
       <p class="col-md-9 boder">
           <?php
             echo "<td>".$rowtr['status']."</td>";
             
           ?> 
       </p> 
    </div>

    <hr style="margin: 0px 0 0px;">
                    <?php
                         }//end of while
                    }//end of if statement
                    else {
                        //echo "Application in Progress";
                    }
                 ?>
 
    </div>

<!----------------------------------------------------------------------------------------------------------------------------------------------------->
<div class="row rec-submit"></div>
<h5>

<span class="sub-title">
<?php 
    if ($_SESSION['staffdetails']['staffid'] == $_SESSION['staffdetails']['hod'] ) {
   echo '<b>Make Recommendation</b>';
  }
  else if ($_SESSION['staffdetails']['staffid'] == $_SESSION['staffdetails']['dean'] ) {
   echo '<b>Make Recommendation</b>';
  }
  else if ($_SESSION['staffdetails']['staffid'] == $_SESSION['staffdetails']['hro'] ) {
   echo '<b>Make Recommendation</b>';
  }
  else if ($_SESSION['staffdetails']['staffid'] == $_SESSION['staffdetails']['rego'] ) {
   echo ' <b>Make Recommendation/Approval</b>';
  }
  else if ($_SESSION['staffdetails']['staffid'] == $_SESSION['staffdetails']['vco'] ) {
   echo ' <b>Make Approval</b>';
  }

?>
        </span>
    </h5>

    <?php 
        if ($datenum > 0) { //if starts here
                    
                    while($lvdate=$chkstmt->fetch(PDO::FETCH_ASSOC))
                     {
                       //extract row this truns array keys into variables
  ?>

<div class="row"> 
  <table class="table">
    <tr>
      <td>Recommended Start date</td>
      <td> <input type="date" id="sdate" value="<?php echo $lvdate['recstartdate']?>"></td>
      <td>Recommended End date</td>
      <td> <input type="date" id="edate" value="<?php echo $lvdate['recenddate']?>"></td>
    </tr>
  <?php } /*while ends here*/ }//if ends here?>
  </table>
  <table class="table">
    <tr>
      <td>Comment</td>
      <td><textarea class="form-control" id="remarks" rows="2" cols="80" required></textarea></td>
    </tr>
  </table>
  <?php
  #Tests to get the role of the logged in staff  
  if ($_SESSION['staffdetails']['staffid'] == $_SESSION['staffdetails']['hod'] ) {
   echo '<input type="hidden" id="role" value="Hod">';
  }
  else if ($_SESSION['staffdetails']['staffid'] == $_SESSION['staffdetails']['dean'] ) {
   echo '<input type="hidden" id="role" value="Dean">';
  }
  else if ($_SESSION['staffdetails']['staffid'] == $_SESSION['staffdetails']['hro'] ) {
   echo '<input type="hidden" id="role" value="HR">';
  }
  else if ($_SESSION['staffdetails']['staffid'] == $_SESSION['staffdetails']['rego'] ) {
   echo '<input type="hidden" id="role" value="Registrar">';
  }
  else if ($_SESSION['staffdetails']['staffid'] == $_SESSION['staffdetails']['vco'] ) {
   echo '<input type="hidden" id="role" value="VC">';
  }
  else
  {
   echo '<input type="hidden" id="role" value="Applicant">';
  }
  ?>
  
  <input type="hidden" id="appno" value="<?php echo $appno; ?>">
   
  <input type="hidden" id="staffid" name="staffId" value="<?php echo $_SESSION['staffdetails']['staffid']; ?>">


  <table class="table">
    <tr>
      <td><label>Recommendation</label>

        <select id="reco" required>
          <option>Select Recommendation</option>         
            <?php
                if ($recnum > 0) { //if starts here
                    
                    while($rowrec=$recstmt->fetch(PDO::FETCH_ASSOC))
                     {
                       //extract row this truns array keys into variables
                       extract($rowrec);
            ?>            
           <option value = '<?php echo $rowrec["recctitle"]; ?>' > <?php echo $rowrec["recctitle"]; ?> </option>
            <?php 
                  }// end of while statement
                }//end of if statement  
            ?>
        </select>     
      </td>
      <td><button id="btn-save" class="btn">Save</button></td>
    </tr>
  </table>  
</div>

<!---------------------------------------------------------------------------------------------------------------------------------------------------->
    <!--<div class="row m-b-1em">
      <button id="myBtn" class="col-sm-5 btn btn-default btn-sm"> Click to make recommendation </button> 
    </div>-->
<!---------------------------------------------------------------------------------------------------------------------------------------------------->
    <!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
    <!-- Recommendation FORM starts here --> 


</div><!-- End of container-->
<?php // print_r($stmtr->errorInfo()); ?>

</div><!-- end of main div-->


<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>


    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script> 
    <script type="text/javascript">

        $(document).ready(function(){

          $("#myBtn").click(function(){
              $("#myModal").modal();
           });
          
          $('.goback').click(function() {
            history.back();
          });   

        $('#btn-rec').click(function(){
          $('.rec-form').slideToggle();
        });

        $('#btn-save').click(function(){
           // $('.rec-form').hide();
            
            var appno = $('#appno').val();
            var staffid = $('#staffid').val();
            var sdate = $('#sdate').val();
            var edate = $('#edate').val();
            var remarks = $('#remarks').val();
            var reco = $('#reco').val();
            var role = $('#role').val();

            var encappno = window.btoa(staffid);

            var url = "leavedashboard.php?id="+encappno;

            if ((appno == '') || (staffid == '') || (sdate == '') || (edate == '') || (remarks == '') || (reco == '') )
            {
                  alert("There is a missing field somewhere.");
            }
            
            else {        

            //alert(reason + edate + sdate + reco);

                  $('#error').load('leaverec.php', {
                      appno: appno,
                      staffid:staffid,
                      sdate: sdate,
                      edate: edate,
                      remarks: remarks,
                      reco: reco,
                      role: role
          }, 
             function(){
                alert("Recommendation Saved");
                $(location).attr('href', url);
             });
        }

        });
      });
    </script>
     
</body>
</html> 
