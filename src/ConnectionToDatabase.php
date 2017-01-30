<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConnectionToDatabase
 *
 * @author gosia
 */
class ConnectionToDatabase {
    //put your code here
    
 
    private $mysqli;
    
    public function __construct()
    {
        
        require 'configuration.php'; 
        
        // Creation of a new connection:
        $this->mysqli = new mysqli(
                                    $serverName,
                                    $userName,
                                    $password,
                                    $databaseName
                                );
        
        // Checking whether the connection succeeded
        if ($this->mysqli->connect_error) {
            die('Connection unsuccessful. Error: ' . $this->mysqli->connect_error);
        }
        echo("Connection successful.");
        
    }

    
    // ?????????????
    public function query($sql){
        $result = $this->mysqli->query($sql);
        if ($result == false) {
            die(sprintf("SQL: %s, Error: %s", $sql, $this->mysqli->error));
        }
        return $this->lastResult = $result;
        
    }    
    
    // ??????
    public function close(){
         $this->mysqli->close();
    }

    // static???
    public function DELETE_fromTable() {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            //echo 'GET';
            if (isset($_GET['id']) && isset($_GET['table']) ) {
                $id = $_GET['id'];
                $table = $_GET['table'];

                $sql = 'DELETE FROM ' . $table . ' WHERE `id` =' . $id;

                // Checking whether DELETE succeeded
                $result = $this->mysqli->query($sql);

                if ($result == FALSE){
                    echo '<br><br>Error<br>';
                }
                else{
                    $numberOfRows = $this->mysqli->affected_rows;
                    echo '<br><br>Success<br> Number of deleted rows: ' . $numberOfRows . '<br><br>';
                }            
            }
        }
    } 

/********************************************************************************************************************/    
    public function INSERT_INTO_cinema() {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            if (isset($_POST['name'])     && 
                isset($_POST['address'])  ){

                $name = $_POST['name'];
                $address = $_POST['address'];

                if (!empty($name) && !empty($address)) {

                    $sql = "INSERT INTO `cinema` (`name`, `address`) VALUES ('$name', '$address')";

                    if ($this->mysqli->query($sql) === TRUE) {
                        echo '<br><br>New cinema added<br><br>';
                    } else {
                        echo("<br><br>Error: <br>" . $sql . "<br>" . $this->mysqli->error);
                    }
                }
                else{
                    echo 'Incomplete data';
                }
            }
        }
    }    
    
    public function dataFromPOST_cinema() {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            if (isset($_POST['radio'])){

                $radio = $_POST['radio'];
                
                if ($radio == 'all') {
                    $sql = "SELECT `id`, `name`, `address` FROM `cinema`";
                }
                else if ($radio == 'letter'){
                    
                    if (isset($_POST['letter'])){
                        
                        $letter = $_POST['letter'];
                        
                        $sql = "SELECT `id`, `name`, `address` FROM `cinema` WHERE `name` LIKE '".$letter."%'";
                    }
                }
            }
        }
        else{
            $sql = "SELECT `id`, `name`, `address` FROM `cinema`";
        }
        return $sql;
    }
    
    public function printCinema($sql, $delete = false) {

        // Checking whether SELECT succeeded
        $result = $this->mysqli->query($sql);

        if ($result != false) {
            // Print data
            echo '<div class="container">
                <br><h3>Cinemas:</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>address</th>';
            if ($delete) {
                echo    '<th>DELETE</th>';
            }    
            echo    '</tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row["id"] . '</td>
                        <td>' . $row["name"] . '</td>
                        <td>' . $row["address"] . '</td>';
                if ($delete) {
                    echo '<td><a href="tab_cinema_add_delete.php?table=cinema&id='. $row["id"] . '">delete</a></td>';
                }
            }
            echo     '</tr>
            </table></div>';            
        } 
        else {
            echo '<br><br>Error<br>';
        }
    }
/********************************************************************************************************************/
    
    
    public function INSERT_INTO_movie() {
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


                        if ($this->mysqli->query($sql) === TRUE) {
                            echo '<br><br>New movie added<br><br>';
                        } 
                    else {
                            echo("<br><br>Error: <br>" . $sql . "<br>" . $this->mysqli->error);
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

    public function dataFromPOST_movie() {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            if (isset($_POST['radio'])){

                $radio = $_POST['radio'];
                
                if ($radio == 'all') {
                    $sql = "SELECT `id`, `name`, `description`, `rating` FROM `movie`";
                }
                else if ($radio == 'letter'){
                    
                    if (isset($_POST['letter'])){
                        
                        $letter = $_POST['letter'];
                        
                        $sql = "SELECT `id`, `name`, `description`, `rating` FROM `movie` WHERE `name` LIKE '".$letter."%'";
                    }
                }
                else if ($radio == 'rating'){
                    
                    if (isset($_POST['rating']) && is_numeric($_POST['rating'])){
                        
                        $rating = $_POST['rating'];
                        
                        $sql = "SELECT `id`, `name`, `description`, `rating` FROM `movie` WHERE `rating` = ".$rating;
                    }
                }
            }
        }
        else{
            $sql = "SELECT `id`, `name`, `description`, `rating` FROM `movie`";
        }
        return $sql;        
    }    
    
    
    public function printMovie($sql, $delete = false) {
        // Checking whether SELECT succeeded
        $result = $this->mysqli->query($sql);

        if ($result != FALSE) {

            // Print data
            echo '<div class="container">
                <h3>Movies":</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>description</th>
                        <th>rating</th>';
            if ($delete) {
                echo    '<th>DELETE</th>';
            }    
            echo    '</tr>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td>' . $row["id"] . '</td>
                            <td>' . $row["name"] . '</td>
                            <td>' . $row["description"] . '</td>
                            <td>' . $row["rating"] . '</td>';
                    if ($delete) {
                        echo '<td><a href="tab_movie_add_delete.php?table=movie&id='. $row["id"] . '">delete</a></td>';
                    }                
                }
                echo     '</tr>
                </table><div>';
        } 
        else {
            echo '<br><br>Error<br>';
        }
    }
}
