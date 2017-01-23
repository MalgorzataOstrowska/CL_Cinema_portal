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
                    $sql = "SELECT `id`, `name`, `address` FROM `cinema`";
                }
                else if ($radio == 'letter'){
                    
                    if (isset($_POST['letter'])){
                        
                        $letter = $_POST['letter'];
                        
                        $sql = "SELECT `id`, `name`, `address` FROM `cinema` WHERE `name` LIKE '".$letter."%'";
                    }
                }
                
                printCinema($connection, $sql); 
            }
        }
    }
       
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Cinema</title>
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
         <a class="navbar-brand" href="../Cinema.php">Cinema</a>
       </div>
       <ul class="nav navbar-nav">
           <li class="active"><a href="../Cinema.php">Home</a></li>
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

            <div class="row" class="radio">
                <div class="col-sm-2">
                    <label><input type="radio" name="radio" value="all" checked>  All</label>
            
                </div>
            </div>
            <div  class="row" class="radio">
                <div class="col-sm-2">
                    <label><input type="radio" name="radio" value="letter" >  Starting with letter</label>
                </div>    
                <div class="col-sm-2">
                    <input type="text" id="letter" name="letter" >
                </div>    
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