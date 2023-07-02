<?php
session_start();

require 'database.php';

if (!isset($_SESSION["Cus_id"])) {
    header("Location: login.php");
}
$today = date('Y-m-d');

$sql = "SELECT Promotion_id,Promotion_name,Discount_baht,Pro_release_date,Pro_leave_date
    FROM promotion
    WHERE (Promotion_id LIKE '%" . $_GET["txtKeyword"] . "%') AND (Pro_leave_date >= '$today')
    ORDER BY Pro_leave_date ASC";
$query = mysqli_query($conn, $sql);


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
    <link rel="stylesheet" href="css/promotion.css">
    <title>หน้าหลัก</title>

</head>

<body style="background-color: #f5f7fb;">
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
    <br> <br>

    <h3 class="promotion-title"> โปรโมชั่น </h3>
    <br> <br>

    <?php
    while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        ?>

        <div class="box">
            <div class="promotion-box">
                <div class="promotion" style="background-color: #fff; box-shadow: 0 1px 8px 0 rgba(0,0,0,.1);">
                    <div class="details">
                        <div class="promotion-name">
                            <p> <strong>
                                    <?php echo $result["Promotion_name"]; ?>
                                </strong> </p>
                        </div>

                        <div class="promotion-leave">
                            <p>ใช้ได้ถึง</p> &nbsp; &nbsp;
                            <p>
                                <?php echo $sumdate = date("j M Y", strtotime($result["Pro_leave_date"]));
                                ; ?>
                            </p>
                        </div>

                        <div class="promotion-button">
                            <button class="btn btn-light btn-sm"><a
                                    href='datapromotion.php?pro_id=<?php echo $result["Promotion_id"]; ?>'
                                    ;>ดูเพิ่มเติม</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
    ?>

    <?php
    mysqli_close($conn);
    ?>
</body>

</html>