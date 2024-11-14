<?php
session_start(); 
include_once("../../controller/cSanPham.php");
$p = new CSanPham();
$kq = $p->getAllSP();

// Lấy danh sách sản phẩm theo loại hoặc theo từ khóa tìm kiếm
if (isset($_REQUEST['loaimonan'])) {
    $kq = $p->getAllSPByCate($_REQUEST['loaimonan']);
} elseif (isset($_REQUEST['btnTimKiem'])) {
    $searchValue = $_REQUEST['txtname'];
    if (is_numeric($searchValue)) {
        $kq = $p->getAllSPByPrice($searchValue);
    } else {
        $kq = $p->getAllSPByName($searchValue);
    }
} else {
    $kq = $p->getAllSP();
}

// Kiểm tra kết quả và hiển thị thông báo nếu không có dữ liệu
if (!$kq || !is_object($kq) || mysqli_num_rows($kq) == 0) {
    echo "Không tìm thấy dữ liệu!";
} else {
    echo "<table>";
    echo "<tr>";
    $dem = 0;
    
    // Hiển thị các sản phẩm
    while ($r = mysqli_fetch_assoc($kq)) {
        echo "<td style='padding: 8px;'>";
        echo "<div style='width: 200px; border: 1px solid #ddd; padding: 10px; text-align: center; font-family: Arial, sans-serif;'>";

        // Hình ảnh sản phẩm
        echo "<div style= padding: 5px;'>";
        echo "<img src='../../image/monan/" . $r["HinhAnh"] . "' width='180px' style='display: block; margin: auto;' />";
        echo "</div>";

        // Tên món ăn
        echo "<div style='margin-top: 10px; font-weight: bold; font-size: 16px;'>";
        echo $r["TenMonAn"];
        echo "</div>";

        echo "<div style='margin-top: 10px; font-weight: bold; font-size: 14px;'>";
        echo $r["Gia"];
        echo "VND</div>";

        // Điều chỉnh số lượng
        echo "<div style='margin-top: 10px; display: flex; justify-content: center; align-items: center;'>";
        echo "<button type='button' onclick='decreaseQuantity(this, " . $r["ID_MonAn"] . ")' style='width: 30px; height: 30px; background-color: #f1f1f1; border: none; font-size: 18px; cursor: pointer;'>-</button>";
        echo "<input type='text' id='quantity_" . $r["ID_MonAn"] . "' name='quantity[" . $r["ID_MonAn"] . "]' value='0' style='width: 50px; text-align: center; margin: 0 10px; border: 1px solid #ccc;' readonly />";
        echo "<button type='button' onclick='increaseQuantity(this, " . $r["ID_MonAn"] . ")' style='width: 30px; height: 30px; background-color: #f1f1f1; border: none; font-size: 18px; cursor: pointer;'>+</button>";
        echo "</div>";

        // Nút thêm vào giỏ hàng
        echo "<form method='POST' style='margin-top: 10px;'>";
        echo "<input type='hidden' name='product_id' value='" . $r["ID_MonAn"] . "'/>";
        echo "<input type='hidden' id='quantity_hidden_" . $r["ID_MonAn"] . "' name='quantity' value='0' />";
        echo "<input type='submit' value='Thêm vào giỏ hàng' style='background-color: #ff4d4d; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;' />";
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $quantity = intval($_POST['quantity']);

    // Lấy thông tin sản phẩm từ cơ sở dữ liệu
    $productResult = $p->getSPById($productId);

    // Kiểm tra và lấy dữ liệu từ $productResult
    if ($productResult && mysqli_num_rows($productResult) > 0) {
        $product = mysqli_fetch_assoc($productResult);

        if ($quantity > 0) {
            // Thêm sản phẩm vào giỏ hàng trong session
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$productId] = [
                    'name' => $product['TenMonAn'],
                    'quantity' => $quantity,
                    'image' => $product['HinhAnh'],
                    'price' => isset($product['Gia']) ? $product['Gia'] : 0  // Kiểm tra giá trị của Gia
                ];
            }
        }
    }
}

?>
<script>
    function decreaseQuantity(button, productId) {
    var input = document.getElementById('quantity_' + productId);
    var hiddenInput = document.getElementById('quantity_hidden_' + productId);
    var currentValue = parseInt(input.value);
    
        if (currentValue > 0) {
            input.value = currentValue - 1;
            hiddenInput.value = input.value; // Cập nhật giá trị cho input ẩn
        }
    }

    function increaseQuantity(button, productId) {
        var input = document.getElementById('quantity_' + productId);
        var hiddenInput = document.getElementById('quantity_hidden_' + productId);
        var currentValue = parseInt(input.value);
        
        input.value = currentValue + 1;
        hiddenInput.value = input.value; // Cập nhật giá trị cho input ẩn
    }
</script>
