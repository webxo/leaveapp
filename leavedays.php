<?php 
	
	header("Content-type: application/jason");

	include('config/database.php');
	include('leavefunction.php');

	
	extract($_POST);	
	// $output = ' ';
	// $output .= '  <p>A test </p>   '; 

	 $session = '2018/2019';
	 $output = ' ';
	 $outp = array();

	 if(($leavetype != 'casual') && ($leavetype != 'annual') && ($leavetype != 'maternity'))
	 {
	 	$output .= "<h5>".ucfirst($leavetype)." application module is not avalable yet </h5>";
	 	$outp['err'] = "Application module is not available";
	 } 
	 else
	 {
		 $leavedaysgone = (int)leavedaysgone($staffid, $session, $leavetype);
	     $leaveallowed = (int)leavedaysallowed($staffid, $leavetype);
	     
	     $dayspermissible = (int)$leaveallowed - (int)$leavedaysgone; 
	     $outp['status'] = 'ok';
	     $outp['dg'] = $leavedaysgone;
	     $outp['da'] = $leaveallowed;
	     $outp['dp'] = $dayspermissible;  
		
		 $output .= "<h6>". ucfirst($leavetype). " leave allowance is: ".$leaveallowed." days</h6>";
		 $output .= "<h6>". ucfirst($leavetype). " leave days gone is ".$leavedaysgone." day(s), ";
		 $output .= "you still have ".$dayspermissible." days out of your ".$leavetype." leave </h6>";
	}

	 echo $outp['da']."|".$outp['dg']."|".$outp['dp'];
	// echo json_encode($outp);
?>