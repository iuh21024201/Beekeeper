<?php
include_once("../../controller/cSanPham.php");
$p = new CSanPham();

// Lấy tham số loại món ăn từ URL
$idLoaiMon = isset($_GET['loaimonan']) ? intval($_GET['loaimonan']) : null;

// Lấy danh sách món ăn dựa trên loại
$kq = $idLoaiMon ? $p->getAllSPByCate($idLoaiMon) : $p->getAllSP();

// Hiển thị danh sách món ăn
if (!$kq || !is_object($kq) || mysqli_num_rows($kq) == 0) {
    echo "<div style='text-align: center; font-family: Arial, sans-serif; color: #999;'>Không tìm thấy dữ liệu!</div>";
} else {
    echo "<table style='width: 100%; border-spacing: 15px; text-align: center;'>";
    echo "<tr>";
    $dem = 0;

    while ($r = mysqli_fetch_assoc($kq)) {
        echo "<td style='padding: 8px;'>";
        echo "<div style='width: 150px; border: 1px solid #ddd; padding: 8px; border-radius: 6px; background-color: #f9f9f9; text-align: center; font-family: Arial, sans-serif;'>";

        $imagePath = "../../image/monan/" . htmlspecialchars($r["HinhAnh"]);
        echo "<div style='margin-bottom: 8px;'>";
        echo "<img src='" . $imagePath . "' alt='" . htmlspecialchars($r["TenMonAn"]) . "' style='width: 120px; height: auto; border-radius: 5px;' />";
        echo "</div>";

        echo "<div style='font-weight: bold; font-size: 14px; margin-bottom: 4px;'>";
        echo "<a href='index.php?action=chitietmonan&product_id=" . htmlspecialchars($r["ID_MonAn"]) . "' style='text-decoration: none; color: #333;'>" . htmlspecialchars($r["TenMonAn"]) . "</a>";
        echo "</div>";

        echo "<div style='color: #888; font-size: 12px; margin-bottom: 8px;'>";
        echo number_format($r["Gia"], 0, ',', '.') . " VND";
        echo "</div>";

        echo "<form method='POST' action='' style='margin-top: 8px;'>";
        echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($r["ID_MonAn"]) . "' />";
        echo "<input type='hidden' name='product_name' value='" . htmlspecialchars($r["TenMonAn"]) . "' />";
        echo "<input type='hidden' name='product_price' value='" . htmlspecialchars($r["Gia"]) . "' />";
        echo "<input type='hidden' name='product_image' value='" . htmlspecialchars($r["HinhAnh"]) . "' />";
        echo "<button type='submit' name='add_to_cart' style='background-color: #ff4d4d; color: white; border: none; padding: 6px 10px; border-radius: 4px; font-size: 12px; cursor: pointer;'>Thêm món</button>";
        echo "</form>";

        echo "</div>";
        echo "</td>";

        $dem++;
        if ($dem % 4 == 0) {
            echo "</tr><tr>";
        }
    }
    echo "</tr>";
    echo "</table>";
}

// Xử lý thêm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    session_start();

    // Lấy các giá trị từ form
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productImage = $_POST['product_image'];

    // Khởi tạo giỏ hàng nếu chưa có
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Lấy thông tin sản phẩm từ database bằng ID
    $productResult = $p->getSPById($productId);  // Lấy sản phẩm theo ID

    if ($productResult && mysqli_num_rows($productResult) > 0) {
        // Lấy thông tin sản phẩm từ kết quả query
        $product = mysqli_fetch_assoc($productResult);

        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity']++;  // Tăng số lượng nếu sản phẩm đã có
        } else {
            // Thêm sản phẩm vào giỏ hàng
            $_SESSION['cart'][$productId] = [
                'id' => $productId,  // Lưu lại ID sản phẩm
                'name' => $product['TenMonAn'],
                'price' => $product['Gia'],
                'image' => $product['HinhAnh'],
                'quantity' => 1  // Mặc định là 1 khi thêm vào lần đầu
            ];
        }
    }

    // Quay lại trang sản phẩm sau khi thêm vào giỏ hàng
    header("Location: " . $_SERVER['PHP_SELF'] . "?action=thucdon&loaimonan=" . $idLoaiMon);
    exit();
}


?>
