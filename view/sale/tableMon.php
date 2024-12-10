<?php

// Khởi tạo giá trị mặc định
$isOrderPlaced = false;
$isCartEmpty = empty($_SESSION['cart']) || count($_SESSION['cart']) === 0;

// Xử lý khi thay đổi số lượng hoặc xóa sản phẩm khỏi giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_product_id'])) {
        // Xóa sản phẩm khỏi giỏ hàng
        $removeProductId = filter_input(INPUT_POST, 'remove_product_id', FILTER_SANITIZE_STRING);
        if ($removeProductId && isset($_SESSION['cart'][$removeProductId])) {
            unset($_SESSION['cart'][$removeProductId]);
        }
    } elseif (isset($_POST['action']) && isset($_POST['product_id'])) {
        // Điều chỉnh số lượng sản phẩm
        $productId = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_STRING);
        $action = $_POST['action'];
        if ($productId && isset($_SESSION['cart'][$productId])) {
            switch ($action) {
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

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            width: 70px;
            border-radius: 5px;
        }
        .actions button {
            padding: 3px 8px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 12px;
            margin: 0 2px;
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
            width: 100%;
            margin: 0 auto;
        }
        .summary textarea {
            width: 100%;
            height: 80px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
        }
        .checkout {
            background-color: #28a745;
            color: white;
            padding: 15px 25px;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .checkout:hover {
            background-color: #218838;
        }
        .checkout:active {
            background-color: #1e7e34;
            transform: scale(0.98);
        }
        td.quantity {
            width: 120px;
        }
    </style>
</head>
<body>
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
                        <td class="quantity">
                            <div class="actions">
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="product_id" value="<?= $productId; ?>">
                                    <input type="hidden" name="action" value="decrease">
                                    <button type="submit" class="decrease">-</button>
                                </form>
                                <span><?= htmlspecialchars($product['quantity']); ?></span>
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
    <form method="POST" action="thanhtoan.php">
        <div class="summary">
            <textarea id="note" name="note" placeholder="Nhập ghi chú (nếu có)"></textarea>
        </div>
        <div>
            <label><input type="radio" name="paymentMethod" value="cash" checked> Tiền mặt</label>
            <label><input type="radio" name="paymentMethod" value="transfer"> Chuyển khoản</label>
        </div>
        <button type="submit" name="placeOrder" class="checkout">Thanh Toán</button>
    </form>
</body>
</html>
