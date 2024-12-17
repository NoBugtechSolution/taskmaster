<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "DB_connection.php";
    include "app/Model/Bug.php";

    // Fetch all bugs
    $bugs = get_all_bugs($conn);
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Bugs List</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css?v=<?php echo time();?>">
    </head>

    <body>
        <input type="checkbox" id="checkbox">
        <?php include "inc/header.php" ?>
        <div class="body">
            <?php include "inc/nav.php" ?>
            <section class="section-1">
                <h4 class="title">Bug Reports</h4>

                <!-- Create Bug Button -->
                <div class="create-bug-btn">
                    <a href="report_bug.php" class="create-btn">Create New Bug</a>
                </div>

                <?php if (isset($_GET['success'])) { ?>
                    <div class="success" role="alert">
                        <?php echo stripcslashes($_GET['success']); ?>
                    </div>
                <?php } ?>
                <?php if ($bugs != 0) { ?>
                    <table class="main-table">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Reported Date</th>
                            <th>Actions</th>
                        </tr>
                        <?php $i = 0;
                        foreach ($bugs as $bug) { ?>
                            <tr>
                                <td><?= ++$i ?></td>
                                <td><?= $bug['bug_title'] ?></td>
                                <td><?= $bug['bug_description'] ?></td>
                                <td><?= $bug['bug_status'] ?></td>
                                <td><?= $bug['reported_date'] ?></td>
                                <td>
                                    <a href="edit_bug.php?id=<?= $bug['bug_id'] ?>" class="edit-btn">Edit</a>
                                    <a href="delete_bug.php?id=<?= $bug['bug_id'] ?>" class="delete-btn">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <h3>No bugs reported yet</h3>
                <?php } ?>
            </section>
        </div>
        <style>
            .create-bug-btn {
                margin: 20px 0;
                text-align: right;
            }

            .create-btn {
                background-color: #4CAF50;
                /* Green */
                color: white;
                padding: 10px 20px;
                text-decoration: none;
                border-radius: 5px;
            }

            .create-btn:hover {
                background-color: #45a049;
            }
        </style>
        <script type="text/javascript">
            var active = document.querySelector("#navList li:nth-child(3)"); // Adjust active navigation link
            active.classList.add("active");
        </script>

    </body>

    </html>
<?php } else {
    $em = "First login";
    header("Location: login.php?error=$em");
    exit();
} ?>