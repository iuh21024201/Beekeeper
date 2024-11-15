<?php

$isOrderPlaced = false;

// Kiểm tra nếu giỏ hàng trống
$isCartEmpty = empty($_SESSION['cart']) || count($_SESSION['cart']) === 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product_id'])) {
    $removeProductId = $_POST['remove_product_id'];
    
    // Kiểm tra và xóa sản phẩm khỏi giỏ hàng
    if (isset($_SESSION['cart'][$removeProductId])) {
        unset($_SESSION['cart'][$removeProductId]);
    }
    
    // Kiểm tra lại giỏ hàng sau khi xóa
    $isCartEmpty = empty($_SESSION['cart']) || count($_SESSION['cart']) === 0;
}

if (!$isCartEmpty) {
    echo "<table border='1'>";
    echo "<tr><th>Hình ảnh</th><th>Tên món ăn</th><th>Số lượng</th><th>Giá</th><th>Tổng</th><th>Hành động</th></tr>";

    $totalCartPrice = 0;

    foreach ($_SESSION['cart'] as $productId => $product) {
        $price = isset($product['price']) ? $product['price'] : 0;
        $totalPrice = $price * $product['quantity'];
        $totalCartPrice += $totalPrice;

        echo "<tr class='cart-item'>"; // Thêm lớp 'cart-item'
        echo "<td><img src='../../image/monan/" . htmlspecialchars($product['image']) . "' width='50px'/></td>";
        echo "<td>" . htmlspecialchars($product['name']) . "</td>";
        echo "<td>" . htmlspecialchars($product['quantity']) . "</td>";
        echo "<td>" . number_format($price, 0, ',', '.') . " VND</td>";
        echo "<td>" . number_format($totalPrice, 0, ',', '.') . " VND</td>";
        
        // Nút xóa
        echo "<td>";
        echo "<form method='POST' style='display:inline;'>";
        echo "<input type='hidden' name='remove_product_id' value='" . $productId . "' />";
        echo "<input type='submit' value='Xóa' />";
        echo "</form>";
        echo "</td>";
        
        echo "</tr>";
    }

    echo "<tr>";
    echo "<td colspan='4' style='text-align:right; font-weight:bold;'>Tổng cộng:</td>";
    echo "<td>" . number_format($totalCartPrice, 0, ',', '.') . " VND</td>";
    echo "<td></td>";
    echo "</tr>";
    echo "</table>";
} else {
    echo "Giỏ hàng của bạn đang trống!";
}



