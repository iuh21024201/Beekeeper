
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Loại Món Ăn</title>
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
#addLoaiMonAnBtn {
        margin-left: -18px;
    }
</style>
<body>
    <div class="container">
        <!-- Nút thêm loại món ăn -->
        <div class="col-md-12 mb-3">
            <nav>
                <ul class="navbar nav">
                    <li><a href="#" id="addLoaiMonAnBtn">Thêm loại món ăn</a></li>
                </ul>
            </nav>
        </div>
        <!-- Bảng danh sách loại món ăn -->
        <div class="col-md-12" height="200px">
            <caption>
                <h3 class="text-center">DANH SÁCH LOẠI MÓN ĂN</h3>
            </caption>
            <table class="table table-bordered">
                <thead style="text-align: center;">
                    <th>STT</th>
                    <th>Tên loại món ăn</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: center; vertical-align: middle;">
                            <ul class="edit">
                                <li><a href="#" id="editBtn">Cập nhật</a></li>
                                <li><a href="delete-item.php?id=<?php echo $item['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa loại món ăn này?');" id="deleteBtn">Xóa</a></li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal thêm mới loại món ăn -->
    <div class="modal" id="addLoaiMonAnModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="btn-block">THÊM LOẠI MÓN ĂN</h4>
                    <button class="close" data-dismiss="modal">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên loại món ăn</label>
                        <input type="text" id="txtTenLoaiMonAn" class="form-control" placeholder="Nhập tên loại món ăn">
                        <span class="text-danger" id="tbTenLoaiMonAn">(*)</span>
                    </div>
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select id="txtTrangThaiLoaiMonAn" class="form-control">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-block" id="btnSaveLoaiMonAn">Thêm loại món ăn</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cập nhật loại món ăn -->
    <div class="modal" id="editLoaiMonAnModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="btn-block">CẬP NHẬT LOẠI MÓN ĂN</h4>
                    <button class="close" data-dismiss="modal">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên loại món ăn</label>
                        <input type="text" id="editTenLoaiMonAn" class="form-control" placeholder="Nhập tên loại món ăn">
                        <span class="text-danger" id="tbTenLoaiMonAn">(*)</span>
                    </div>
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select id="editTrangThaiLoaiMonAn" class="form-control">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-block" id="btnUpdateLoaiMonAn">Lưu thay đổi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script hiển thị modal thêm/cập nhật -->
    <script>
        $(document).ready(function() {
            $("#addLoaiMonAnBtn").on("click", function() {
                $("#addLoaiMonAnModal").modal("show");
            });

            $("#editBtn").on("click", function() {
                $("#editLoaiMonAnModal").modal("show");
            });
        });
    </script>
</body>
</html>
