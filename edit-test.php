<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";

    // Get the test ID from the URL
    if (!isset($_GET['id'])) {
        header("Location: test_management.php");
        exit();
    }

    $test_id = $_GET['id'];
    $test = get_ready_for_testing_by_id($conn, $test_id);

    if ($test == 0) {
        header("Location: test_management.php");
        exit();
    }

    // Handle form submission for updating test status
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $test_status = $_POST['test_status'];

        // Update the test status in the database
        update_test_status($conn, $test_id, $test_status);

        header("Location: test_management.php?success=Test status updated successfully");
        exit();
    }

    // Handle delete request
    if (isset($_GET['delete'])) {
        delete_test($conn, $test_id);
        header("Location: test_management.php?success=Test deleted successfully");
        exit();
    }

?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Edit Test</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css?v=<?php echo time();?>">
    </head>

    <body>
        <input type="checkbox" id="checkbox">
        <?php include "inc/header.php" ?>
        <div class="body">
            <?php include "inc/nav.php" ?>
            <section class="section-1">
                <h4 class="title">Edit Test</h4>
                <form method="POST" action="">
                    <div class="input-holder">
                        <p><b>Title: </b><?= $test['title'] ?></p>
                    </div>
                    <div class="input-holder">
                        <p><b>Description: </b><?= $test['description'] ?></p>
                    </div>
                    <div class="input-holder">
                        <label for="test_status">Test Status:</label>
                        <select name="test_status" class="input-1">
                            <option <?php if ($test['test_status'] == "Developed") echo "selected"; ?>>Developed</option>
                            <option <?php if ($test['test_status'] == "testing") echo "selected"; ?>>testing</option>
                            <option <?php if ($test['test_status'] == "Bug") echo "selected"; ?>>Bug</option>
                            <option <?php if ($test['test_status'] == "Passed") echo "selected"; ?>>Passed</option>
                        </select><br>
                    </div>
                    <button type="submit" class="edit-btn">Update Status</button>
                </form>

                <a href="edit-test.php?id=<?= $test['id'] ?>&delete=true" class="delete-btn" onclick="return confirm('Are you sure you want to delete this test?');">Delete Test</a>
            </section>
        </div>

        <script type="text/javascript">
            var active = document.querySelector("#navList li:nth-child(2)");
            active.classList.add("active");
        </script>
        <style>
            /* Example button styles */
            .edit-btn {
                background-color: #4CAF50;
                color: white;
                padding: 10px 15px;
                text-decoration: none;
                border-radius: 5px;
                margin-right: 10px;
            }

            .delete-btn {
                background-color: #f44336;
                color: white;
                padding: 10px 15px;
                text-decoration: none;
                border-radius: 5px;
            }
        </style>
    </body>

    </html>

<?php
} else {
    $em = "First login";
    header("Location: login.php?error=$em");
    exit();
}
?>