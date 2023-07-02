<?php
session_start();

require 'database.php';
require "2-reserve-lib.php";
if (!isset($_SESSION["Cus_id"])) {
    header("Location: index.php");
}

ini_set('display_errors', 1);
error_reporting(~0);
if (isset($_GET["Moviename"])) {
    $Moviename = $_GET["Moviename"];
}

$val = $_GET["value"];
$val_M = mysqli_real_escape_string($conn, $val);

$sql = "SELECT Region_id,Cinema_name,Cinema_id
FROM cinema_branch
WHERE Region_id= '$val_M'";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    echo "<select>";

    while ($rows = mysqli_fetch_assoc($result)) {
        echo "<option>" . $rows["Cinema_name"] . "</option>";
    }
    echo "</select>";
} else {
    echo "<select>
    <option>-เลือกโรงภาพยนตร์-</option>
    </select>";
}
?>