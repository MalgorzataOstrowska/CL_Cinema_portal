<?php

    include_once '../library.php';    
    // Creation of a new connection:
    $connection = new mysqli(
        'localhost', 
        'root',
        'coderslab',
        'cinemas_db_branch_master'
        );

    // Checking whether the connection succeeded
    if ($connection->connect_error) {
        die("Connection unsuccessful. Error: " . $connection->connect_error);
    }
    echo("Connection successful.");
    
    function dataFromPOST(mysqli $connection) {
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
                    echo 'before';
                    if (isset($_POST['after'])){
                        
                        $after = $_POST['after'];
                        $sql = "SELECT `id`, `date`, `type` FROM `payment` WHERE `date` > '".$after."'";

                    }
                }
                
                else if ($radio == 'between'){
                    echo 'between';
                    if (isset($_POST['after_between']) && isset($_POST['before_between'])){
                        
                        $after = $_POST['after_between'];
                        $before = $_POST['before_between'];
                        $sql = "SELECT `id`, `date`, `type` FROM `payment` WHERE `date` BETWEEN '".$after."' AND '" . $before . "'";
                    }
                }

                
            printPayment($connection, $sql); 
            }
        }
    }
       
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>MySQL homework</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-inverse">
     <div class="container-fluid">
       <div class="navbar-header">
         <a class="navbar-brand" href="../homework.php">MySQL - DAY 1 - HOMEWORK </a>
       </div>
       <ul class="nav navbar-nav">
           <li class="active"><a href="../homework.php">Home</a></li>
         <li class="dropdown">
           <a class="dropdown-toggle" data-toggle="dropdown" href="#">Add / delete
           <span class="caret"></span></a>
           <ul class="dropdown-menu">
             <li><a href="../src/tab_cinema_add_delete.php">Cinema</a></li>
             <li><a href="../src/tab_movie_add_delete.php">Movie</a></li>
             <li><a href="../src/tab_payment_add_delete.php">Payment</a></li>
             <li><a href="../src/tab_ticket_add_delete.php">Ticket</a></li>
           </ul>
         </li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Show
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../src/tab_cinema_show.php">Cinema</a></li>
            <li><a href="../src/tab_movie_show.php">Movie</a></li>
            <li><a href="../src/tab_payment_show.php">Payment</a></li>
          </ul>
        </li> 
       </ul>
     </div>
   </nav>


    <div class="container">
        <form class="cinema_form" method="post" action="#">

            <div class="radio">
                <label><input type="radio" name="radio" value="all" checked>All</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="radio" value="date" >Date</label>
                <label for="date">Date:</label>
                <input type="text" id="date" name="date" placeholder="rrrr-mm-dd">
            </div>
            <div class="radio">
                <label><input type="radio" name="radio" value="before" >Before date</label>
                <label for="before">Date:</label>
                <input type="text" id="before" name="before" placeholder="rrrr-mm-dd">
            </div>
            <div class="radio">
                <label><input type="radio" name="radio" value="after" >After date</label>
                <label for="after">Date:</label>
                <input type="text" id="after" name="after" placeholder="rrrr-mm-dd">
            </div>
            <div class="radio">
                <label><input type="radio" name="radio" value="between" >Between dates</label>
                
                <label for="after">After:</label>
                <input type="text" id="after" name="after_between" placeholder="rrrr-mm-dd">
                
                <label for="before">Before:</label>
                <input type="text" id="before" name="before_between" placeholder="rrrr-mm-dd">                
            </div>

            
            
           
            <button type="submit" name="submit" value="cinema">Show</button>
       </form>
   </div>
    
    
    <?php 
    
        dataFromPOST($connection);
        
    ?>
</body>

<?php 
    // Destruction of the connection:
    $connection->close();
    $connection = null; 
?>