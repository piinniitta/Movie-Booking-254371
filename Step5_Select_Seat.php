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

if (isset($_POST["txtMovie_name"])) {
  $txtMovie_name = $_POST["txtMovie_name"];
}


ini_set('display_errors', 1);
error_reporting(~0);
if (isset($_GET["theater_id"])) {
  $theater_id = $_GET["theater_id"];
}
// 2. เขียน SQL query
$sql = "SELECT *
FROM seats
WHERE theater_id = '" . $theater_id . "'
";

// 3. ส่งคำสั่ง SQL query
$result = mysqli_query($conn, $sql);

// 2. เขียน SQL query
$sql1 = "SELECT *
FROM theater
WHERE theater_id = '" . $theater_id . "'
";

// 3. ส่งคำสั่ง SQL query
$result1 = mysqli_query($conn, $sql1);
$result1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);

$sql2 = "SELECT *
FROM showtime
WHERE theater_id = '" . $theater_id . "'
";

// 3. ส่งคำสั่ง SQL query
$result2 = mysqli_query($conn, $sql2);
$result2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);


?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="css/Movie-Step.css">
  <link rel="stylesheet" href="css/seat.css">
  <title> เลือกเวลา </title>
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

  <div class="container-2">
    <div class="Pic_Movies">
      <!-- รูปภาพของภาพยนตร์แต่ละเรื่อง -->
      <div id="for_Pic_Movies" class="for_Pic_Movies">
        <img src="picture/<?php echo $_SESSION["Pic_Movies"]; ?>">
      </div>
    </div>

    <div class="detail">
      <!-- ชื่อของภาพยนตร์แต่ละเรื่อง -->
      <div id="for_Movie_name">
        <h3><strong>
            <?php echo $_SESSION["Movie_name"]; ?>
          </strong></h3>
      </div>
      <br>

      <!-- วันที่เข้าโรงภาพยนตร์ของภาพยนตร์แต่ละเรื่อง -->
      <div id="for_Movie_release_date" class="release_date">
        <p>วันที่เข้าฉาย: </p> &nbsp;
        <?php echo $sumdate = date("j M Y", strtotime($_SESSION["Movie_release_date"])); ?>
      </div>

      <div class="Genre_Period">
        <!-- ประเภทของภาพยนตร์แต่ละเรื่อง -->
        <div id="for_Genre_name" class="Genre_name">
          <p>ประเภทภาพยนตร์: </p> &nbsp;
          <?php echo $_SESSION["Genre_name"]; ?>
        </div>
        &nbsp; &nbsp; &nbsp;

        <div class="navrl-line"></div>

        <!-- ระยะเวลาในการเล่นของภาพยนตร์แต่ละเรื่อง -->
        <div id="for_Period">
          <img src="picture/clock.png" class="clock-img"> &nbsp;
          <?php echo $_SESSION["Period"]; ?> นาที
        </div>
      </div>
    </div>
    <br>

    <form id="myForm" method="POST" action="Step6_Booking_Information.php">
      <input type="hidden" name="txtCus_id" value="<?php echo $_SESSION['Cus_id']; ?>">
      <input type="hidden" name="txtMovie_id" value="<?php echo $_SESSION["Movie_id"]; ?>">
      <input type="hidden" name="txtshowtime_id" value="<?php echo $result1["showtime_id"]; ?>">
      <input type="hidden" name="txtshowtime_time" value="<?php echo $result2["Showtime_time"]; ?>">
      <input type="hidden" name="txttheater_id" value="<?php echo $result1["theater_id"]; ?>">
      <input type="hidden" name="txttheater_name" value="<?php echo $result1["theater_name"]; ?>">
      <input type="hidden" name="Cinema_id" value="<?php echo $_SESSION['Cinema_id'] ?>">
      <input type="hidden" name="selected_date1" value="<?php echo $_SESSION["selecteddate"]; ?>">
      <input type="hidden" name="selected_date2" value="<?php echo $_SESSION["selected_date"]; ?>">

      <input type="hidden" name="Movie_name" value="<?php echo $_SESSION["Movie_name"]; ?>">
      <input type="hidden" name="Pic_Movies" value="<?php echo $_SESSION["Pic_Movies"]; ?>">
      <input type="hidden" name="Movie_release_date" value="<?php echo $_SESSION["Movie_release_date"]; ?>">
      <input type="hidden" name="Genre_name" value="<?php echo $_SESSION["Genre_name"]; ?>">
      <input type="hidden" name="Period" value="<?php echo $_SESSION["Period"]; ?>">

      <div class="select_seat">
        <!-- โค้ดที่มาจากส่วนที่แสดงผลที่นั่ง -->
        <h3>เลือกที่นั่ง</h3> <br>
        <?php
        // 4. รับผลลัพธ์
        if (mysqli_num_rows($result) > 0) {

          // กำหนดค่าตัวแปรเริ่มต้น
          $counter = 0;
          // แสดงผลบนหน้าเว็บไซต์
          while ($row = mysqli_fetch_assoc($result)) {
            // กำหนด id ของแต่ละที่นั่งให้ตรงกับ seat_id ที่ได้จากฐานข้อมูล
            $is_booked = $row["is_booked"];
            $seat = $row["seat"];
            $seat_id = $row["seat_id"];

            if ($is_booked == 1) { // ถ้าที่นั่งถูกจองแล้ว
              echo "<div class='seat book' name='txtseat-book' id='$seat_id'>" . $seat . "</div>";
            } else { // ถ้าที่นั่งยังไม่ถูกจอง
              echo "<div required class='seat seat1'name='txtseat' id='$seat_id' onclick='bookSeat(\"$seat_id\")'>" . $seat . "</div>";
            }
            // เพิ่มค่าตัวแปร $counter ขึ้นทีละ 1
            $counter++;
            // ถ้าค่าของ $counter หาร 10 ลงตัวให้ขึ้นบรรทัดใหม่
            if ($counter % 10 == 0) {
              echo "<br>";
            }
          }
        } else {
          echo "0 results";
        }
        ?>

        <br>
        <p>จำนวนที่นั่ง : <span id="seats-selected" name="seats-selected">0</span></p>
        <p><span id="seats-select" hidden></span></p>
        <input type="hidden" name="txtselecseat[]" id="seats-select-input">

        <!-- เพิ่มปุ่มส่งข้อมูล -->
        <button class="btn btn-primary" type=button onClick="window.history.back()" name="previous"
          class="previous btn btn-default">ย้อนกลับ</button> &nbsp;
        <button type="submit" class="btn btn-primary">เลือก</button>
      </div>

      <br> <br>
      <div class='movie-title1'>
        <p>
        <div class='seat seat2'></div>ว่าง</p>
        <p>
        <div class='seat seat3'></div>จองแล้ว</p>
        <p>
        <div class='seat seat4'></div>กำลังเลือก</p>
      </div>
    </form>

    <?php
    // 5. ปิดการเชื่อมต่อ
    mysqli_close($conn);
    ?>
  </div>
</body>

<script>
  var seatsSelected = 0; // กำหนดค่าตัวแปรเริ่มต้นเป็น 0
  var bookedSeats = []; // สร้างตัวแปร array เพื่อเก็บข้อมูลที่นั่งที่ถูกจองไว้
  function bookSeat(seat_id) {
    var seat = document.getElementById(seat_id);

    if (seat.classList.contains("booked")) {
      seat.classList.remove("booked");
      seatsSelected--;

      // ลบข้อมูลที่นั่งที่ถูกเลือกออกจาก array bookedSeats
      var index = bookedSeats.indexOf(seat.id);
      if (index > -1) {
        bookedSeats.splice(index, 1);
      }

    } else {
      seat.classList.add("booked");
      seatsSelected++;

      // เพิ่มข้อมูลที่นั่งที่ถูกเลือกเข้าไปใน array bookedSeats
      bookedSeats.push(seat.id);
    }

    document.getElementById("seats-selected").innerHTML = seatsSelected;
    console.log(bookedSeats); // แสดงข้อมูลที่นั่งที่ถูกจองไว้ใน console เพื่อตรวจสอบ
    document.getElementById("seats-select").innerHTML = bookedSeats;
    // ตัวอย่างการเก็บข้อมูลที่อยู่ใน span เข้าไปใน input
    const seatsSelectSpan = document.getElementById('seats-select');
    const seatsSelectInput = document.getElementById('seats-select-input');
    seatsSelectInput.value = seatsSelectSpan.innerText.split(',');

  }

</script>

</html>