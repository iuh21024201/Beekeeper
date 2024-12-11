<?php
include_once("../../controller/cNguoiDung.php");
include_once("../../controller/cSanPham.php");
include_once("../../controller/cCuaHang.php");
include_once("../../controller/cLoaiTrangTri.php");
include_once("../../controller/cDonTiec.php");

// Lấy thông tin người dùng
$controlNguoiDung = new controlNguoiDung();
$idTaiKhoan = $_SESSION['ID_TaiKhoan'] ?? null;
$hoTen = $soDienThoai = "";
$idKH = null;

if ($idTaiKhoan) {
    $idKH = $controlNguoiDung->getCustomerIdByAccountId($idTaiKhoan);
    $idKH1 = $controlNguoiDung->getOneNguoiDung($idTaiKhoan);
    if ($idKH1 && is_object($idKH1) && mysqli_num_rows($idKH1) > 0) {
        $row = mysqli_fetch_assoc($idKH1);
        $hoTen = htmlspecialchars($row['HoTen']);
        $soDienThoai = htmlspecialchars($row['SoDienThoai']);
    }
}

// Lấy thông tin từ form
$selectedDecorationId = $_POST['decoration_id'] ?? ($_SESSION['selected_decoration_id'] ?? '');
$selectedStoreId = $_POST['store_id'] ?? ($_SESSION['selected_store_id'] ?? '');
$selectedDate = $_POST['date'] ?? ($_SESSION['selected_date'] ?? '');
$selectedPeople = $_POST['songuoi'] ?? ($_SESSION['selected_people'] ?? '');
$note = $_POST['ghichu'] ?? ($_SESSION['note'] ?? '');

// Xử lý đặt tiệc
$pSanPham = new CSanPham();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lưu thông tin form vào session
    $_SESSION['selected_decoration_id'] = $selectedDecorationId;
    $_SESSION['selected_store_id'] = $selectedStoreId;
    $_SESSION['selected_date'] = $selectedDate;
    $_SESSION['selected_people'] = $selectedPeople;
    $_SESSION['note'] = $note;

    // Thêm món ăn vào giỏ hàng
    if (isset($_POST['product_id'], $_POST['quantity'])) {
        $productId = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);

        if ($quantity > 0) {
            $productResult = $pSanPham->getSPById($productId);
            if ($productResult && mysqli_num_rows($productResult) > 0) {
                $product = mysqli_fetch_assoc($productResult);

                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }
                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['quantity'] += $quantity;
                } else {
                    $_SESSION['cart'][$productId] = [
                        'id' => $product['ID_MonAn'],
                        'name' => htmlspecialchars($product['TenMonAn']),
                        'quantity' => $quantity,
                        'image' => htmlspecialchars($product['HinhAnh']),
                        'price' => $product['Gia'],
                    ];
                }
            }
        }
    }
        // Xử lý trang trí
        if (isset($_POST['decoration_id'])) {
            $decorationId = intval($_POST['decoration_id']);
            $pLoaiTrangTri = new CLoaiTrangTri();
            $decoration = $pLoaiTrangTri->getDecorationById($decorationId);
    
            if ($decoration && mysqli_num_rows($decoration) > 0) {
                $decorationData = mysqli_fetch_assoc($decoration);
                $_SESSION['cart']['decoration'] = [
                    'id' => $decorationData['ID_LoaiTrangTri'],
                    'name' => htmlspecialchars($decorationData['TenTrangTri']),
                    'price' => $decorationData['Gia']
                ];
            }
        }

    // Kiểm tra đặt tiệc
    if (isset($_POST['placeOrder'])) {
        // Kiểm tra giỏ hàng có tồn tại và không rỗng
        if (empty($_SESSION['cart']) || !is_array($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
            echo "<script>alert('Vui lòng chọn ít nhất một món ăn trước khi đặt tiệc!');</script>";
        } else {
            // Kiểm tra từng sản phẩm trong giỏ hàng có hợp lệ không
            $hasValidItem = false;
            foreach ($_SESSION['cart'] as $cartItem) {
                if (isset($cartItem['id'], $cartItem['quantity']) && $cartItem['quantity'] > 0) {
                    $hasValidItem = true;
                    break;
                }
            }
    
            if (!$hasValidItem) {
                echo "<script>alert(' Vui lòng chọn món ăn trước khi đặt tiệc!');</script>";
            } else {
                // Tiếp tục xử lý đặt tiệc
                $donTiec = new controlDonTiec();
    
                $idCH = intval($_POST['store_id'] ?? 0);
                $idTT = intval($_POST['decoration_id'] ?? 0);
                $giohen = htmlspecialchars($_POST['date'] . ' ' . date('H:i:s'));
                $songuoi = intval($_POST['songuoi'] ?? 0);
                $ghichu = htmlspecialchars($_POST['ghichu'] ?? '');
                $trangthai = '1';
    
                $idDonTiec = $donTiec->insertDonTiec($idKH, $idCH, $idTT, $giohen, $songuoi, $ghichu, $trangthai);
    
                if ($idDonTiec) {
                    foreach ($_SESSION['cart'] as $cartItem) {
                        $idMonAn = $cartItem['id'];
                        $soLuong = $cartItem['quantity'];
                        if ($idMonAn && $soLuong > 0) {
                            $donTiec->insertCTDT($idDonTiec, $idMonAn, $soLuong);
                        }
                    }
                    unset($_SESSION['cart']); // Xóa giỏ hàng sau khi đặt thành công
                    echo "<script>alert('Đặt tiệc thành công!'); window.location.href = 'index.php?action=dattiec';</script>";
                } else {
                    echo "<script>alert('Đặt tiệc thất bại. Vui lòng thử lại.');</script>";
                }
            }
        }
    }
    



    // Xóa món ăn khỏi giỏ hàng
    if (isset($_POST['remove_product_id'])) {
        $removeProductId = intval($_POST['remove_product_id']);
        if (isset($_SESSION['cart'][$removeProductId])) {
            unset($_SESSION['cart'][$removeProductId]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Tiệc</title>
    <style>
        /* CSS Styles */
        .btn {
            background-color: #00b2a9;
            border: none;
            color: #fff;
            padding: 12px 0;
            width: 200px;
            border-radius: 48px;
            margin: 0 auto;
            display: block;
            font-weight: 700;
        }
        .title h4{
            padding-left: 20px;
            padding-right: 20px;
            font-weight: 700;
            color:#ff4d4d;
            margin: 0 0 10px;
        }
        .title p{
            font-weight: 400;
            color: #000;
        }
        .title h3{
            color:#ff4d4d;
            font-weight: 700;
            margin: 0 0 10px;
        }
        .chitiet {
            background-color: #ffde94;
            padding: 20px 0 100px;
        }
        .form-wrapper h5 {
            font-weight: bold;
            text-align: center;
            margin-top: 30px;
        }
        .form-control {
            border: 1px solid #ffc522;
            background-color: #FFC522;
            height: 46px;
            border-radius: 8px;
        }
        .items-container {
            display: flex;
            justify-content: center;
            gap: 50px;
            margin: 20px auto;
        }
        .item img {
            width: 120px;
            height: 120px;
        }
        .order-summary {
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
        }
        .product{
            height:433px;
            border:1px solid #E8E8E8 ;
            overflow-y:scroll;
            width: 100%;
            background-color: #E8E8E8;
            border-radius: 10px;
        }
        .product table{
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }

        td {
            background-color: #f2f2f2;
        }

        td img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        .order-summary table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .order-summary th, .order-summary td {
            text-align: left;
            padding: 8px;
        }
        .order-summary .item-name {
            font-weight: bold;
            color: #333;
        }
        
        .order-summary .remove-btn {
            color: #e74c3c;
            background-color: transparent;
            border: none;
            cursor: pointer;
        }
        .banner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px; 
            padding:50px;
        }

        .banner .item {
            position: relative;
            width: 30%;  
        }

        .banner img {
            width: 100%;  /* Make the images fill their container */
            height: auto;  /* Maintain aspect ratio */
            border-radius: 10px;  /* Add rounded corners to images */
        }
    </style>
</head>
<body>
<div class="container">
    <div class="title" style="text-align: center;">
        <h4>Buổi tiệc khó quên cùng những món ngon</h4>
        <h4>& quà tặng từ BeeKeeper</h4>
        <p>Chúng tôi sẵn sàng phục vụ mọi buổi tiệc của bạn</p>
    </div>
    <div class="items-container">
        <div class="item">
            <img src="image/tochuctiec.png" alt="Đèn led">
            <p>Đèn led</p>
        </div>
        <div class="item">
            <img src="image/tochuctiec1.png" alt="Trang trí tiệc">
            <p>Trang trí tiệc</p>
        </div>
        <div class="item">
            <img src="image/tochuctiec4.png" alt="Bong bóng">
            <p>Bong bóng</p>
        </div>
        <div class="item">
            <img src="image/tochuctiec3.png" alt="Quà tặng">
            <p>Quà tặng</p>
        </div>
    </div>

    <!-- Hiển thị danh sách món ăn -->
    <h5 style="text-align:center;">DANH SÁCH MÓN ĂN</h5>
    <div class=" product">
            <table>
                <?php
                $products = $pSanPham->getAllSP();
                if ($products && mysqli_num_rows($products) > 0) {
                    while ($row = mysqli_fetch_assoc($products)) {
                        echo "<tr>";
                        echo "<td><img src='../../image/monan/" . htmlspecialchars($row["HinhAnh"]) . "' width='120px' /></td>";
                        echo "<td>" . htmlspecialchars($row["TenMonAn"]) . "</td>";
                        echo "<td>" . number_format($row["Gia"], 0, ',', '.') . " VND</td>";
                        echo "<td>
                            <button onclick='decreaseQuantity(this, " . $row["ID_MonAn"] . ")'>-</button>
                            <input type='text' id='quantity_" . $row["ID_MonAn"] . "' value='0' readonly style='width: 30px; text-align: center;' />
                            <button onclick='increaseQuantity(this, " . $row["ID_MonAn"] . ")'>+</button>
                            <form method='POST' style='display:inline;'>
                                <input type='hidden' name='product_id' value='" . $row["ID_MonAn"] . "' />
                                <input type='hidden' id='quantity_hidden_" . $row["ID_MonAn"] . "' name='quantity' value='0' />
                                <input type='submit' value='Đặt hàng' />
                            </form>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<p>Không tìm thấy sản phẩm!</p>";
                }
                ?>
            </table>
        </div>
    </div>
<div class="banner">
        <div class="item">
            <img src="image/tung-bung.jpg">
        </div>
        <div class="item">
            <img src="image/vui-nhon.jpg">
        </div>
        <div class="item">
            <img src="image/don-gian.jpg">
        </div>
</div>
<div class="chitiet">
    <div class="container">
        <div class="row">
            <div class="form-wrapper col-md-6">
                <h5>THÔNG TIN KHÁCH HÀNG ĐẶT TIỆC</h5>
                <form action="" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="Tên*" value="<?= htmlspecialchars($hoTen) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="phone" placeholder="Số điện thoại*" value="<?= htmlspecialchars($soDienThoai) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="action" value="dattiec">
                        <select class="form-control" name="decoration_id" required id="decoration_id"  aria-label="Select category " onchange="this.form.submit()">
                            <option value="">Chọn trang trí</option>
                            <?php
                            $pLoaiTrangTri = new CLoaiTrangTri();
                            $decorations = $pLoaiTrangTri->getAllTrangTri();
                            while ($row = mysqli_fetch_assoc($decorations)) {
                                $selected = ($selectedDecorationId == $row['ID_LoaiTrangTri']) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($row['ID_LoaiTrangTri']) . '" ' . $selected . '>'
                                    . htmlspecialchars($row['TenTrangTri']) 
                                    . ' - ' . number_format($row['Gia'], 0, ',', '.') . ' VND</option>';
                            }
                            ?>
                        </select>
                        <span class="text-danger" id="tbTrangTri">(*)</span>
                    </div>
                    <div class="form-group">
                        <input type="date" name="date" class="form-control" placeholder="Giờ hẹn*" value="<?= htmlspecialchars($selectedDate) ?>" required >
                        <span class="text-danger" id="tbGio">(*)</span>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="songuoi" placeholder="Số người*" value="<?= htmlspecialchars($selectedPeople) ?>" required>
                        <span class="text-danger" id="tbnguoi">(*)</span>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="store_id"  id=""  required>
                            <option value="">--Chọn cửa hàng--</option>
                            <?php
                            $pCuaHang = new cCuaHang();
                            $stores = $pCuaHang->getAllStore();
                            while ($store = mysqli_fetch_assoc($stores)) {
                                $selected = ($selectedStoreId == $store['ID_CuaHang']) ? 'selected' : '';
                                echo "<option value='" . htmlspecialchars($store['ID_CuaHang']) . "' $selected>" . htmlspecialchars($store['TenCuaHang']) . "</option>";
                            }
                            ?>
                        </select>
                        <span class="text-danger" id="tbCuaHang">(*)</span>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="ghichu"  placeholder="Ghi chú"><?= htmlspecialchars($note) ?></textarea>
                    </div>
                    <button class="btn" type="submit" name="placeOrder">Xác nhận đặt tiệc</button>
                </div>
            </form>
            <div class="form-wrapper col-md-6">
                <h5>CHI TIẾT ĐƠN TIỆC</h5>
                <div class="order-summary">
                        <?php if (!empty($_SESSION['cart'])): ?>
                            <table>
                                <tbody>
                                    <?php 
                                    // Tính tổng tiền món ăn và trang trí
                                    $totalCartPrice = 0;
                                    $decorationPrice = 0;
                                    if (!empty($_POST['decoration_id'])) {
                                        $decorationId = intval($_POST['decoration_id']);
                                        $pLoaiTrangTri = new CLoaiTrangTri();
                                        $decoration = $pLoaiTrangTri->getDecorationById($decorationId);
                                        if ($decoration && mysqli_num_rows($decoration) > 0) {
                                            $row = mysqli_fetch_assoc($decoration);
                                            $decorationPrice = isset($row['Gia']) ? $row['Gia'] : 0; // Kiểm tra nếu 'Gia' tồn tại
                                        }
                                    }
                                    foreach ($_SESSION['cart'] as $key => $item): ?>
                                        <?php if ($key !== 'decoration'): ?>
                                            <tr>
                                                <td><img src="../../image/monan/<?= htmlspecialchars($item['image']) ?>" width="100"></td>
                                                <td><?= htmlspecialchars($item['name']) ?></td>
                                                <td><?= $item['quantity'] ?></td>
                                                <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VND</td>
                                                <td>
                                                    <form method="POST">
                                                        <input type="hidden" name="remove_product_id" value="<?= $item['id'] ?>">
                                                        <button type="submit" style="background: none; border: none;">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php 
                                            // Cộng dồn giá trị món ăn vào tổng tiền
                                            $totalCartPrice += $item['price'] * $item['quantity'];
                                            ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <p>
                                <strong>Tổng tiền món ăn: </strong>
                                <?= number_format($totalCartPrice, 0, ',', '.') ?> VND
                            </p>
                            <p>
                                <strong>Tiền trang trí: </strong>
                                <?= number_format($decorationPrice, 0, ',', '.') ?> VND
                            </p>
                            <p>
                                <strong>Tổng cộng: </strong>
                                <?= number_format($totalCartPrice + $decorationPrice, 0, ',', '.') ?> VND
                            </p>
                        <?php else: ?>
                            <p><strong>Tổng cộng: </strong>0 VND</p>
                        <?php endif; ?>
                    </div>
            </div>
        </div>
    </div>
</div>
<script>
    function decreaseQuantity(button, productId) {
        var input = document.getElementById('quantity_' + productId);
        var hiddenInput = document.getElementById('quantity_hidden_' + productId);
        var currentValue = parseInt(input.value) || 0;
        if (currentValue > 0) {
            input.value = currentValue - 1;
            hiddenInput.value = input.value;
        }
    }
    function increaseQuantity(button, productId) {
        var input = document.getElementById('quantity_' + productId);
        var hiddenInput = document.getElementById('quantity_hidden_' + productId);
        var currentValue = parseInt(input.value) || 0;
            input.value = currentValue + 1;
            hiddenInput.value = input.value;
    }
    function checkdate() {
        const dateInput = document.querySelector('input[name="date"]');
        const tbGio = document.getElementById('tbGio');
        const currentDate = new Date();
        const selectedDate = new Date(dateInput.value);

        // Kiểm tra xem ngày chọn có nhỏ hơn ngày hiện tại không
        if (!dateInput.value) {
            tbGio.textContent = 'Vui lòng chọn ngày đặt tiệc.';
            return false;
        } else if (selectedDate < currentDate) {
            tbGio.textContent = 'Ngày đặt tiệc phải lớn hơn ngày hiện tại.';
            return false;
        } else {
            tbGio.textContent = '';
            return true;
        }
    }

    function checkSoNguoi() {
        const soNguoiInput = document.querySelector('input[name="songuoi"]');
        const tbNguoi = document.getElementById('tbnguoi');
        if (!soNguoiInput.value || parseInt(soNguoiInput.value) <= 0) {
            tbNguoi.textContent = 'Vui lòng nhập số người lớn hơn 0.';
            return false;
        } else {
            tbNguoi.textContent = '';
            return true;
        }
    }

    function checkCuaHang() {
        const storeSelect = document.querySelector('select[name="store_id"]');
        const tbCuaHang = document.getElementById('tbCuaHang');
        if (!storeSelect.value) {
            tbCuaHang.textContent = 'Vui lòng chọn cửa hàng.';
            return false;
        } else {
            tbCuaHang.textContent = '';
            return true;
        }
    }

    function checkTrangTri() {
        const decorationSelect = document.querySelector('select[name="decoration_id"]');
        const tbTrangTri = document.getElementById('tbTrangTri');
        if (!decorationSelect.value) {
            tbTrangTri.textContent = 'Vui lòng chọn trang trí.';
            return false;
        } else {
            tbTrangTri.textContent = '';
            return true;
        }
    }

    function validateForm() {
        const validDate = checkdate();
        const validSoNguoi = checkSoNguoi();
        const validCuaHang = checkCuaHang();
        const validTrangTri = checkTrangTri();

        return validDate && validSoNguoi && validCuaHang && validTrangTri;
    }

    // Gán sự kiện kiểm tra form khi người dùng bấm nút xác nhận đặt tiệc
    document.querySelector('[name="placeOrder"]').addEventListener('click', function (event) {
        if (!validateForm()) {
            event.preventDefault(); // Ngăn không cho form submit nếu không hợp lệ
            alert("Vui lòng điền đầy đủ và chính xác thông tin trước khi gửi.");
        }
    });
</script>

</body>
</html>
