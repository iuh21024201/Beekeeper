<?php

include_once("../../controller/cLoaiSanPham.php");

$p = new cLoaiSanPham();
$kq = $p->getAllLSP(); // Lấy danh sách loại sản phẩm (chưa đảo)

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

// Xử lý đảo ngược mảng nếu không thể sửa truy vấn SQL
$loaiMonList = [];
if ($kq) {
    while ($row = mysqli_fetch_assoc($kq)) {
        $loaiMonList[] = $row;
    }
    // Đảo ngược thứ tự
    $loaiMonList = array_reverse($loaiMonList);
} else {
    echo "<script>alert('Không có dữ liệu!')</script>";
}

// Hiển thị các nút loại món ăn
foreach ($loaiMonList as $r) {
    echo "<div id='loaimon'>
            <a href='?action=thucdon&loaimonan=" . $r['ID_LoaiMon'] . "' 
               class='" . (isset($_GET['loaimonan']) && $_GET['loaimonan'] == $r['ID_LoaiMon'] ? 'active' : '') . "'>
                " . $r["TenLoaiMon"] . "
            </a>
          </div>";
}

echo "</div>";

?>
