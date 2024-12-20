<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "employee") {
	include "DB_connection.php";
	include "app/Model/Task.php";
	include "app/Model/User.php";

	if (!isset($_GET['id'])) {
		header("Location: tasks.php");
		exit();
	}
	$id = $_GET['id'];
	$task = get_task_by_id($conn, $id);

	if ($task == 0) {
		header("Location: tasks.php");
		exit();
	}
	$users = get_all_users($conn);
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Edit Task</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css?v=<?php echo time();?>">

	</head>

	<body>
		<input type="checkbox" id="checkbox">
		<?php include "inc/header.php" ?>
		<div class="body">
			<?php include "inc/nav.php" ?>
			<section class="section-1">
				<h4 class="title">Edit Task <a href="my_task.php">Tasks</a></h4>
				<form class="form-1"
				name='TheForm'
					method="POST"
					action="app/update-task-employee.php">
					<?php if (isset($_GET['error'])) { ?>
						<div class="danger" role="alert">
							<?php echo stripcslashes($_GET['error']); ?>
						</div>
					<?php } ?>

					<?php if (isset($_GET['success'])) { ?>
						<div class="success" role="alert">
							<?php echo stripcslashes($_GET['success']); ?>
						</div>
					<?php } ?>
					<div class="input-holder">
						<lable></lable>
						<p><b>Title: </b><?= $task['title'] ?></p>
					</div>
					<div class="input-holder">
						<lable></lable>
						<p><b>Description: </b><?= $task['description'] ?></p>
					</div><br>
					<div class="input-holder">
						<lable id="Header">Status</lable>
						<textarea name="devComment" id="devComment" class="input-1" style='display:none' rows="10" placeholder='Developer Comment'></textarea>
						<select name="status" class="input-1" id='StatusSelect'>
							<option <?php if ($task['status'] == "pending") echo "selected"; ?> value="pending">Pending</option>
							<option <?php if ($task['status'] == "in_progress") echo "selected"; ?> value="in_progress">In Progress</option>
							<option <?php if ($task['status'] == "completed") echo "selected"; ?> value="completed">Completed</option>
							<option <?php if ($task['status'] == "bugs_founded") echo "selected"; ?> value="bugs_founded">Bugs Reported</option>

						</select><br>
					</div>
					<input type="text" name="id" value="<?= $task['id'] ?>" hidden>
					<button class="edit-btn" id="SwitchBox"  onclick="TestingOn()" type='button'>Add To Testing</button>
					<button class="edit-btn" id="SubmitBox" name='update'>Update</button>
				</form>

			</section>
		</div>

		<script type="text/javascript">
			var active = document.querySelector("#navList li:nth-child(2)");
			active.classList.add("active");
			var test=true;
			function TestingOn(){
				Button1=document.getElementById("SubmitBox");
				Button2=document.getElementById("SwitchBox");
				TextArea=document.getElementById("devComment");
				Selector=document.getElementById("StatusSelect");
				Header=document.getElementById("Header");
				if(test){
					Button1.textContent='Add';
					Button2.textContent='Update Details';
					TextArea.style.display='flex';
					Selector.style.display='none';
					Button1.setAttribute("name", "Testing");
					Header.textContent="Add Developer Comment";
					test=false;
				}else{
					Button1.textContent='Update';
					Button2.textContent='Add To Testing';
					TextArea.style.display='none';
					Selector.style.display='flex';
					Header.textContent="Status";
					Button1.setAttribute("name", "update");
					test=true;
				}
			}
		</script>
	</body>

	</html>
<?php } else {
	$em = "First login";
	header("Location: login.php?error=$em");
	exit();
}
?>