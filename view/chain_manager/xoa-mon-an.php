<?php
    include_once("../../controller/cMonAn.php");
    $p = new controlMonAn();
    $maSP = $_REQUEST["id_monan"];
    $sp = $p->updateTinhTrangMonAn($maSP);

    if($sp){
        echo "<script>alert('Xóa thành công')</script>";
        header("refresh:0.5; url=index.php?action=quan-ly-mon-an");
    }else{
        echo "<script>alert('Xóa thất bại!')</script>";
        header("refresh:0.5; url=index.php?action=quan-ly-mon-an");  
    }
?>
