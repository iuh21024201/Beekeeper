<?php
$isOrderPlaced = $_SERVER["REQUEST_METHOD"] == "POST"; // Kiểm tra xem đơn hàng đã được gửi hay chưa

if ($isOrderPlaced && isset($_POST['paymentMethod'])) {
    $paymentMethod = $_POST['paymentMethod'];
    
    // Kiểm tra phương thức thanh toán
    if ($paymentMethod === "cash") {
        echo "<script>alert('Đặt hàng thành công! Bạn sẽ thanh toán bằng tiền mặt.');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'menu.php'; }, 1000);</script>"; 
    } elseif ($paymentMethod === "transfer") {
        header("Location: thanhtoan.php"); 
        exit();
    }
}
?>
<div class= "giohang">
    <h2>Giỏ hàng</h2>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá(VND)</th>
                <th>Tổng tiền(VND)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <button class="order-btn" onclick="showOrderForm()">Đặt Hàng</button>

    <div id="form">
        <div id="orderForm">
            <h4>NHẬP THÔNG TIN ĐẶT HÀNG</h4>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Địa chỉ giao hàng:</label>
                    <input type="text" name="address" required>
                </div>
                <div class="form-group">
                    <label>Ghi chú:</label>
                    <input type="text" name="note">
                </div>
                <div class="form-group">
                    <button class="btn-thanhtoan" type="submit">Tiến hành thanh toán</button>
                </div>
            </form>
        </div>
    </div>

    <?php if ($isOrderPlaced) : ?>
        <div id="orderSummary" style="display: block;">
            <p>Mã khách hàng:<span id="CustomerID"></span></p>
            <p>SĐT:<span id="phone"></span></p>
            <p>Địa chỉ giao hàng: <?php echo htmlspecialchars($_POST['address']); ?></p>
            <p>Ghi chú: <?php echo htmlspecialchars($_POST['note']); ?></p>
            <p>Tổng tiền:<span id="Total"></span></p>
            <div>
                <p>Chọn phương thức thanh toán:</p>
                <form method="POST">
                    <input type="hidden" name="address" value="<?php echo htmlspecialchars($_POST['address']); ?>">
                    <input type="hidden" name="note" value="<?php echo htmlspecialchars($_POST['note']); ?>">
                    <label>
                        <input type="radio" name="paymentMethod" value="cash" checked> Tiền mặt
                    </label>
                    <label>
                        <input type="radio" name="paymentMethod" value="transfer"> Chuyển khoản
                    </label>
                    <button type="submit" class="btn-thanhtoan1">Thanh toán</button>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <script>
        // Hiển thị form nhập thông tin khi nhấn nút Đặt hàng
        function showOrderForm() {
            document.getElementById("form").style.display = "block"; 
            document.querySelector(".order-btn").style.display = "none"; 
        }

        // Kiểm tra nếu có dữ liệu POST thì hiển thị tóm tắt đơn hàng và ẩn form nhập thông tin
        <?php if ($isOrderPlaced) : ?>
            document.getElementById("form").style.display = "none"; 
            document.querySelector(".order-btn").style.display = "none";
            document.getElementById("orderSummary").style.display = "block"; 
        <?php endif; ?>
    </script>
</div>
