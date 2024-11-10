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
        <th>Nguyên liệu</th>
        <th>Mô tả</th>
        <th>Giá</th>
        <th>Trạng thái</th>
        <th> </th>

      </tr>
    </thead>
    <tbody>
      <tr>
<?php
if ($p) {
  if ($listMonMoi->num_rows > 0) {
      while ($monMoi = $listMonMoi->fetch_assoc()) { 
        if ($monMoi['TrangThai'] == 0){ 
        $tinh_trang = 'Chưa duyệt';        
        echo '<tr>
        <td>'.$monMoi['TenMon'].'</td>
        <td>'.$monMoi['NguyenLieu'].'</td>
        <td>'.$monMoi['MoTa'].'</td>
        <td>'.$monMoi['Gia'].'</td>
        <td class="text-danger">'.$tinh_trang.'</td>
        <td><button class="btn btn-success btn-sm btn-duyet">Duyệt</button></td>
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