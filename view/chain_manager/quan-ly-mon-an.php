
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
    <script src="../../asset/js/jquery-3.4.1.min.js"></script>
    <script src="../../asset/js/bootstrap.min.js"></script>
</head>
<style>
    .container {
    margin-top: 30px;
    }

    .navbar li {
        display: inline-block; 
    }

    .navbar a {
        background-color: #dc3545; 
        color: white; 
        padding: 8px 12px;
        border-radius: 4px;
        border: none;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .navbar a:hover {
        background-color: #c82333; 
        color: #ffffff; 
    }

    #myBtn {
        margin-left: -30px;
    }

    .edit {
        display: flex; 
        justify-content: center; 
        align-items: center; 
        list-style: none; 
        padding: 0; 
        margin: 0;
    }

    .edit li {
        margin: 0 10px; 
    }

    .edit a {
        text-decoration: none; 
        padding: 8px 20px; 
        display: inline-block;
        color: #ffffff; 
        font-size: 14px; 
        text-align: center; 
        background-color: #007bff; 
        border-radius: 5px; 
        transition: background-color 0.3s ease; 
    }

    .edit a:hover {
        background-color: #0056b3; 
    }

    #editBtn {
        background-color: #ffc107; 
        color: #000; 
    }

    #editBtn:hover {
        background-color: #e0a800; 
    }
    .table-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .btnTimKiem{
        height: 500px;
        width: 600px; 
    }
    .txtTimKiem {     
    width: 400px; 
    }
    .form-select {
    background-color: #ffffff; 
    border: 1px solid #ced4da; 
    border-radius: 4px; 
    color: #495057; 
    padding: 8px 12px; 
    font-size: 14px; 
    transition: border-color 0.3s ease, box-shadow 0.3s ease; 
    margin-left: 305px;
    }
    .form-select:hover, 
    .form-select:focus {
        border-color: #80bdff; 
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.25); 
        outline: none; 
    }

    .form-select option {
        color: #495057; 
    }
    .text-success {
    color: #28a745; /* Màu xanh cho "Đang bán" */
    }
    .text-danger {
        color: #dc3545; /* Màu đỏ cho "Ngừng bán" */
    }
    .text-muted {
        color: #6c757d; /* Màu xám cho "Không xác định" */
    }
</style>
<body>
<div class="table-container">
    <div class="col-md-12">
        <nav>
            <div class="col-md-3">
                <ul class="navbar nav">
                    <li><a href="?action=them-mon-an" id="myBtn">Thêm món ăn</a></li>
                </ul>
            </div>
            <div class="text-center mb-4">
                <h2>QUẢN LÝ DANH SÁCH MÓN ĂN</h2>
            </div>
            <div class="input-group mb-4 search-bar">
    <form action="#" method="get" class="d-flex align-items-center w-100">
        <input type="hidden" name="action" value="quan-ly-mon-an">
        <input type="text" name="txtname" id="txtTimKiem" class="form-control me-2 txtTimKiem" placeholder="Tìm kiếm sản phẩm...">
        <button class="btn btn-primary me-2" name="btnTimKiem" id="btnTimKiem">Tìm kiếm</button>
        <select name="type" class="form-select" style="width: auto; min-width: 200px;" aria-label="Select category" onchange="this.form.submit()">
            <option value="">Tất cả loại món ăn</option>
            <?php
            include_once("../../controller/cLoaiMonAn.php");
            $p = new controlLoaiMon();
            $kqLoai = $p->getAllLoaiMon();

            if ($kqLoai) {
                while ($row = mysqli_fetch_assoc($kqLoai)) {
                    $selected = (isset($_GET['type']) && $_GET['type'] == $row['ID_LoaiMon']) ? 'selected' : '';
                    echo "<option value='" . $row['ID_LoaiMon'] . "' $selected>" . $row['TenLoaiMon'] . "</option>";
                }
            } else {
                echo "<option disabled>Không có dữ liệu!</option>";
            }
            ?>
        </select>
    </form>
</div>

        </nav>
    </div>
    <div class="col-md-12" height="200px">
        <?php
        include ("../../controller/cMonAn.php");
        $p = new controlMonAn();
        if (isset($_GET['type']) && !empty($_GET['type'])) {
            $kq = $p->getAllMonAnByType($_GET['type']);
        } elseif(isset($_REQUEST['btnTimKiem'])){
            $kq = $p -> getAllMonAnByName($_REQUEST['txtname']);
        }
        else {
            $kq = $p->getAllMonAn();
        }
        if (!$kq) {
            echo "Không có dữ liệu!";
        } else {
            echo '
            <table class="table table-bordered">
                <thead style="text-align: center;">
                    <tr>
                        <th>STT</th>
                        <th>Tên món ăn</th>
                        <th>Loại món ăn</th>
                        <th>Giá</th>
                        <th>Hình ảnh</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>';

            $stt = 1; 
            while ($r = mysqli_fetch_assoc($kq)) {
                echo "<tr>";
                echo "<td style='text-align: center;'>" . $stt++ . "</td>";
                echo "<td>" . $r["TenMonAn"] . "</td>";
                echo "<td>" . $r["TenLoaiMon"] . "</td>";
                echo "<td style='text-align: center;'>" . number_format($r["Gia"], 0, ',', '.') . " VND</td>";
                echo "<td style='text-align: center;'><img src='../../image/monan/" . $r["HinhAnh"] . "' width='100px' height='100px' /></td>";
                if ($r["TinhTrang"] == 0) {
                    $trangThai = "Đang bán";
                    $classTrangThai = "text-success"; 
                } elseif ($r["TinhTrang"] == 1) {
                    $trangThai = "Ngừng bán";
                    $classTrangThai = "text-danger"; 
                } else {
                    $trangThai = "Không xác định";
                    $classTrangThai = "text-muted"; 
                }
                echo "<td class='$classTrangThai' style='text-align: center;'>$trangThai</td>";                             
                echo "<td style='text-align: center; vertical-align: middle;'>
                        <ul class='edit'>
                            <li><a href='?action=sua-mon-an&id_monan=".$r["ID_MonAn"]."' id='editBtn'>Cập nhật</a></li>
                            <li><a href='?action=xoa-mon-an&id_monan=".$r["ID_MonAn"]."'onclick='return confirm(\"Bạn có chắc chắn muốn ngừng bán món ăn này?\");' id='deleteBtn'>Ngừng bán</a></li>
                        </ul>
                      </td>";
                echo "</tr>";
            }

            echo '
                </tbody>
            </table>';
        }
        ?>
    </div>
</div>
</body>
</html>