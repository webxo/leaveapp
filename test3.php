<?php 
	
include 'config/database.php';
     $vari='';
	$query = "SELECT appno
             FROM leaveapplication
             LIMIT 1";

        $stmt = $con->prepare($query);
        $stmt -> execute();

        $num = $stmt->rowCount();

    	 while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    	 {
    	 	
    	 	 $vari= $row['appno'] + 1;
    	 	 echo sprintf('%09d', $vari);
             // echo ++$vari;
	     }

?>