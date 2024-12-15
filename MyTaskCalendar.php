<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";

    $tasks = get_all_tasks_by_id($conn, $_SESSION['id']);
    // while($row=$tasks->fetch_assoc()){
    //     echo $row['title'];
    // }
//    foreach($tasks as $data){
//     echo $data['title']."<br>";
//    }
    $tasksJson = json_encode($tasks);
 ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Task Calendar</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/main.min.css' rel='stylesheet' />
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/main.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.5/main.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.5/main.min.js'></script>
    </head>

    <body>
        <input type="checkbox" id="checkbox">
        <?php include "inc/header.php" ?>
        <div class="body">
        <?php include "inc/nav.php" ?>
            <section class="section-1">
                <h4 class="title-2">
                    <a href="create_task.php" class="btn">Create Task</a>
                    <a href="tasks.php">Task List View</a>
                </h4>
                <div id='calendar'>
                    <!-- Custom calendar structure here -->
                    <div class="calendar-container">
                        <header class="calendar-header">
                            <p class="calendar-current-date"></p>
                            <div class="calendar-navigation">
                                <span id="calendar-prev" class="material-symbols-rounded">
                                    < </span>
                                        <span id="calendar-next" class="material-symbols-rounded">
                                            > </span>
                            </div>
                        </header>
                        <div class="calendar-body">
                            <ul class="calendar-weekdays">
                                <li>Sun</li>
                                <li>Mon</li>
                                <li>Tue</li>
                                <li>Wed</li>
                                <li>Thu</li>
                                <li>Fri</li>
                                <li>Sat</li>
                            </ul>
                            <ul class="calendar-dates"></ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <style>
            #calendar{
                height: 80%;
            }
            .calendar-container {
                background: #fff;
                width: 100%;
                border-radius: 12px;
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
                padding: 20px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding-bottom: 10px;
                border-bottom: 1px solid #eee;
            }

            .calendar-header {
                display: flex;
                justify-content: space-between;
                width: 100%;
                align-items: center;
            }

            .calendar-navigation {
                display: flex;
                align-items: center;
            }

            .calendar-navigation span {
                height: 35px;
                width: 35px;
                margin: 0 10px;
                cursor: pointer;
                text-align: center;
                line-height: 35px;
                border-radius: 50%;
                user-select: none;
                color: #666;
                font-size: 1.5rem;
                transition: background-color 0.3s;
            }

            .calendar-navigation span:hover {
                background-color: #f0f0f0;
            }

            .calendar-current-date {
                font-size: 1.3rem;
                font-weight: 600;
                color: #333;
            }

            .calendar-body {
                margin-top: 20px;
                text-align: center;
                height: fit-content;
            }

            .calendar-weekdays,
            .calendar-dates {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                gap: 10px;
            }
            .calendar-dates{
                height: 90%;
            }

            .calendar-weekdays li,
            .calendar-dates li {
                list-style: none;
                font-size: 1.1rem;
                color: #333;
                display: flex;
                gap:0px;
                flex-direction:column;
                padding: 10px;
                transition: background-color 0.3s, color 0.3s;
            }

            .calendar-weekdays li {
                font-weight: bold;
                color: #888;
            }

            .calendar-dates li {
                cursor: pointer;
                border-radius: 10px;
                position: relative;
            }

            .calendar-dates li:hover {
                background-color: #e4e1e1;
            }

            .calendar-dates li.inactive {
                color: #ddd;
            }

            .calendar-dates li.active {
                background-color: #6332c5;
                color: #222;
            }

            .calendar-dates li.active:hover {
                background-color: #45209f;
            }

            .calendar-dates li::before {
                position: absolute;
                content: "";
                z-index: -1;
                top: 50%;
                left: 50%;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                transform: translate(-50%, -50%);
                background: rgba(99, 50, 197, 0.2);
            }

            .calendar-dates li.active::before {
                background: rgba(99, 50, 197, 0.4);
            }

            .calendar-dates li[data-date] {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .calendar-dates li[data-date]:hover::before {
                background-color: #e4e1e1;
            }

            footer {
                margin-top: 20px;
                text-align: center;
            }

            footer a {
                color: #6332c5;
                text-decoration: none;
                font-weight: 600;
            }

            footer a:hover {
                text-decoration: underline;
            }
            #TasksData{
                width:100%;
                height: 15px;
                display: flex;
                gap:5px;
                align-items:center;
                justify-content:center;
            }
            #TasksData div{
                height: 10px;
                width: 10px;
                border-radius:50%;
            }
        </style>
        <script>
            let date = new Date();
            let year = date.getFullYear();
            let month = date.getMonth();

            const tasks = <?php echo $tasksJson; ?>; 

            const day = document.querySelector(".calendar-dates");
            const currdate = document.querySelector(".calendar-current-date");
            const prenexIcons = document.querySelectorAll(".calendar-navigation span");

            const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

            // Function to generate the calendar
            const manipulate = () => {
                let dayone = new Date(year, month, 1).getDay();
                let lastdate = new Date(year, month + 1, 0).getDate();
                let dayend = new Date(year, month, lastdate).getDay();
                let monthlastdate = new Date(year, month, 0).getDate();

                let lit = "";

                for (let i = dayone; i > 0; i--) {
                    lit += `<li class="inactive"><br>${monthlastdate - i + 1}</li>`;
                }

                for (let i = 1; i <= lastdate; i++) {
                    let isToday = i === date.getDate() && month === new Date().getMonth() && year === new Date().getFullYear() ? "active" : "";
                    lit += `<li class="${isToday}" data-date="${year}-${month+1}-${i.toString().padStart(2, '0')}" ><div id='TasksData'></div><br>${i}</li>`;
                }

                for (let i = dayend; i < 6; i++) {
                    lit += `<li class="inactive"><br>${i - dayend + 1}</li>`;
                }

                currdate.innerText = `${months[month]} ${year}`;
                day.innerHTML = lit;
                resetTask();
            }

            manipulate();

            // Click events for navigation
            prenexIcons.forEach(icon => {
                icon.addEventListener("click", () => {
                    month = icon.id === "calendar-prev" ? month - 1 : month + 1;

                    if (month < 0 || month > 11) {
                        date = new Date(year, month, new Date().getDate());
                        year = date.getFullYear();
                        month = date.getMonth();
                    } else {
                        date = new Date();
                    }

                    manipulate();
                });
            });

            // Attach task data to the calendar dates
            
            function resetTask(){
                document.querySelectorAll(".calendar-dates li").forEach(dateElement => {
                    let taskDate = dateElement.getAttribute('data-date');
                    if (taskDate) {
                        // Check if there are tasks on this date and highlight
                        let i=1;
                        tasks.forEach(task => {
                            if (task.due_date === taskDate) {
                                let div=document.createElement('div')
                                if(task[5]=='completed'){
                                    div.style.backgroundColor='#22ee22'
                                    
                                }else if(task[5]=='in_progress'){
                                    div.style.backgroundColor='orange'
                                }else{
                                    div.style.backgroundColor='red'
                                }
                                dateElement.style.backgroundColor = "#eee"; 
                                dateElement.title+=`\nTask ${i}: `+task.title;
                                
                                dateElement.querySelector('#TasksData').appendChild(div)
                                i++;
                            }
                        });
                    }
                });
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