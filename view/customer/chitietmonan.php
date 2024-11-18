<style>
    /* Đặt font mặc định cho trang */
body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
}

/* Container cho chi tiết món ăn */
.product-details {
    max-width: 800px;
    margin: 40px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

/* Tiêu đề món ăn */
.product-details h1 {
    font-size: 28px;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

/* Hình ảnh món ăn */
.product-details img {
    max-width: 50%;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Mô tả và thông tin món ăn */
.product-details p {
    font-size: 16px;
    line-height: 1.6;
    color: #555;
    margin-bottom: 15px;
}

/* Phần thông tin "Giá" và "Mô tả" */
.product-details p strong {
    color: #333;
    font-weight: bold;
}

/* Liên kết quay lại */
.product-details a {
    display: inline-block;
    margin-top: 20px;
    font-size: 16px;
    color: #007BFF;
    text-decoration: none;
    font-weight: bold;
    padding: 10px 20px;
    border: 1px solid #007BFF;
    border-radius: 5px;
    background-color: #fff;
    transition: all 0.3s ease;
}

/* Hiệu ứng hover cho liên kết quay lại */
.product-details a:hover {
    background-color: #007BFF;
    color: white;
    border-color: #0056b3;
}

</style>
<?php
include_once("../../controller/cSanPham.php");
$p = new CSanPham();

// Lấy ID sản phẩm từ URL
$productId = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

if ($productId > 0) {
    // Lấy thông tin chi tiết món ăn
    $result = $p->getCTSPByID($productId);

    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();

        echo "<div class='product-details'>";
        echo "<h1>" . htmlspecialchars($product['TenMonAn']) . "</h1>";
        echo "<div style='text-align: center; margin: 20px 0;'>";
        echo "<img src='../../image/monan/" . htmlspecialchars($product['HinhAnh']) . "' />";
        echo "</div>";
        echo "<p><strong>Giá:</strong> " . htmlspecialchars(number_format($product['Gia'], 0, ',', '.')) . " VND</p>";
        echo "<p><strong>Mô tả:</strong> " . nl2br(htmlspecialchars($product['MoTa'])) . "</p>";
        echo "<p><strong>Loại món:</strong> " . nl2br(htmlspecialchars($product['TenLoaiMon'])) . "</p>";
        echo "<a href='index.php?action=thucdon'>Quay lại thực đơn</a>";
        echo "</div>";
    } else {
        echo "<p style='color: red;'>Không tìm thấy thông tin món ăn.</p>";
        echo "<a href='index.php?action=thucdon' style='text-decoration:none; color:blue;'>Quay lại thực đơn</a>";
    }
} else {
    echo "<p style='color: red;'>ID món ăn không hợp lệ.</p>";
    echo "<a href='index.php?action=thucdon' style='text-decoration:none; color:blue;'>Quay lại thực đơn</a>";
}
?>
