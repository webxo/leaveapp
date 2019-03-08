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
        #A QUICK QUERY TO CHECK IF A SUPERVISOR HAS ACTED ON AN APPLICATION
    $chkdtqry = "SELECT recstartdate, recenddate, remarks FROM leavetransaction 
                 WHERE appno = '$appno' 
                 ORDER BY `sn` DESC
                 LIMIT 1";

        $chkstmt1 = $con->prepare($chkdtqry);
        $chkstmt1->execute();
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

                     $recqry = "SELECT recctitle, reccgroup
                                FROM leaverecommendations
                                WHERE reccgroup = 3";            
                    

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
    .wrapper{
      padding-left: 300px;
    }
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
<div class="wrapper">
  <?php
  if ($num > 0) { 
    while($staffdet=$stmtleave->fetch(PDO::FETCH_ASSOC))
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
<!---------------------------------------------------------------------------------------------------------------------------------------------------->
<div class="col-sm-4">
  <h4 id="title"><b>Applicant Release Details</b></h4>
  
<!----------------------------------------------------------------------------------------------------------------------------------------------------->
<h5><span class="sub-title">

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

 if ($_SESSION['staffdetails']['staffid'] == $_SESSION['staffdetails']['hro'] ) {
   //echo '<b>Make Recommendation</b>';
   echo "</span>";
        echo "</h5>";

        echo '<div class="row">'; 
            echo '<table class="table">';
             echo '<tr>';
               echo '<td><b>Recommended Start date</b></td>';
         
            while($lvdate=$chkstmt1->fetch(PDO::FETCH_ASSOC))
            {     
                 
                  $sdate = date('Y-m-d', strtotime($lvdate["recstartdate"]));
                  $edate = date('Y-m-d', strtotime($lvdate["recenddate"]));

                  echo '<td> <input type="date" id="sdate" value='.$sdate.' readonly></td>';
                  echo '<td><b>Recommended End date</td></b>';
                  echo '<td> <input type="date" id="edate" value='.$edate.' readonly></td>';
                  echo '<td id="datecomot">'.numdays($lvdate['recstartdate'], $lvdate['recenddate']). ' days';
                  echo  '</td>';
                  echo '<td id="datedif"> </td>';
                               
                   echo '</tr>';
                   // echo '</table>';
                    //echo '<table class="table">';
                      echo '<tr>';
                        echo '<td><b>Comment</b></td>';
                        echo '<td colspan="5"><textarea class="form-control" id="remarks" rows="2" cols="80" readonly>'.$lvdate["remarks"].'</textarea></td>';
                      echo '</tr>';
                    //echo '</table>';                    
            }//end of while    
                    echo '<input type="hidden" id="role" value="HR">'; 
                        echo '<td colspan="2"><label>Release Options</label>';
                        echo '<input type="hidden" id="appno" value="'.$appno.'">';
                         echo '<input type="hidden" id="staffid" name="staffId" value="'.$_SESSION['staffdetails']['staffid'].'">';
                          echo '&nbsp; <select id="reco">';
                            echo '<option>Select Release</option>';         
                              
                                  if ($recnum > 0) { //if starts here
                                      
                                      while($rowrec=$recstmt->fetch(PDO::FETCH_ASSOC))
                                       {                                                    
                                          echo '<option value = "'.$rowrec["recctitle"].'" disabled>'.$rowrec["recctitle"].'</option>'; 
                                      }// end of while statement
                                  }//end of if statement  
                            
                          echo '</select>'; 
}
  
?>  
    </td>
      <!-- <td>
        <button id="btn-save" class="btn">Release</button>
      </td> -->
      <td colspan="2">
        <button>
          <a style="font-size: 14px;" href="overstayedview.php?id= <?php echo base64_encode($_SESSION['staffdetails']['staffid']); ?>">Back</a>
        </button>
      </td>
      </tr>
  </table>  
</div>
</div>
<div id="error"></div>
  
</div>
</div><!--End of wrapper-->

 <script type="text/javascript">

        $(document).ready(function(){
           
             $('select#reco').change(function(){

            var appno = $('#appno').val();
            var staffid = $('#staffid').val();
            var sdate = $('#sdate').val();
            var edate = $('#edate').val();
            var remarks = $('#remarks').val();
            var reco = $('#reco').val();
            var role = $('#role').val();

            alert(appno+staffid+sdate+edate+remarks+reco+role);

            var encappno = window.btoa(staffid);

            var url = "leavedashboard.php?id="+encappno;            

            if ((appno == '') || (staffid == '') || (sdate == '') || (edate == '') || (remarks == '') || (reco == '') )
            {
                  alert("There is a missing field somewhere.");
            }

            $('#error').load('hrapproval.php', {
                      appno: appno,
                      staffid:staffid,
                      sdate: sdate,
                      edate: edate,
                      remarks: remarks,
                      reco: reco,
                      role: role
                 }, 
                 function(){
                      alert("Approval Sent");
                      $(location).attr('href', url);
                });         

        });
            
    });
    </script>
</body>
</html>
