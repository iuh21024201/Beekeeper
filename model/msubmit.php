<?php
session_start();
include_once("ketnoi.php");

$p = new clsketnoi();
$con = $p->moKetNoi();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = mysqli_real_escape_string($con, $_POST['message']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $day = date('Y-m-d');

    $sql = "INSERT INTO messages (ID_KhachHang, FeedBack, NgayFeedBack, TrangThai) 
                        VALUES ('$name', '$message', '$day', 0)";
    if (mysqli_query($con, $sql) === TRUE) {
        // Đặt thông báo thành công vào session và chuyển hướng
        $_SESSION['message'] = "Tin nhắn của bạn đã được gửi thành công!";
        header("Location: http://localhost/Beekeeper/view/customer/?action=lienhe");
        exit();
    } else {
        echo "Lỗi: " . $sql . "<br>" . mysqli_error($con);
    }
}

$p->dongKetNoi($con);
?>
