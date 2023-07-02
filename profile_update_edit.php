<?php
session_start();

require 'database.php';
if (!isset($_SESSION["Cus_id"])) {
    header("Location: index.php");
}
$cus_id = $_SESSION["Cus_id"];
$cus_name = $_SESSION["cus_name"];
$cus_Address = $_SESSION["cus_address"];
$cus_Tel = $_SESSION["cus_tel"];
$cus_email = $_SESSION["cus_email"];


$sql = "UPDATE customers SET Cus_name = '" . $_POST["name"] . "',
Cus_address = '" . $_POST["address"] . "',
Cus_tel = '" . $_POST["tel"] . "',
Cus_email = '" . $_POST["email"] . "' WHERE Cus_id = $cus_id";

$result = mysqli_query($conn, $sql) or die("Error in query: $sql " . mysqli_error($conn));

if ($result) {
    echo "<script type='text/javascript'>";
    echo "alert('แก้ไขสำเร็จ! โปรดเข้าสู่ระบบอีกครั้ง');";
    echo "location = 'logout.php'; ";
    echo "</script>";
} else {
    echo "<script type='text/javascript'>";
    echo "alert('Error: Could not update information. Please try again.');";
    echo "location = 'profile.php'; ";
    echo "</script>";
}
?>