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
        $queryleave = "SELECT st.sname, st.fname, l.staffid, l.leavetype, l.startdate, l.enddate, l.phone, l.reason, l.officer1, l.officer2, l.officer3, st.post, st.dept, st.kol, st.unitprg, st.category
                       FROM leaveapplication AS l
                       INNER JOIN stafflst AS st
                       ON st.staffid = l.staffid
                       WHERE appno = $appno";

        $stmtleave = $con->prepare($queryleave);
        $stmtapp = $con->prepare($queryleave);
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
<html lang="en">
<head>
  <title>Leave Application Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 1500px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    
   table {
    width: 50px;
  }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
  </style>
</head>
<body>
  <?php
  if ($num > 0) { 
    while($staffdet=$stmtleave->fetch(PDO::FETCH_ASSOC))
        {
    ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-7">
        <h3>Applicant Details</h3>
  <table class="table table-bordered table-condensed">
    <tr>
      <th>First Name</th>
      <th>Last Name</th>
      <th>College/Directorate</th>
      <th>Department</th>
      <th>Category</th>
      <th>Post</th>
    </tr>
    <tr>
      <td>
        <?php echo $staffdet['fname'];  ?>
      </td>
      <td>
        <?php echo $staffdet['sname'];  ?>
      </td>
      <td>
        <?php echo $staffdet['kol'];  ?>
      </td>
      <td>
        <?php echo $staffdet['dept'];  ?>
      </td>
      <td>
        <?php echo $staffdet['category'];  ?>
      </td>
      <td>
        <?php echo $staffdet['post'];  ?>
      </td>

    </tr>
  </table>
      
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">

      <!-- <h4>John's Blog</h4>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="#section1">Home</a></li>
        <li><a href="#section2">Friends</a></li>
        <li><a href="#section3">Family</a></li>
        <li><a href="#section3">Photos</a></li>
      </ul><br>
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search Blog..">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div> -->
<!------------------------------------------------New Content---------------------------------------------------------------------------------------------->
<h4 class="card-title"><b>Application Details</b></h4>

               <table class="table table-bordered table-condensed">
                      <tbody>
                          <tr>
                            <td>Staff Name:</td>
                              <td>
                                  <?php 
                                      echo getname($staffdet['staffid']); //getname() is a function for getting name of staff from the database
                                  ?>
                              </td>
                          </tr>
                        
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
                        <?php  } // end of while loop 
                           }//end of if statement
                            else {
                                echo "No Active Leave Application";
                            }
                        ?>

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
<div class="col-sm-6">

      <h4 id="title"><b>Recommendations/Approvals</b></h4>
 
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
    <table class="table table-bordered table-condensed">
    <tr>
      <th>Recommended Start Date</th>
      <td>
        <?php
                $resdate = date_create($rowtr['recstartdate']);
                echo date_format($resdate, "d-M-Y");
        ?>
      </td>

      <th>Recommended End Date</th>
      <td>
        <?php
                   $recedate = date_create($rowtr['recenddate']);
                   echo date_format($recedate, "d-M-Y");
                ?>
      </td>
      <th>Days</th>
      <td>
        <?php
            echo numdays($rowtr['recstartdate'], $rowtr['recenddate']);
        ?>
      </td>
    </tr>
    <tr>
      <th>Comment </th>
      <td colspan="5">
        <?php
            echo $rowtr['remarks'];
        ?>
      </td>
    </tr>
    <tr>
      <th>Recommendation</th>
      <td colspan="5">
         <?php
             echo $rowtr['status'];
           ?>
      </td>
    </tr>
  </table>
        
    <hr style="margin: 0px 0 0px;">
                    <?php
                         }//end of while
                    }//end of if statement
                    else {
                        echo "Application in Progress";
                    }
                 ?>
<!----------------------------------------------------------------------------------------------------------------------------------------------------->
<h5><span class="sub-title">

<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
    if ($_SESSION['staffdetails']['staffid'] == $_SESSION['staffdetails']['hod'] ) 
    {
  
        echo '<b>Make Recommendation</b>';

        echo "</span>";
        echo "</h5>";

        echo '<div class="row">'; 
            echo '<table class="table">';
             echo '<tr>';
               echo '<td>Recommended Start date</td>';
    
        if ($datenum > 0) //if starts here
        {          
            while($lvdate=$chkstmt->fetch(PDO::FETCH_ASSOC))
             {     
              $datearr[] = $lvdate;
              }
        } 

                        echo '<td> <input type="date" id="sdate" value='.$datearr["recstartdate"].'></td>';
                        echo '<td>Recommended End date</td>';
                        echo '<td> <input type="date" id="edate" value='.$datearr["recenddate"].'></td>';
                      
                   echo '</tr>';
                    echo '</table>';
                    echo '<table class="table">';
                      echo '<tr>';
                        echo '<td>Comment</td>';
                        echo '<td><textarea class="form-control" id="remarks" rows="2" cols="80" required></textarea></td>';
                      echo '</tr>';
                    echo '</table>';                    
                    
                    echo '<input type="hidden" id="role" value="Hod">';                  
                    
                    echo '<input type="hidden" id="appno" value="'.$appno.'">';
                     
                    echo '<input type="hidden" id="staffid" name="staffId" value="'.$_SESSION['staffdetails']['staffid'].'">';

                    echo '<table class="table">';
                      echo '<tr>';
                        echo '<td><label>Recommendation</label>';

                          echo '<select id="reco" required>';
                            echo '<option>Select Recommendation</option>';         
                              
                                  if ($recnum > 0) { //if starts here
                                      
                                      while($rowrec=$recstmt->fetch(PDO::FETCH_ASSOC))
                                       {                                                    
                                          echo '<option value = '.$rowrec["recctitle"].'>'.$rowrec["recctitle"].'</option>'; 
                                      }// end of while statement
                                  }//end of if statement  
                            
                          echo '</select>'; 

  }
  else if ($_SESSION['staffdetails']['staffid'] == $_SESSION['staffdetails']['dean'] ) {
   echo '<b>Make Recommendation</b>';
   echo "</span>";
        echo "</h5>";

        echo '<div class="row">'; 
            echo '<table class="table">';
             echo '<tr>';
               echo '<td>Recommended Start date</td>';
    
        if ($datenum > 0) //if starts here
        {          
            while($lvdate=$chkstmt->fetch(PDO::FETCH_ASSOC))
             {     
              $datearr[] = $lvdate;
              }
        } 
                      echo '<td> <input type="date" id="sdate" value=".$datearr["recstartdate"]."></td>';
                        echo '<td>Recommended End date</td>';
                        echo '<td> <input type="date" id="edate" value=".$datearr["recenddate"]."></td>';
                      
                   echo '</tr>';
                    echo '</table>';
                    echo '<table class="table">';
                      echo '<tr>';
                        echo '<td>Comment</td>';
                        echo '<td><textarea class="form-control" id="remarks" rows="2" cols="80" required></textarea></td>';
                      echo '</tr>';
                    echo '</table>';                    
                    
                    echo '<input type="hidden" id="role" value="Dean">';                  
                    
                    echo '<input type="hidden" id="appno" value="'.$appno.'">';
                     
                    echo '<input type="hidden" id="staffid" name="staffId" value="'.$_SESSION['staffdetails']['staffid'].'">';

                    echo '<table class="table">';
                      echo '<tr>';
                        echo '<td><label>Recommendation</label>';

                          echo '<select id="reco" required>';
                            echo '<option>Select Recommendation</option>';         
                              
                                  if ($recnum > 0) { //if starts here
                                      
                                      while($rowrec=$recstmt->fetch(PDO::FETCH_ASSOC))
                                       {                                                    
                                          echo '<option value = '.$rowrec["recctitle"].'>'.$rowrec["recctitle"].'</option>'; 
                                      }// end of while statement
                                  }//end of if statement  
                            
                          echo '</select>'; 

  }
  else if ($_SESSION['staffdetails']['staffid'] == $_SESSION['staffdetails']['hro'] ) {
   echo '<b>Make Recommendation</b>';
   echo "</span>";
        echo "</h5>";

        echo '<div class="row">'; 
            echo '<table class="table">';
             echo '<tr>';
               echo '<td>Recommended Start date</td>';
    
        if ($datenum > 0) //if starts here
        {          
            while($lvdate=$chkstmt->fetch(PDO::FETCH_ASSOC))
             {     
              $datearr[] = $lvdate;
              }
      } 

                        echo '<td> <input type="date" id="sdate" value=".$datearr["recstartdate"]."></td>';
                        echo '<td>Recommended End date</td>';
                        echo '<td> <input type="date" id="edate" value=".$datearr["recenddate"]."></td>';
                      
                   echo '</tr>';
                    echo '</table>';
                    echo '<table class="table">';
                      echo '<tr>';
                        echo '<td>Comment</td>';
                        echo '<td><textarea class="form-control" id="remarks" rows="2" cols="80" required></textarea></td>';
                      echo '</tr>';
                    echo '</table>';                    
                    
                    echo '<input type="hidden" id="role" value="HR">';                  
                    
                    echo '<input type="hidden" id="appno" value="'.$appno.'">';
                     
                    echo '<input type="hidden" id="staffid" name="staffId" value="'.$_SESSION['staffdetails']['staffid'].'">';

                    echo '<table class="table">';
                      echo '<tr>';
                        echo '<td><label>Recommendation</label>';

                          echo '<select id="reco" required>';
                            echo '<option>Select Recommendation</option>';         
                              
                                  if ($recnum > 0) { //if starts here
                                      
                                      while($rowrec=$recstmt->fetch(PDO::FETCH_ASSOC))
                                       {                                                    
                                          echo '<option value = '.$rowrec["recctitle"].'>'.$rowrec["recctitle"].'</option>'; 
                                      }// end of while statement
                                  }//end of if statement  
                            
                          echo '</select>'; 

  }
  else if ($_SESSION['staffdetails']['staffid'] == $_SESSION['staffdetails']['rego'] ) {
   echo ' <b>Make Recommendation/Approval</b>';

   echo "</span>";
        echo "</h5>";

        echo '<div class="row">'; 
            echo '<table class="table">';
             echo '<tr>';
               echo '<td>Recommended Start date</td>';
    
        if ($datenum > 0) //if starts here
        {          
            while($lvdate=$chkstmt->fetch(PDO::FETCH_ASSOC))
             {     
              $datearr[] = $lvdate;
              }
      } 

                        echo '<td> <input type="date" id="sdate" value=".$datearr["recstartdate"]."></td>';
                        echo '<td>Recommended End date</td>';
                        echo '<td> <input type="date" id="edate" value=".$datearr["recenddate"]."></td>';
                      
                   echo '</tr>';
                    echo '</table>';
                    echo '<table class="table">';
                      echo '<tr>';
                        echo '<td>Comment</td>';
                        echo '<td><textarea class="form-control" id="remarks" rows="2" cols="80" required></textarea></td>';
                      echo '</tr>';
                    echo '</table>';                    
                    
                    echo '<input type="hidden" id="role" value="Registrar">';                  
                    
                    echo '<input type="hidden" id="appno" value="'.$appno.'">';
                     
                    echo '<input type="hidden" id="staffid" name="staffId" value="'.$_SESSION['staffdetails']['staffid'].'">';

                    echo '<table class="table">';
                      echo '<tr>';
                        echo '<td><label>Recommendation</label>';

                          echo '<select id="reco" required>';
                            echo '<option>Select Recommendation</option>';         
                              
                                  if ($recnum > 0) { //if starts here
                                      
                                      while($rowrec=$recstmt->fetch(PDO::FETCH_ASSOC))
                                       {                                                    
                                          echo '<option value = '.$rowrec["recctitle"].'>'.$rowrec["recctitle"].'</option>'; 
                                      }// end of while statement
                                  }//end of if statement  
                            
                          echo '</select>'; 

  }
  else if ($_SESSION['staffdetails']['staffid'] == $_SESSION['staffdetails']['vco'] ) {
   echo ' <b>Make Approval</b>';

   echo '<input type="hidden" id="role" value="VC">';   

   echo "</span>";
        echo "</h5>";
           echo '<table class="table">';
              echo '<tr>';
               echo '<td><label>Recommendation</label>';
                echo '<select id="reco" required>';
                 echo '<option>Select Recommendation</option>';                                     
                      
                      if ($recnum > 0) { //if starts here                
                            while($rowrec=$recstmt->fetch(PDO::FETCH_ASSOC))
                              {                                             
                                   
                                echo '<option value = '.$rowrec["recctitle"].'>'.$rowrec["recctitle"].'</option>'; 
                              }// end of while statement
                           }//end of if statement  
                            
                  echo '</select>'; 

  }
?>

        <!--------------------------cut from here---------------------------------------------------->    
      </td>
      <td>
        <button id="btn-save" class="btn">Save</button>
      </td>
      <td>
        <button>
          <a style="font-size: 14px;"  href="leavedashboard.php?id= <?php echo base64_encode($_SESSION['staffdetails']['staffid']); ?>">Cancel</a>
        </button>
      </td>
      </tr>
  </table>  
</div>
</div>
<div id="error"></div>
  <!-- 
      <h4><small>RECENT POSTS</small></h4>
      <hr>
      <h2>I Love Food</h2>
      <h5><span class="glyphicon glyphicon-time"></span> Post by Jane Dane, Sep 27, 2015.</h5>
      <h5><span class="label label-danger">Food</span> <span class="label label-primary">Ipsum</span></h5><br>
      <p>Food is my passion. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      <br><br>
      
      <h4><small>RECENT POSTS</small></h4>
      <hr>
      <h2>Officially Blogging</h2>
      <h5><span class="glyphicon glyphicon-time"></span> Post by John Doe, Sep 24, 2015.</h5>
      <h5><span class="label label-success">Lorem</span></h5><br>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      <hr>

      <h4>Leave a Comment:</h4>
      <form role="form">
        <div class="form-group">
          <textarea class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
      </form>
      <br><br>
      
      <p><span class="badge">2</span> Comments:</p><br>
      
      <div class="row">
        <div class="col-sm-2 text-center">
          <img src="bandmember.jpg" class="img-circle" height="65" width="65" alt="Avatar">
        </div>
        <div class="col-sm-10">
          <h4>Anja <small>Sep 29, 2015, 9:12 PM</small></h4>
          <p>Keep up the GREAT work! I am cheering for you!! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          <br>
        </div>
        <div class="col-sm-2 text-center">
          <img src="bird.jpg" class="img-circle" height="65" width="65" alt="Avatar">
        </div>
        <div class="col-sm-10">
          <h4>John Row <small>Sep 25, 2015, 8:25 PM</small></h4>
          <p>I am so happy for you man! Finally. I am looking forward to read about your trendy life. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          <br>
          <p><span class="badge">1</span> Comment:</p><br>
          <div class="row">
            <div class="col-sm-2 text-center">
              <img src="bird.jpg" class="img-circle" height="65" width="65" alt="Avatar">
            </div>
            <div class="col-xs-10">
              <h4>Nested Bro <small>Sep 25, 2015, 8:28 PM</small></h4>
              <p>Me too! WOW!</p>
              <br>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->
</div>


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
