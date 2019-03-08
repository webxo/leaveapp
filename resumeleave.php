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

//get transaction id for the current application stream 
$track = trackid($appno); //this is the transactionid which will later be increased by 1
$transactionid = $track + 1;

//get the time viewed
$timeviewed = date('Y-m-d', strtotime($rdate));
 
//need be changed
//get comment
#comment is gotten from the post variables

//get status
try{

		$qry = "INSERT INTO leavetransaction (appno, tstaffid, role, transactionid, timeviewed, status, recstartdate, recenddate) 
				VALUES (:appno, :staffid, :role, :transactionid, :timeviewed, :status, :recstartdate, :recenddate)";

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
        //$stmtu->bindParam(':remarks', $remarks);

        if($stmtu->execute()){
            $resumed = 1;
            
            $qry3 = "UPDATE approvedleaves 
                          SET resumed = :resumed
                            WHERE appno = :appno";

                // prepare query for excecution
                $stmt3 = $con->prepare($qry3);     

                // bind the parameters
                $stmt3->bindParam(':resumed', $resumed);
                $stmt3->bindParam(':appno', $appno);

                if($stmt3->execute());
                {
                    $message = "Query Submitted";
                    echo $message;
                }
    
        }
        else
        {
            echo "Query not inserted";
           // print_r($_POST);
        }

    }
        catch(PDOException $e){
   	            echo "Error: " . $e->getMessage();
 }//end of catch

?>
