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
                    <input type="text" name="seance_date" placeholder="rrrr-mm-dd"><br>
                    <label>Time</label><br>
                    <input type="text" name="seance_time" placeholder="hh:mm"><br>

                    <br>
                    <button type="submit" name="submit" value="add">Add</button>
                </div>
            </form>
        </div>
        
        <?php 
            $connection->INSERT_INTO_seance();
            $connection->DELETE_fromTable();
            
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
                ON seance.cinema_id = cinema.id";
            
            $connection->printSeance($sql, true);
        ?>
        
    </body>
</html>
<?php 
    // Destruction of the connection:
    $connection->close();
    $connection = null; 
?>