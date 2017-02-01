<?php

    include_once 'library.php';    
    // Creation of a new connection:
    $connection = new ConnectionToDatabase();
    
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
            <form class="cinema_form" method="post" action="#">

                <?php
                    $connection->selectSeance();
                ?>

                <br><br>
                    <h3>Ticket:</h3>
                    <label>Quantity</label><br>
                    <input name="quantity" type="number" min="0"/><br>
                    <label>Price</label><br>
                    <input name="price" type="number" min="0" step="0.01"/>
                    <br><br>
                    
                    <label>Payment type</label><br>
                    <select name="payment_type">
                        <option value="none">None</option>
                        <option value="transfer">Transfer</option>
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                    </select><br>
                    <label>Date</label><br>
                    <input type="date" name="payment_date"><br>
                    <br>
                    <button type="submit" name="submit" value="buy">Buy</button>
                </div>
            </form>
        </div>

        <?php 
        $connection->INSERT_INTO_ticket(); 
        ?>
    </body>
</html>

<?php 
    // Destruction of the connection:
    $connection->close();
    $connection = null; 
?>