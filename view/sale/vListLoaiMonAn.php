<?php

include_once("../../controller/cLoaiSanPham.php");

$p = new cLoaiSanPham();
$kq = $p->getAllLSP();

echo "<style>
    #loaimon-container {
        display: flex;
        flex-wrap: nowrap;
        gap: 8px;
        justify-content: flex-start;
        align-items: center;
        padding: 8px;
        border-radius: 8px;
        margin-bottom: 0;
    }

    #loaimon a {
        padding: 5px 12px;
        font-size: 13px;
        text-decoration: none;
        color: #fff;
        border-radius: 4px;
        font-family: Arial, sans-serif;
        white-space: nowrap;
        transition: background-color 0.2s ease;
    }

    #loaimon a.active {
        background-color: #0056b3;
    }

    #loaimon a:hover {
        background-color: #0056b3;
    }
</style>";

echo "<div id='loaimon-container'>";

// Nút "Tất cả"
echo "<div id='loaimon'>
        <a href='?action=thucdon' 
           class='" . (!isset($_GET['loaimonan']) ? 'active' : '') . "'>
            Tất cả
        </a>
      </div>";

// Các nút loại món ăn
if ($kq) {
    while ($r = mysqli_fetch_assoc($kq)) {
        echo "<div id='loaimon'>
                <a href='?action=thucdon&loaimonan=" . $r['ID_LoaiMon'] . "' 
                   class='" . (isset($_GET['loaimonan']) && $_GET['loaimonan'] == $r['ID_LoaiMon'] ? 'active' : '') . "'>
                    " . $r["TenLoaiMon"] . "
                </a>
              </div>";
    }
} else {
    echo "<script>alert('Không có dữ liệu!')</script>";
}

echo "</div>";

?>