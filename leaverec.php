<?php

/*
Developer: Ekunkoya Isaiah
Site:      ekunkoya.com.ng
Script:    Inserts data into transaction table
File:      leavetrack.php
For every appno entrying this file, the transactionid increases by 1.
*/

require_once "config/database.php";
require_once "leavefunction.php";

extract($_POST);

//get appno of leave application


//get staffid
//$staffid = randomID(6);

//get transaction id for the current application stream 
$track = trackid($appno); //this is the transactionid which will later be increased by 1
$transactionid = $track + 1;

//get the time viewed
$timeviewed = date('Y-m-d H:i:s');
 
//need be changed
//get comment
#comment is gotten from the post variables

//get status

		$qry = "INSERT INTO leavetransaction (appno, tstaffid, transactionid, timeviewed, status, recstartdate, recenddate, remarks) 
				VALUES (:appno, :staffid, :transactionid, :timeviewed, :status, :recstartdate, :recenddate, :remarks)";

        // prepare query for excecution
        $stmtu = $con->prepare($qry);

        // bind the parameters
        $stmtu->bindParam(':appno', $appno);
        $stmtu->bindParam(':staffid', $staffid);
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
			$message = '<div class="row">
		       				<p class="col-sm-6">Applied Start Date: <span class="boder border-l">'.$dbegin.'<span></p>
		       					<p class="col-sm-6 boder-p">Applied Start Date: <span class="boder border-r">'.$dend.'<span></p>
		    			</div>';

		    $message .= '<div class="row m-b-0em">
		    		       <p class="col-sm-3">Comment: </p> 
		    		       <p class="col-sm-9 boder">'.$remarks.'</p> 
		    		    </div>';
		   $message .=  '<div class="row m-b-0em">
		    		       <p class="col-md-3">Recommendation: </p> 
		    		       <p class="col-md-9 boder">Approved</p> 
		    		    </div>';

		   echo $message;
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
