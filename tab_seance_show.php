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
                <h3>Show seances:</h3>
                <div class="row">
                    <div class="col-sm-6">
                        <?php
                            $connection->selectCinema();
                        ?>

                        <div class="container">
                            <br>
                            <button type="submit" name="submit" value="showInCinema">Show</button>
                        </div>
                    </div>

                    <div class="col-sm-6">               
                        <?php
                            $connection->selectMovie();
                        ?>
                        <div class="container">
                            <br>
                            <button type="submit" name="submit" value="showInMovie">Show</button>
                        </div>

               
                    </div>
                </div>
                
            </form>
            
            <?php 
                $connection->SELECT_FROM_seance_in_cinema();
                $connection->SELECT_FROM_seance_in_movie();
                $connection->SELECT_FROM_seance_in_cinema_GET();
            ?> 
        </div>
        
     


    </body>

</html>

<?php 
    // Destruction of the connection:
    $connection->close();
    $connection = null; 
?>