<?php
include_once('../../model/ketnoi.php');
$p = new clsketnoi();
$con = $p->moKetNoi(); 
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch làm việc 7 ngày</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .calendar {
            width: 1000px;
            height: 700px;
            background-color: white;
            border: 1px solid #ddd;
            display: grid;
            grid-template-columns: 100px repeat(7, 1fr);
            grid-template-rows: repeat(13, 50px);
            position: relative;
        }

        .time-slot, .day {
            border-right: 1px solid #e0e0e0;
            border-left: 1px solid #e0e0e0;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
        }

        .time-slot {
            background-color: #f9f9f9;
            color: #333;
        }

        .day-header {
            background-color: #f4f4f4;
            border-bottom: 1px solid #e0e0e0;
            border-left: 1px solid #e0e0e0;
            text-align: center;
            padding: 5px;
            font-weight: bold;
            grid-row: 1;
        }

        /* CSS cho các thời gian của ca A */
        .time-slot-ca-a {
            background-color: #28a745; /* Màu xanh cho ca A */
        }

        /* CSS cho các thời gian của ca B */
        .time-slot-ca-b {
            background-color: #007bff; /* Màu xanh dương cho ca B */
        }
    </style>
</head>
<body>

<div class="calendar">
    <!-- Cột thời gian -->
    <div class="time-slot" style="grid-row: 2;">08:00</div>
    <div class="time-slot" style="grid-row: 3;">09:00</div>
    <div class="time-slot" style="grid-row: 4;">10:00</div>
    <div class="time-slot" style="grid-row: 5;">11:00</div>
    <div class="time-slot" style="grid-row: 6;">12:00</div>
    <div class="time-slot" style="grid-row: 7;">13:00</div>
    <div class="time-slot" style="grid-row: 8;">14:00</div>
    <div class="time-slot" style="grid-row: 9;">15:00</div>
    <div class="time-slot" style="grid-row: 10;">16:00</div>
    <div class="time-slot" style="grid-row: 11;">17:00</div>
    <div class="time-slot" style="grid-row: 12;">18:00</div>
    <div class="time-slot" style="grid-row: 13;">19:00</div>
    <div class="time-slot" style="grid-row: 14;">20:00</div>

    <!-- Cột cho các ngày trong tuần -->
    <?php
    // Tính toán ngày đầu tuần (Thứ Hai) và các ngày còn lại
    $monday = strtotime('last Monday', strtotime('tomorrow'));
    $daysOfWeek = [];
    for ($i = 0; $i < 7; $i++) {
        $daysOfWeek[] = date('d/m', strtotime("+$i day", $monday));
    }
    ?>

    <div class="day-header" style="grid-column: 1;"></div>
    <div class="day-header" style="grid-column: 2;">Thứ hai<br><?php echo $daysOfWeek[0]; ?></div>
    <div class="day-header" style="grid-column: 3;">Thứ ba<br><?php echo $daysOfWeek[1]; ?></div>
    <div class="day-header" style="grid-column: 4;">Thứ tư<br><?php echo $daysOfWeek[2]; ?></div>
    <div class="day-header" style="grid-column: 5;">Thứ năm<br><?php echo $daysOfWeek[3]; ?></div>
    <div class="day-header" style="grid-column: 6;">Thứ sáu<br><?php echo $daysOfWeek[4]; ?></div>
    <div class="day-header" style="grid-column: 7;">Thứ bảy<br><?php echo $daysOfWeek[5]; ?></div>
    <div class="day-header" style="grid-column: 8;">Chủ nhật<br><?php echo $daysOfWeek[6]; ?></div>

    <!-- Các ô trống cho các ngày -->
    <?php for ($i = 2; $i <= 8; $i++): ?>
        <?php for ($j = 2; $j <= 14; $j++): ?>
            <div class="day" style="grid-column: <?= $i ?>; grid-row: <?= $j ?>;"></div>
        <?php endfor; ?>
    <?php endfor; ?>

    <!-- Kết nối cơ sở dữ liệu và hiển thị sự kiện -->
    <?php
    // Truy vấn sự kiện cho từng ngày
    $events = [];
    foreach ($daysOfWeek as $day) {
        // Truy vấn dữ liệu từ bảng chamcong
        $sql = "SELECT Checkin, Checkout, TenCa, SoGioLam, TrangThai FROM chamcong WHERE NgayChamCong = '$day'";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            // Kiểm tra nếu là ca A hoặc ca B và thêm lớp tương ứng
            $timeSlotClass = '';
            if ($row['TenCa'] == 'Ca A') {
                $timeSlotClass = 'time-slot-ca-a'; // Ca A: màu xanh
            } elseif ($row['TenCa'] == 'Ca B') {
                $timeSlotClass = 'time-slot-ca-b'; // Ca B: màu xanh dương
            }

            // Hiển thị sự kiện với lớp thời gian tương ứng
            echo "<div class='time-slot $timeSlotClass' style='grid-column: 2;'>". $row['Checkin'] . "</div>"; // Bạn có thể hiển thị thời gian check-in hoặc thông tin khác tại đây
        }
    }
    ?>
</div>

</body>
</html>
