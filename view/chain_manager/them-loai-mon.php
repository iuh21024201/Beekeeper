<h2 class="text-center">THÊM LOẠI MÓN ĂN</h2>
<form action="#" method="post" enctype="multipart/form-data" class="container bg-light p-4 rounded shadow">
    <div class="form-group">
        <label>Tên loại món ăn</label>
        <input type="text" id="txtTenSP" name= 'txtTenSP' class="form-control" placeholder="Nhập tên món ăn">
        <span class="text-danger" id="tbTenSP">(*)</span>
    </div>
    <div class="form-group">
        <label>Trạng thái</label>
            <select id="txtTrangThaiMonAn" name="txtTrangThaiMonAn" class="form-control">
                <option value="0">Hiển thị</option>
                <option value="1">Ẩn</option>
            </select>
    </div>
    <div class="text-center">
        <button type="submit" name="btnThem" class="btn btn-primary">Thêm loại món</button>
        <button type="reset" class="btn btn-secondary">Hủy</button>
    </div>
</form>
<?php
    include_once("../../controller/cLoaiMonAn.php");
    $p = new controlLoaiMon();
    if(isset($_POST['btnThem'])){
        // Get the values from the form
        $tenLM = $_POST['txtTenSP'];
        $trangThai = $_POST['txtTrangThaiMonAn'];
        
        // Call the insert function
        $kq = $p->insertLoaiMon($tenLM, $trangThai);
        
        if($kq){
            echo "<script>alert('Thêm món ăn thành công!');
            window.location.href = 'index.php?action=quan-ly-loai-mon-an';
            </script>";
        } else {
            echo "<script>alert('Thêm món ăn thất bại!');
            window.location.href = 'index.php?action=quan-ly-loai-mon-an';
            </script>";
        }
    }
?>
