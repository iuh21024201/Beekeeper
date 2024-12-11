<h3>Danh sách phản hồi từ khách hàng:</h3>
<?php
    include_once("../../controller/c_phan_hoi.php");
    $p = new cPhanHoi();
    $listPH = $p->getAllPhanHoi();
?>

<table class="table">
    <thead>
        <tr>
            <th>STT</th>
            <th>Khách hàng</th>
            <th>Số điện thoại </th>
            <th>Mail</th>
            <th>Thời Gian</th>
            <th>Chi tiết</th>
        </tr>
    </thead>
    <tbody>
<?php
        $i = 0;
if ($p) {
  if ($listPH->num_rows > 0) {
      while ($PH = $listPH->fetch_assoc()) {
        if($PH['TrangThai'] == 0){
        $color = "secondary";
        }else if ($PH['TrangThai'] == 1){
        $color = "light";
        }
            echo '<tr class="table-'.$color.'">';
            $i++;
            echo '<td>'.$i.'</td>';
            echo '<td>'.$PH['HoTen'].'</td>';
            echo '<td>'.$PH['SoDienThoai'].'</td>';
            echo '<td>'.$PH['Email'].'</td>';
            echo '<td>'.$PH['NgayFeedBack'].'</td>';
            echo '<td><button class ="btn btn-success"><a href="?action=chi-tiet-phan-hoi&id='.$PH['ID_FeedBack'].'" class= "text-decoration-none text-body" >Chi tiết</a></button></td></tr>';   
        
      }
      if ($i < 1 ){
      echo "<p>Không có yêu cầu nào!</p>";
      }
  } else {
      echo "<p>Không có feedback nào.</p>";
  }
} elseif ($p == false) {
  echo "<p>Có lỗi xảy ra khi truy vấn dữ liệu.</p>";
}
?>
<!-- <button></button>
<a href="?action=chi-tiet-phan-hoi&id='.$PH['ID_FeedBack'].'" class= "text-decoration-none text-body" >Chi tiết</a> -->