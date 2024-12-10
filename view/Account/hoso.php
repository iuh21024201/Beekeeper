<?php
include_once("../../controller/cNguoiDung.php");
$p = new controlNguoiDung();
$maND = $_SESSION['ID_TaiKhoan'] ?? null;

if ($maND === null) {
    echo "Người dùng chưa đăng nhập!";
} else {
    $kq = $p->getOneNguoiDung($maND);
    if (!$kq) {
        echo "No data!";
    } else {
        echo '<style>
        .card-container {
            width: 80%;
            margin: 20px auto;
            display: flex;
            align-items: center;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
            flex-shrink: 0;
        }
        .card-details {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .card-details div {
            font-size: 16px;
            color: #333;
        }
        .card-details div label {
            font-weight: bold;
            color: #4CAF50;
            margin-right: 8px;
        }
        .action-link {
            margin-top: 10px;
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }
        .action-link:hover {
            text-decoration: underline;
        }
    </style>';


        while ($r = mysqli_fetch_assoc($kq)) {
            echo "<div class='card-container'>";
            echo "<img src='../../asset/image/user.jpg' alt='Avatar' class='card-image'>"; // Đường dẫn tới ảnh đại diện mặc định
            echo "<div class='card-details'>";
            echo "<div><label>ID:</label> " . $r["ID_KhachHang"] . "</div>";
            echo "<div><label>Họ và tên:</label> " . $r["HoTen"] . "</div>";
            echo "<div><label>Số điện thoại:</label> " . $r["SoDienThoai"] . "</div>";
            echo "<div><label>Email:</label> " . $r["Email"] . "</div>";
            echo "<div><label>Địa chỉ:</label> " . $r["DiaChi"] . "</div>";
            echo "</div></div>";
        }
    }
}
?>
