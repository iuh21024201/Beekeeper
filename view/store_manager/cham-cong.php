<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chấm Công Nhân Viên</title>
    <style>
        .chon-thang{
            align-items: center;
            margin: 0 auto;
        }
        .chon-thang input{
            margin-left: 10px;
        }
        .chon-thang label{
            margin: 0 auto;
        }
        h3{
            text-align: center;
        }
        table {
            align-items: center;
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        th, td {
            border: 1px solid #ccc;
            text-align: center;
            padding: 10px;
        }
        th {
            background-color: #e0e0e0;
            font-weight: bold;
        }
        .shift {
            font-weight: bold;
        }
        .employee-checkbox {
            margin: 5px 0;
        }
        .submit-btn {
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
        .submit-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div>
    <div class="chon-thang" style="border: 1px solid black; padding: 10px; width: 350px;display:flex;">
        <label for="">Chọn tuần: </label>
        <input type="week">
    </div>
    
    <h3>Chấm Công Nhân Viên</h3>
    <table>
        <tr>
            <th></th>
            <th>Thứ 2</th>
            <th>Thứ 3</th>
            <th>Thứ 4</th>
            <th>Thứ 5</th>
            <th>Thứ 6</th>
            <th>Thứ 7</th>
            <th>Chủ nhật</th>
        </tr>
        <tr>
            <td class="shift">Ca A<br>8h - 14h</td>
            <td><input type="checkbox" class="employee-checkbox"> Nhân viên 1<br><input type="checkbox" class="employee-checkbox"> Nhân viên 2</td>
            <td><input type="checkbox" class="employee-checkbox"> Nhân viên 3<br><input type="checkbox" class="employee-checkbox"> Nhân viên 4</td>
            <td><input type="checkbox" class="employee-checkbox"> Nhân viên 5<br><input type="checkbox" class="employee-checkbox"> Nhân viên 6</td>
            <td><input type="checkbox" class="employee-checkbox"> Nhân viên 7<br><input type="checkbox" class="employee-checkbox"> Nhân viên 8</td>
            <td><input type="checkbox" class="employee-checkbox"> Nhân viên 9<br><input type="checkbox" class="employee-checkbox"> Nhân viên 10</td>
            <td><input type="checkbox" class="employee-checkbox"> Nhân viên 11<br><input type="checkbox" class="employee-checkbox"> Nhân viên 12</td>
            <td><input type="checkbox" class="employee-checkbox"> Nhân viên 13<br><input type="checkbox" class="employee-checkbox"> Nhân viên 14</td>
        </tr>
        <tr>
            <td class="shift">Ca B<br>14h - 20h</td>
            <td><input type="checkbox" class="employee-checkbox"> Nhân viên 15<br><input type="checkbox" class="employee-checkbox"> Nhân viên 16</td>
            <td><input type="checkbox" class="employee-checkbox"> Nhân viên 17<br><input type="checkbox" class="employee-checkbox"> Nhân viên 18</td>
            <td><input type="checkbox" class="employee-checkbox"> Nhân viên 19<br><input type="checkbox" class="employee-checkbox"> Nhân viên 20</td>
            <td><input type="checkbox" class="employee-checkbox"> Nhân viên 21<br><input type="checkbox" class="employee-checkbox"> Nhân viên 22</td>
            <td><input type="checkbox" class="employee-checkbox"> Nhân viên 23<br><input type="checkbox" class="employee-checkbox"> Nhân viên 24</td>
            <td><input type="checkbox" class="employee-checkbox"> Nhân viên 25<br><input type="checkbox" class="employee-checkbox"> Nhân viên 26</td>
            <td><input type="checkbox" class="employee-checkbox"> Nhân viên 27<br><input type="checkbox" class="employee-checkbox"> Nhân viên 28</td>
        </tr>
    </table>

    <button class="submit-btn" onclick="submitAttendance()">Chấm Công</button>
</div>

<script>
    function submitAttendance() {
        // Lấy tất cả checkbox đã được chọn
        const checkedEmployees = document.querySelectorAll('.employee-checkbox:checked');
        
        if (checkedEmployees.length === 0) {
            alert("Vui lòng chọn ít nhất một nhân viên để chấm công.");
            return;
        }
        
        // Duyệt qua các checkbox đã chọn và in ra tên nhân viên (giả sử tên nằm ngay sau checkbox)
        let message = "Chấm công thành công cho các nhân viên:\n";
        checkedEmployees.forEach((checkbox) => {
            message += "- " + checkbox.nextSibling.textContent.trim() + "\n";
        });
        
        alert(message);
    }
</script>

</body>
</html>
