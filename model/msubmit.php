<?php
session_start();
include_once("ketnoi.php");

$p = new clsketnoi();
$con = $p->moKetNoi();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $numberPhone = mysqli_real_escape_string($con, $_POST['numberPhone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);
    
    $sql = "INSERT INTO messages (name, numberPhone, email, message) VALUES ('$name', '$numberPhone', '$email', '$message')";

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
