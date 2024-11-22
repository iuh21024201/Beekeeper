<?php
include_once('../../controller/cLoaiMonAn.php');
$p = new controlLoaiMon();
$maLM = $_REQUEST["id_loaimon"];
$lm = $p -> getOneLoaiMon($maLM);
if($lm){
    while($r = mysqli_fetch_assoc($lm)){
        $tenLM = $r['TenLoaiMon'];
        $tinhTrangLM = $r['TrangThai']; // Ensure variable name consistency
    }
}else{
    echo "<script>alert('Mã loại món không tồn tại !!!')</script>";
    header("refresh:0; url='admin.php'");
}
?>
<h2 class="text-center">CẬP NHẬT LOẠI MÓN ĂN</h2>
<form action="#" method="post" enctype="multipart/form-data" class="container bg-light p-4 rounded shadow">
    <div class="form-group">
        <label>Tên loại món ăn</label>
        <input type="text" id="txtTenSP" name='txtTenSP' class="form-control" value="<?php if(isset($tenLM)) echo $tenLM;?>">
        <span class="text-danger" id="tbTenSP">(*)</span>
    </div>
    <div class="form-group">
        <label>Trạng thái</label>
        <select id="txtTrangThaiMonAn" name="txtTrangThaiMonAn" class="form-control">
            <option value="0" <?php echo (isset($tinhTrangLM) && $tinhTrangLM == 0) ? 'selected' : ''; ?>>Hiển thị</option>
            <option value="1" <?php echo (isset($tinhTrangLM) && $tinhTrangLM == 1) ? 'selected' : ''; ?>>Ẩn</option>
        </select>
    </div>
    <div class="text-center">
        <button type="submit" name="btnCapNhat" class="btn btn-primary">Cập nhật loại món</button>
        <button type="reset" class="btn btn-secondary">Hủy</button>
    </div>
</form>
<?php
    if(isset($_REQUEST['btnCapNhat'])){
        $kq = $p->updateLoaiMon($maLM, $_REQUEST['txtTenSP'],$_REQUEST['txtTrangThaiMonAn']);        
        if($kq){
            echo "<script>alert('Cập nhật thành công');
            window.location.href = 'index.php?action=quan-ly-loai-mon-an';
            </script>";
        }else{
            echo "<script>alert('Cập nhật thất bại');
            window.location.href = 'index.php?action=quan-ly-loai-mon-an';
            </script>";
        }
    }
?>
