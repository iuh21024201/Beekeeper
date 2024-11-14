<?php
    include_once("../../controller/cMonAn.php");
    $p = new controlMonAn();
    $maSP = $_REQUEST["id_monan"];
    $sp = $p->updateTinhTrangMonAn($maSP);

    // Move header() before echo statements to prevent the "headers already sent" error
    if($sp){
        header("Location: view/chain_manager/?action=quan-ly-mon-an");
        exit(); // Ensure no further code executes after header
    } else {
        header("Location: view/chain_manager/?action=quan-ly-mon-an");
        exit(); // Ensure no further code executes after header
    }
?>
