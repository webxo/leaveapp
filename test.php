<?php

include 'config/database.php';
include 'leavefunction.php';

        $query ="SELECT * FROM approvedleaves WHERE resumeddate = ' '";


        $stmt = $con->prepare($query);
        $stmt->execute();  

        $num = $stmt->rowCount();

        $today = date('Y-m-d');

        echo "Overstay Page <br>";
        echo "------------------------------------------------------"; 

        if( $num > 0 )
        {
            while( $row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
              $resdt = resumptionday($row['apenddate']);
             // echo $resdt.' '.$row['apenddate']. ' '. $today. '<br>';

              if($today > $resdt)
              {
                echo '<br>'.$row['staffid'].'---'. $resdt.'----'.$row['apenddate']. '---'. $today. 'This staff has overstayed <br>';
                //echo "This staff has overstayed<br>";
              }
            }
        }
        else
        {
          echo 'No staff has overstayed';
        }



?>