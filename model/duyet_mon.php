<?php
include_once("../../controller/c_mon_moi.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $controller = new cMonMoi();
    if ($controller->duyetMonMoi($id)) {
        echo 'success';
    } else {
        echo 'error từ controller';
    }
} else {
    echo 'error: Không nhận được ID';
}
?>
