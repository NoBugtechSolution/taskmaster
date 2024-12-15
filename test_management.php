<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";

    // Fetch all ready-for-testing records
    $tests = get_all_ready_for_testing($conn);
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Test Management</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">
        <style>
            /* Custom Styles for Status Colors */
            .status {
                padding: 5px 10px;
                border-radius: 5px;
                color: white;
                text-align: center;
                font-weight: bold;
            }

            .status.developed {
                background-color: #007bff;
                /* Blue */
            }

            .status.testing {
                background-color: #ffc107;
                /* Yellow */
            }

            .status.bug {
                background-color: #dc3545;
                /* Red */
            }

            .status.passed {
                background-color: #28a745;
                /* Green */
            }
        </style>
    </head>

    <body>
        <input type="checkbox" id="checkbox">
        <?php include "inc/header.php" ?>
        <div class="body">
            <?php include "inc/nav.php" ?>
            <section class="section-1">
                <h4 class="title">Test Management</h4>
                <?php if (isset($_GET['success'])) { ?>
                    <div class="success" role="alert">
                        <?php echo stripcslashes($_GET['success']); ?>
                    </div>
                <?php } ?>
                <?php if ($tests != 0) { ?>
                    <table class="main-table">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Test Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        <?php $i = 0;
                        foreach ($tests as $test) { ?>
                            <tr>
                                <td><?= ++$i ?></td>
                                <td><?= $test['title'] ?></td>
                                <td><?= $test['description'] ?></td>
                                <td>
                                    <span class="status <?= strtolower($test['test_status']); ?>">
                                        <?= $test['test_status'] ?>
                                    </span>
                                </td>
                                <td><?= $test['created_at'] ?></td>

                                <td>
                                    <a href="edit-test.php?id=<?= $test['id'] ?>" class="edit-btn">Edit</a>
                                    <!-- Add delete or other actions here if needed -->
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <h3>No tests available</h3>
                <?php } ?>

            </section>
        </div>

        <script type="text/javascript">
            var active = document.querySelector("#navList li:nth-child(2)");
            active.classList.add("active");
        </script>

    </body>

    </html>
<?php } else {
    $em = "First login";
    header("Location: login.php?error=$em");
    exit();
} ?>