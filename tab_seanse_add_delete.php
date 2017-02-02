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
                    $connection->selectCinema();
                    $connection->selectMovie();

                ?>

                <br><br>
                <div class="container">
                    <label>Date</label><br>
                    <input type="date" name="seance_date"><br>
                    <label>Time</label><br>
                    <input type="time" name="seance_time"><br>

                    <br>
                    <button type="submit" name="submit" value="add">Add</button>
                </div>
            </form>
        </div>

    </body>
</html>
<?php 
    // Destruction of the connection:
    $connection->close();
    $connection = null; 
?>