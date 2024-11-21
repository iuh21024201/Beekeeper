<?php
    include_once("../../controller/cMonAn.php");
    $p = new controlMonAn();
    $maSP = $_REQUEST["id_monan"];
    $sp = $p->updateTinhTrangMonAn($maSP);

    if($sp){
        echo "<script>alert('Xóa thành công');
        window.location.href = 'index.php?action=quan-ly-mon-an';
        </script>";
        
    }else{
        echo "<script>alert('Xóa thất bại!');
        window.location.href = 'index.php?action=quan-ly-mon-an';
        </script>";
    }
?>
