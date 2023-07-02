<?php
// Start session
session_start();

require 'database.php';

if (!isset($_SESSION["Cus_id"])) {
    header("Location: index.php");
}

// Check if promotion data is set
if (isset($_GET["Discount_baht"])) {
    $discount = $_GET["Discount_baht"];
    // คำสั่ง SQL เพื่อดึงข้อมูล Promotion_id และ Discount_baht จากตาราง promotion
    $sql = "SELECT  Promotion_id, Discount_baht
    FROM promotion
    WHERE Discount_baht = '$discount'";

    // ทำการ query คำสั่ง SQL
    $result = mysqli_query($conn, $sql);

    // ตรวจสอบว่า query สำเร็จหรือไม่
    if (mysqli_num_rows($result) > 0) {
        // ดึงข้อมูล Promotion_id และ Discount_baht ออกมาจาก row แรก
        $row = mysqli_fetch_assoc($result);
        $promotion_id = $row['Promotion_id'];
        $discount_baht = $row['Discount_baht'];

        // แสดง Promotion_id และ Discount_baht ออกมา
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="css/Movie-Step.css">
        <title> ยืนยันการจอง </title>
    </head>
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

        <form method="post" action="updateseat.php">
            <h3>จ่ายเงิน</h3>
            <br>

            <div class="reservations_details">
                <div class="details_title"> ชื่อผู้จอง : </div>
                <p value="<?php echo $_SESSION['Cus_id']; ?>">
                    <?php echo $_SESSION['Cus_name']; ?>
                    <input type="hidden" name="Cus_id" value="<?php echo $_SESSION["Cus_id"]; ?>">
                </p>
            </div>

            <div class="reservations_details">
                <div class="details_title"> ชื่อหนัง :</div>
                <p>
                    <?php echo $_SESSION['Movie_name']; ?>
                    <input type="hidden" name="Movie_id" value="<?php echo $_SESSION["Movie_id"]; ?>">
                </p>
            </div>

            <div class="reservations_details">
                <div class="details_title"> โรงภาพยนตร์ : </div>
                <p>
                    <?php echo $_SESSION['Cinema_name'] ?>
                    <input type="hidden" name="Cinema_id" value="<?php echo $_SESSION["Cinema_id"]; ?>">
                </p>
            </div>

            <div class="reservations_details">
                <div class="details_title"> วันที่ : </div>
                <p>
                    <?php echo $_SESSION["selected_date"]; ?>
                    <input type="hidden" name="selected_date1" value="<?php echo $_SESSION["selecteddate"]; ?>">
                </p>
            </div>

            <div class="reservations_details">
                <div class="details_title"> เวลา : </div>
                <p>
                    <?php echo $_SESSION['showtime_time'] ?>
                    <input type="hidden" name="showtime_id" value="<?php echo $_SESSION["showtime_id"]; ?>">
                </p>
            </div>

            <div class="reservations_details">
                <div class="details_title"> Theater : </div>
                <p>
                    <?php echo $_SESSION['theater_name'] ?>
                    <input type="hidden" name="theater_id" value="<?php echo $_SESSION["theater_id"]; ?>">
                </p>
            </div>

            <div class="reservations_details">
                <div class="details_title"> ที่นั่ง : </div>
                <p>
                    <?php echo $_SESSION['all_seats_str'] ?>
                    <input type="hidden" name="seats_str" value="<?php echo $_SESSION["seats_str"]; ?>">
                </p>
            </div>

            <div class="reservations_details">
                <div class="details_title"> จำนวนตั๋ว : </div>
                <p>
                    <?php echo $_SESSION['count'] ?> ใบ
                    <input type="hidden" name="count" value="<?php echo $_SESSION["count"]; ?>">
                </p>
            </div>

            <div class="reservations_details">
                <div class="details_title"> ส่วนลด : </div>
                <p>
                    <?php echo $discount ?> บาท
                    <input type="hidden" name="promotion_id" value="<?php echo $promotion_id; ?>">
                </p>
            </div>

            <div class="reservations_details">
                <div class="details_title"> ราคารวม : </div>
                <p>
                    <?php
                    if ($_SESSION['count'] * $_SESSION["normal_price"] > $discount) {
                        echo ($_SESSION["count"] * $_SESSION["normal_price"]) - $discount . "บาท";
                    } elseif ($_SESSION['count'] * $_SESSION["normal_price"] < $discount) {
                        echo "0 บาท";
                    }
                    ?>
                    <input type="hidden" name="Price"
                        value="<?php echo is_numeric($_SESSION["count"]) ? ($_SESSION["count"] * $_SESSION["normal_price"]) - $discount : '' ?>">
                </p>
            </div>

            <br>
            <div>
                <button class="btn btn-primary" type=button onClick="window.history.back()" name="previous"
                    class="previous btn btn-default">ย้อนกลับ</button> &nbsp;
                <button class="btn btn-primary" type="submit">ยืนยันการจอง</button>
            </div>
        </form>
    </div>
</body>

</html>