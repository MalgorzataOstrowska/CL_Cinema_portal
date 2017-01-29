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
    
    function dataFromPOST(mysqli $connection) {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            if (isset($_POST['radio'])){

                $radio = $_POST['radio'];
                
                if ($radio == 'all') {
                    $sql = "SELECT `id`, `date`, `type` FROM `payment`";
                }
                else if ($radio == 'date'){
                    
                    if (isset($_POST['date'])){
                        
                        $date = $_POST['date'];
                        $sql = "SELECT `id`, `date`, `type` FROM `payment` WHERE `date` LIKE '".$date."'";

                    }
                }
                else if ($radio == 'before'){

                    if (isset($_POST['before'])){
                        
                        $before = $_POST['before'];
                        $sql = "SELECT `id`, `date`, `type` FROM `payment` WHERE `date` < '".$before."'";

                    }
                }
                
                else if ($radio == 'after'){
                    echo 'before';
                    if (isset($_POST['after'])){
                        
                        $after = $_POST['after'];
                        $sql = "SELECT `id`, `date`, `type` FROM `payment` WHERE `date` > '".$after."'";

                    }
                }
                
                else if ($radio == 'between'){
                    echo 'between';
                    if (isset($_POST['after_between']) && isset($_POST['before_between'])){
                        
                        $after = $_POST['after_between'];
                        $before = $_POST['before_between'];
                        $sql = "SELECT `id`, `date`, `type` FROM `payment` WHERE `date` BETWEEN '".$after."' AND '" . $before . "'";
                    }
                }

                
            printPayment($connection, $sql); 
            }
        }
    }
       
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
                    <label><input type="radio" name="radio" value="date" >  Date</label>
                </div>
                <div class="col-sm-2">    
                    <input type="text" id="date" name="date" placeholder="rrrr-mm-dd">
                </div>
            </div>
            <div class="row" class="radio">
                <div class="col-sm-2">
                    <label><input type="radio" name="radio" value="before" >   Before date</label>
                </div>    
                <div class="col-sm-2">
                    <input type="text" id="before" name="before" placeholder="rrrr-mm-dd">
                </div>
            </div>
            <div class="row" class="radio">
                <div class="col-sm-2">
                    <label><input type="radio" name="radio" value="after" >  After date</label>
                </div>            
                <div class="col-sm-2">     
                    <input type="text" id="after" name="after" placeholder="rrrr-mm-dd">
                </div>
            </div>
            <div class="row" class="radio">
                <div class="col-sm-2">
                    <label><input type="radio" name="radio" value="between" >  Between dates</label>
                </div>
                <div class="col-sm-2">    
                    <input type="text" id="after" name="after_between" placeholder="rrrr-mm-dd">
                </div>
                <div class="col-sm-2">    
                    <input type="text" id="before" name="before_between" placeholder="rrrr-mm-dd">    
                </div>
            </div>

            
            
           
            <button type="submit" name="submit" value="cinema">Show</button>
       </form>
   </div>
    
    
    <?php 
    
        dataFromPOST($connection);
        
    ?>
</body>

<?php 
    // Destruction of the connection:
    $connection->close();
    $connection = null; 
?>