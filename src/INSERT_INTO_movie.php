<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
   
/**
 * INSERT_INTO_movie
 * @param mysqli $connection
 */
function INSERT_INTO_movie($connection) {
    if ($_SERVER['REQUEST_METHOD']==='POST') {
        if (isset($_POST['name'])     && 
            isset($_POST['rating'])     &&  
            isset($_POST['description'])  ){

            $rating = $_POST['rating'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            
            
            if (!empty($name) && !empty($rating) && !empty($description)) {
                if (is_numeric($rating) && $rating >= 0.00 && $rating <= 10.00) {



                    $sql = "INSERT INTO `movie` (`name`, `description`, `rating`) VALUES ('$name', '$description', '$rating')";


                    if ($connection->query($sql) === TRUE) {
                        echo '<br><br>New movie added<br><br>';
                    } 
                else {
                        echo("<br><br>Error: <br>" . $sql . "<br>" . $connection->error);
                    }
                }             else {
                    die('<br>ERROR: Bad rating');
                }
            }
            else{
                echo 'Incomplete data';
            }            
        }
    }
}