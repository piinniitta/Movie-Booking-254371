<?php
// Start session
session_start();
// Database connection
require 'database.php';
if (!isset($_SESSION["Cus_id"])) {
    header("Location: index.php");
}
ini_set('display_errors', 1);
error_reporting(~0);
if (isset($_GET["Movie_id"])) {
    $Movie_id = $_GET["Movie_id"];
}

ini_set('display_errors', 1);
error_reporting(~0);
if (isset($_GET["Cinema_id"])) {
    $Cinema_id = $_GET["Cinema_id"];
}

$sql_Cinema = "SELECT *
    FROM cinema_branch
    WHERE Cinema_id = '$Cinema_id'";
$result_Cinema = mysqli_query($conn, $sql_Cinema);
$result_Cinema = mysqli_fetch_array($result_Cinema, MYSQLI_ASSOC);

$_SESSION['Cinema_id'] = $Cinema_id;

$sql1 = "SELECT *
FROM movies";
$result1 = mysqli_query($conn, $sql1);

$sql = "SELECT *
FROM showtime";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
date_default_timezone_set('Asia/Bangkok');
$dates = [];
for ($i = 0; $i < 7; $i++) {
    $date = strtotime('+' . $i . ' day');
    $date_string = date('j F Y', $date);
    $dates[] = [
        'date' => $date_string,
    ];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get selected date and time from form
    $selected_date = $_POST['txtdate'];

    // แปลงวันที่ในรูปแบบ d F Y เป็น timestamp
    $timestamp = strtotime($selectedDate);

    // แปลง timestamp เป็นวันที่ในรูปแบบ Y-m-d
    $newDate = date("Y-m-d", $timestamp);

    echo $newDate; // ผลลัพธ์: 2023-04-06

    // Save selected date and time in session
    $_SESSION['selected_date'] = $selected_date;

    // Redirect to Step4_Select_Time.php
    header('Location: Step4_Select_Time.php');
    exit;
}

// เก็บค่าข้อมูลหนังที่ผู้ใช้กรอกใน session //ค่า session ที่เราจะใช้จากหน้าที่แล้ว
$sql_Movie = "SELECT * FROM movies ";
$result_Movie = mysqli_query($conn, $sql_Movie);

$sql_Region = "SELECT * FROM region";
$result_Region = mysqli_query($conn, $sql_Region);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $region_id = $_POST['region'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/Movie-Step.css">
    <title> เลือกวันที่ </title>
</head>

<body>
    <!--navbar-->
    <nav class="navbar-header" id="navbar">
        <div class="container-fluid">
            <div class="nav-logo">
                <a href="#">
                    <img src="picture/logo.png" class="img-logo">
                </a>
            </div>

            <div class="nav-menu">
                <ul class="menu-list">
                    <li><a href="index.php"> หน้าหลัก </a></li>
                    <li><a href="Movie-Showing.php"> ภาพยนตร์ </a></li>
                    <li><a href="#"> โรงภาพยนตร์ </a></li>
                    <li><a href="promotion.php"> โปรโมชั่น </a></li>
                    <li><a href="E-ticket.php"> E-Ticket </a></li>
                    <li><a href="#"> ติดต่อเจ้าหน้าที่ </a></li>
                </ul>
            </div>

            <div class="nav-right">
                <div class="navr-list">
                    <div class="navrl-lang">
                        <div class="logout">
                            <a href="logout.php" class="btn btn-light btn-sm">LOGOUT</a>
                        </div>
                    </div>

                    <div class="navrl-line"></div>

                    <div class="navrl-profile">
                        <div class="dropdown">
                            <a href="profile.php" class="btn-profile " id="Profile">
                                <img src="picture/profile.png" class="icon-profile">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!--สิ้นสุด navbar-->

    <div class="container">
        <div class="Pic_Movies">
            <!-- รูปภาพของภาพยนตร์แต่ละเรื่อง -->
            <div id="for_Pic_Movies" class="for_Pic_Movies">
                <img src="picture/<?php echo $_SESSION["Pic_Movies"]; ?>">
            </div>
        </div>

        <div class="detail">
            <!-- ชื่อของภาพยนตร์แต่ละเรื่อง -->
            <div id="for_Movie_name">
                <h3><strong>
                        <?php echo $_SESSION["Movie_name"]; ?>
                    </strong></h3>
            </div>
            <br>

            <!-- วันที่เข้าโรงภาพยนตร์ของภาพยนตร์แต่ละเรื่อง -->
            <div id="for_Movie_release_date" class="release_date">
                <p>วันที่เข้าฉาย: </p> &nbsp;
                <?php echo $sumdate = date("j M Y", strtotime($_SESSION["Movie_release_date"])); ?>
            </div>

            <div class="Genre_Period">
                <!-- ประเภทของภาพยนตร์แต่ละเรื่อง -->
                <div id="for_Genre_name" class="Genre_name">
                    <p>ประเภทภาพยนตร์: </p> &nbsp;
                    <?php echo $_SESSION["Genre_name"]; ?>
                </div>
                &nbsp; &nbsp; &nbsp;

                <div class="navrl-line"></div>

                <!-- ระยะเวลาในการเล่นของภาพยนตร์แต่ละเรื่อง -->
                <div id="for_Period">
                    <img src="picture/clock.png" class="clock-img"> &nbsp;
                    <?php echo $_SESSION["Period"]; ?> นาที
                </div>
            </div>
        </div>
        <br>

        <div class="region_branch">
            <form method="post" action="">
                <input type="hidden" name="txtCus_id" value="<?php echo $_SESSION['Cus_id']; ?>">
                <input type="hidden" name="txtMovie_id" value="<?php echo $_SESSION["Movie_id"]; ?>">
                <input type="hidden" name="txtMovie_name" value="<?php echo $_SESSION["Movie_name"]; ?>">
                <input type="hidden" name="Pic_Movies" value="<?php echo $_SESSION["Pic_Movies"]; ?>">
                <input type="hidden" name="Movie_release_date" value="<?php echo $_SESSION["Movie_release_date"]; ?>">
                <input type="hidden" name="Genre_name" value="<?php echo $_SESSION["Genre_name"]; ?>">
                <input type="hidden" name="Period" value="<?php echo $_SESSION["Period"]; ?>">
                <input type="hidden" name="Cinema_id" value="<?php echo $_SESSION['Cinema_id'] ?>">

                <h3>เลือกวันที่</h3>
                <?php foreach ($dates as $date) { ?>
                    <div class="select_date">
                        <input type="radio" name="txtdate" value="<?php echo $date['date']; ?>" required>
                        <?php echo $date['date']; ?>
                    </div>
                <?php } ?>
                <br>

                <button type="submit" class="btn btn-primary">เลือก</button>
                <br>
            </form>
        </div>
    </div>
</body>

</html>