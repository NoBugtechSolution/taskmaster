<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "DB_connection.php";

    // Fetch the bug to edit
    if (isset($_GET['id'])) {
        $bug_id = $_GET['id'];
        $query = "SELECT * FROM bug_reports WHERE bug_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$bug_id]);
        $bug = $stmt->fetch();

        if (!$bug) {
            echo "Bug not found";
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $bug_title = $_POST['bug_title'];
            $bug_description = $_POST['bug_description'];
            $bug_url = $_POST['bug_url'];
            $bug_status = $_POST['bug_status'];
            $remarks_by_tester = $_POST['remarks_by_tester'];

            // Update the bug in the database
            $update_query = "UPDATE bug_reports SET bug_title = ?, bug_description = ?, bug_url = ?, bug_status = ?, remarks_by_tester = ? WHERE bug_id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->execute([$bug_title, $bug_description, $bug_url, $bug_status, $remarks_by_tester, $bug_id]);

            header("Location: bugs.php?success=Bug updated successfully");
            exit();
        }
    } else {
        echo "No bug ID specified";
        exit();
    }
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Edit Bug</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css?v=<?php echo time();?>">
    </head>

    <body>
        <input type="checkbox" id="checkbox">
        <?php include "inc/header.php" ?>
        <div class="body">
            <?php include "inc/nav.php" ?>
            <section class="section-1">
                <h4 class="title">Edit Bug</h4>
                <form action="edit_bug.php?id=<?= $bug['bug_id'] ?>" method="POST">
                    <label for="bug_title">Bug Title</label>
                    <input type="text" id="bug_title" name="bug_title" value="<?= $bug['bug_title'] ?>" required>

                    <label for="bug_description">Bug Description</label>
                    <textarea id="bug_description" name="bug_description" required><?= $bug['bug_description'] ?></textarea>

                    <label for="bug_url">Bug URL (Optional)</label>
                    <input type="text" id="bug_url" name="bug_url" value="<?= $bug['bug_url'] ?>">

                    <label for="remarks_by_tester">Remarks</label>
                    <textarea id="remarks_by_tester" name="remarks_by_tester"><?= $bug['remarks_by_tester'] ?></textarea>

                    <label for="bug_status">Status</label>
                    <select id="bug_status" name="bug_status">
                        <option value="New" <?= $bug['bug_status'] == 'New' ? 'selected' : '' ?>>New</option>
                        <option value="In Progress" <?= $bug['bug_status'] == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="Resolved" <?= $bug['bug_status'] == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                        <option value="Closed" <?= $bug['bug_status'] == 'Closed' ? 'selected' : '' ?>>Closed</option>
                    </select>

                    <button type="submit">Update Bug</button>
                </form>
            </section>
        </div>
        <style>
            /* Form Container */
            .section-1 {
                background: #fff;
                padding: 40px;
                border-radius: 8px;
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
                max-width: 800px;
                width: 100%;
                margin: 20px;
                box-sizing: border-box;
            }

            /* Title Styling */
            .title {
                font-size: 28px;
                font-weight: 600;
                color: #333;
                margin-bottom: 20px;
                text-align: center;
            }

            /* Form Styling */
            form {
                display: flex;
                flex-direction: column;
                gap: 20px;
            }

            /* Form Labels */
            label {
                font-size: 14px;
                color: #555;
                font-weight: 500;
            }

            /* Input fields, textareas, and selects */
            input[type="text"],
            input[type="date"],
            textarea,
            select {
                padding: 12px;
                font-size: 14px;
                border: 1px solid #ccc;
                border-radius: 6px;
                background-color: #f1f1f1;
                box-sizing: border-box;
                transition: border-color 0.3s ease, box-shadow 0.3s ease;
            }

            /* Focus effect for inputs */
            input[type="text"]:focus,
            input[type="date"]:focus,
            textarea:focus,
            select:focus {
                border-color: #007bff;
                outline: none;
                box-shadow: 0 0 6px rgba(0, 123, 255, 0.2);
            }

            /* Textarea Styling */
            textarea {
                resize: vertical;
                min-height: 120px;
            }

            /* Submit Button Styling */
            button[type="submit"] {
                background-color: #28a745;
                color: #fff;
                padding: 12px 20px;
                border: none;
                border-radius: 6px;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.3s ease, transform 0.2s ease;
                align-self: center;
            }

            /* Submit Button Hover Effect */
            button[type="submit"]:hover {
                background-color: #218838;
                transform: translateY(-2px);
            }

            /* Success and Error Message */
            .danger,
            .success {
                padding: 12px;
                border-radius: 6px;
                margin-bottom: 20px;
                font-size: 14px;
                color: #fff;
                text-align: center;
            }

            .danger {
                background-color: #f44336;
            }

            .success {
                background-color: #4caf50;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .section-1 {
                    padding: 30px;
                }

                .title {
                    font-size: 24px;
                }

                form {
                    gap: 15px;
                }

                button[type="submit"] {
                    padding: 10px 18px;
                }
            }
        </style>
        <script type="text/javascript">
            var active = document.querySelector("#navList li:nth-child(6)"); // Adjust active navigation link
            active.classList.add("active");
        </script>

    </body>

    </html>

<?php } else {
    $em = "First login";
    header("Location: login.php?error=$em");
    exit();
} ?>