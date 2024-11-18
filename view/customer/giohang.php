<?php
<<<<<<< HEAD
$idTaiKhoan=isset($_SESSION["ID_TaiKhoan"]) ? intval($_SESSION["ID_TaiKhoan"]) : 0; 
$isOrderPlaced = isset($_SESSION['isOrderPlaced']) ? $_SESSION['isOrderPlaced'] : false;

// Xử lý đơn hàng khi người dùng nhấn nút "Tiến hành thanh toán"
=======
>>>>>>> eb8bc861c255231318d6f17e98cf9db2bd99bd55
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['placeOrder'])) {
    include_once("../../controller/cDonHang.php");
    include_once("../../controller/cNguoiDung.php");
    include_once("../../controller/cChiTietDonHang.php");

<<<<<<< HEAD
    // Thông báo và chuyển hướng tùy thuộc vào phương thức thanh toán
    if ($_POST['paymentMethod'] === 'transfer') {
        echo "<script>
                alert('Đặt hàng thành công! Vui lòng chuyển sang trang thanh toán.');
                window.location.href = '?action=thanhtoan';
              </script>";
    } elseif ($_POST['paymentMethod'] === 'cash') {
        echo "<script>
                alert('Đặt hàng thành công! Bạn sẽ thanh toán bằng tiền mặt.');
                 header('Location: ?action=donhang');
                exit();
              </script>";
=======
    $donHang = new controlDonHang();
    $controlNguoiDung = new controlNguoiDung();
    $chiTietDonHang = new controlCTDonHang();

    // Kiểm tra đăng nhập
    if (!isset($_SESSION['ID_TaiKhoan'])) {
        echo "<script>alert('Bạn cần đăng nhập để thực hiện đặt hàng.');</script>";
        exit;
>>>>>>> eb8bc861c255231318d6f17e98cf9db2bd99bd55
    }

    $idTaiKhoan = $_SESSION['ID_TaiKhoan'];
    $idKH = $controlNguoiDung->getCustomerIdByAccountId($idTaiKhoan);

    if (!$idKH) {
        echo "<script>alert('Không tìm thấy khách hàng tương ứng với tài khoản này.');</script>";
        exit;
    }

    // Thông tin đơn hàng từ form
    $idCH = $_POST['store_id'];
    $ngaydat = date('Y-m-d H:i:s');
    $diachi = htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8');
    $note = htmlspecialchars($_POST['note'], ENT_QUOTES, 'UTF-8'); // Lấy ghi chú từ form
    $phuongthucthanhtoan = ($_POST['paymentMethod'] === 'cash') ? 0 : 1;
    $trangthai = $phuongthucthanhtoan === 0 ? 'Đặt thành công và thu tiền mặt' : 'Đặt thành công và chuyển khoản';

    // Thêm đơn hàng và lấy ID_DonHang
    $idDonHang = $donHang->insertDH($idCH, $idKH, $ngaydat, $diachi, $trangthai, $phuongthucthanhtoan);

    if ($idDonHang) {
        // Chèn chi tiết đơn hàng từ giỏ hàng
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $cartItem) {
                $idMonAn = $cartItem['id']; // ID món ăn
                $soLuong = $cartItem['quantity']; // Số lượng
                $ghichu = $note; // Lấy ghi chú từ form và áp dụng cho từng món ăn

                // Chèn chi tiết đơn hàng vào cơ sở dữ liệu
                if (!empty($idMonAn) && is_numeric($idMonAn) && $soLuong > 0) {
                    $chiTietDonHang->insertCTDH($idDonHang, $idMonAn, $soLuong, $ghichu); // Ghi chú chung cho toàn bộ đơn hàng
                }
            }
        }

        // Thông báo thành công
        if ($phuongthucthanhtoan === 0) {
            echo "<script>
                    alert('Đặt hàng thành công! Bạn sẽ thanh toán bằng tiền mặt.');
                    window.location.href = 'index.php?action=donhang';
                  </script>";
        } else {
            echo "<script>
                    alert('Đặt hàng thành công! Vui lòng chuyển sang trang thanh toán.');
                    window.location.href = 'index.php?action=thanhtoan';
                  </script>";
        }

        unset($_SESSION['cart']); // Xóa giỏ hàng sau khi đặt
        exit;
    } else {
        echo "<script>alert('Đặt hàng thất bại. Vui lòng thử lại.');</script>";
    }
}

include_once("../../controller/cCuaHang.php");
$p = new cCuaHang();
$stores = $p->getAllStore();
?>

<div class= "giohang">
    <h2>Giỏ hàng</h2>
    <?php include_once("../../view/customer/add_to_cart.php"); ?>

    <!-- Nút đặt hàng -->
    <button class="order-btn" onclick="showOrderForm()" style="display: <?= $isOrderPlaced ? 'none' : 'block' ?>;">Đặt Hàng</button>

    <!-- Form nhập thông tin đơn hàng -->
    <div id="form" style="display: <?= $isOrderPlaced ? 'none' : 'none' ?>;">
        <div id="orderForm">
            <h4>NHẬP THÔNG TIN ĐẶT HÀNG</h4>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Chọn cửa hàng:</label>
                    <select name="store_id" required>
                        <option value="">Chọn cửa hàng</option>
                        <?php while ($store = mysqli_fetch_assoc($stores)) : ?>
                            <option value="<?= $store['ID_CuaHang'] ?>"><?= htmlspecialchars($store['TenCuaHang']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Giao hàng tới địa chỉ:</label>
                    <input type="text" name="address" required>
                </div>
                <div class="form-group">
                    <label>Ghi chú:</label>
                    <input type="text" name="note">
                </div>
                <div class="form-group">
                    <label>Chọn phương thức thanh toán:</label>
                    <input type="radio" name="paymentMethod" value="cash" checked> Tiền mặt khi nhận hàng<br>
                    <input type="radio" name="paymentMethod" value="transfer"> Chuyển khoản<br>
                </div>
                <div class="form-group">
                    <button class="btn-thanhtoan" type="submit" name="placeOrder">Tiến hành thanh toán</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Hiển thị form đặt hàng khi nhấn nút "Đặt Hàng"
        function showOrderForm() {
            document.getElementById("form").style.display = "block";
            document.querySelector(".order-btn").style.display = "none";
        }

        // Ẩn nút "Đặt Hàng" khi trang tải nếu giỏ hàng trống
        document.addEventListener('DOMContentLoaded', function() {
            const cartItems = document.querySelectorAll('.cart-item');
            const orderButton = document.querySelector('.order-btn');
            
            if (cartItems.length === 0 && orderButton) {
                orderButton.style.display = 'none'; // Ẩn nút "Đặt Hàng" nếu giỏ hàng trống
            }
        });
    </script>

