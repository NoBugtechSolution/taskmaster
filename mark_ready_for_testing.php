<?php
session_start();

// Include the database connection
include "DB_connection.php";

if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "employee") {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get form data
        $title = $_POST['title'];
        $description = $_POST['description'];
        $test_status = $_POST['status']; // Default to 'testing'

        // SQL query to insert the data into the ready_for_testing table
        $sql = "INSERT INTO ready_for_testing (title, description, test_status) 
                VALUES (:title, :description, :test_status)";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the parameters to the statement
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':test_status', $test_status, PDO::PARAM_STR);

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: tasks.php?success=Task marked as Ready for Testing.");
            exit();
        } else {
            header("Location: tasks.php?error=Failed to execute the query.");
            exit();
        }
    }
} else {
    $em = "First login";
    header("Location: login.php?error=$em");
    exit();
}
