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

    private $mysqli;
    
    /**
     * Constructor
     */
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
        
        $this->mysqli->set_charset("utf8");
        
    }

    /**
     * query
     * @param string $sql
     * @return bool
     */
    public function query($sql){
        $result = $this->mysqli->query($sql);
        if ($result == false) {
            die(sprintf("SQL: %s, Error: %s", $sql, $this->mysqli->error));
        }
        return $this->lastResult = $result;
        
    }    
    
    /**
     * close
     * @return bool
     */
    public function close(){
         $this->mysqli->close();
    }

    /**
     * DELETE_fromTable
     */
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
    /**
     * INSERT_INTO_cinema
     */
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
    
    /**
     * dataFromPOST_cinema
     * @return string
     */
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
    
    /**
     * printCinema
     * @param string $sql
     * @param bool $delete
     */
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
    /**
     * INSERT_INTO_movie
     */
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

    /**
     * dataFromPOST_movie
     * @return string
     */
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
                    else{
                        $sql = "SELECT * FROM `movie` WHERE 0";
                    }
                }
            }
        }
        else{
            $sql = "SELECT `id`, `name`, `description`, `rating` FROM `movie`";
        }
        return $sql;        
    }    
    
    /**
     * printMovie
     * @param string $sql
     * @param bool $delete
     */
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
    
    
/********************************************************************************************************************/
    /**
     * INSERT_INTO_payment
     */
    public function INSERT_INTO_payment() {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            if (isset($_POST['payment_type'])     && 
                isset($_POST['payment_date'])        ){

                $payment_type = $_POST['payment_type'];
                $payment_date = $_POST['payment_date'];


                if (!empty($payment_type) && !empty($payment_date)) {
                    if ($payment_type == 'transfer' ||
                            $payment_type == 'cash' ||
                            $payment_type == 'card') {

                        $sql = "INSERT INTO `payment` (`date`, `type`) VALUES ('$payment_date', '$payment_type')";

                        if ($this->mysqli->query($sql) === TRUE) {
                            echo '<br><br>New payment added<br><br>';
                        } 
                    else {
                            echo("<br><br>Error: <br>" . $sql . "<br>" . $this->mysqli->error);
                        }
                    } 
                    else {
                        die('<br>ERROR: Bad payment type');
                    }
                }
                else{
                    echo 'Incomplete data';
                }              
            }
        }
    }  
    
    /**
     * dataFromPOST_payment
     * @return string
     */
    public function dataFromPOST_payment() {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            if (isset($_POST['radio'])){

                $radio = $_POST['radio'];
                
                if ($radio == 'all') {
                    $sql = "SELECT `id`, `date`, `type` FROM `payment`";
                }
                else if ($radio == 'date'){
                    
                    if (isset($_POST['date'])){
                        
                        $date = $_POST['date'];
                        $sql = "SELECT `id`, `date`, `type` FROM `payment` WHERE `date` LIKE '".$date."'";

                    }
                }
                else if ($radio == 'before'){

                    if (isset($_POST['before'])){
                        
                        $before = $_POST['before'];
                        $sql = "SELECT `id`, `date`, `type` FROM `payment` WHERE `date` < '".$before."'";

                    }
                }
                
                else if ($radio == 'after'){
                    
                    if (isset($_POST['after'])){
                        
                        $after = $_POST['after'];
                        $sql = "SELECT `id`, `date`, `type` FROM `payment` WHERE `date` > '".$after."'";

                    }
                }
                
                else if ($radio == 'between'){

                    if (isset($_POST['after_between']) && isset($_POST['before_between'])){
                        
                        $after = $_POST['after_between'];
                        $before = $_POST['before_between'];
                        $sql = "SELECT `id`, `date`, `type` FROM `payment` WHERE `date` BETWEEN '".$after."' AND '" . $before . "'";
                    }
                }
            }
        }
        else{
            $sql = "SELECT `id`, `date`, `type` FROM `payment`";
        }
        return $sql;        
    }  

    /**
     * 
     * @param string $sql
     * @param bool $delete
     */
    public function printPayment($sql, $delete = false) {
        // Checking whether SELECT succeeded
        $result = $this->mysqli->query($sql);

        if ($result != FALSE) {
            // Print data
            echo '<div class="container">
                <h3>Payments:</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>id</th>
                        <th>date</th>
                        <th>type</th>';
            if ($delete) {
                echo    '<th>DELETE</th>';
            }    
            echo    '</tr>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td>' . $row["id"] . '</td>
                            <td>' . $row["date"] . '</td>
                            <td>' . $row["type"] . '</td>';
                    if ($delete) {                    
                        echo '<td><a href="tab_payment_add_delete.php?table=payment&id='. $row["id"] . '">delete</a></td>';
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
    /**
     * INSERT_INTO_ticket
     */
    public function INSERT_INTO_ticket() {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            if (isset($_POST['seance'])       &&
                isset($_POST['quantity'])     && 
                isset($_POST['price'])        ){

                $seance = $_POST['seance'];
                $price = $_POST['price'];
                $quantity = $_POST['quantity'];

                if (!empty($seance) && !empty($price) && !empty($quantity)) {
                    if ($price > 0) {

                        $sql = "INSERT INTO `ticket` (`id`, `quantity`, `price`, `seance_id`) VALUES (NULL, '$quantity', '$price', '$seance')";
                        if ($this->mysqli->query($sql) === TRUE) {
                            echo '<br><br>New ticket added<br><br>';
                        } 
                    else {
                            echo("<br><br>Error: <br>" . $sql . "<br>" . $this->mysqli->error);
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

    /**
     * dataFromPOST_ticket
     * @return string
     */
    public function dataFromPOST_ticket() {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            if (isset($_POST['radio'])){

                $radio = $_POST['radio'];
                
                if ($radio == 'all') {
                    $sql = "SELECT `id`, `quantity`, `price` FROM `ticket`";
                }
            }
        }
        else{
            $sql = "SELECT `id`, `quantity`, `price` FROM `ticket`";
        }
        return $sql;        
    } 
    
    /**
     * printTicket
     * @param string $sql
     * @param bool $delete
     */
    public function printTicket($sql, $delete = false) {
        // Checking whether SELECT succeeded
        $result = $this->mysqli->query($sql);

        if ($result != FALSE) {
            // Print data
            echo '<div class="container">
                <h3>Tickets:</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>id</th>
                        <th>quantity</th>
                        <th>price</th>';
                if ($delete) {
                    echo    '<th>DELETE</th>';
                }    
                echo    '</tr>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td>' . $row["id"] . '</td>
                            <td>' . $row["quantity"] . '</td>
                            <td>' . $row["price"] . '</td>';
                    if ($delete) {                     
                        echo '<td><a href="tab_ticket_add_delete.php?table=ticket&id='. $row["id"] . '">delete</a></td>';
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
    /**
     * selectSeance
     */
    public function selectSeance(){
        $sql  = 'SELECT 
                seance.`id`,
                seance.`date`,
                seance.`time`,
                movie.name AS movie,
                cinema.name AS cinema
                FROM `seance` 
                LEFT JOIN movie ON seance.movie_id=movie.id 
                LEFT JOIN cinema ON seance.cinema_id=cinema.id';
        
        // Checking whether SELECT succeeded
        $result = $this->mysqli->query($sql);

        if ($result != FALSE) {

            // Print data
            echo '<div class="container">
                <h3>Seance:</h3>
                <select name="seance">';

            while($row = $result->fetch_assoc()) {

                    echo '<option value="'.$row["id"].'">id = ' . $row["id"]. ', ' .$row["date"].', '.$row["time"].' - '.$row["movie"].' - '.$row["cinema"].'</option>';

            }
            echo '</select>';
        }

        else {
            echo("<br><br>Error: <br>");
        }        
    }    
}
