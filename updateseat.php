<?php
session_start();
// 1. ติดต่อฐานข้อมูล
$servername = "localhost"; // ชื่อเซิร์ฟเวอร์
$username = "root"; // ชื่อผู้ใช้ฐานข้อมูล
$password = "12345678"; // รหัสผ่านฐานข้อมูล
$dbname = "movieonline"; // ชื่อฐานข้อมูล

$conn = mysqli_connect($servername, $username, $password, $dbname);
// เช็คการเชื่อมต่อฐานข้อมูล
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
date_default_timezone_set('Asia/Bangkok');

if (isset($_POST["seats_str"])) {
    $seats_str = $_POST["seats_str"];
    $seats_arr = array_map(function ($seat) {
        return explode(',', $seat); }, explode('|', $seats_str));

    foreach ($seats_arr as $seats) {
        foreach ($seats as $seat) {
            // 2. ใช้คำสั่ง SQL UPDATE เพื่ออัพเดทข้อมูลในฐานข้อมูล
            $sql = "UPDATE seats SET is_booked = 1 WHERE seat_id = '$seat'";
            mysqli_query($conn, $sql);
        }
    }
}
$Cus_id = $_POST["Cus_id"];
$Movie_id = $_POST["Movie_id"];
$Cinema_id = $_POST["Cinema_id"];
$selected_date1 = $_POST["selected_date1"];
$showtime_id = $_POST["showtime_id"];
$theater_id = $_POST["theater_id"];
$seats = $_POST["seats_str"];
$count = $_POST["count"];
$promotion_id = $_POST["promotion_id"];
$Price = $_POST["Price"];
$date = date('Y-m-d H:i:s');

// เพิ่มข้อมูลลงฐานข้อมูล
$sql = "
    INSERT INTO purchase_order
        (Order_number,Cus_id,Movie_id,Cinema_id,date_id,Showtime_id,theater_id,Seat_id,Promotion_id,Quantity_ticket,Total_price,Purchase_date)
        VALUES
        ('','$Cus_id','$Movie_id','$Cinema_id','$selected_date1','$showtime_id','$theater_id','$seats','$promotion_id','$count','$Price','$date')
";

mysqli_query($conn, $sql);
if (mysqli_affected_rows($conn)) {
    echo "<script type='text/javascript'>";
    echo "alert('จองสำเร็จ');";
    echo "location = 'E-ticket.php'; ";
    echo "</script>";
} else {
    echo "<script>alert('จองไม่สำเร็จ');</script>";
}
// 5. ปิดการเชื่อมต่อ
mysqli_close($conn);
?>