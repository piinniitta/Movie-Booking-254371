<?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "12345678";
$dbName = "movieonline";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

//สร้างตัวแปร
//echo "<pre>";
//    print_r($_POST);
//echo "</pre>";
//exit();

// Set UTF8 character set
mysqli_query($conn, "SET NAMES UTF8");
$Order_number = $_POST['Order_number'];
$Cus_id = $_POST['txtCus_id'];
$Movie_id = $_POST['txtMovie_id'];
$Cinema_id = $_POST['txtCinema_id'];
$Showtime_id = $_POST['txtShowtime_id'];
$Showtime_date = $_POST['txtdate'];

$sessid = $_POST['sessid'];
$seats = $_POST['seats'];
$date = date("Y-m-d");

$sql = "
        INSERT INTO purchase_order
        (Order_number,Cus_id,Movie_id,Cinema_id,Purchase_date,Showtime_id)
        VALUES
        ('','$Cus_id','$Movie_id','$Cinema_id','$date','$Showtime_id')
    ";

mysqli_query($conn, $sql);
if (mysqli_affected_rows($conn)) {
    header("Location: index.php");
} else {
    echo "ไม่สามารถเพิ่มข้อมูลได้";
}

// Close database connection
mysqli_close($conn);

// (A) LOAD LIBRARY
require "2-reserve-lib.php";

// (B) SAVE
$_RSV->save($_POST["sessid"], $_POST["txtCus_id"], $_POST["seats"]);
echo "SAVED";
?>