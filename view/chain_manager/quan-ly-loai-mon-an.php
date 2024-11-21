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

    .txtTimKiem {
        width: 600px;
    }

    .form-select {
        background-color: #ffffff;
        border: 1px solid #ced4da;
        border-radius: 4px;
        color: #495057;
        padding: 8px 12px;
        font-size: 14px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        margin-left: 234px;
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
</style>

<body>
    <div class="table-container">
        <div class="col-md-12">
            <nav>
                <div class="col-md-3">
                    <ul class="navbar nav">
                        <li><a href="#" id="myBtn">Thêm loại món ăn</a></li>
                    </ul>
                </div>
                <div class="text-center mb-4">
                    <h2>QUẢN LÝ DANH SÁCH LOẠI MÓN ĂN</h2>
                </div>
                
            </nav>
        </div>
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead style="text-align: center;">
                    <tr>
                        <th>STT</th>
                        <th>Tên loại món ăn</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">1</td>
                        <td>Loại món ăn 1</td>
                        <td class="text-success" style="text-align: center;">Đang bán</td>
                        <td style="text-align: center; vertical-align: middle;">
                            <ul class="edit">
                                <li><a href="#" id="editBtn">Cập nhật</a></li>
                                <li><a href="#" id="deleteBtn" onclick="return confirm('Bạn có chắc chắn muốn xóa món ăn này?');">Xóa</a></li>
                            </ul>
                        </td>
                    </tr>
                    <!-- Additional rows can be added here as needed -->
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
