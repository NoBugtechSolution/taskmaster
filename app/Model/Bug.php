
<?php
// DB_connection.php or Bug.php

function get_all_bugs($conn)
{
    // Prepare the SQL query to fetch all bugs
    $query = "SELECT * FROM bug_reports ORDER BY reported_date DESC"; // You can modify this query as needed
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Fetch all the rows and return them
    $bugs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // If there are no bugs, return an empty array
    return $bugs ?: [];
}
