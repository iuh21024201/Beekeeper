<?php
session_start();
include_once("../../controller/c_lay_nhan_vien.php");
include_once("../../controller/cDonHang.php");
include_once("../../controller/cChiTietDonHang.php");

$pNhanVien = new cNhanVien();
$donHang = new controlDonHang();
$chiTietDonHang = new controlCTDonHang();

$idTaiKhoan = $_SESSION['ID_TaiKhoan'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['placeOrder'])) {
    // Kiểm tra giỏ hàng
    if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        echo "<script>alert('Giỏ hàng trống, không thể thanh toán.'); window.history.back();</script>";
        exit;
    }

    // Kiểm tra thông tin người dùng
    if ($idTaiKhoan !== null) {
        $kq = $pNhanVien->get01NhanVien($idTaiKhoan);
        if ($kq && $row = mysqli_fetch_assoc($kq)) {
            $idCH = intval($row['ID_CuaHang']);
            $idNV = intval($row['ID_NhanVien']);
        } else {
            echo "<script>alert('Không tìm thấy thông tin nhân viên. Vui lòng đăng nhập lại.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Người dùng chưa đăng nhập.'); window.history.back();</script>";
        exit;
    }

    // Thiết lập thông tin đơn hàng
    $diachi = 'Ăn tại quầy';
    $note = htmlspecialchars($_POST['note'] ?? '', ENT_QUOTES, 'UTF-8');
    $phuongthucthanhtoan = ($_POST['paymentMethod'] ?? 'cash') === 'cash' ? 0 : 1;
    $trangthai = 'Đặt thành công';
    $ngaydat = date('Y-m-d H:i:s');
    $idKH = null;

    // Tạo đơn hàng
    $idDonHang = $donHang->insertDHNV($idCH, $idKH, $idNV, $ngaydat, $diachi, $trangthai, $phuongthucthanhtoan);

    if ($idDonHang) {
        // Chèn chi tiết đơn hàng từ giỏ hàng
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $cartItem) {
                $idMonAn = $cartItem['id']; // ID món ăn
                $soLuong = $cartItem['quantity']; // Số lượng
                $ghichu = isset($cartItem['note']) ? $cartItem['note'] : $note; // Ghi chú riêng hoặc chung

                // Chèn chi tiết đơn hàng vào cơ sở dữ liệu
                if (!empty($idMonAn) && is_numeric($idMonAn) && $soLuong > 0) {
                    $result = $chiTietDonHang->insertCTDHNV($idDonHang, $idMonAn, $soLuong, $ghichu);

                    if (!$result) {
                        echo "<script>alert('Có lỗi xảy ra khi thêm chi tiết đơn hàng.'); window.history.back();</script>";
                        exit;
                    }
                }
            }
        }

        // Xóa giỏ hàng sau khi đặt hàng thành công
        unset($_SESSION['cart']);
        $redirectPage = $phuongthucthanhtoan === 0 ? 'index.php?action=donhang' : "index.php?action=thanhtoan&idDonHang=$idDonHang";
        echo "<script>alert('Tạo đơn hàng thành công!'); window.location.href = '$redirectPage';</script>";
    } else {
        echo "<script>alert('Đặt hàng thất bại, vui lòng thử lại.'); window.history.back();</script>";
    }
}
?>
