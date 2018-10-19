<?php 

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

		$qry = "SELECT staffname
				FROM pdata
				WHERE staffid = '$id'";

		$stmtname = $con->prepare($qry);
		$stmtname->execute();

		$row = $stmtname->fetch(PDO::FETCH_ASSOC);

		$name = $row['staffname'];

		return $name;

	}//end of function getname

function isStaffDept($staffid){
		if($staff === "acs"){
			echo "ACS";
		} 
		elseif ($staff === "nts") {
			if($unit === "directorate")
			{
				//follow the directorate flow
			} 
			else if ($unit === "dept") {
				# follow dept flow
			}
			else{
				//
			}
		}
	}//end of function isStaffDept

	function randomString($length = 6) {
		$str = "";
		$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
	}//end of function random string
?>