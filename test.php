<?php

include 'config/database.php';

		$qry = "SELECT staffname
				FROM pdata
				WHERE staffid = 'CU/05/89'";

		$stmtname = $con->prepare($qry);
		$stmtname->execute();

		$row = $stmtname->fetch(PDO::FETCH_ASSOC);

		$name = $row['staffname'];

		echo $name;
?>