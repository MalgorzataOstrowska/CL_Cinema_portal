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
    <form class="payment_form" method="post" action="#">
        <label>Payment type</label><br>
        <select name="payment_type">
            <option value="transfer">Transfer</option>
            <option value="cash">Cash</option>
            <option value="card">Card</option>
        </select><br>
        <label>Date</label><br>
        <input type="date" name="payment_date"><br>
        <button type="submit" name="submit" value="payment">Wyślij</button>
    </form>
</div>

    
    
    <?php 
        INSERT_INTO_payment($connection);
        DELETE_fromTable($connection);
        $sql = "SELECT `id`, `date`, `type` FROM `payment`";
        printPayment($connection, $sql);     
    ?>
</body>

<?php 
    // Destruction of the connection:
    $connection->close();
    $connection = null; 
?>