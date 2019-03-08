<?php
/*
Developer: Ekunkoya Isaiah
Site:      ekunkoya.com.ng
Script:    Inserts data into transaction table
File:      leaverec.php
For every appno entrying this file, the transactionid increases by 1.
*/

require_once "config/database.php";
require_once "leavefunction.php";

extract($_POST);

if($reco == 'Released'){

//get transaction id for the current application stream 
$track = trackid($appno); //this is the transactionid which will later be increased by 1
$transactionid = $track + 1;

//get the time viewed
$timeviewed = date('Y-m-d H:i:s');
$dateofrelease = date('Y-m-d H:i:s');

$edate = date('Y-m-d', strtotime($edate));
$sdate = date('Y-m-d', strtotime($sdate));
 

$qry = "INSERT INTO leavetransaction (appno, tstaffid, role, transactionid, timeviewed, status, recstartdate, recenddate, remarks) 
        VALUES (:appno, :staffid, :role, :transactionid, :timeviewed, :status, :recstartdate, :recenddate, :remarks)";

        // prepare query for excecution
        $stmtu = $con->prepare($qry);

        // bind the parameters
        $stmtu->bindParam(':appno', $appno);
        $stmtu->bindParam(':staffid', $staffid);
        $stmtu->bindParam(':role', $role);
        $stmtu->bindParam(':transactionid', $transactionid);
        $stmtu->bindParam(':timeviewed', $timeviewed);
        $stmtu->bindParam(':status', $reco);
        $stmtu->bindParam(':recstartdate', $sdate);
        $stmtu->bindParam(':recenddate', $edate); 
        $stmtu->bindParam(':remarks', $remarks);

        //format date to this format 00-Mon-0000
        $dbegin = date_format(date_create($sdate), "d-M-Y"); //date began
        $dend = date_format(date_create($edate), "d-M-Y"); //date ending

 try {

    if($stmtu->execute())
    {
        
        $qry1 = "UPDATE approvedleaves
                  SET releaseddate=:dateofrelease
                  WHERE appno = :appno";

        // prepare query for excecution
        $stmt1 = $con->prepare($qry1);     

        // bind the parameters
        $stmt1->bindParam(':dateofrelease', $dateofrelease);
        $stmt1->bindParam(':appno', $appno);
    
        if($stmt1->execute());
          {
            $qry3 = "UPDATE leaveapplication 
                          SET leavestatus = :leavestatus, leavestageid = :stage
                            WHERE appno = :appno";

                // prepare query for excecution
                $stmt3 = $con->prepare($qry3);     

                // bind the parameters
                $stmt3->bindParam(':leavestatus', $reco);
                $stmt3->bindParam(':stage', $stage);
                $stmt3->bindParam(':appno', $appno);
    
                if($stmt3->execute());
                {
                    $message = "Query Submitted";
                    echo $message;
                }
          }//end of if stmt1

  }//end of if
    else 
    {
      $error="Not Inserted,Some Problem occur.";
      // print_r($stmtu->errorInfo());
      //echo json_encode($error);
      echo $error;
    }//end of else statement
 }//end of try
 catch(PDOException $e){
     echo "Error: " . $e->getMessage();
 }//end of catch

}//end of if Released

else if ($reco == 'Not Yet Released') {
  
  //get transaction id for the current application stream 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$track = trackid($appno); //this is the transactionid which will later be increased by 1
/*$qry = "SELECT MAX(transactionid) 
        FROM leavetransaction
        WHERE appno = '$appno'";

    $stmt= $con->prepare($qry);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $track = (int)$row['transactionid'];
    */

    $transactionid = $track + 1;
    
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//get the time viewed
$timeviewed = date('Y-m-d H:i:s');
 
//need be changed
//get comment
#comment is gotten from the post variables

//get status

    $qry = "INSERT INTO leavetransaction (appno, tstaffid, role, transactionid, timeviewed, status, recstartdate, recenddate, remarks) 
        VALUES (:appno, :staffid, :role, :transactionid, :timeviewed, :status, :recstartdate, :recenddate, :remarks)";

        // prepare query for excecution
        $stmtu = $con->prepare($qry);

        // bind the parameters
        $stmtu->bindParam(':appno', $appno);
        $stmtu->bindParam(':staffid', $staffid);
        $stmtu->bindParam(':role', $role);
        $stmtu->bindParam(':transactionid', $transactionid);
        $stmtu->bindParam(':timeviewed', $timeviewed);
        $stmtu->bindParam(':status', $reco);
        $stmtu->bindParam(':recstartdate', $sdate);
        $stmtu->bindParam(':recenddate', $edate); 
        $stmtu->bindParam(':remarks', $remarks);

        //format date to this format 00-Mon-0000
        $dbegin = date_format(date_create($sdate), "d-M-Y"); //date began
        $dend = date_format(date_create($edate), "d-M-Y"); //date ending

 try {

    if($stmtu->execute())
    {
      $qry3 = "UPDATE leaveapplication 
                SET leavestatus = :leavestatus, leavestageid = :stage
                  WHERE appno = :appno";

                // prepare query for excecution
                $stmt3 = $con->prepare($qry3);     

                // bind the parameters
                $stmt3->bindParam(':leavestatus', $reco);
                $stmt3->bindParam(':stage', $stage);
                $stmt3->bindParam(':appno', $appno);
    
                if($stmt3->execute());
                {
                    $message = "Query Submitted";
                    echo $message;
                }
    }//end of if stmtu
    else 
    {
      $error="Not Inserted,Some Problem occur.";
      // print_r($stmtu->errorInfo());
      //echo json_encode($error);
      echo $error;
    }//end of else statement
 }//end of try
 catch(PDOException $e){
     echo "Error: " . $e->getMessage();
 }//end of catch

}//end of if Not yet Released

else {
  //get transaction id for the current application stream 
$track = trackid($appno); //this is the transactionid which will later be increased by 1
$transactionid = $track + 1;

//get the time viewed
$timeviewed = date('Y-m-d H:i:s');
 
//need be changed
//get comment
#comment is gotten from the post variables

//get status

    $qry = "INSERT INTO leavetransaction (appno, tstaffid, role, transactionid, timeviewed, status, recstartdate, recenddate, remarks) 
        VALUES (:appno, :staffid, :role, :transactionid, :timeviewed, :status, :recstartdate, :recenddate, :remarks)";

        // prepare query for excecution
        $stmtu = $con->prepare($qry);

        // bind the parameters
        $stmtu->bindParam(':appno', $appno);
        $stmtu->bindParam(':staffid', $staffid);
        $stmtu->bindParam(':role', $role);
        $stmtu->bindParam(':transactionid', $transactionid);
        $stmtu->bindParam(':timeviewed', $timeviewed);
        $stmtu->bindParam(':status', $reco);
        $stmtu->bindParam(':recstartdate', $sdate);
        $stmtu->bindParam(':recenddate', $edate); 
        $stmtu->bindParam(':remarks', $remarks);

        //format date to this format 00-Mon-0000
        $dbegin = date_format(date_create($sdate), "d-M-Y"); //date began
        $dend = date_format(date_create($edate), "d-M-Y"); //date ending

 try {

    if($stmtu->execute())
    {
      $qry3 = "UPDATE leaveapplication 
                SET leavestatus = :leavestatus, leavestageid = :stage
                  WHERE appno = :appno";

                // prepare query for excecution
                $stmt3 = $con->prepare($qry3);     

                // bind the parameters
                $stmt3->bindParam(':leavestatus', $reco);
                $stmt3->bindParam(':stage', $stage);
                $stmt3->bindParam(':appno', $appno);
    
                if($stmt3->execute());
                {
                    $message = "Query Submitted";
                    echo $message;
                }
    }//end of if stmtu
    else 
    {
      $error="Not Inserted,Some Problem occur.";
      // print_r($stmtu->errorInfo());
      //echo json_encode($error);
      echo $error;
    }//end of else statement
 }//end of try
 catch(PDOException $e){
     echo "Error: " . $e->getMessage();
 }//end of catch

}//end of else.

?>
