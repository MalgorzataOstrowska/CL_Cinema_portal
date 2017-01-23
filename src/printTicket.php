<?php

/**
 * printTicket
 * @param mysqli $connection
 */
function printTicket(mysqli $connection, $sql) {
    // Checking whether SELECT succeeded
    $result = $connection->query($sql);

    if ($result != FALSE) {
        // Print data
        echo '<div class="container">
            <h3>Tickets:</h3>
            <table class="table table-bordered">
                <tr>
                    <th>id</th>
                    <th>quantity</th>
                    <th>price</th>
                    <th>DELETE</th>
                 </tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row["id"] . '</td>
                        <td>' . $row["quantity"] . '</td>
                        <td>' . $row["price"] . '</td>
                        <td><a href="tab_ticket_add_delete.php?table=ticket&id='. $row["id"] . '">delete</a></td>';
            }
            echo     '</tr>
            </table></div>';            
    } 
    else {
        echo '<br><br>Error<br>';
    }
}