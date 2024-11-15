<?php
include_once("../../controller/cLoaiSanPham.php");

$p = new cLoaiSanPham();    
$kq = $p->getAllLSP();

if($kq){
    while($r = mysqli_fetch_assoc($kq)){
        // Using <div> or <p> to force each item on a new line
        echo "<div>
                <a href='?action=thucdon&loaimonan=" . $r['ID_LoaiMon'] . "' 
                   class='" . (isset($_REQUEST['loaimonan']) && $_REQUEST['loaimonan'] == $r['ID_LoaiMon'] ? 'active' : '') . "'>
                    " . $r["TenLoaiMon"] . "
                </a>
              </div>";
    }
} else {
    echo "<script>alert('Không có dữ liệu!')</script>";
}
?>
