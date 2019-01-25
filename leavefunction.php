<?php 

function checkSession(){

	session_start();
 
	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["staffdetails"]) && $_SESSION["staffdetails"] !== true){
    	header("location: login.php");
    exit;
	}
}//end of function checkSession

function checkLeaveStatus($id)
{
	include 'config/database.php';

		$qry = "SELECT appstatus
				FROM leaveapp
				WHERE staffid = '$id'
				LIMIT 0,1";

		$stmt = $con->prepare($qry);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$status = $row['appstatus'];
		
		if ($status = 0) {
			echo "denied";
		} elseif ($status = 1) {
			echo "pending";
		} elseif ($status = 2){
			echo "approved";
		} else {
			echo "The staff has no application in the database";
		}
			
}//end of function check leave status

function leavedetails($id)
{

}//end of function leave details
	

function getname($id)
{
		include 'config/database.php';

		$qry = "SELECT sname, mname, fname
				FROM stafflist
				WHERE staffid = '$id'";

		$stmtname = $con->prepare($qry);
		$stmtname->execute();

		$row = $stmtname->fetch(PDO::FETCH_ASSOC);

		$name = $row['sname']." ".$row['mname']." ".$row['fname'];

		return $name;

	}//end of function getname

function getunitprgid($id){
	
	include 'config/database.php';

	$qry = "SELECT unitprgid 
        	  FROM stafflst
			  WHERE staffid = '$id'";

    $stmt = $con->prepare($qry);
    $stmt->execute();
        
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

	$unitprgid = $row['unitprgid'];

	return $unitprgid;

}//end of function to get unit/program ID

function getcolid($id){
	
	include 'config/database.php';

	$qry = "SELECT coldirid	 
        	  FROM stafflst
			  WHERE staffid = '$id'";

    $stmt = $con->prepare($qry);
    $stmt->execute();
        
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

	$coldirid = $row['coldirid'];

	return $coldirid;

}//end of function to get unit/program ID

function getkol($id){
	
	include 'config/database.php';

	$qry = "SELECT kol	 
        	  FROM stafflst
			  WHERE staffid = '$id'";

    $stmt = $con->prepare($qry);
    $stmt->execute();
        
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

	$kol = $row['kol'];

	return $kol;

}

function getdept($id){
	
	include 'config/database.php';

	$qry = "SELECT dept	 
        	  FROM stafflst
			  WHERE staffid = '$id'";

    $stmt = $con->prepare($qry);
    $stmt->execute();
        
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

	$dept = $row['dept'];

	return $dept;

}

function isHod($staffid){

	include 'config/database.php';

		$qry = "SELECT staffid
				FROM stafflst
				WHERE hod = '$staffid'";

		$stmt = $con->prepare($qry);
		$stmt->execute();
			 if($stmt->rowCount() >= 1)
			{
				return true;
			}
			else
			{
				return false;
			}
	}//end of function isHod

function isdean($staffid){

	include 'config/database.php';

		$qry = "SELECT staffid
				FROM stafflst
				WHERE '$staffid' = dean";

		$stmt = $con->prepare($qry);
		$stmt->execute();
		if($stmt->rowCount() >= 1)
			{
				return true;
			}
			else
			{
				return false;
			}
	}//end of function isHod

function getstaffidbyappno($appno){
	
	include 'config/database.php';

	$qry = "SELECT staffid
        	  FROM leaveapplication
			  WHERE appno = '$appno'";

    $stmt = $con->prepare($qry);
    $stmt->execute();
        
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

	$staffid = $row['staffid'];

	return $staffid;

}//end of function to get staffid by appno in leaveapplication tabless

	function randomString($length) {
		$str = "";
		$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
	}//end of function random string

	function randomID($length) {
		$str = "";
		$characters = array_merge(range('A','Z'), range('0','9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
	}//end of function randomID


	function appNo($length) {
		$str = "";
		$characters = array_merge(range('0','9'), range('0','9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
	}//end of function randomID

	function serAppno(){

		include 'config/database.php';

		$query = "SELECT appno
                  FROM leaveapplication
                  ORDER BY sn
                  DESC LIMIT 1";

        $stmt = $con->prepare($query);
        $stmt -> execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
        	 $row = $stmt->fetch(PDO::FETCH_ASSOC);
        	 $appno = sprintf('%09d', ($row['appno'] + 1));
	       	 return $appno;
        
        } else {

        	return $appno = "000000001";
        }//end of if else      
	}//end of function serAppno

	function test_input($data) {
		$data = trim($data);
		$data = addslashes($data);
		$data = htmlspecialchars($data);
		$data = filter_var($data, FILTER_SANITIZE_STRING);
		return $data;
	}//end of function test_input

	
	function get_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = filter_var($data, FILTER_SANITIZE_STRING);
		return $data;
	}//end of function get_input

	function trackid($appno){
		
		include 'config/database.php';

		$qry = "SELECT MAX(transactionid) AS transaction
				FROM leavetransaction
				WHERE appno = '$appno'";

		$stmt= $con->prepare($qry);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$track = $row['transaction'];

		return $track;

	}//end of trackid

function getstatusbyID($id)
{
		include 'config/database.php';

		$query = "SELECT st.fname, st.sname, s.dept, s.hod, l.staffid, l.leavetype, l.reason, l.startdate, l.enddate, l.leavestatus, l.appno, lt.tstaffid, lt.comment, lt.transactionid, lt.recstartdate, lt.recenddate, lt.status, lt.timeviewed
				  FROM stafflst AS s
                  INNER JOIN leaveapplication AS l
                  ON s.staffid = l.staffid
                  INNER JOIN stafflist AS st
                  ON s.staffid = st.staffid
                  INNER JOIN leavetransaction AS lt
                  ON l.appno = lt.appno
                  WHERE l.staffid = '$id'";

        	$stmt = $con->prepare($query);
        	$stmt->execute(); 

        	$row=$stmt->fetch(PDO::FETCH_ASSOC);

        	return $row;

}

function getstaffnames($id)
	{
		
		include 'config/database.php';

		$query = "";

        	$stmt = $con->prepare($query);
        	$stmt->execute(); 

        	$row=$stmt->fetch(PDO::FETCH_ASSOC);

        	return $row;
        

	}

	function getstatus($appno){

		include 'config/database.php';

		$qry = "SELECT status
				FROM leavetransaction
				WHERE appno = '$appno'
				ORDER BY transactionid DESC
				LIMIT 1";

		$stmt= $con->prepare($qry);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$status = $row['status'];

		//use status to get recomendation

		$qry1 = "SELECT rectitle
				FROM leaverecommendation
				WHERE recid = '$status'";

		$stmt1= $con->prepare($qry1);
		$stmt1->execute();

		$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

		$recomendation = $row1['rectitle'];

		return $recomendation; //recommendations in the database gives the status of the application.

	}

	function cleandata($formdata){
			$arrlength=count($formdata);

			for($x = 0; $x < $arrlength; $x++)
		  	{
		  		 $formdata[$x] = trim($formdata[$x]);
		  		 $formdata[$x] = stripslashes($formdata[$x]);
		  		 $formdata[$x] = filter_var($formdata[$x], FILTER_SANITIZE_STRING);  		
		  	}

		  	return $formdata;
	}//end of function clean data

	function numdays($date1, $date2)
	{
		$stdate = date_create($date1);
		$eddate = date_create($date2);
        
        $diff = date_diff($stdate,$eddate);
        $ndays = $diff->format("%r%a ");

        return $ndays;
	}//end of function number of days

	function staffDetails()
	{
		
		$userdetails = get_user($_SESSION['loginid']);

		$staffdetails = get_user($staffid);
		$staffid = implode(',',array_map(function($el){return $el['idno']; }, $userdetails));
	}

	function decoder($words)
	{
            echo base64_encode($words);
            echo base64_decode($words); 

	}//end of function to encode and decode words 


?>