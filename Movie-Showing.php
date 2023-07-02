<?php
session_start();

require 'database.php';
if (!isset($_SESSION["Cus_id"])) {
    header("Location: login.php");
}

$today = date('Y-m-d');
$sql1 = "SELECT *
    FROM movies
    INNER JOIN movie_genre
    ON movies.Genre_id = movie_genre.Genre_id
    WHERE (Movie_id LIKE '%" . $_GET["txtKeyword"] . "%') AND (Movie_leaving_date >= '$today' )
    ORDER BY Movie_release_date ASC"; // เพิ่มเงื่อนไขวันที่แสดงและจัดเรียงตามวันที่
$query1 = mysqli_query($conn, $sql1);

$sql2 = "SELECT *
    FROM movies
    INNER JOIN movie_genre
    ON movies.Genre_id = movie_genre.Genre_id
    WHERE (Movie_id LIKE '%" . $_GET["txtKeyword"] . "%') AND (Movie_release_date > '$today')
    ORDER BY Movie_release_date ASC"; // เพิ่มเงื่อนไขวันที่แสดงและจัดเรียงตามวันที่
$query2 = mysqli_query($conn, $sql2);

$sql3 = "SELECT *
    FROM customers
    WHERE (Cus_id LIKE '%" . $_GET["txtKeyword"] . "%')";
$result3 = mysqli_query($conn, $sql3);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <link rel="stylesheet" href="css/index.css">
    <title>หน้าหลัก</title>

</head>

<body>
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
                    <li><a href="Movie-Showing.php"> ภาพยนตร์ </a></li>
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

    <!--เลือกดูหนัง กำลังฉาย-->
    <div class="show-program">
        <h2>
            <a href="Movie-Showing.php" style="text-decoration: none; color: rgb(0, 0, 0); float: left;">
                <strong>กำลังฉาย</strong>
            </a>
        </h2>
        <h2>
            <a href="Movie-Coming.php" style="text-decoration: none; color: rgb(0, 0, 0, 0.2); margin:0 30px;"
                onmouseover="this.style.color='rgb(0, 0, 0)'" onmouseout="this.style.color='rgb(0, 0, 0, 0.2)'">
                <strong>โปรแกรมหน้า</strong>
            </a>
        </h2>
    </div>

    <div class="container">
        <div class="box-personalized">
            <div class="row" style="display: flex;">
                <div class="col-md-12">
                    <div class="carousel-inner">
                        <div class="items">
                            <?php
                            $i = 1;
                            $next_item = true;
                            while ($result = mysqli_fetch_array($query1, MYSQLI_ASSOC)) {
                                if ($i == 1) {
                                    echo '<div class="item active" style="display: flex;">';
                                } elseif ($next_item == true) {
                                    echo '<div class="item" style="display: flex;">';
                                }
                                ?>

                                <div class="ml-box">
                                    <div class="mlb-cover">
                                        <img src="picture/<?php echo $result["Pic_Movies"]; ?>">
                                    </div>

                                    <div class="mlb-date">
                                        <?php echo $sumdate = date("j M Y", strtotime($result["Movie_release_date"]));
                                        ; ?>
                                    </div>

                                    <div class="mlb-name" style="width: 250px;">
                                        <?php echo $result["Movie_name"]; ?>
                                    </div>

                                    <div class="mlb-genres">
                                        <div class="genres_span">
                                            <?php echo $result["Genre_name"]; ?></br>
                                        </div>
                                        <div class="genres_span">
                                            <?php echo $result["Period"]; ?> นาที </br>
                                        </div>
                                    </div>

                                    <div class="mlb-seemore">
                                        <a href='Step1_Select_Movie.php? Movie_id=<?php echo $result["Movie_id"]; ?>' ;>
                                            ดูเพิ่มเติม </a></br>
                                    </div>
                                </div>

                                <?php
                                $next_item = false;
                                if ($i % 5 == 0) {
                                    echo '</div>';
                                    $next_item = true;
                                }
                                $i++;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--สิ้นสุดเลือกดูหนัง กำลังฉาย-->
    <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>

    <!-- partial -->
    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
    <script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
    <script src="index.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <?php
    mysqli_close($conn);
    ?>
</body>

</html>