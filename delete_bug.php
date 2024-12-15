<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "DB_connection.php";

    if (isset($_GET['id'])) {
        $bug_id = $_GET['id'];

        // Delete the bug from the database
        $query = "DELETE FROM bug_reports WHERE bug_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$bug_id]);

        header("Location: bugs.php?success=Bug deleted successfully");
        exit();
    } else {
        echo "No bug ID specified";
        exit();
    }
} else {
    $em = "First login";
    header("Location: login.php?error=$em");
    exit();
}
