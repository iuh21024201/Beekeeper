<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng Lương Nhân Viên</title>
    <style>
        .salary-sheet {
            width: 100%;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .salary-sheet h2 {
            text-align: center;
            color: #d32f2f;
            margin-bottom: 20px;
        }
        .salary-info {
            width: 100%;
            border-collapse: collapse;
        }
        .salary-info th, .salary-info td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        .salary-info th {
            background-color: #f5f5f5;
            font-weight: bold;
            color: #333;
        }
        .salary-info td {
            color: #555;
        }
        .total-salary {
            font-weight: bold;
            color: #d32f2f;
            text-align: right;
        }
        .chon-thang{
            display: flex;
            margin: 0 auto;
            border: 1px solid black;

        }
        .chon-thang{
            align-items: center;
            margin: 0 auto;
            width: 40%;
            padding: 10px;
            margin-bottom: 10px;
        }
        .chon-thang input{
            margin-left: 10px;
        }
        .chon-thang label{
            margin: 0 auto;
        }
        .xac-nhan-luong {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 4px;
            justify-content: center;
            display: flex;
            margin: 0 auto;
            margin-top: 20px;
            
        }
        .xac-nhan-luong:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="chon-thang">
    <label for="">Chọn tháng :</label>
    <input type="month">
</div>
<div class="salary-sheet">
    <h2>Bảng Lương Nhân Viên</h2>
    <table class="salary-info">
        <tr>
            <th>Mã nhân viên</th>
            <td>VTS5311</td>
        </tr>
        <tr>
            <th>Họ tên nhân viên</th>
            <td>Phạm Thị Chức Ly</td>
        </tr>
        <tr>
            <th>Tổng giờ làm</th>
            <td>27.75 giờ</td>
        </tr>
        <tr>
            <th>Lương theo giờ</th>
            <td>150,000 VNĐ</td>
        </tr>
        <tr>
            <th>Thưởng</th>
            <td>500,000 VNĐ</td>
        </tr>
        <tr>
            <th class="total-salary">Tổng lương</th>
            <td class="total-salary">5,964,265 VNĐ</td>
        </tr>
    </table>
    <button type="submit" class="xac-nhan-luong">Xác nhận</button>
</div>

</body>
</html>
