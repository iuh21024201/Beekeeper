<div class="container-fluid">
<?php
include_once("../../controller/c_mon_moi.php");
$p = new cMonMoi();
$listMonMoi = $p->getAllMonMoi();
?>
<h3>Danh sách món ăn cần duyệt</h3>
<table class="table">
    <thead>
      <tr>
        
        <th>Tên món ăn</th>
        <th>Giá</th>
        <th>Trạng thái</th>
      </tr>
    </thead>
    <tbody>
      <tr>
<?php
// href="?action=sua-mon-an&id_monan='.$r["ID_MonAn"].'"
if ($p) {
  if ($listMonMoi->num_rows > 0) {
      while ($monMoi = $listMonMoi->fetch_assoc()) { 
        if ($monMoi['TrangThai'] == 0){ 
          $tinh_trang = 'Chưa duyệt'; 
          $idMonMoi = $monMoi['ID_MonMoi'];
          $_SESSION["idMonMoi"] = $monMoi['ID_MonMoi'];      
          echo '<tr>
          <td><a href="?action=duyet_mon&id='.$idMonMoi.'" class= "text-decoration-none text-body" >'. htmlspecialchars($monMoi['TenMon']).'</a></td>
          <td class= "text-decoration-none text-body" >'.number_format($monMoi['Gia'], 0, ',', '.').' VNĐ</td>
          <td class= "text-decoration-none text-danger" >'.$tinh_trang.'</td>
        </tr>';
        }
        else if ($monMoi['TrangThai']== 1){  
          $tinh_trang = 'Đã duyệt'; 
          $idMonMoi = $monMoi['ID_MonMoi'];
          $_SESSION["idMonMoi"] = $monMoi['ID_MonMoi'];      
          echo '<tr>
          <td><a href="?action=duyet_mon&id='.$idMonMoi.'" class= "text-decoration-none text-body" >'.htmlspecialchars($monMoi['TenMon']).'</a></td>
          <td class= "text-decoration-none text-body" >'.number_format($monMoi['Gia'], 0, ',', '.').' VNĐ</td>
          <td class= "text-decoration-none text-success" >'.$tinh_trang.'</td>
        </tr>';
        } 
      }
  } else {
      echo "<p>Không có món mới nào được đề xuất.</p>";
  }
} elseif ($p == false) {
  echo "<p>Có lỗi xảy ra khi truy vấn dữ liệu.</p>";
}
?>
    </tbody>
</table>






</div>
<!-- <input type="submit" name="nut" id="nut" value="Xóa sản phẩm"> -->