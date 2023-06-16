<?php

if (isset($_REQUEST['Submit'])) {
    // Get input
    $id = $_REQUEST['id'];

    switch ($_DVWA['SQLI_DB']) {
        case MYSQL:
            // Check database
            $query  = "SELECT first_name, last_name FROM users WHERE user_id = ?";
            $statement = $mysqli->prepare($query);
            $statement->bind_param("s", $id);
            $statement->execute();
            $result = $statement->get_result();

            // Get results
            while ($row = $result->fetch_assoc()) {
                // Get values
                $first = $row["first_name"];
                $last  = $row["last_name"];

                // Feedback for end user
                $html .= "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
            }

            break;
        case SQLITE:
            global $sqlite_db_connection;

            $query  = "SELECT first_name, last_name FROM users WHERE user_id = ?";
            $statement = $sqlite_db_connection->prepare($query);
            $statement->bindValue(1, $id, SQLITE3_TEXT);
            $results = $statement->execute();

            if ($results) {
                while ($row = $results->fetchArray()) {
                    // Get values
                    $first = $row["first_name"];
                    $last  = $row["last_name"];

                    // Feedback for end user
                    $html .= "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
                }
            } else {
                echo "Error in fetch " . $sqlite_db->lastErrorMsg();
            }
            break;
    }
}

?>