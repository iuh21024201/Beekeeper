<?php

// Khởi tạo giá trị mặc định
$isOrderPlaced = false;
$isCartEmpty = empty($_SESSION['cart']) || count($_SESSION['cart']) === 0;

// Xử lý khi thay đổi số lượng hoặc xóa sản phẩm khỏi giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_product_id'])) {
        // Xóa sản phẩm khỏi giỏ hàng
        $removeProductId = $_POST['remove_product_id'];
        if (isset($_SESSION['cart'][$removeProductId])) {
            unset($_SESSION['cart'][$removeProductId]);
        }
    } elseif (isset($_POST['action']) && isset($_POST['product_id'])) {
        // Điều chỉnh số lượng sản phẩm
        $productId = $_POST['product_id'];
        if (isset($_SESSION['cart'][$productId])) {
            switch ($_POST['action']) {
                case 'increase':
                    $_SESSION['cart'][$productId]['quantity']++;
                    break;
                case 'decrease':
                    if ($_SESSION['cart'][$productId]['quantity'] > 1) {
                        $_SESSION['cart'][$productId]['quantity']--;
                    }
                    break;
            }
        }
    }

    // Cập nhật lại trạng thái giỏ hàng
    $isCartEmpty = empty($_SESSION['cart']) || count($_SESSION['cart']) === 0;
}

// Tính tổng tiền giỏ hàng
$totalCartPrice = 0;
if (!$isCartEmpty) {
    foreach ($_SESSION['cart'] as $product) {
        $totalCartPrice += ($product['price'] ?? 0) * ($product['quantity'] ?? 1);
    }
}

?>
<style>
   body {
    font-family: Arial, sans-serif;
    margin: 20px;
}
table {
    width: 100%; /* Tăng độ rộng bảng lên một chút */
    margin: 0 auto;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    text-align: center;
    padding: 10px; /* Tăng khoảng cách bên trong */
    border: 1px solid #ddd;
}
th {
    background-color: #f2f2f2;
}
img {
    width: 70px; /* Tăng kích thước hình ảnh */
    border-radius: 5px;
}
.actions button {
    padding: 3px 8px; /* Giảm kích thước nút */
    border: none;
    cursor: pointer;
    border-radius: 5px;
    font-size: 12px; /* Giảm kích thước chữ */
    margin: 0 2px; /* Giảm khoảng cách giữa các nút */
}
.actions .increase {
    background-color: #28a745;
    color: white;
}
.actions .decrease {
    background-color: #ffc107;
    color: white;
}
.actions .remove {
    background-color: #ff4d4d;
    color: white;
}
.summary {
    margin-top: 20px;
    width: 100%; /* Tăng độ rộng phần ghi chú */
    margin: 0 auto;
}
.summary textarea {
    width: 100%;
    height: 80px;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
}
.checkout-section {
    margin-top: 20px;
    display: flex;
    justify-content: center; /* Căn giữa nội dung */
}
.checkout-section button {
    padding: 12px 20px; /* Tăng kích thước nút "Thanh Toán" */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}
.checkout {
    background-color: #28a745;
    color: white;
}
.empty-cart {
    text-align: center;
    color: #999;
    font-style: italic;
    margin-bottom: 20px;
}


</style>
<body>

    <!-- Hiển thị giỏ hàng -->
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Hình ảnh</th>
                <th>Tên món ăn</th>
                <th>Số lượng</th>
                <th>Giá bán</th>
                <th>Thành tiền</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($isCartEmpty): ?>
                <tr>
                    <td colspan="7" class="empty-cart">Không có món nào trong giỏ hàng.</td>
                </tr>
            <?php else: ?>
                <?php $stt = 1; ?>
                <?php foreach ($_SESSION['cart'] as $productId => $product): ?>
                    <tr>
                        <td><?= $stt++; ?></td>
                        <td><img src="../../image/monan/<?= htmlspecialchars($product['image'] ?? 'default.png'); ?>" alt="Product Image"></td>
                        <td><?= htmlspecialchars($product['name']); ?></td>
                        <td>
                            <div class="actions">
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="product_id" value="<?= $productId; ?>">
                                    <input type="hidden" name="action" value="decrease">
                                    <button type="submit" class="decrease">-</button>
                                </form>
                                <span><?= $product['quantity']; ?></span>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="product_id" value="<?= $productId; ?>">
                                    <input type="hidden" name="action" value="increase">
                                    <button type="submit" class="increase">+</button>
                                </form>
                            </div>
                        </td>
                        <td><?= number_format($product['price'], 0, ',', '.'); ?> VND</td>
                        <td><?= number_format($product['price'] * $product['quantity'], 0, ',', '.'); ?> VND</td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="remove_product_id" value="<?= $productId; ?>">
                                <button type="submit" class="remove">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="5" style="text-align: right; font-weight: bold;">Tổng đơn:</td>
                    <td colspan="2"><?= number_format($totalCartPrice, 0, ',', '.'); ?> VND</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>


    <!-- Form tải ảnh lên và chọn phương thức thanh toán -->
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



</body>
</html>
