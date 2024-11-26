<h3>Chi tiết phản hồi của khách hàng:</h3>
<?php
$idFB = $_REQUEST['id'] ?? null;

include_once("../../controller/c_phan_hoi.php");
$p = new cPhanHoi();
$listPH = $p->getPH($idFB);
?>

<?php
    echo '<table class="table">
      <tr>';
          if ($listPH->num_rows > 0) {
      while ($PH = $listPH->fetch_assoc()) {
        echo '
            <td>Tên Khách Hàng: </td>
            <td>'.$PH['TenKhachHang'].'</td>
        </tr>
        <tr>
            <td>Số Điện Thoại: </td>
            <td>'.$PH['SoDienThoai'].'</td>
        </tr>
        <tr>
            <td>Email: </td>
            <td>'.$PH['Email'].'</td>
        </tr>
        <tr>
            <td>Phản Hồi: </td>
            <td>'.$PH['FeedBack'].'</td>
        </tr>
        <tr>
            <td>Ngày gửi FeedBack: </td>
            <td>'.$PH['NgayFeedBack'].'</td>
        ';
      }
    }
      echo' </tr>
      <tr>
        <td colspan = 2>
                <button onclick="window.history.back()" class="btn btn-secondary">Thoát</button>
        </td>
      </tr>
        </table>';
?>
