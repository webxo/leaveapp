<?php
require_once "config/database.php";

$sql = "SELECT idno, fname, sname FROM userz";

$stmt = $con->prepare($sql);

$stmt->execute();

			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		             {
		               //extract row this truns array keys into variables
		               extract($row);
		               echo $idno."  ".$fname."<br>";
		              }

		
?>