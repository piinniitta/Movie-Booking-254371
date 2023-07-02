<?php
// เริ่ม session
session_start();

require 'database.php';
if (!isset($_SESSION["Cus_id"])) {
    header("Location: index.php");
}

//ภูมิภาค
$sql_Region = "SELECT * FROM region";
$result_Region = mysqli_query($conn, $sql_Region);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $region_id = $_POST['region'];
}
// Query ข้อมูลโรงภาพยนตร์ที่เกี่ยวข้องกับภูมิภาคที่เลือก

$sql_Cinema = "SELECT *
    FROM cinema_branch
    INNER JOIN region ON cinema_branch.Region_id = region.Region_id
    WHERE region.Region_id = '$region_id'";
$result_Cinema = mysqli_query($conn, $sql_Cinema);

$sql_cinema1 = "SELECT *
    FROM cinema_branch
    WHERE (Cinema_id LIKE '%" . $_GET["txtKeyword"] . "%')";
$result_cinema1 = mysqli_query($conn, $sql_cinema1);
// ตรวจสอบว่ามีการส่งค่า Movie_id มาหรือไม่
//if (!isset($_SESSION["Cus_id"]) || !isset($_GET["Movie_id"])) {
//  header("Location: Step2_Select_Cinema.php");
//}

//หนัง
if (isset($_POST["txtMovie_id"])) {
    $txtMovie_id = $_POST["txtMovie_id"];
}
if (isset($_POST["movie_name"])) {
    $movie_name = $_POST["movie_name"];
}
if (isset($_POST["normal_price"])) {
    $normal_price = $_POST["normal_price"];
}
if (isset($_POST["txtPic_Movies"])) {
    $Pic_Movies = $_POST["txtPic_Movies"];
}
if (isset($_POST["Moviereleasedate"])) {
    $Moviereleasedate = $_POST["Moviereleasedate"];
}
if (isset($_POST["Genre_name"])) {
    $Genre_name = $_POST["Genre_name"];
}
if (isset($_POST["Period"])) {
    $Period = $_POST["Period"];
}

// คิวรีข้อมูลภาพยนตร์
$sql_Movie = "SELECT * FROM movie WHERE Movie_id = '$movie_id'";
$result_Movie = mysqli_query($conn, $sql_Movie);
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
    <title> เลือกโรงภาพยนตร์ </title>
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
        <div class="region_branch">
            <form method="post">
                <input type="hidden" name="txtCus_id" value="<?php echo $_SESSION['Cus_id']; ?>">
                <input type="hidden" name="movie_id" value="<?php echo $txtMovie_id ?>">
                <h3>เลือกภูมิภาค</h3>
                <br>
                <div class="input-group">
                    <select class="custom-select" id="region" name="region" onchange="showCinema()" required>
                        <option value="" hidden>-เลือกภูมิภาค-</option>
                        <?php while ($row = mysqli_fetch_assoc($result_Region)) { ?>
                            <option value="<?php echo $row['Region_id']; ?>">
                                <?php echo $row['Region_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="submit"> เลือก </button>
                    </div>
                </div>
            </form>
            <br>

            <form method="post" id="cinema">
                <?php if (isset($result_Cinema)) { ?>
                    <!-- แสดงโรงภาพยนตร์ที่เกี่ยวข้องกับภูมิภาคที่เลือก -->
                    <?php while ($row = mysqli_fetch_assoc($result_Cinema)) { ?>
                        <div class="select_cenima">
                            <input type="radio" name="txtCinema_id" required
                                onclick="location.href='Step3_Select_Date.php?Cinema_id=<?php echo $row["Cinema_id"]; ?>'">
                            &nbsp; <?php echo $row["Cinema_name"]; ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            </form>
        </div>
    </div>

    <script>
        function showCinema() {
            var Region = document.getElementById("region").value;
            var Cinema = document.getElementById("cinema");

            // ถ้าเลือกภูมิภาคแล้ว
            if (Region === Cinema) {
                // แสดง form สำหรับโรงภาพยนตร์นั้น ๆ
                Cinema.style.display = "block";
            }
            else {
                //ซ่อน form ทั้งหมด
                Cinema.style.display = "none";
            } //var xmlhttp = new XMLHttpRequest();
        }
    </script>

</body>

</html>