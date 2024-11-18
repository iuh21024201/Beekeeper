<?php
	include("../../controller/cNguyenLieu.php");
    $p = new controlNguyenLieu();
    $idNL = $_REQUEST["id_nguyenlieu"];
    $tbl = $p->getMotNguyenLieu($idNL);
    if($tbl){
        while($r = mysqli_fetch_assoc($tbl)){
            $tennl = $r['TenNguyenLieu'];
            $gia = $r['GiaMua'];
            $soluong = $r['SoLuong'];
            $donvi = $r['DonViTinh'];
            $trangthai = $r['TrangThai'];
            $cuahang = $r['ID_CuaHang'];
            $hinhanh = $r['HinhAnh'];
        }
    }else {
        echo "<script>alert('Mã Sản Phẩm Không Tồn Tại !!!')</script>";
        header("refresh:0; url='admin.php'");
    }
    
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4>Cập nhật nguyên liệu</h4>
        </div>
        <div class="card-body">
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Tên nguyên liệu</label>
                    <input type="text" name="tenNL" class="form-control" value="<?php if(isset($tennl)) echo $tennl; ?>">
                    <span class="text-danger" id="tbten">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Giá mua</label>
                    <input type="text" name="gia" class="form-control" value="<?php if(isset($gia)) echo $gia; ?>">
                    <span class="text-danger" id="tbgia">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Số lượng</label>
                    <input type="text" name="soLuong" class="form-control" value="<?php if(isset($soluong)) echo $soluong; ?>">
                    <span class="text-danger" id="tbSL">(*)</span>
                </div>
                <div class="form-group">
                    <label for="">Đơn vị tính</label>
                    <select name="donVi" class="form-control" value="<?php if(isset($donvi)) echo $donvi; ?>">
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
                    <select name="trangThai" class="form-control" >
                        <option value="0" <?php echo (isset($trangthai) && $trangthai == 0) ? 'selected' : ''; ?>>Còn hàng</option>
                        <option value="1" <?php echo (isset($trangthai) && $trangthai == 1) ? 'selected' : ''; ?>>Hết hàng</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Cửa hàng</label>
                    <select name="cuaHang" class="form-control">
                        <option value="">- Chọn cửa hàng -</option>
                        <?php
                            include_once("../../controller/cCuaHang.php");
                            $p = new CCuaHang();
                            $tbl = $p->getAllCuaHang(); 
                            if ($tbl) {
                                while ($row = mysqli_fetch_assoc($tbl)) {
                                    if ($row['ID_CuaHang'] == $cuahang) {
                                        echo "<option value='" . $row['ID_CuaHang'] . "' selected>" . $row['TenCuaHang'] . "</option>";
                                    } else {
                                        echo "<option value='" . $row['ID_CuaHang'] . "'>" . $row['TenCuaHang'] . "</option>";
                                    }
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Hình ảnh</label>
                    <input type="file" name="hinhanh" class="form-control" id="">
                    <span class="text-danger" id="tbHinh">(*)</span>
                </div>

                <button name="submit" class="btn btn-success" type="submit">Cập nhật nguyên liệu</button>
            </form>
        </div>
    </div>
</div>