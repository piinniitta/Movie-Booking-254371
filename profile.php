<?php
session_start();

require 'database.php';
if (!isset($_SESSION["Cus_id"])) {
    header("Location: login.php");
}

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
    <link rel="stylesheet" href="css/profile.css">
    <title>โปรไฟล์</title>
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
                    <li><a href="#"> ภาพยนตร์ </a></li>
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
    <br>

    <div class="top row profile-row">
        <div class="profile-col">
            <div class="profile-box"
                style="width: 600px; background-color: #fff; box-shadow: 0 1px 8px 0 rgba(0,0,0,.1);">
                <div class="profile-title">
                    <img src="picture/profile.png" class="photo">

                    <div class="box-profile-name-editB">
                        <h3> <strong>
                                <?php echo $_SESSION['Cus_name']; ?>
                            </strong></h3>
                        <a href="profile_fromedit.php">
                            <button type="submit" class="btn btn-primary btn-sm"> Edit Profile </button>
                            </br>
                        </a>
                    </div>
                </div>

                <?php if (isset($_SESSION['Cus_id'])): ?>
                    <div class="Info">
                        <p class="topic"> Name </p>
                        <p class="detail"> <strong>
                                <?php echo $_SESSION['Cus_name']; ?>
                            </strong></p>
                    </div>
                <?php endif ?>

                <?php if (isset($_SESSION['Cus_address'])): ?>
                    <div class="Info">
                        <p class="topic"> Address </p>
                        <p class="detail"> <strong>
                                <?php echo $_SESSION['Cus_address']; ?>
                            </strong></p>
                    </div>
                <?php endif ?>

                <?php if (isset($_SESSION['Cus_tel'])): ?>
                    <div class="Info">
                        <p class="topic"> Tel </p>
                        <p class="detail"> <strong>
                                <?php echo $_SESSION['Cus_tel']; ?>
                            </strong></p>
                    </div>
                <?php endif ?>

                <?php if (isset($_SESSION['Cus_email'])): ?>
                    <div class="Info">
                        <p class="topic"> Email </p>
                        <p class="detail"> <strong>
                                <?php echo $_SESSION['Cus_email']; ?>
                            </strong></p>
                    </div>
                <?php endif ?>

                <br>
            </div>
        </div>

        <div class="profile-col2">
            <div class="menu-box"
                style="width: 700px; margin: 0 90px; background-color: #fff; box-shadow: 0 1px 8px 0 rgba(0,0,0,.1);">
                <h3 class="menu-p">เมนูอื่นๆ</h3> <br> <br> <br>
                <ul class="menu" style="list-style: none;">
                    <li><a href="E-ticket.php">ตั๋วของฉัน</a></li>
                    <hr>
                    <li><a href="receipt.php">ประวัติการซื้อตั๋ว</a></li>
                    <hr>
                    <li><a href="customer_promotion.php">ส่วนลดที่มี</a></li>
                    <hr>
                    <li><a href="#">ภาพยนตร์ที่อยากดู</a></li>
                    <hr>
                    <li><a href="#">ประวัติการชำระเงิน</a></li>
                    <!--<a href="logout.php" class="btn btn-warning">ออกจากระบบ</a> -->
                    <br> <br>
                </ul>
            </div>
        </div>

        <?php
        mysqli_close($conn);
        ?>

        <!--<button><a href="javascript:window.history.back(-1);">ย้อนกลับ</a></button>
        <button><a href="index.php">หน้าหลัก</a></button>-->
    </div>

</body>

</html>