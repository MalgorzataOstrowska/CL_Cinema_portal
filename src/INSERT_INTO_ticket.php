<?php

/**
 * INSERT_INTO_ticket
 * @param mysqli $connection
 */
function INSERT_INTO_ticket($connection) {
    if ($_SERVER['REQUEST_METHOD']==='POST') {
        if (isset($_POST['quantity'])     && 
            isset($_POST['price'])        ){

            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            
            if (!empty($price) && !empty($quantity)) {
                if ($price > 0) {


                    $sql = "INSERT INTO `ticket` (`quantity`, `price`) VALUES ('$quantity', '$price')";

                    if ($connection->query($sql) === TRUE) {
                        echo '<br><br>New ticket added<br><br>';
                    } 
                else {
                        echo("<br><br>Error: <br>" . $sql . "<br>" . $connection->error);
                    }
                } 
                else {
                    die('<br>ERROR: Bad price');
                }
            }
            else{
                echo 'Incomplete data';
            } 
        }
    }
}