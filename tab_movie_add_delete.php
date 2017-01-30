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
        $connection->INSERT_INTO_movie();
        $connection->DELETE_fromTable();
        $sql = "SELECT `id`, `name`, `description`, `rating` FROM `movie`";
        $connection->printMovie($sql, true);     
    ?>
</body>

<?php 
    // Destruction of the connection:
    $connection->close();
    $connection = null; 
?>