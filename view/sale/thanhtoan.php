<?php
session_start();


include_once("../../controller/cNguoiDung.php");
include_once("../../controller/c_lay_nhan_vien.php");
$controlNguoiDung = new controlNguoiDung();

// Lấy store_id của nhân viên từ cơ sở dữ liệu nếu chưa có trong session
if (!isset($_SESSION['store_id'])) {
    if (isset($_SESSION['idTaiKhoan'])) {
        $storeId = $controlNguoiDung->getSaleIdByAccountId($_SESSION['idTaiKhoan']);
        if ($storeId) {
            $_SESSION['store_id'] = $storeId;
        } else {
            echo "<script>alert('Không tìm thấy cửa hàng của nhân viên.');</script>";
            exit;
        }
    } else {
        echo "<script>alert('Bạn cần đăng nhập để thực hiện đặt hàng.');</script>";
        exit;
    }
}

// Kiểm tra phương thức POST và nút Thanh Toán
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['placeOrder'])) {
    include_once("../../controller/cDonHang.php");
    include_once("../../controller/cChiTietDonHang.php");

    $donHang = new controlDonHang();
    $chiTietDonHang = new controlCTDonHang();

    // Thu thập thông tin từ form
    $idCH = intval($_POST['store_id'] ?? 0); // Sử dụng store_id từ POST
    $diachi = htmlspecialchars($_POST['address'] ?? '', ENT_QUOTES, 'UTF-8');
    $note = htmlspecialchars($_POST['note'] ?? '', ENT_QUOTES, 'UTF-8');
    $phuongthucthanhtoan = ($_POST['paymentMethod'] ?? 'cash') === 'cash' ? 0 : 1;
    $trangthai = 'Đặt thành công';
    $ngaydat = date('Y-m-d H:i:s');

    // Kiểm tra dữ liệu hợp lệ
    if (empty($idCH) || empty($diachi)) {
        echo "<script>alert('Vui lòng chọn cửa hàng và nhập địa chỉ giao hàng.');</script>";
        exit;
    }

    if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        echo "<script>alert('Giỏ hàng của bạn đang trống.');</script>";
        exit;
    }

    // Tạo đơn hàng
    $idDonHang = $donHang->insertDH($idCH, $_SESSION['ID_NhanVien'], $ngaydat, $diachi, $trangthai, $phuongthucthanhtoan);

    if ($idDonHang) {
        // Thêm từng sản phẩm vào chi tiết đơn hàng
        foreach ($_SESSION['cart'] as $cartItem) {
            $idMonAn = intval($cartItem['id']);
            $soLuong = intval($cartItem['quantity']);
            $ghichu = $note;

            if ($soLuong > 0) {
                $chiTietDonHang->insertCTDH($idDonHang, $idMonAn, $soLuong, $ghichu);
            }
        }

        // Xóa giỏ hàng sau khi đặt thành công
        unset($_SESSION['cart']);

        // Điều hướng sau khi đặt hàng
        if ($phuongthucthanhtoan === 0) {
            echo "<script>
                    alert('Đặt hàng thành công! Bạn sẽ thanh toán bằng tiền mặt.');
                    window.location.href = 'index.php?action=donhang';
                  </script>";
        } else {
            echo "<script>
                    alert('Đặt hàng thành công! Vui lòng thực hiện thanh toán chuyển khoản.');
                    window.location.href = 'index.php?action=thanhtoan&idDonHang=$idDonHang';
                  </script>";
        }
        exit;
    } else {
        echo "<script>alert('Đặt hàng thất bại. Vui lòng thử lại.');</script>";
    }
}



?>
<div class="checkout-section">
    <form method="POST" action="thanhtoan.php">
        <input type="hidden" name="store_id" value="1"> <!-- Thay 1 bằng giá trị ID cửa hàng thực tế -->
        <input type="hidden" name="address" value="Ăn tại quán"> <!-- Sửa địa chỉ mặc định -->
        <div>
            <label for="note" style="font-weight: bold;">Ghi chú:</label>
            <textarea id="note" name="note" placeholder="Nhập ghi chú (nếu có)"></textarea>
        </div>
        <div>
            <label>
                <input type="radio" name="paymentMethod" value="cash" checked> Tiền mặt
            </label>
            <label>
                <input type="radio" name="paymentMethod" value="transfer"> Chuyển khoản
            </label>
        </div>
        <button type="submit" name="placeOrder" class="checkout">Thanh Toán</button>
    </form>
</div>