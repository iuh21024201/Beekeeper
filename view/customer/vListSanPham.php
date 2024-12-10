<?php

include_once("../../controller/cSanPham.php");
$p = new CSanPham();

include_once("../../controller/cSanPham.php");
$p = new CSanPham();

// Check if 'action=thucdon' is set in the URL
if (isset($_GET['action']) && $_GET['action'] === 'thucdon') {
    // If 'loaimonan' is set, filter products by category
    if (isset($_REQUEST['loaimonan'])) {
        $kq = $p->getAllSPByCate($_REQUEST['loaimonan']);
    } else {
        // Check if a search value is provided
        $searchValue = isset($_GET['txtname']) ? $_GET['txtname'] : '';

        // Fetch products based on the search query
        if (!empty($searchValue)) {
            // If numeric, assume it's a price; otherwise, search by name
            if (is_numeric($searchValue)) {
                $kq = $p->getAllSPByPrice($searchValue);
            } else {
                $kq = $p->getAllSPByName($searchValue);
            }
        } else {
            // No search query, fetch all products
            $kq = $p->getAllSP();
        }
    }

    // Display the results
    if (!$kq || !is_object($kq) || mysqli_num_rows($kq) == 0) {
        echo "Không tìm thấy dữ liệu!";
    } else {
        echo "<table>";
        echo "<tr>";
        $dem = 0;

        // Display each product
        while ($r = mysqli_fetch_assoc($kq)) {
            echo "<td style='padding: 8px; border:none'>";
            echo "<div style='width: 200px; border: 1px solid #ddd; padding: 10px; text-align: center; font-family: Arial, sans-serif;'>";

            // Product image
            echo "<div style='padding: 5px;'>";
            echo "<img src='../../image/monan/" . htmlspecialchars($r["HinhAnh"]) . "' width='180px' style='display: block; margin: auto;' />";
            echo "</div>";

            // Product name as a link
            echo "<div style='margin-top: 10px; font-weight: bold; font-size: 16px;'>";
            echo "<a href='index.php?action=chitietmonan&product_id=" . $r["ID_MonAn"] . "' style='text-decoration: none; color: #333;'>" . htmlspecialchars($r["TenMonAn"]) . "</a>";
            echo "</div>";

            // Product price
            echo "<div style='margin-top: 10px; font-weight: bold; font-size: 14px;'>";
            echo htmlspecialchars($r["Gia"]) . " VND</div>";

            // Quantity adjustment controls
            echo "<div style='margin-top: 10px; display: flex; justify-content: center; align-items: center;'>";
            echo "<button type='button' onclick='decreaseQuantity(this, " . $r["ID_MonAn"] . ")' style='width: 30px; height: 30px; background-color: #f1f1f1; border: none; font-size: 18px; cursor: pointer;'>-</button>";
            echo "<input type='text' id='quantity_" . $r["ID_MonAn"] . "' name='quantity[" . $r["ID_MonAn"] . "]' value='0' style='width: 50px; text-align: center; margin: 0 10px; border: 1px solid #ccc;' readonly />";
            echo "<button type='button' onclick='increaseQuantity(this, " . $r["ID_MonAn"] . ")' style='width: 30px; height: 30px; background-color: #f1f1f1; border: none; font-size: 18px; cursor: pointer;'>+</button>";
            echo "</div>";

            // Add to cart button
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
}

// Handle form submission for adding to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $quantity = intval($_POST['quantity']);
    $note = isset($_POST['note']) ? $_POST['note'] : ''; // Lấy ghi chú từ form

    // Fetch product information from the database
    $productResult = $p->getSPById($productId);

    // Check and retrieve data from $productResult
    if ($productResult && mysqli_num_rows($productResult) > 0) {
        $product = mysqli_fetch_assoc($productResult);

        if ($quantity > 0) {
            // Add product to cart in session
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$productId] = [
                    'id' => $product['ID_MonAn'], // Lưu ID_MonAn từ bảng MonAn
                    'name' => $product['TenMonAn'],
                    'quantity' => $quantity,
                    'image' => $product['HinhAnh'],
                    'price' => isset($product['Gia']) ? $product['Gia'] : 0,
                    // 'note' => $note // Lưu ghi chú cho món ăn
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
            hiddenInput.value = input.value; // Update hidden input value
        }
    }

    function increaseQuantity(button, productId) {
        var input = document.getElementById('quantity_' + productId);
        var hiddenInput = document.getElementById('quantity_hidden_' + productId);
        var currentValue = parseInt(input.value);
        
        input.value = currentValue + 1;
        hiddenInput.value = input.value; // Update hidden input value
    }
</script>
