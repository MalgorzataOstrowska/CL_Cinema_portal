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

            if (isset($_GET['id']) && isset($_GET['table']) ) {
                $id = $_GET['id'];
                $table = $_GET['table'];

                echo $sql = 'DELETE FROM ' . $table . ' WHERE `id` =' . $id;

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
    public function printCinema($sql, $delete = false, $seance = false) {

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
            if ($seance) {
                echo    '<th>SEANCE</th>';
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
                if ($seance) {
                    echo '<td><a href="tab_seance_show.php?table=cinema&id='. $row["id"] . '">seance</a></td>';
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
    public function INSERT_INTO_payment($ticket_id) {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            if (isset($_POST['payment_type'])     && 
                isset($_POST['payment_date'])        ){

                $payment_type = $_POST['payment_type'];
                $payment_date = $_POST['payment_date'];


                if (!empty($payment_type)) {
                    if ($payment_type == 'transfer' ||
                            $payment_type == 'cash' ||
                            $payment_type == 'card') {

                        if (empty($payment_date)) {

                            echo 'Payment date: present date was used - ';
                            echo $payment_date = date("d.m.Y");
                        }
                        $sql = "INSERT INTO `payment` (`id`, `date`, `type`, `ticket_id`) VALUES (NULL,'$payment_date', '$payment_type', '$ticket_id')";

                        if ($this->mysqli->query($sql) === TRUE) {
                            echo '<br><br>New payment added<br><br>';
                        } 
                        else {
                            echo("<br><br>Error: <br>" . $sql . "<br>" . $this->mysqli->error);
                        }                        
                        
                    }
                    else if($payment_type == 'none'){
                        die('<br>Payment type: none');
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
                            $ticket_id = $this->mysqli->insert_id;
                            $this->printBoughtTicket($ticket_id);
                            $this->INSERT_INTO_payment($ticket_id);                            
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
                    $sql = "SELECT ticket.`id`, ticket.`quantity`, ticket.`price`, payment.`type` FROM `ticket` LEFT JOIN `payment` ON ticket.id=payment.ticket_id";
                }
                
                else if ($radio == 'none') {
                    $sql  = 'SELECT ticket.`id`, ticket.`quantity`, ticket.`price`, payment.`type` FROM `ticket` LEFT JOIN `payment` ON ticket.id=payment.ticket_id '
                            . 'WHERE payment.`type` IS NULL';

                }
                
                else if ($radio == 'transfer') {
                    $sql = "SELECT ticket.`id`, ticket.`quantity`, ticket.`price`, payment.`type` FROM `ticket` LEFT JOIN `payment` ON ticket.id=payment.ticket_id "
                            . "WHERE payment.`type` LIKE 'transfer'";
                }
                
                else if ($radio == 'cash') {
                    $sql = "SELECT ticket.`id`, ticket.`quantity`, ticket.`price`, payment.`type` FROM `ticket` LEFT JOIN `payment` ON ticket.id=payment.ticket_id "
                            . "WHERE payment.`type` LIKE 'cash'";
                }
                
                else if ($radio == 'card') {
                    $sql = "SELECT ticket.`id`, ticket.`quantity`, ticket.`price`, payment.`type` FROM `ticket` LEFT JOIN `payment` ON ticket.id=payment.ticket_id "
                            . "WHERE payment.`type` LIKE 'card'";
                }
            }
            
        }
        else{
            $sql = "SELECT ticket.`id`, ticket.`quantity`, ticket.`price`, payment.`type` FROM `ticket` LEFT JOIN `payment` ON ticket.id=payment.ticket_id";
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
                        <th>price</th>
                        <th>payment type</th>';
                if ($delete) {
                    echo    '<th>DELETE</th>';
                }    
                echo    '</tr>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td>' . $row["id"] . '</td>
                            <td>' . $row["quantity"] . '</td>
                            <td>' . $row["price"] . '</td>
                            <td>' . $row["type"] . '</td>';
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
    
    public function printBoughtTicket($ticket_id) {
        // Checking whether SELECT succeeded
        //echo $sql = "SELECT * FROM `ticket` WHERE `id`='$ticket_id'";
        $sql = "SELECT
                ticket.seance_id,
                movie.name AS movie,
                cinema.name AS cinema,
                ticket.price
                FROM `ticket`
                LEFT JOIN seance
                ON ticket.seance_id = seance.id
                LEFT JOIN movie
                ON seance.movie_id = movie.id
                LEFT JOIN cinema
                ON seance.cinema_id = cinema.id
                WHERE ticket.id='$ticket_id'";
        
        $result = $this->mysqli->query($sql);

        if ($result != FALSE) {
            // Print data
            echo '<div class="container">
                <h3>Informations about bought ticket:</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>seance id</th>
                        <th>movie</th>
                        <th>cinema</th>
                        <th>price</th>    
                        </tr>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td>' . $row["seance_id"] . '</td>
                            <td>' . $row["movie"] . '</td>
                            <td>' . $row["cinema"] . '</td>
                            <td>' . $row["price"] . '</td>';
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

    /**
     * selectCinema
     */
    public function selectCinema(){
        $sql  = 'SELECT `id`, `name`, `address` FROM `cinema`';
        
        // Checking whether SELECT succeeded
        $result = $this->mysqli->query($sql);

        if ($result != FALSE) {

            // Print data
            echo '<div class="container">
                <h3>Cinema:</h3>
                <select name="cinema_id">';

            while($row = $result->fetch_assoc()) {

                    echo '<option value="'.$row["id"].'">' . $row["id"]. ' - ' .$row["name"].'</option>';

            }
            echo '</select></div>';
        }

        else {
            echo("<br><br>Error: <br>");
        }        
    }

    /**
     * selectMovie
     */
    public function selectMovie(){
        $sql  = 'SELECT `id`, `name`, `description`, `rating` FROM `movie`';
        
        // Checking whether SELECT succeeded
        $result = $this->mysqli->query($sql);

        if ($result != FALSE) {

            // Print data
            echo '<div class="container">
                <h3>Movie:</h3>
                <select name="movie_id">';

            while($row = $result->fetch_assoc()) {

                    echo '<option value="'.$row["id"].'">' . $row["id"]. ' - ' .$row["name"].'</option>';

            }
            echo '</select></div>';
        }

        else {
            echo("<br><br>Error: <br>");
        }        
    } 

    /**
     * INSERT_INTO_seance
     */
    public function INSERT_INTO_seance() {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            if (isset($_POST['seance_date'])    &&
                isset($_POST['seance_time'])    && 
                isset($_POST['cinema_id'])         &&
                isset($_POST['movie_id'])        ){

                $seance_date = $_POST['seance_date'];
                $seance_time = $_POST['seance_time'];
                $cinema_id = $_POST['cinema_id'];
                $movie_id = $_POST['movie_id'];

                if (!empty($cinema_id) && !empty($movie_id)) {
                    if (empty($seance_date)) {

                        echo 'Seance date: present date was used - ';
                        echo $seance_date = date("Y.m.d");
                    }
                    
                    if (empty($seance_time)) {

                        echo '<br>Seance time: 18:00 was used';
                        $seance_time = '18:00:00';
                    }

                    $sql = "INSERT INTO `seance` 
                            (`id`, `date`, `time`, `movie_id`, `cinema_id`) 
                            VALUES (NULL, '$seance_date', '$seance_time', $movie_id, $cinema_id);";
                    if ($this->mysqli->query($sql) === TRUE) {
                        echo '<br><br>New seance added<br><br>';
                    } 
                    else {
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
     * printSeance
     * @param bool $delete
     */
    public function printSeance($sql, $delete = false) {

        // Checking whether SELECT succeeded
        $result = $this->mysqli->query($sql);

        if ($result != FALSE) {
            // Print data
            echo '<div class="container">
                <table class="table table-bordered">
                    <tr>
                        <th>id</th>
                        <th>date</th>
                        <th>time</th>
                        <th>movie</th>
                        <th>cinema</th>';
                if ($delete) {
                    echo    '<th>DELETE</th>';
                }    
                echo    '</tr>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td>' . $row["id"] . '</td>
                            <td>' . $row["date"] . '</td>
                            <td>' . date('H:i', strtotime($row["time"])) . '</td>
                            <td>' . $row["movie"] . '</td>
                            <td>' . $row["cinema"] . '</td>';
                    if ($delete) {                     
                        echo '<td><a href="tab_seance_add_delete.php?table=seance&id='. $row["id"] . '">delete</a></td>';
                    }
                }
                echo     '</tr>
                </table></div>';            
        } 
        else {
            echo '<br><br>Error<br>';
        }
    }      

    /**
     * SELECT_FROM_seance_in_cinema
     */
    public function SELECT_FROM_seance_in_cinema() {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            if ($_POST['submit'] == 'showInCinema'       &&
                isset($_POST['cinema_id'])        ){

                $cinema_id = $_POST['cinema_id'];
                
                $sql = "SELECT 
                    seance.`id`,
                    seance.date,
                    seance.time,
                    movie.name as movie,
                    cinema.name AS cinema
                    FROM `seance` 
                    LEFT JOIN movie
                    ON seance.movie_id = movie.id
                    LEFT JOIN cinema
                    ON seance.cinema_id = cinema.id
                    WHERE cinema.id = $cinema_id";

                    $this->callPrintSeanceInCinema($sql,$cinema_id);                

            }
        }
    }
    
    /**
     * SELECT_FROM_seance_in_cinema_GET
     */
    public function SELECT_FROM_seance_in_cinema_GET() {
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            if (isset($_GET['id']) && isset($_GET['table']) ) {
                
                $table = $_GET['table'];
                
                if ($table == 'cinema') {
                    
                    $cinema_id = $_GET['id'];
                    $sql = "SELECT 
                    seance.`id`,
                    seance.date,
                    seance.time,
                    movie.name as movie,
                    cinema.name AS cinema
                    FROM `seance` 
                    LEFT JOIN movie
                    ON seance.movie_id = movie.id
                    LEFT JOIN cinema
                    ON seance.cinema_id = cinema.id
                    WHERE cinema.id = $cinema_id";
                    
                    $this->callPrintSeanceInCinema($sql,$cinema_id);
                }        
            }
        }
    }
    
    /**
     * callPrintSeanceInCinema
     * @param string $sql
     * @param int $cinema_id
     */
    private function callPrintSeanceInCinema($sql, $cinema_id){
        // Checking whether SELECT succeeded
        $result = $this->mysqli->query($sql);

        if ($result != FALSE) {
            $row = $result->fetch_assoc();
            $cinema = $row["cinema"];
            if ($cinema) {
                echo '<br><h3>Seances in cinema ' . $cinema . ':</h3>';
                $this->printSeance($sql);
            }
            else{
                $sql = 'SELECT * FROM `cinema` WHERE `id` ='. $cinema_id;
                // Checking whether SELECT succeeded
                $result = $this->mysqli->query($sql);
                $row = $result->fetch_assoc();
                $cinema = $row["name"];

                echo '<br><h3>No seances in cinema ' . $cinema . '</h3>';
            }
        } 
        else {
            echo '<br><br>Error<br>';
        }          
    }

    /**
    * SELECT_FROM_seance_in_movie
    */
    public function SELECT_FROM_seance_in_movie() {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            if ($_POST['submit'] == 'showInMovie'       &&
                isset($_POST['movie_id'])        ){

                $movie_id = $_POST['movie_id'];
                
                $sql = "SELECT 
                    seance.`id`,
                    seance.date,
                    seance.time,
                    movie.name as movie,
                    cinema.name AS cinema
                    FROM `seance` 
                    LEFT JOIN movie
                    ON seance.movie_id = movie.id
                    LEFT JOIN cinema
                    ON seance.cinema_id = cinema.id
                    WHERE movie.id = $movie_id";

                $this->printSeance($sql);
                    
            }
        }
    }    
    
}
