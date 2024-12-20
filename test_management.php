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
        <link rel="stylesheet" href="css/style.css?v=<?php echo time();?>">
        <style>
            /* Custom Styles for Status Colors */
            .status {
                padding:10px;
                border-radius:5px;
                font-weight: 500;
                width: 100%;
                color: white;
            }

            .status.developed {
                background-color: #007bff;
                /* Blue */
            }

            .status.testing {
                background-color: #efef05;
                color:black;
                /* Yellow */
            }

            .status.bug {
                background-color: orange;
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
                            <th>Project Name</th>
                            <th>Feature Title</th>
                            <th>Description</th>
                            <th>Dev Comments</th>
                            <th>Tester Comments</th>
                            <th>Created At</th>
                            <th>Test Status</th>
                            <th>Action</th>
                        </tr>
                        <?php $i = 0;
                        foreach ($tests as $test) { ?>
                            <tr>
                                <td><?= ++$i ?></td>
                                <td><?= $test['ProjectName'] ?></td>
                                <td><?= $test['title'] ?></td>
                                <td><?= $test['description'] ?></td>
                                <td><?= $test['DeveloperComments'] ?></td>
                                <td><?= $test['TesterComments'] ?></td>
                                <td><?= $test['created_at'] ?></td>
                                <td style='width:200px'>
                                    <div class="status <?= strtolower($test['test_status']); ?>">
                                        <?= $test['test_status'] ?>
                                    </div>
                                </td>
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
            var active = document.querySelector("#navList li:nth-child(5)");
            active.classList.add("active");
        </script>

    </body>

    </html>
<?php } else {
    $em = "First login";
    header("Location: login.php?error=$em");
    exit();
} ?>