<?php 
	
include 'config/database.php';

try{

    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $qry = "SELECT MAX(transactionid) AS transaction
        FROM leavetransaction
        WHERE appno = '000000001'
        LIMIT 1";

    $stmt= $con->prepare($qry);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {            
        $track = $row['transaction'];

        $transactionid = $track + 1;

        echo $track;
        echo "<br>".$transactionid;
    }

}
 catch(PDOException $e){
     echo "Error: " . $e->getMessage();
 }//end of catch






?>