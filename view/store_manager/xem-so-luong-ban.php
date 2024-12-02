<?php
include_once("../../controller/c_xem_so_luong_ban.php");
// Xử lý khi người dùng chọn một cửa hàng
if ($idTaiKhoan) {
    $banController = new CBan();
    $listBan = $banController->getBan1CH($idTaiKhoan);
}

$cuaHangController = new CCuaHang();
$tenCuaHang = $cuaHangController->get1CuaHang($idTaiKhoan);
?>
<!-- <h1>

</h1> -->
    <table class="table">
    <!-- Hiển thị danh sách bàn nếu đã chọn cửa hàng -->
<?php
if ($tenCuaHang && $tenCuaHang->num_rows > 0) {
    while ($row = $tenCuaHang->fetch_assoc()) {
        $idCuaHang = $row['ID_CuaHang'];
        echo "<h2>Danh sách bàn của cửa hàng: <span class='text-danger'>" . $row['TenCuaHang'] . "</span></h2>";

    }
}
echo '<button type="button" class="btn btn-primary" 
        data-bs-toggle="modal" 
        data-bs-target="#myModal" 
        data-idcuahang="' . $idCuaHang . '">
        Thêm bàn
    </button>';
// echo "<h2>Danh sách bàn của cửa hàng:" .$row['TenCuaHang']. " </h2>";
echo "<thead>
        <tr>
            <th>STT:</th>
            <th>Mã bàn:</th>
            <th>Tình Trạng</th>
            <th>Xóa</th>
        </tr>
        </thead>
        <tbody>
        <tr>";
$i = 1;
if ($listBan) {
    if ($listBan->num_rows > 0) {
        while ($ban = $listBan->fetch_assoc()) {
            if ($ban['TinhTrang'] == 0) {
                $color = 'text-danger';
                $tinh_trang = 'Trống';
            } else {
                $color = 'text-success';
                $tinh_trang = 'Có khách';
            }
        echo "<td>". $i ."</td>", "<td>". $ban['TenBan'] ."</td>" , "<td class='".$color."'>" . $tinh_trang . "</td>";
        echo '<td>
                <form method="post">
                        <input type="hidden" name="idBan" value="'.$ban['ID_Ban'].'">
                        <input type="submit" name="delete" class="btn btn-secondary" value="Xóa">
                </form>
            </td>';
        echo        "</tr>";
        echo        "<tr>";
        $i++;
        }
        echo "</tr>";
    } else {
        echo "<p>Không có bàn nào trong cửa hàng này.</p>";
    }
} elseif ($listBan === false) {
    echo "<p>Có lỗi xảy ra khi truy vấn dữ liệu.</p>";
}

// Xử lý cập nhật
if (isset($_POST['delete'])) {     
    $idBan = $_POST['idBan'];

    if ($banController->setXoaBan($idBan)) {         
        echo '<script language="javascript">             
                alert("Xóa thành công!");             
                window.location.href = "index.php?action=xem-so-luong-ban";             
            </script>';     
    } else {         
        echo "<p>Đã xảy ra lỗi khi gửi yêu cầu.</p>";     
    } 
}
?>
</tbody>
</table>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Thêm bàn</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form method="post" action="">
        <div class="modal-body">
        <div class="mb-3">
            <label for="tenBan" class="form-label">Tên bàn</label>
            <input type="text" class="form-control" id="tenBan" name="tenBan" required>
        </div>
        <!-- Trường ẩn để lưu ID_CuaHang -->
        <input type="hidden" id="idCuaHang" name="idCuaHang">
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
    </form>
    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    var myModal = document.getElementById('myModal');
    myModal.addEventListener('show.bs.modal', function (event) {
        // Lấy nút kích hoạt modal
        var button = event.relatedTarget;

        // Lấy ID_CuaHang từ thuộc tính data-idcuahang
        var idCuaHang = button.getAttribute('data-idcuahang');

        // Gán giá trị vào trường ẩn trong modal
        var inputIdCuaHang = document.getElementById('idCuaHang');
        inputIdCuaHang.value = idCuaHang;
    });
});
</script>


<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tenBan = $_POST['tenBan'];
        $idCuaHang = $_POST['idCuaHang'];

        $banController = new CBan();


        // Gọi hàm để thêm bàn vào CSDL
        $result = $banController->setBan($tenBan, $idCuaHang);

        if ($result) {
            echo '<script>alert("Thêm bàn thành công!"); window.location.href="index.php?action=xem-so-luong-ban";</script>';
        } else {
            echo '<script>alert("Có lỗi xảy ra, vui lòng thử lại.");</script>';
        }
    }

?>






