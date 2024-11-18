<?php
include_once("../../model/ketnoi.php");
$p = new clsketnoi();
$con = $p->moKetNoi();
    if(isset($_POST["btnThem"])){
        // Lấy dữ liệu từ form
        $tenNL = $_POST["tenNL"];
        $gia = $_POST["gia"];
        $soluong = $_POST["soLuong"];
        $donVi = $_POST["donVi"];
        $trangthai = $_POST["trangThai"];
        $cuahang = $_POST["cuaHang"];
        $hinhanh = $_FILES["hinhanh"]["name"];
        
        // Kiểm tra giá
        if($gia > 0) {
            // Kiểm tra file ảnh
            if($_FILES["hinhanh"]["type"] == "image/png" || $_FILES["hinhanh"]["type"] == "image/jpeg" || $_FILES["hinhanh"]["type"] == "image/jpg") {
                
                // Tiến hành upload file ảnh
                if(move_uploaded_file($_FILES["hinhanh"]["tmp_name"], "../../image/nguyenlieu/".$hinhanh)) {
                    include_once("../../controller/cNguyenLieu.php");
                    $p = new controlNguyenLieu();
                    
                    // Chèn nguyên liệu vào bảng nguyenlieu
                    $sqlInsertMonAn = "INSERT INTO nguyenlieu (TenNguyenLieu, GiaMua, HinhAnh, DonViTinh, TrangThai) 
                                       VALUES (?, ?, ?, ?, ?)";
                    $stmt = $con->prepare($sqlInsertMonAn);

                    // Liên kết tham số và thực thi truy vấn
                    $stmt->bind_param("sisss", $tenNL, $gia, $hinhanh, $donVi, $trangthai);
                    if ($stmt->execute()) {
                        $idNL = $stmt->insert_id; // ID của nguyên liệu vừa được thêm

                        // Thêm chi tiết nguyên liệu vào các cửa hàng
                        if (isset($cuahang) && is_array($cuahang) && count($cuahang) > 0) {
                            foreach ($cuahang as $cuahangID) {
                                if (!empty($cuahangID) && $soluong > 0) {
                                    $sqlInsertChiTiet = "INSERT INTO chitietnguyenlieu (ID_NguyenLieu, ID_CuaHang, SoLuong) 
                                                         VALUES (?, ?, ?)";
                                    $stmtChiTiet = $con->prepare($sqlInsertChiTiet);
                                    $stmtChiTiet->bind_param("iii", $idNL, $cuahangID, $soluong);

                                    if (!$stmtChiTiet->execute()) {
                                        echo "<script>alert('Lỗi khi thêm chi tiết nguyên liệu!');</script>"; 
                                        exit;
                                    }
                                }
                            }
                        }

                        echo "<script>alert('Thêm nguyên liệu thành công!');</script>";
                    } else {
                        echo "<script>alert('Lỗi khi thêm nguyên liệu!');</script>"; 
                    }
                } else {
                    echo "<script>alert('Upload ảnh thất bại!');</script>";
                }
            } else {
                echo "<script>alert('Chỉ chấp nhận các loại file ảnh (PNG, JPEG, JPG)!');</script>";
            }
        } else {
            echo "<script>alert('Giá không được là số âm!');</script>";
        }
    }
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4>Thêm nguyên liệu</h4>
        </div>
        <div class="card-body">
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Tên nguyên liệu</label>
                    <input type="text" name="tenNL" class="form-control" required>
                    <span class="text-danger" id="tbten">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Giá mua</label>
                    <input type="text" name="gia" class="form-control" required>
                    <span class="text-danger" id="tbgia">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Số lượng</label>
                    <input type="text" name="soLuong" class="form-control" required>
                    <span class="text-danger" id="tbSL">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Đơn vị tính</label>
                    <select name="donVi" class="form-control" required>
                        <option value="gam">100 gam</option>
                        <option value="Gói">Gói</option>
                        <option value="Hộp">Hộp</option>
                        <option value="Cánh">Cánh</option>
                        <option value="Đùi">Đùi</option>
                        <option value="Trứng">Trứng</option>
                        <option value="Ức">Ức</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label><br>
                    <select name="trangThai" class="form-control" required>
                        <option value="0">Còn hàng</option>
                        <option value="1">Hết hàng</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Cửa hàng</label>
                    <select name="cuaHang" class="form-control" required>
                        <option value="">- Chọn cửa hàng -</option>
                        <?php
                            include_once("../../controller/cCuaHang.php");
                            $p = new CCuaHang();
                            $tbl = $p->getAllCuaHang();
                            if ($tbl) {
                                while ($row = mysqli_fetch_assoc($tbl)) {
                                    $selected = (isset($_GET['id_cuahang']) && $_GET['id_cuahang'] == $row['ID_CuaHang']) ? 'selected' : '';
                                    echo "<option value='" . $row['ID_CuaHang'] . "' $selected>" . $row['TenCuaHang'] . "</option>";
                                }
                            } 
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Hình ảnh</label>
                    <input type="file" name="hinhanh" class="form-control" required>
                    <span class="text-danger" id="tbHinh">(*)</span>
                </div>

                <button name="btnThem" class="btn btn-success" type="submit">Thêm nguyên liệu</button>
            </form>
        </div>
    </div>
</div>
