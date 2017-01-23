<?php

/**
 * INSERT_INTO_payment
 * @param mysqli $connection
 */
function INSERT_INTO_payment($connection) {
    if ($_SERVER['REQUEST_METHOD']==='POST') {
        if (isset($_POST['payment_type'])     && 
            isset($_POST['payment_date'])        ){

            $payment_type = $_POST['payment_type'];
            
            if ($payment_type == 'transfer' ||
                $payment_type == 'cash' ||
                $payment_type == 'card') {
                
                $payment_date = $_POST['payment_date'];

                $sql = "INSERT INTO `payment` (`date`, `type`) VALUES ('$payment_date', '$payment_type')";

                if ($connection->query($sql) === TRUE) {
                    echo '<br><br>New payment added<br><br>';
                } 
                else {
                    echo("<br><br>Error: <br>" . $sql . "<br>" . $connection->error);
                }
            }                   
            else{
                die('<br>ERROR: Bad payment type');
            }
        }
    }
}