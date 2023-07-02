<?php
session_start();

require 'database.php';
if (!isset($_SESSION["Cus_id"])) {
    header("Location: index.php");
}

$sql = "SELECT * FROM region";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ภูมิภาค</title>
</head>

<body style="background-color: #f5f7fb;">
    <br>
    <form action="#" method="post" class="form-horizontal">
        <div class="form-group">
            <div class="col-sm-3  control-label">
                Column region_name :
            </div>
            <div class="col-sm-3">
                <select name="test" class="form-control" required>
                    <option value="">-Choose-</option>

                    <?php foreach ($result as $results) {
                        ?>
                        <option value="<?php echo $results["Region_name"]; ?>">
                            <?php echo $results["Region_name"]; ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-1">
                <button type="submit" class="btn btn-primary"> submit </button>
            </div>
    </form>

    <button><a href="javascript:window.history.back(-1);">ย้อนกลับ</a></button>
    <button><a href="index.php">หน้าหลัก</a></button>

    <?php
    mysqli_close($con);
    ?>
</body>

</html>