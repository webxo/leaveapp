<?php 
	require_once 'leavefunction.php';


checkSession();
$staffid = $_SESSION['staffdetails']['staffid'];
$level = $_SESSION['staffdetails']['level'];
$leavetype = $_POST['leavetype'];

$result = array();

$session = '2018/2019';

		//numdays($_POST['sdate'], $_POST['edate'])." Days ";

		 $leavedaysgone = (int)leavedaysgone($staffid, $session, $leavetype);
	     $leaveallowed = (int)leavedaysallowed($staffid, $leavetype);
	     
	     $dayspermissible = $leaveallowed - $leavedaysgone;

	     $ndaysapplied = numdays($_POST['sdate'], $_POST['edate']);

		 if($ndaysapplied < 0 )
		 {
		   	$result['status'] = 'neg';
		   	$result['reason'] = 'Invalid Days Selected';
		 }
	     
	     else if ($ndaysapplied > $dayspermissible) 
	     {
	     	$result['status'] = 'err';
	     	$result['reason'] = 'Leave duration is more than allowed and permissible';
	     	$result['daysapplied'] = $ndaysapplied;
	     }
	     
	     else
	     {
	     	$result['status'] = 'ok';
	     	$result['allow'] = $dayspermissible;
	     	$result['daysapplied'] = $ndaysapplied;
	     }

	     echo json_encode($result);
?>