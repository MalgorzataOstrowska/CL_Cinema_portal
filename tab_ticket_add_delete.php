<?php

    include_once 'library.php';    
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
  <title>Cinema</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <?php include "src/navbar.html"; ?>


<div class="container">
    <form class="ticket_form" method="post" action="#">
        <label>Quantity</label><br>
        <input name="quantity" type="number" min="0"/><br>
        <label>Price</label><br>
        <input name="price" type="number" min="0" step="0.01"/><br>
        <button type="submit" name="submit" value="ticket">Add</button>
    </form>
</div>
    
    
    <?php 
        INSERT_INTO_ticket($connection);
        DELETE_fromTable($connection);
        $sql = "SELECT `id`, `quantity`, `price` FROM `ticket`";
        printTicket($connection, $sql);     
    ?>
</body>

<?php 
    // Destruction of the connection:
    $connection->close();
    $connection = null; 
?>