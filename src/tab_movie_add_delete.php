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
    <form class="movie_form" method="post" action="#">
        <label>Name</label><br>
        <input name="name" type="text" maxlength="255" value=""/><br>
        <label>Description</label><br>
        <input name="description" type="text" maxlength="255" value=""/><br>
        <label>Rating</label><br>
        <input name="rating" type="float" min="0.0" max="10.0"/><br>
        <button type="submit" name="submit" value="movie">Add</button>
    </form>
</div>
    
    
    <?php 
        INSERT_INTO_movie($connection);
        DELETE_fromTable($connection);
        $sql = "SELECT `id`, `name`, `description`, `rating` FROM `movie`";
        printMovie($connection, $sql);     
    ?>
</body>

<?php 
    // Destruction of the connection:
    $connection->close();
    $connection = null; 
?>