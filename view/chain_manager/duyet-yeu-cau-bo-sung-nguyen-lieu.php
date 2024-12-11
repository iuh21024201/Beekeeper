<div class="container-fluid">
    <h3>Danh sách các yêu cầu:</h3>
<?php
    include_once("../../controller/c_yeu_cau.php");
    $p = new cYeuCau();
    $listCHYC = $p->getAllCHYeuCau();
?>

<table class="table">
    <thead>
        <tr>
            <th>STT</th>
            <th>Cửa hàng yêu cầu</th>
            <th>Món ăn</th>
            <th>Ngày gửi</th>
            <th>Chi tiết</th>
        </tr>
    </thead>
    <tbody>
        <tr>
<?php
$i = 0;
if ($p) {
  if ($listCHYC->num_rows > 0) {
      while ($CHYC = $listCHYC->fetch_assoc()) {
        if($CHYC['TrangThai'] == 0){
            $i++;
            echo '<td>'.$i.'</td>';
            echo '<td>'.$CHYC['TenCuaHang'].'</td>';
            echo '<td>'.$CHYC['TenMonAn'].'</td>';
            echo '<td>'.$CHYC['NgayGui'].'</td>';
            echo '<td><a href="?action=chi-tiet-yeu-cau&id='.$CHYC['ID_YeuCau'].' " class= "btn btn-danger text-decoration-none text-body" >Chi tiết</a></td></tr>';   
        }
      }
      if ($i < 1 ){
      echo "<p>Không có yêu cầu nào!</p>";
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