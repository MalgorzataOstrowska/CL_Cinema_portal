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
            <form method="post" action="#">

                <input  type="hidden" name="seance_id" 
                        value="<?php 
                                     isset($_GET['id']) ? $seance_id = $_GET['id']
                                                        : $seance_id = -1;
                                ?>" 
                />
        
            <?php
                echo '<h3>Buy a ticket for the seance:</h3>';

                if ($seance_id==-1) {
                    $connection->selectSeance();
                }
                else{
                    $sql = 'SELECT 
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
                    WHERE seance.`id` = ' . $seance_id;

                    $connection->printSeance($sql);
                }
            ?>  
        
            <form class="cinema_form" method="post" action="#">       
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
                <input type="text" name="payment_date" placeholder="rrrr-mm-dd"><br>
                <br>
                <button type="submit" name="submit" value="buy">Buy</button>
            </form>
        </div>

        <?php 
            $connection->INSERT_INTO_ticket($seance_id); 
        ?>
    </body>
</html>

<?php 
    // Destruction of the connection:
    $connection->close();
    $connection = null; 
?>