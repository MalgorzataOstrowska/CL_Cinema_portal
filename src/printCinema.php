<?php

/******************************************************************************/  
/**
 * printCinema
 * @param mysqli $connection
 */
function printCinema(mysqli $connection, $sql) {

    // Checking whether SELECT succeeded
    $result = $connection->query($sql);

    if ($result != FALSE) {
        // Print data
        echo '<div class="container">
            <br><h3>Cinemas:</h3>
            <table class="table table-bordered">
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>address</th>
                    <th>DELETE</th>
                 </tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row["id"] . '</td>
                        <td>' . $row["name"] . '</td>
                        <td>' . $row["address"] . '</td>
                        <td><a href="tab_cinema_add_delete.php?table=cinema&id='. $row["id"] . '">delete</a></td>';
            }
            echo     '</tr>
            </table></div>';            
    } 
    else {
        echo '<br><br>Error<br>';
    }
}