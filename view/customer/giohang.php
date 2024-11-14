<?php
$isOrderPlaced = isset($_SESSION['isOrderPlaced']) ? $_SESSION['isOrderPlaced'] : false;

// Xử lý đơn hàng khi người dùng nhấn nút "Tiến hành thanh toán"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['placeOrder'])) {
    $_SESSION['order_address'] = $_POST['address'];
    $_SESSION['order_note'] = $_POST['note'];
    $_SESSION['order_store_id'] = $_POST['store_id'];
    $_SESSION['payment_method'] = $_POST['paymentMethod'];
    $_SESSION['isOrderPlaced'] = true;
    $isOrderPlaced = true;

    // Thông báo và chuyển hướng tùy thuộc vào phương thức thanh toán
    if ($_POST['paymentMethod'] === 'transfer') {
        echo "<script>
                alert('Đặt hàng thành công! Vui lòng chuyển sang trang thanh toán.');
                window.location.href = '?action=thanhtoan';
              </script>";
    } elseif ($_POST['paymentMethod'] === 'cash') {
        echo "<script>
                alert('Đặt hàng thành công! Bạn sẽ thanh toán bằng tiền mặt.');
                setTimeout(function(){ window.location.href = '?action=donhang'; }, 1000);
              </script>";
    }

    // Reset lại session để người dùng có thể đặt hàng lại
    session_unset();
    session_destroy();
    exit();
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
