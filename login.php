<?php
session_start();
if (isset($_SESSION["Cus_id"])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <?php
        if (isset($_POST["login"])) {
            $username = $_POST["Cus_email"];
            $password = $_POST["password"];
            require_once "database.php";
            $sql = "SELECT * FROM customers WHERE username = '$username'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $_SESSION['Cus_id'] = $row["Cus_id"];
            $_SESSION['Cus_name'] = $row["Cus_name"];
            $_SESSION['Cus_address'] = $row["Cus_address"];
            $_SESSION['Cus_tel'] = $row["Cus_tel"];
            $_SESSION['Cus_email'] = $row["Cus_email"];
            $_SESSION['username'] = $row["username"];

            if ($row) {
                if (password_verify($password, $row["password"])) {
                    session_start();
                    $row["Cus_id"];
                    header("Location: index.php");
                    die();
                } else {
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>username does not match</div>";
            }
        }
        ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="username" placeholder="Enter Username:" name="username" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div>
            <p>Not registered yet <a href="registration.php">Register Here</a></p>
        </div>
    </div>
</body>

</html>