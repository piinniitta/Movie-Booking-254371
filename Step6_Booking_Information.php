<?php
// เริ่ม session
session_start();

require 'database.php';

if (!isset($_SESSION["Cus_id"])) {
    header("Location: index.php");
}

if (isset($_POST["txtshowtime_id"])) {
    $txtshowtime_id = $_POST["txtshowtime_id"];
}
$_SESSION['showtime_id'] = $txtshowtime_id;

if (isset($_POST["txtshowtime_time"])) {
    $txtshowtime_time = $_POST["txtshowtime_time"];
}
$_SESSION['showtime_time'] = $txtshowtime_time;

if (isset($_POST["txttheater_name"])) {
    $txttheater_name = $_POST["txttheater_name"];
}
$_SESSION['theater_name'] = $txttheater_name;

if (isset($_POST["txttheater_id"])) {
    $txttheater_id = $_POST["txttheater_id"];
}
$_SESSION['theater_id'] = $txttheater_id;

if (isset($_POST["txtselecseat"])) {
    $txtselecseat = $_POST["txtselecseat"];
    $txtselecseat = array_map(function ($seat) {
        return explode(',', $seat);
    }, $txtselecseat);
    $count = array_reduce($txtselecseat, function ($acc, $seat) {
        return $acc + count($seat);
    }, 0);
    // flatten array
    $seats = array_reduce($txtselecseat, function ($acc, $seat) {
        return array_merge($acc, $seat);
    }, []);

    $seats_str = implode(',', $seats);
}

while ($row = mysqli_fetch_assoc($result_Promotion)) {
    $_SESSION['promotion'][$row['Promotion_name']] = $row['Discount_baht'];
}

$_SESSION['seats_str'] = $seats_str;
$_SESSION['count'] = $count;

$sql_Promotion = "SELECT *
    FROM customer_promotion
    INNER JOIN promotion
    ON customer_promotion.Promotion_id = promotion.Promotion_id
    INNER JOIN customers
    ON customer_promotion.Cus_id = customers.Cus_id
    WHERE customer_promotion.Cus_id = '{$_SESSION["Cus_id"]}' 
    ORDER BY customer_promotion.Cus_id ASC
    ";
$result_Promotion = mysqli_query($conn, $sql_Promotion);

// ตรวจสอบว่ามี session cinema_id หรือไม่
if (isset($_SESSION['Cinema_id'])) {
    // ดึง cinema_id จาก session
    $Cinema_id = $_SESSION['Cinema_id'];

    // คำสั่ง SQL เพื่อดึง cinema_name จากตาราง cinema_branch
    $sql = "SELECT Cinema_name FROM cinema_branch WHERE Cinema_id = '$Cinema_id'";

    // ทำการ query คำสั่ง SQL
    $result = mysqli_query($conn, $sql);

    // ตรวจสอบว่า query สำเร็จหรือไม่
    if (mysqli_num_rows($result) > 0) {
        // ดึงข้อมูล cinema_name ออกมาจาก row แรก
        $row = mysqli_fetch_assoc($result);
        $Cinema_name = $row['Cinema_name'];

        // ใช้ session ของ cinema_name ในการส่งต่อไปยังหน้าต่อไป
        $_SESSION['Cinema_name'] = $Cinema_name;
    }
}
$sql = "SELECT *
      FROM seats
      WHERE theater_id = '" . $theater_id . "'
      ";
//แปลงเก้าอี้ เป็น name
if (isset($_SESSION['seats_str'])) {
    $seats_str = $_SESSION['seats_str'];
    $seats_arr = array_map(function ($seat) {
        return explode(',', $seat);
    }, explode('|', $seats_str));


    foreach ($seats_arr as $seats) {
        // ตรวจสอบว่า $seats มีหลายค่าหรือไม่
        if (count($seats) > 0) {
            // แปลงค่า $seats เป็น string โดยใช้ implode()
            $seat_str = implode(",", $seats);
        } else {
            // ถ้ามีค่าเดียวก็แสดงค่านั้นได้เลย
        }

        foreach ($seats as $seat_id) {
            // คำสั่ง SQL เพื่อดึงข้อมูลที่นั่งจากตาราง seats
            $sql_seat = "SELECT seat FROM seats WHERE seat_id = '$seat_id'";

            // ทำการ query คำสั่ง SQL
            $result_seat = mysqli_query($conn, $sql_seat);

            // ตรวจสอบว่า query สำเร็จหรือไม่
            if (mysqli_num_rows($result_seat) > 0) {
                // ดึงข้อมูลที่นั่งออกมาจาก row แรก
                $row = mysqli_fetch_assoc($result_seat);
                $seat_name = $row['seat'];
                $seats = array($seat_name);
            } else {
                echo "ไม่สามารถค้นหาชื่อที่นั่ง $seat_id ได้ <br>";
            }
            //print_r($seats);
        }
    }
}
// สร้างตัวแปร $all_seats เพื่อเก็บ array ของทุกๆ seats
$all_seats = array();
foreach ($seats_arr as $seats) {
    // ตรวจสอบว่า $seats มีหลายค่าหรือไม่
    if (count($seats) > 0) {
        // แปลงค่า $seats เป็น string โดยใช้ implode()
        $seat_str = implode(",", $seats);
    } else {
        // ถ้ามีค่าเดียวก็แสดงค่านั้นได้เลย
    }

    foreach ($seats as $seat_id) {
        // คำสั่ง SQL เพื่อดึงข้อมูลที่นั่งจากตาราง seats
        $sql_seat = "SELECT seat FROM seats WHERE seat_id = '$seat_id'";

        // ทำการ query คำสั่ง SQL
        $result_seat = mysqli_query($conn, $sql_seat);

        // ตรวจสอบว่า query สำเร็จหรือไม่
        if (mysqli_num_rows($result_seat) > 0) {
            // ดึงข้อมูลที่นั่งออกมาจาก row แรก
            $row = mysqli_fetch_assoc($result_seat);
            $seat_name = $row['seat'];
            $seats = array($seat_name);

            // เพิ่มค่าใหม่เข้าไปใน array ที่มีอยู่แล้ว
            $_SESSION['seats'][] = $seats;

            // เพิ่มค่าใน $all_seats
            $all_seats = array_merge($all_seats, $seats);

            // แปลง array เป็น string โดยใช้ implode()
            $seats_str = implode(",", $seats);

            // ใช้ session ของ seat_name ในการส่งต่อไปยังหน้าต่อไป
            $_SESSION['seat'] = $seats_str;
        } else {
            echo "ไม่สามารถค้นหาชื่อที่นั่ง $seat_id ได้ <br>";
        }
    }
}
// แสดงผลของ $all_seats เก้าอี้ที่เราต้องการ
$all_seats_str = implode(",", $all_seats);
$_SESSION['all_seats_str'] = $all_seats_str;

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
    <title> ยืนยันการจอง </title>
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

        <form action="Step7_Payment.php">
            <div class="detail">
                <h3>ยืนยันการจอง</h3>
                <br>

                <div class="reservations_details">
                    <div class="details_title"> ชื่อผู้จอง : </div>
                    <p value="<?php echo $_SESSION['Cus_id']; ?>"> <?php echo $_SESSION['Cus_name']; ?></p>
                </div>

                <div class="reservations_details">
                    <div class="details_title"> ชื่อหนัง :</div>
                    <p>
                        <?php echo $_SESSION['Movie_name']; ?>
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

                    </p>
                </div>

                <div class="reservations_details">
                    <div class="details_title"> ที่นั่ง : </div>
                    <p>
                        <?php echo $all_seats_str ?>
                        <input type="hidden" name="seats_str" value="<?php echo $_SESSION["seats_str"]; ?>">
                    </p>
                </div>

                <div class="reservations_details">
                    <div class="details_title"> จำนวนตั๋ว : </div>
                    <p>
                        <?php echo $_SESSION['count'] ?> &nbsp; ใบ
                        <input type="hidden" name="count" value="<?php echo $_SESSION["count"]; ?>">
                    </p>
                </div>

                <div class="reservations_details">
                    <div class="details_title"> ราคา : </div>
                    <p>
                        <?php echo $_SESSION['count'] * $_SESSION["normal_price"] ?> บาท
                        <input type="hidden" name="Price"
                            value="<?php echo is_numeric($_SESSION["count"]) ? $_SESSION["count"] * $_SESSION["normal_price"] : '' ?>">
                    </p>
                </div>

                <div class="reservations_details">
                    <div class="details_title"> เลือกโปรโมชัน : </div>
                    <p>
                        <select name="Discount_baht" id="Discount_baht" required>
                            <option value="" hidden>-เลือกโปรโมชั่น-</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($result_Promotion)) {
                                ?>
                                <option value="<?php echo $row['Discount_baht']; ?>">
                                    <?php echo $row['Promotion_name']; ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </p>
                </div>
            </div>
            <br>
            <div>
                <button class="btn btn-primary" type=button onClick="window.history.back()" name="previous"
                    class="previous btn btn-default">ย้อนกลับ</button> &nbsp;
                <button class="btn btn-primary" type="submit">ยืนยันการจอง</button>
            </div>
    </div>
    </form>
    </div>

    <?php
    // ปิดการเชื่อมต่อฐานข้อมูล
    mysqli_close($conn);
    ?>

</body>

</html>