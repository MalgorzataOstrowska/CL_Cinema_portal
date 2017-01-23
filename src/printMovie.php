<?php

/**
 * printMovie
 * @param mysqli $connection
 */    
function printMovie(mysqli $connection, $sql) {
    // Checking whether SELECT succeeded
    $result = $connection->query($sql);

    if ($result != FALSE) {

        // Print data
        echo '<div class="container">
            <h3>Movies":</h3>
            <table class="table table-bordered">
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>description</th>
                    <th>rating</th>
                    <th>DELETE</th>
                 </tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row["id"] . '</td>
                        <td>' . $row["name"] . '</td>
                        <td>' . $row["description"] . '</td>
                        <td>' . $row["rating"] . '</td>
                        <td><a href="tab_movie_add_delete.php?table=movie&id='. $row["id"] . '">delete</a></td>';
            }
            echo     '</tr>
            </table><div>';
    } 
    else {
        echo '<br><br>Error<br>';
    }
}