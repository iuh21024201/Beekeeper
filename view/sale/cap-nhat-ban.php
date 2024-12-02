<?php 
include_once("../../controller/c_update_ban.php");  
$cuaHangController = new cLayCuaHang(); 

// Lấy thông tin cửa hàng
$tenCuaHang = $cuaHangController->getCuaHang($idTaiKhoan); 
?> 

<table class="table">     
<?php     
if ($tenCuaHang && $tenCuaHang->num_rows > 0) {         
    while ($row = $tenCuaHang->fetch_assoc()) {             
        $idCuaHang = $row['ID_CuaHang'];             
        echo "<h2>Danh sách bàn của cửa hàng: <span class='text-danger'>" . $row['TenCuaHang'] . "</span></h2>";         
    }     
} else {
    echo "<p>Không tìm thấy cửa hàng nào.</p>";
    return; // Kết thúc nếu không có cửa hàng
}

// Lấy danh sách bàn
$banController = new cUpdateBan();     
$listBan = $banController->getBan($idCuaHang);     

echo "<thead>             
<tr>          
    <th>STT</th>       
    <th>Mã bàn:</th>                 
    <th>Tình Trạng</th>                 
    <th>Cập nhật</th>             
</tr>           
</thead>           
<tbody>";
$i = 1; 
if ($listBan) {         
    if ($listBan->num_rows > 0) {             
        while ($ban = $listBan->fetch_assoc()) {                 
            $idBan = $ban['ID_Ban'];                 
            if ($ban['TinhTrang'] == 0) {                     
                $color = 'danger';                     
                $tinh_trang = 'Trống';                     
                $status = 1;                  
            } else {                     
                $color = 'success';                     
                $tinh_trang = 'Có khách';                     
                $status = 0;                 
            }
            echo "<tr>";
            echo "<td>". $i ."</td>"; 
            echo "<td>". $ban['TenBan'] ."</td>"; 
            echo "<td class='text-".$color."'>" . $tinh_trang . "</td>"; 
            echo '<td>
                    <form method="post">
                        <input type="hidden" name="idBan" value="'.$idBan.'">
                        <input type="hidden" name="status" value="'.$status.'">
                        <input type="submit" name="update" class="btn btn-'.$color.'" value="Cập nhật">
                    </form>
                  </td>';             
            echo "</tr>";  
            $i ++;           
        }         
    } else {             
        echo "<p>Không có bàn nào trong cửa hàng này.</p>";         
    }     
} elseif ($listBan === false) {         
    echo "<p>Có lỗi xảy ra khi truy vấn dữ liệu.</p>";     
} 

// Xử lý cập nhật
if (isset($_POST['update'])) {     
    $idBan = $_POST['idBan'];
    $status = $_POST['status'];

    if ($banController->setStatusBan($idBan, $status)) {         
        echo '<script language="javascript">             
                alert("Cập nhật thành công!");             
                window.location.href = "trang-quan-tri.php?action=cap-nhat-ban";             
              </script>';     
    } else {         
        echo "<p>Đã xảy ra lỗi khi gửi yêu cầu.</p>";     
    } 
}
?> 
</tbody>     
</table>
