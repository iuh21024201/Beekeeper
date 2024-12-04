<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Beekeeper/model/mQuanLyCuaHang.php');
$mCuaHang = new mQuanLyCuaHang();
$cuahangs = $mCuaHang->selectAllCuaHang();
$nhanvienlist = $mCuaHang->selectAllNhanVien();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Thêm nhân viên mới
    if (isset($_POST['luuthongtin'])) {
        $fullName = $_POST['fullName'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); // Hash mật khẩu
        $position = $_POST['position']; // Quy ước mã phân quyền
        $store = $_POST['store']; // ID cửa hàng
        $status = $_POST['status'] == '1' ? 1 : 0;

        $conn = new mysqli("localhost", "root", "", "beekeeper");

        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        $sqlAccount = "INSERT INTO taikhoan (TenTaiKhoan, MatKhau, PhanQuyen) VALUES ('$username', '$password', $position)";
        if ($conn->query($sqlAccount) === TRUE) {
            $accountID = $conn->insert_id;
        } else {
            echo "Lỗi khi thêm tài khoản: " . $conn->error;
            exit;
        }

        $sqlEmployee = "INSERT INTO nhanvien (ID_TaiKhoan, ID_CuaHang, HoTen, username, SoDienThoai, Email, TrangThai) 
                        VALUES ('$accountID', '$store', '$fullName', '$username', '$phone', '$email', $status)";
        if ($conn->query($sqlEmployee) === TRUE) {
            echo "<script>alert('Thêm nhân viên thành công!');</script>";
            echo "<script>window.location.href = 'index.php?action=quan-ly-nhan-vien'</script>";
        } else {
            echo "Lỗi khi thêm nhân viên: " . $conn->error;
        }

        $conn->close();
    }

    if (isset($_POST['id'])) {
        $id = $_POST['id'] ?? null;
        $nhanvien = $mCuaHang->selectOneNhanVien($id);

        if ($nhanvien['TrangThai'] == 1) {
            $mCuaHang->updateTrangThai($id, 0);
        } else {
            $mCuaHang->updateTrangThai($id, 1);
        }

        echo "<script>alert('Cập nhật trạng thái nhân viên thành công!')</script>";
        echo "<script>window.location.href = 'index.php?action=quan-ly-nhan-vien'</script>";
    }

    // Cập nhật thông tin nhân viên
    if (isset($_POST['updateEmployeeID'])) {
        $updateEmployeeID = $_POST['updateEmployeeID'];
        $updateFullName = $_POST['updateFullName'];
        $updateEmail = $_POST['updateEmail'];
        $updatePhone = $_POST['updatePhone'];
        $updateUsername = $_POST['updateUsername'];
        $updatePosition = $_POST['updatePosition'];
        $updateStore = $_POST['updateStore'];
        $updateStatus = $_POST['updateStatus'] == '1' ? 1 : 0;

        $conn = new mysqli("localhost", "root", "", "beekeeper");

        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        $sqlUpdate = "UPDATE nhanvien 
                      SET HoTen='$updateFullName', Email='$updateEmail', SoDienThoai='$updatePhone', 
                          username='$updateUsername', ID_CuaHang='$updateStore', TrangThai='$updateStatus' 
                      WHERE ID_NhanVien='$updateEmployeeID'";

        $sqlUpdateAccount = "UPDATE taikhoan 
                             SET PhanQuyen='$updatePosition' 
                             WHERE ID_TaiKhoan=(SELECT ID_TaiKhoan FROM nhanvien WHERE ID_NhanVien='$updateEmployeeID')";

        if ($conn->query($sqlUpdate) === TRUE) {
            $conn->query($sqlUpdateAccount);
            echo "<script>alert('Cập nhật nhân viên thành công!');</script>";
            echo "<script>window.location.href = 'index.php?action=quan-ly-nhan-vien';</script>";
        } else {
            echo "Lỗi khi cập nhật nhân viên: " . $conn->error;
        }

        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="bg-gray-200">
    <div class="flex justify-between items-center ">
        <select id="cuahang" class="cuahang p-2" >
            <?php
            if (!empty($cuahangs)) {
                ?>
                <option value="all">Tất cả chi nhánh</option>
                <?php
                foreach ($cuahangs as $key => $value) {
                    ?>
                    <option value="<?= $value['ID_CuaHang'] ?>">Chi nhánh : <?= $value['TenCuaHang'] ?></option>
                    <?php
                }
            }
            ?>
        </select>
        <div class="flex justify-between items-center mb-4 mt-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                id="them-btn">Thêm</button>
        </div>
    </div>
    <table class="table table-bordered" id="ds-nhan-vien">
        <thead>
            <tr>
                <th class="p-2">Mã nhân viên</th>
                <th class="p-2">Họ và tên</th>
                <th class="p-2">Tên đăng nhập</th>
                <th class="p-2">Email</th>
                <th class="p-2">SDT</th>
                <th class="p-2">Mật khẩu</th>
                <th class="p-2">Chức vụ</th>
                <th class="p-2">Chi nhánh</th>
                <th class="p-2">Trạng thái</th>
                <th class="p-2">Hành động</th>
            </tr>
        </thead>
        <tbody id="ds-nhan-vien-tbody">
            <?php
            $nhanvienHoatDong = [];
            $nhanvienNgungHoatDong = [];
            // Phân loại nhân viên theo trạng thái
            foreach ($nhanvienlist as $nv) {
                // Xác định trạng thái
                $trangThai = ($nv['TrangThai'] == 0) ? 'Hoạt động' : 'Không hoạt động';

                // Phân loại vào mảng tương ứng
                if ($trangThai == 'Hoạt động') {
                    $nhanvienHoatDong[] = $nv;
                } else {
                    $nhanvienNgungHoatDong[] = $nv;
                }
            }

            // In ra bảng các nhân viên đang hoạt động
            foreach ($nhanvienHoatDong as $nv) {
                ?>
                <tr data-employee-id="<?= $nv['ID_NhanVien'] ?>">
                    <td><?= $nv['ID_NhanVien'] ?></td>
                    <td><?= $nv['HoTen'] ?></td>
                    <td><?= $nv['username'] ?></td>
                    <td><?= $nv['Email'] ?></td>
                    <td><?= $nv['SoDienThoai'] ?></td>
                    <td>********</td>
                    <td><?php
                        if ($nv['PhanQuyen'] == 3) {
                            echo 'Nhân viên';
                        } else if ($nv['PhanQuyen'] == 4) {
                            echo 'Nhân viên bếp';
                        } else if ($nv['PhanQuyen'] == 2) {
                            echo 'Quản lý cửa hàng';
                        }
                    ?></td>
                    <td><?= $nv['TenCuaHang'] ?></td>
                    <td>Hoạt động</td>
                    <td style="width: 200px">
                        <div class="d-flex justify-content-center alighn-items-center">
                            <button data-bs-toggle="modal" data-bs-target="#formEdit" style="margin-right: 10px"
                                type="button" class="btn btn-warning"
                                onclick="editEmployee('<?= $nv['ID_NhanVien'] ?>')">Sửa</button>
                            <form action="" method="POST">
                                <input type="hidden" name="id" value="<?= $nv['ID_NhanVien'] ?>">
                                <button type="submit" name="btnUpdateTrangThai" class="btn btn-danger">Thay đổi trạng
                                    thái</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php
            }

            // In ra bảng các nhân viên ngưng hoạt động
            foreach ($nhanvienNgungHoatDong as $nv) {
                ?>
                <tr data-employee-id="<?= $nv['ID_NhanVien'] ?>">
                    <td><?= $nv['ID_NhanVien'] ?></td>
                    <td><?= $nv['HoTen'] ?></td>
                    <td><?= $nv['username'] ?></td>
                    <td><?= $nv['Email'] ?></td>
                    <td><?= $nv['SoDienThoai'] ?></td>
                    <td>********</td>
                    <td><?php
                        if ($nv['PhanQuyen'] == 3) {
                            echo 'Nhân viên';
                        } else if ($nv['PhanQuyen'] == 4) {
                            echo 'Nhân viên bếp';
                        } else if ($nv['PhanQuyen'] == 2) {
                            echo 'Quản lý cửa hàng';
                        }
                    ?></td>
                    <td><?= $nv['TenCuaHang'] ?></td>
                    <td>Ngưng hoạt động</td>
                    <td style="width: 200px">
                        <div class="d-flex justify-content-center alighn-items-center">
                            <button data-bs-toggle="modal" data-bs-target="#formEdit" style="margin-right: 10px"
                                type="button" class="btn btn-warning"
                                onclick="editEmployee('<?= $nv['ID_NhanVien'] ?>')">Sửa</button>
                            <form action="" method="POST">
                                <input type="hidden" name="id" value="<?= $nv['ID_NhanVien'] ?>">
                                <button type="submit" name="btnUpdateTrangThai" class="btn btn-danger">Thay đổi trạng
                                    thái</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>


    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">NHẬP THÔNG TIN NHÂN VIÊN</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="form-container" class="form-container">
                            <div class="form-group">
                                <label for="fullName">Họ và tên</label>
                                <input type="text" class="form-control" id="fullName" name="fullName" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Số điện thoại</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="position">Chức vụ</label>
                                <select id="position" class="form-select" name="position" required>
                                    <option value="3">Nhân viên</option>
                                    <option value="4">Nhân viên bếp</option>
                                    <option value="2">Quản lý cửa hàng</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="store">Cửa hàng</label>
                                <select id="store" class="form-select" name="store" required>
                                    <?php
                                    if (!empty($cuahangs)) {
                                        foreach ($cuahangs as $key => $value) {
                                            ?>
                                            <option value="<?= $value['ID_CuaHang'] ?>">Chi nhánh : <?= $value['TenCuaHang'] ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" name="luuthongtin" class="btn btn-primary">Lưu thông tin</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Nút mở form -->
    <div class="modal fade" id="formEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">NHẬP THÔNG TIN NHÂN VIÊN</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="employeeID">Mã nhân viên</label>
                            <input type="hidden" class="form-control" id="updateEmployeeID" name="updateEmployeeID"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="fullName">Họ và tên</label>
                            <input type="text" class="form-control" id="updateFullName" name="updateFullName" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="updateEmail" name="updateEmail" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="tel" class="form-control" id="updatePhone" name="updatePhone" required>
                        </div>
                        <div class="form-group">
                            <label for="updateUsername">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="updateUsername" name="updateUsername" required>
                        </div>
                        <div class="form-group">
                            <label for="updatePosition">Chức vụ</label>
                            <select id="updatePosition" class="form-select" name="updatePosition" required>
                                <option value="3">Nhân viên</option>
                                <option value="4">Nhân viên bếp</option>
                                <option value="2">Quản lý cửa hàng</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="updateStore">Chi nhánh</label>
                            <select class="form-control" id="updateStore" name="updateStore">
                                <?php foreach ($cuahangs as $store) { ?>
                                    <option value="<?= $store['ID_CuaHang'] ?>"><?= $store['TenCuaHang'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="updateStatus">Trạng thái</label>
                            <select class="form-control" id="updateStatus" name="updateStatus">
                                <option value="0">Hoạt động</option>
                                <option value="1">Ngưng hoạt động</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.getElementById('cuahang').addEventListener('change', function () {
            var storeID = this.value;
            if (storeID == 'all') {
                window.location.href = 'index.php?action=quan-ly-nhan-vien';
            } else {
                if (storeID) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'ajax-ql-nv.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function () {
                        if (xhr.status == 200) {
                            // Cập nhật bảng nhân viên với dữ liệu trả về
                            document.getElementById('ds-nhan-vien-tbody').innerHTML = xhr.responseText;
                        } else {
                            console.error('Lỗi khi lấy dữ liệu nhân viên');
                        }
                    };
                    xhr.send('storeID=' + storeID);  // Gửi ID cửa hàng lên server
                }
            }

        });

        function openForm() {
            document.getElementById("form-container").style.display = "block";
            document.getElementById("them-btn").style.display = "none";
        }

        function editEmployee(employeeID) {
            $.ajax({
                url: 'ajax-ql-nv.php', // Endpoint để lấy thông tin nhân viên
                type: 'POST',
                data: { id: employeeID }, // Gửi ID nhân viên qua AJAX
                dataType: 'json',
                success: function (response) {
                    console.log(response);

                    if (response.success) {
                        // Gắn dữ liệu nhận được vào modal
                        $('#updateEmployeeID').val(response.data.ID_NhanVien);
                        $('#updateFullName').val(response.data.HoTen);
                        $('#updateEmail').val(response.data.Email);
                        $('#updatePhone').val(response.data.SoDienThoai);
                        $('#updateUsername').val(response.data.username);
                        $('#updatePosition').val(response.data.PhanQuyen);

                        // Đặt giá trị mặc định cho chi nhánh
                        $('#updateStore').val(response.data.ID_CuaHang);

                        // Kiểm tra nếu giá trị không tồn tại trong options
                        if (!$('#updateStore option[value="' + response.data.ID_CuaHang + '"]').length) {
                            // Nếu chi nhánh không có trong danh sách, thêm option mới
                            $('#updateStore').append(
                                '<option value="' + response.data.ID_CuaHang + '">' + response.data.TenCuaHang + '</option>'
                            );
                            $('#updateStore').val(response.data.ID_CuaHang);
                        }

                        // Trạng thái checkbox
                        $('#updateStatus').val(response.data.TrangThai);

                        // Hiển thị modal sửa
                        $('#formEdit').modal('show');
                    } else {
                        alert('Không tìm thấy thông tin nhân viên.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Có lỗi xảy ra:', error);
                    alert('Không thể lấy dữ liệu. Vui lòng thử lại.');
                }
            });
        }

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>
