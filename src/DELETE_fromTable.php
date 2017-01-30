<?php

function DELETE_fromTable($connection) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        //echo 'GET';
        if (isset($_GET['id']) && isset($_GET['table']) ) {
            $id = $_GET['id'];
            $table = $_GET['table'];
            
            $sql = 'DELETE FROM ' . $table . ' WHERE `id` =' . $id;
            
            // Checking whether DELETE succeeded
            $result = $connection->query($sql);
            
            if ($result == FALSE){
                echo '<br><br>Error<br>';
            }
            else{
                $numberOfRows = $connection->affected_rows;
                echo '<br><br>Success<br> Number of deleted rows: ' . $numberOfRows . '<br><br>';
            }            
        }
    }
}  