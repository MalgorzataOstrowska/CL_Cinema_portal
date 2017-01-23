<?php

/**
 * printPayment
 * @param mysqli $connection
 */
function printPayment(mysqli $connection, $sql) {
    // Checking whether SELECT succeeded
    $result = $connection->query($sql);

    if ($result != FALSE) {
        // Print data
        echo '<div class="container">
            <h3>Payments:</h3>
            <table class="table table-bordered">
                <tr>
                    <th>id</th>
                    <th>date</th>
                    <th>type</th>
                    <th>DELETE</th>
                 </tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row["id"] . '</td>
                        <td>' . $row["date"] . '</td>
                        <td>' . $row["type"] . '</td>
                        <td><a href="tab_payment_add_delete.php?table=payment&id='. $row["id"] . '">delete</a></td>';
            }
            echo     '</tr>
            </table></div>';            
    } 
    else {
        echo '<br><br>Error<br>';
    }
}