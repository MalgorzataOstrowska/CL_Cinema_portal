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

                <div class="row" class="radio">
                    <div class="col-sm-2">
                        <label><input type="radio" name="radio" value="all" checked>  All</label>
                    </div>   
                </div>
                <div class="row" class="radio" >
                    <div class="col-sm-2">
                        <label><input type="radio" name="radio" value="date" id="radio_date" >  Date</label>
                    </div>
                    <div class="col-sm-2">    
                        <input type="text" id="date" name="date" placeholder="rrrr-mm-dd">
                    </div>
                </div>
                <div class="row" class="radio">
                    <div class="col-sm-2">
                        <label><input type="radio" name="radio" value="before" id="radio_before">   Before date</label>
                    </div>    
                    <div class="col-sm-2">
                        <input type="text" id="before" name="before" placeholder="rrrr-mm-dd">
                    </div>
                </div>
                <div class="row" class="radio">
                    <div class="col-sm-2">
                        <label><input type="radio" name="radio" value="after" id="radio_after">  After date</label>
                    </div>            
                    <div class="col-sm-2">     
                        <input type="text" id="after" name="after" placeholder="rrrr-mm-dd">
                    </div>
                </div>
                <div class="row" class="radio">
                    <div class="col-sm-2">
                        <label><input type="radio" name="radio" value="between" id="radio_between">  Between dates</label>
                    </div>
                    <div class="col-sm-2">    
                        <input type="text" id="after_between" name="after_between" placeholder="rrrr-mm-dd">
                    </div>
                    <div class="col-sm-2">    
                        <input type="text" id="before_between" name="before_between" placeholder="rrrr-mm-dd">    
                    </div>
                </div>

                <button type="submit" name="submit" value="cinema">Show</button>
           </form>
        </div>

        <?php 
            $sql = $connection->dataFromPOST_payment();
            $connection->printPayment($sql); 
        ?>
        
    </body>
    <script
    src="https://code.jquery.com/jquery-2.2.4.min.js"
    integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
    crossorigin="anonymous"></script>
    <script src="js/tab_payment_show.js"></script>       
</html>
<?php 
    // Destruction of the connection:
    $connection->close();
    $connection = null; 
?>