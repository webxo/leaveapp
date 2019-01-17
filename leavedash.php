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
        $trqry = "SELECT remarks, recstartdate, recenddate, status
                           FROM leavetransaction
                           WHERE appno = $appno 
                           AND transactionid > 1
                           ORDER BY transactionid DESC";

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
                            WHERE reccgroup = 3";              
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
                                    <?php 
                                    ?>
                                    <tr>
                                      <td colspan="2">
                                       <!--  <input type="submit" value="Add more comment" class="btn btn-default btn-sm" readonly> -->
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>                                       
                                          <a style="font-size: 14px;"  href='leavedashboard.php?id= <?php echo base64_encode($staffid); ?>'>Cancel</a>
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
    <?php
    if ($chkqrynum > 0) {
            echo "<h6>You have reviewed this application before</h6>";
            exit;
          }

              if ($numtr > 0) { //if starts here
                    
                    while($rowtr=$stmtr->fetch(PDO::FETCH_ASSOC))
                     {
                       //extract row this truns array keys into variables
                       extract($rowtr);
    ?>
                 
    <h5>
        <span class="sub-title">
          Supervisor Comment
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
                        echo "Application in Progress";
                    }
                 ?>
 
    </div>
    <div class="row m-b-1em">
      <button id="btn-rec" class="col-sm-5 btn btn-default btn-sm"> Click to make recommendation </button> 
    </div>

    <!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
    <!-- Recommendation FORM starts here --> 
<div class="row rec-submit"></div>
<div class="row rec-form"> 
    <legend></legend>  
    <table class="table table-sm m-b-0em">
      <tbody>
        <tr>
          <?php 
            echo $row1['sdate'];
              foreach ($row1 as $vrow) {
          ?>
          <td>Recommended Start date <input type="date" id="sdate" value="<?php echo $vrow['sdate'];?>"></td>
          <td>Recommended End date <input type="date" id="edate" value="<?php echo $vrow['edate']; ?>"></td>
        <?php } //end of foreach ?>
          <input type="hidden" id="appno" value='<?php echo $appno; ?>'>
          <input type="hidden" id="staffid" value='<?php echo $_SESSION['loginid']; ?>'>
        </tr>
      </tbody>
    </table>

    <table class="table table-sm row">
  <tbody>
    <tr>
      <td width="50px">Comment</td>
      <td><textarea class="form-control" id="remarks" rows="2" cols="40" required></textarea></td>
    </tr>
    <tr>
      <td><label>Recommendation</label></td>
        <td>   
            <select id="reco" required>
                          <option value = ''>Select Recommendation</option>         
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
      <td colspan="2"><button id="btn-save" class="btn btn-default btn-sm">Save</button></td>
    </tr>  
  </tbody>
    </table>                            
</div><!--End of rec-form-->

</div><!-- End of container-->
<?php // print_r($stmtr->errorInfo()); ?>

</div><!-- end of main div-->


    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script> 
    <script type="text/javascript">

        $(document).ready(function(){
          
          $('.goback').click(function() {
            history.back();
          });   

        $('#btn-rec').click(function(){

          $('.rec-form').slideToggle();
         
        });

        $('#btn-save').click(function(){
            $('.rec-form').hide();
            
            var appno = $('#appno').val();
            var staffid = $('#staffid').val();
            var sdate = $('#sdate').val();
            var edate = $('#edate').val();
            var remarks = $('#remarks').val();
            var reco = $('#reco').val();

            var encappno = window.btoa(appno);

            var url = "leavedash.php?appno="+encappno;

            //alert(reason + edate + sdate + reco);

            $('#show-form').load('leaverec.php', {
                appno: appno,
                staffid:staffid,
                sdate: sdate,
                edate: edate,
                remarks: remarks,
                reco: reco
            }, 
             function(){
                $(location).attr('href', url);
             });


        });
      });
    </script>
     
</body>
</html> 
