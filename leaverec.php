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

// $time = strtotime('10/16/2003');

// $newformat = date('Y-m-d',$time);

// echo $newformat;
// // 2003-10-16

$edate = date('Y-m-d', strtotime($edate));
$sdate = date('Y-m-d', strtotime($sdate));
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
                $qry1 = "UPDATE leaveapplication 
                          SET leavestatus = :leavestatus, leavestageid = :stage
                            WHERE appno = :appno";

                // prepare query for excecution
                $stmt1 = $con->prepare($qry1);     

                // bind the parameters
                $stmt1->bindParam(':leavestatus', $reco);
                $stmt1->bindParam(':stage', $stage);
                $stmt1->bindParam(':appno', $appno);
    
                if($stmt1->execute());
                {
                    $message = "Query Submitted";
                    echo $message;
                }

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

?>
