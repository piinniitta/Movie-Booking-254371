<?php
session_start();

require 'database.php';
if (!isset($_SESSION["Cus_id"])) {
    header("Location: index.php");
}

$customer_id = $_SESSION['Cus_id'];
$sql = "SELECT * FROM purchase_order
    inner join movies on purchase_order.Movie_id = movies.Movie_id
    inner join promotion on purchase_order.Promotion_id = promotion.Promotion_id
    inner join cinema_branch on purchase_order.Cinema_id = cinema_branch.Cinema_id
    inner join customers on purchase_order.Cus_id = customers.Cus_id
    WHERE customers.Cus_id = '$customer_id'";
$query = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบสั่งซื้อ</title>
</head>

<body style="background-color: #f5f7fb;">
    <table border="1">
        <tr class="colortr">
            <th>
                <div>เลขออเดอร์</div>
            </th>
            <th>
                <div>รหัสลูกค้า</div>
            </th>
            <th>
                <div>รหัสภาพยนต์</div>
            </th>
            <th>
                <div>รหัสโรงภาพยนต์</div>
            </th>
            <th>
                <div>รหัสโปรโมชั่น</div>
            </th>
            <th>
                <div>จำนวนตั๋ว</div>
            </th>
            <th>
                <div>ราคารวม</div>
            </th>
            <th>
                <div>วันที่ซื้อ</div>
            </th>
        </tr>

        <?php
        while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            ?>
            <tr>
                <td>
                    <?php echo $result["Order_number"]; ?>
                </td>
                <td>
                    <?php echo $result["Cus_id"]; ?>
                </td>
                <td>
                    <?php echo $result["Movie_name"]; ?>
                </td>
                <td>
                    <?php echo $result["Cinema_name"]; ?>
                </td>
                <td>
                    <?php echo $result["Promotion_name"]; ?>
                </td>
                <td>
                    <?php echo $result["Quantity_ticket"]; ?>
                </td>
                <td>
                    <?php echo $result["Total_price"]; ?>
                </td>
                <td>
                    <?php echo $result["Purchase_date"]; ?>
                </td>
            </tr><br />
            <?php
        }
        ?>
    </table>
    <?php
    mysqli_close($conn);
    ?>
    <br /> <br />

    <button><a href="javascript:window.history.back(-1);">ย้อนกลับ</a></button>
    <button><a href="index.php">หน้าหลัก</a></button>
</body>

</html>