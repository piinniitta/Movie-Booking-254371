<?php
// เริ่ม session
session_start();

require 'database.php';

//if (!isset($_SESSION["Cus_id"])) {
// header("Location: index.php");
//}
//header('Location: Step1_Select_Movie.php');
$_SESSION['Movie_id'] = $_GET['Movie_id'];

ini_set('display_errors', 1);
error_reporting(~0);
if (isset($_GET["Movie_id"])) {
    $Movieid = $_GET["Movie_id"];
}
// ตรวจสอบว่ามีการส่งค่า Movie_id มาหรือไม่
if (!isset($_SESSION["Cus_id"]) || !isset($_GET["Movie_id"])) {
    header("Location: index.php");
}

$movie_id = $_GET["Movie_id"];
$sql_Movie_Genre = "SELECT *
FROM movies
INNER JOIN movie_genre
ON movies.Genre_id = movie_genre.Genre_id
WHERE Movie_id = '" . $Movieid . "' ";

$query_Movie_Genre = mysqli_query($conn, $sql_Movie_Genre);
$result_Movie_Genre = mysqli_fetch_array($query_Movie_Genre, MYSQLI_ASSOC);

$_SESSION['Movie_id'] = $result_Movie_Genre['Movie_id'];
$_SESSION['Movie_name'] = $result_Movie_Genre['Movie_name'];
$_SESSION['Pic_Movies'] = $result_Movie_Genre['Pic_Movies'];
$_SESSION['Video_Movies'] = $result_Movie_Genre['Video_Movies'];
$_SESSION['normal_price'] = $result_Movie_Genre['normal_price'];
$_SESSION['Movie_release_date'] = $result_Movie_Genre['Movie_release_date'];
$_SESSION['Genre_name'] = $result_Movie_Genre['Genre_name'];
$_SESSION['Period'] = $result_Movie_Genre['Period'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="css/Movie-Step.css">
    <title>
        <?php echo $result_Movie_Genre["Movie_name"]; ?>
    </title>
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
        <form method="post" action="Step2_Select_Cinema.php">
            <!-- fieldset หน้าที่ 1 -->

            <input type="hidden" name="txtCus_id" value="<?php echo $_SESSION['Cus_id']; ?>">
            <input type="hidden" name="txtMovie_id" value="<?php echo $result_Movie_Genre["Movie_id"]; ?>">
            <input type="hidden" name="normal_price" value="<?php echo $result_Movie_Genre["normal_price"]; ?>">
            <input type="hidden" name="Moviereleasedate"
                value="<?php echo $result_Movie_Genre["Movie_release_date"]; ?>">
            <input type="hidden" name="Genre_name" value="<?php echo $result_Movie_Genre["Genre_name"]; ?>">
            <input type="hidden" name="Period" value="<?php echo $result_Movie_Genre["Period"]; ?>">

            <div class="Pic_Movies">
                <!-- รูปภาพของภาพยนตร์แต่ละเรื่อง -->
                <div id="for_Pic_Movies" class="for_Pic_Movies">
                    <img src="picture/<?php echo $result_Movie_Genre["Pic_Movies"]; ?>">
                    <input type="hidden" name="txtPic_Movies" value="<?php echo $result_Movie_Genre["Pic_Movies"]; ?>">
                </div>
            </div>

            <div class="detail">
                <!-- ชื่อของภาพยนตร์แต่ละเรื่อง -->
                <div id="for_Movie_name">
                    <input type="text" id="movie_name" name="movie_name"
                        value="<?php echo $result_Movie_Genre["Movie_name"]; ?>" hidden>
                    <h3><strong>
                            <?php echo $result_Movie_Genre["Movie_name"]; ?>
                        </strong></h3>
                    </input>
                </div>
                <br>

                <!-- วันที่เข้าโรงภาพยนตร์ของภาพยนตร์แต่ละเรื่อง -->
                <div id="for_Movie_release_date" class="release_date">
                    <p>วันที่เข้าฉาย: </p> &nbsp;
                    <input type="text" name="Moviereleasedate"
                        value="<?php echo $result_Movie_Genre["Movie_release_date"]; ?>" hidden>
                    <?php echo $sumdate = date("j M Y", strtotime($result_Movie_Genre["Movie_release_date"]));
                    ; ?>
                    </input>
                </div>

                <div class="Genre_Period">
                    <!-- ประเภทของภาพยนตร์แต่ละเรื่อง -->
                    <div id="for_Genre_name" class="Genre_name">
                        <p>ประเภทภาพยนตร์: </p> &nbsp;
                        <input type="text" hidden>
                        <?php echo $result_Movie_Genre["Genre_name"]; ?>
                        </input>
                    </div>
                    &nbsp; &nbsp; &nbsp;

                    <div class="navrl-line"></div>

                    <!-- ระยะเวลาในการเล่นของภาพยนตร์แต่ละเรื่อง -->
                    <div id="for_Period">
                        <img src="picture/clock.png" class="clock-img"> &nbsp;
                        <input type="text" hidden>
                        <?php echo $result_Movie_Genre["Period"]; ?> นาที
                        </input>
                    </div>
                </div>
                <br>
                <button class="btn btn-primary" type=button onClick="window.history.back()" name="previous"
                    class="previous btn btn-default">ย้อนกลับ</button> &nbsp;
            </div>
        </form>
    </div>
</body>

</html>