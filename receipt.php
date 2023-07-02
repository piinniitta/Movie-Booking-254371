<?php
session_start();

require 'database.php';
if (!isset($_SESSION["Cus_id"])) {
    header("Location: index.php");
}

$Cus_id_loged = $_SESSION["Cus_id"];
$sql = "SELECT * FROM ticket_with_receipt 
    INNER JOIN  customers
    ON (ticket_with_receipt.Cus_id = customers.Cus_id)
    INNER JOIN  movies
    ON (ticket_with_receipt.Movie_id = movies.Movie_id)
    INNER JOIN  cinema_branch
    ON (ticket_with_receipt.Cinema_id = cinema_branch.Cinema_id)
    INNER JOIN  theater
    ON (ticket_with_receipt.theater_id = theater.theater_id)
    INNER JOIN  seats
    ON (ticket_with_receipt.seat_id = seats.seat_id)
    INNER JOIN  showtime
    ON (ticket_with_receipt.Showtime_id = showtime.Showtime_id)
    INNER JOIN  promotion
    ON (ticket_with_receipt.Promotion_id = promotion.Promotion_id)
    WHERE customers.Cus_id = '$Cus_id_loged'";
$query = mysqli_query($conn, $sql);

$sql2 = "SELECT *
    FROM movies";
$result2 = mysqli_query($conn, $sql2);

$_SESSION['Movie_name'] = $result['Movie_name'];
$_SESSION['Pic_Movies'] = $result['Pic_Movies'];

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
    <link rel="stylesheet" href="css/receipt.css">
    <!--<script defer src="https://pyscript.net/latest/pyscript.js"></script>-->
    <title>ประวัติการซื้อตั๋ว</title>
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
    <br> <br>

    <div class="actor-actress">
        <h3>ประวัติการซื้อตั๋ว</h3>
    </div>

    <?php
    while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        ?>

        <div class="box" style="margin: 0 80px; ">
            <div class="box-personalized" style="padding: 10px 0; float:left;">
                <div class="box-eticket" style="margin: 0 10px; margin-top: -100px; margin-bottom: 200px;">
                    <div class="Eticket" style="height: 640px; border: 1px solid rgba(0, 0, 0, 0.5); 
                background-color: #fff; box-shadow: 0 1px 8px 0 rgba(0,0,0,.1);">

                        <div class="img-Eticket">
                            <img src="picture/<?php echo $result["Pic_Movies"]; ?>" width="200" height="300">
                        </div>

                        <div class="Message">
                            <div class="title" style="text-align: center;">
                                <h6><strong>
                                        <?php echo $result["Movie_name"]; ?>
                                    </strong></h6>
                            </div>

                            <div class="date-details" style="margin: 2px 0;">
                                <p class="date-title">Order Number</p> &nbsp;
                                <p>
                                    <?php echo $result["Order_number"]; ?>
                                </p>
                            </div>

                            <div class="date-details" style="margin: 2px 0;">
                                <p class="date-title">Date</p> &nbsp;
                                <p>
                                    <?php echo $sumdate = date("j M Y", strtotime($result["date_id"])); ?>
                                </p>
                            </div>

                            <div class="time-details" style="margin: 2px 0;">
                                <p class="time-title">Time</p> &nbsp;
                                <p>
                                    <?php echo $result["Showtime_time"]; ?> น.
                                </p>
                            </div>

                            <div class="seats-details" style="margin: 2px 0;">
                                <p class="seats-title">Theater</p>
                                <p>
                                    <?php echo $result["theater_name"]; ?>
                                </p>
                            </div>

                            <div class="seats-details" style="margin: 2px 0;">
                                <p class="seats-title">Seats</p> &nbsp;
                                <p>
                                    <?php echo $result["seat"]; ?>
                                </p>
                            </div>

                            <div class="location-details" style="margin: 2px 0;">
                                <p class="location-title">Location</p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                <p>
                                    <?php echo $result["Cinema_name"]; ?>
                                </p>
                            </div>
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