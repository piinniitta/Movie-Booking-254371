<?php
session_start();

require 'database.php';

if (!isset($_SESSION["Cus_id"])) {
    header("Location: index.php");
}

if (isset($_GET["pro_id"])) {
    $pro_id = $_GET["pro_id"];
}

$sql = "SELECT Promotion_id,Promotion_name,Discount_baht,Pro_release_date,Pro_leave_date,Promotion_info
    FROM promotion
    WHERE Promotion_id = '" . $pro_id . "' ";
$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_array($query, MYSQLI_ASSOC);

$sql3 = "SELECT *
    FROM customers";
$result3 = mysqli_query($conn, $sql3);

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
    <link rel="stylesheet" href="datapromotion.css">
    <title>รายละเอียดโปรโมชั่น</title>
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
    <br> <br> <br> <br>


    <div class="box" style="background-color: #fff; box-shadow: 0 1px 8px 0 rgba(0,0,0,.1);">
        <h3>รายละเอียดโปรโมชัน</h3> <br>
        <form action="promoadd.php" method="post">
            <input type="text" name="txtCus_id" value="<?php echo $_SESSION['Cus_id']; ?>" hidden>
            <input type="text" name="txtPromotion_id" value="<?php echo $result["Promotion_id"]; ?>" hidden>

            <div class="promotion_details">
                <p>ชื่อโปรโมชัน : </p> &nbsp;
                <p value="<?php echo $result["Promotion_name"]; ?>"><?php echo $result["Promotion_name"]; ?></p>
            </div>

            <div class="promotion_details">
                <p>วันที่โปรโมชันเข้า : </p> &nbsp;
                <p value="<?php echo $result["Pro_release_date"]; ?>"><?php echo $sumdate = date("j M Y", strtotime($result["Pro_release_date"]));
                  ; ?></p>
            </div>

            <div class="promotion_details">
                <p>วันหมดอายุโปรโมชัน : </H3> &nbsp;
                <p value="<?php echo $result["Pro_leave_date"]; ?>"><?php echo $sumdate = date("j M Y", strtotime($result["Pro_leave_date"]));
                  ; ?></p>
            </div>

            <div class="promotion_details">
                <p>รายละเอียดโปรโมชัน : </p> &nbsp;
                <p value="<?php echo $result["Promotion_info"]; ?>"><?php echo $result["Promotion_info"]; ?></p>
            </div>

            </br>

            <input type="submit" name="submit" class="submit btn btn-success" value="เก็บส่วนลด" />
        </form>
    </div>

    <?php
    mysqli_close($conn);
    ?>
</body>

</html>