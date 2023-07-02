<?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "12345678";
$dbName = "movieonline";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}
// Set UTF8 character set
mysqli_query($conn, "SET NAMES UTF8");

$Cus_id = $_POST['txtCus_id'];
$Promotion_id = $_POST['txtPromotion_id'];

// Check if the promotion has already been added for this customer
$sql_check = "
        SELECT COUNT(*) AS cnt
        FROM customer_promotion
        WHERE Cus_id = '$Cus_id' AND Promotion_id = '$Promotion_id'
    ";
$result_check = mysqli_query($conn, $sql_check);
$row_check = mysqli_fetch_assoc($result_check);
$count = $row_check['cnt'];

if ($count > 0) {
    // Promotion already added for this customer

    echo "<script type='text/javascript'>";
    echo "alert('คุณเก็บโปรโมชั่นนี้ไปแล้ว');";
    echo "window.location = 'promotion.php'; ";
    echo "</script>";

} else {
    // Insert new record
    $sql = "
            INSERT INTO customer_promotion
            (Cus_id, Promotion_id)
            VALUES
            ('$Cus_id', '$Promotion_id')
        ";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn)) {
        // Success
        echo "<script type='text/javascript'>";
        echo "alert('เก็บโปรโมชั่นสำเร็จ');";
        echo "window.location = 'promotion.php'; ";
        echo "</script>";
    } else {
        // Error
        echo "ไม่สามารถเพิ่มข้อมูลได้";
    }
}

// Close database connection
mysqli_close($conn);
?>