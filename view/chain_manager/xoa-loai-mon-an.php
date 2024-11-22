<?php
    include_once("../../controller/cLoaiMonAn.php");
    $p = new controlLoaiMon();
    $maSP = $_REQUEST["id_loaimon"];
    $sp = $p->updateTinhTrangLoaiMon($maSP);

    if($sp){
        echo "<script>alert('Xóa thành công');
        window.location.href = 'index.php?action=quan-ly-loai-mon-an';
        </script>";
        
    }else{
        echo "<script>alert('Xóa thất bại!');
        window.location.href = 'index.php?action=quan-ly-loai-mon-an';
        </script>";
    }
?>