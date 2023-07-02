<?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "12345678";
$dbName = "mymovie2";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}
// Set UTF8 character set
mysqli_query($conn, "SET NAMES UTF8");

$Order_number = $_POST['Order_number'];
$Cus_id = $_POST['txtCus_id'];
$Movie_id = $_POST['txtMovie_id'];
$Cinema_id = $_POST['txtCinema_id'];


$sql = "
        INSERT INTO purchase_order+
        (Order_number,Cus_id,Movie_id,Cinema_id)
        VALUES
        ('','$Cus_id','$Movie_id','$Cinema_id')
    ";
mysqli_query($conn, $sql);
if (mysqli_affected_rows($conn)) {
    header("Location: index.php");
} else {
    echo "ไม่สามารถเพิ่มข้อมูลได้";
}

// Close database connection
mysqli_close($conn);
?>