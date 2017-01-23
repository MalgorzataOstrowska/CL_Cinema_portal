
<?php

/******************************************************************************/    
/**
 * INSERT_INTO_cinema
 * @param mysqli $connection
 */
function INSERT_INTO_cinema($connection) {
    if ($_SERVER['REQUEST_METHOD']==='POST') {
        if (isset($_POST['name'])     && 
            isset($_POST['address'])  ){

            $name = $_POST['name'];
            $address = $_POST['address'];
            
            if (!empty($name) && !empty($address)) {
                
                $sql = "INSERT INTO `cinema` (`name`, `address`) VALUES ('$name', '$address')";

                if ($connection->query($sql) === TRUE) {
                    echo '<br><br>New cinema added<br><br>';
                } else {
                    echo("<br><br>Error: <br>" . $sql . "<br>" . $connection->error);
                }
            }
            else{
                echo 'Incomplete data';
            }
        }
    }
}