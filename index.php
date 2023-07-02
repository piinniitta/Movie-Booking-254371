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

    <!--โฆษณา-->
    <section class="box-slider">
        <div class="container" style="width:100%;max-width:100%;padding-left:0px;padding-right:0px">
            <div class="blogbanner">
                <div id="bigslider" class="royalSlider">
                    <div class="rsOverflow grab-cursor">
                        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active" data-bs-interval="10000">
                                    <img src="https://www.taokaecafe.com/asp-bin/pic_taokae/sl_19113938.jpg"
                                        class="d-block w-100" alt="..." style="width: 1519px; height: 280px;">
                                </div>
                                <div class="carousel-item" data-bs-interval="2000">
                                    <img src="https://www.taokaecafe.com/asp-bin/pic_taokae/sl_19113938.jpg"
                                        class="d-block w-100" alt="..." style="width: 1519px; height: 280px;">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://www.taokaecafe.com/asp-bin/pic_taokae/sl_19113938.jpg"
                                        class="d-block w-100" alt="..." style="width: 1519px; height: 280px;">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    <!--สิ้นสุดโฆษณา-->
    <br> <br>

    <!--เลือกดูหนัง กำลังฉาย-->
    <h2 class="show-program"><strong>กำลังฉาย</strong></h2>
    <div class="container">
        <div class="box-personalized">
            <div class="row">
                <div class="col-md-12">
                    <div class="carousel slide multi-item-carousel" id="theCarousel">
                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="slick-slider">
                                    <div class="multiple-items">

                                        <?php
                                        while ($result = mysqli_fetch_array($query1, MYSQLI_ASSOC)) {
                                            ?>

                                            <div class="ml-box">
                                                <div class="mlb-cover">
                                                    <img src="picture/<?php echo $result["Pic_Movies"]; ?>">
                                                </div>

                                                <div class="mlb-date">
                                                    <?php echo $sumdate = date("j M Y", strtotime($result["Movie_release_date"]));
                                                    ; ?>
                                                </div>

                                                <div class="mlb-name">
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
                                                    <a href='Step1_Select_Movie.php? Movie_id=<?php echo $result["Movie_id"]; ?>'
                                                        ;> ดูเพิ่มเติม </a></br>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--สิ้นสุดเลือกดูหนัง กำลังฉาย-->
    <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>

    <!--โปรแกรมหน้า-->
    <h2 class="show-program"><strong>โปรแกรมหน้า</strong></h2>
    <div class="container">
        <div class="box-personalized">
            <div class="row">
                <div class="col-md-12">
                    <div class="carousel slide multi-item-carousel" id="theCarousel">
                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="slick-slider">
                                    <div class="multiple-items">

                                        <?php
                                        while ($result = mysqli_fetch_array($query2, MYSQLI_ASSOC)) {
                                            ?>

                                            <div class="ml-box">
                                                <div class="mlb-cover">
                                                    <img src="picture/<?php echo $result["Pic_Movies"]; ?>">
                                                </div>

                                                <div class="mlb-date">
                                                    <?php echo $sumdate = date("j M Y", strtotime($result["Movie_release_date"]));
                                                    ; ?>
                                                </div>

                                                <div class="mlb-name">
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
                                                    <a href='Movie2.php? Movie_id=<?php echo $result["Movie_id"]; ?>'
                                                        ;>ดูเพิ่มเติม</a></br>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--สิ้นสุดโปรแกรมหน้า-->

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