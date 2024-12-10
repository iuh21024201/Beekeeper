<?php
require_once('../../model/mQuanLyCuaHang.php');


$mCuaHang = new mQuanLyCuaHang();

if (isset($_POST['storeID'])) {
    $storeID = $_POST['storeID'];
    $nhanvienlist = $mCuaHang->getEmployeesByStore($storeID);
    $quanlylist = $mCuaHang->getEmployeesByStoreQuanLy($storeID);

    // In lại bảng nhân viên
    if (!empty($nhanvienlist)) {
        foreach ($nhanvienlist as $nv) {
            $chucVu = ($nv['PhanQuyen'] == 2) ? 'Nhân viên' : 'Nhận viên bếp';
            $status = ($nv['TrangThai'] == 1) ? 'Hoạt động' : 'Không hoạt động';
            ?>
            <tr>
                <td><?= $nv['ID_NhanVien'] ?></td>
                <td><?= $nv['HoTen'] ?></td>
                <td><?= $nv['TenTaiKhoan'] ?></td>
                <td><?= $nv['Email'] ?></td>
                <td><?= $nv['SoDienThoai'] ?></td>
                <td>********</td>
                <td><?= $chucVu ?></td>
                <td><?= $nv['TenCuaHang'] ?></td>
                <td><?= $status ?></td>
                <td style="width: 200px">
                    <div class="d-flex justify-content-center alighn-items-center">
                        <button data-bs-toggle="modal" data-bs-target="#formEdit" style="margin-right: 10px" type="button"
                            class="btn btn-warning" onclick="editEmployee('<?= $nv['ID_NhanVien'] ?>')">Sửa</button>
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
    }

    if (!empty($quanlylist)) {
        foreach ($quanlylist as $ql) {
            $chucVu = ($ql['PhanQuyen'] == 2) ? 'Nhân viên' : 'Nhận viên bếp';
            $status = ($ql['TrangThai'] == 1) ? 'Hoạt động' : 'Không hoạt động';
            ?>
            <tr>
                <td><?= $ql['ID_QuanLyCuaHang'] ?></td>
                <td><?= $ql['HoTen'] ?></td>
                <td><?= $ql['TenTaiKhoan'] ?></td>
                <td><?= $ql['Email'] ?></td>
                <td><?= $ql['SoDienThoai'] ?></td>
                <td>********</td>
                <td><?= $chucVu ?></td>
                <td><?= $ql['TenCuaHang'] ?></td>
                <td><?= $status ?></td>
                <td style="width: 200px">
                    <div class="d-flex justify-content-center alighn-items-center">
                        <button data-bs-toggle="modal" data-bs-target="#formEdit" style="margin-right: 10px" type="button"
                            class="btn btn-warning" onclick="editEmployee('<?= $ql['ID_QuanLyCuaHang'] ?>')">Sửa</button>
                        <form action="" method="POST">
                            <input type="hidden" name="id" value="<?= $ql['ID_QuanLyCuaHang'] ?>">
                            <button type="submit" name="btnUpdateTrangThai" class="btn btn-danger">Thay đổi trạng
                                thái</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nhanvienL = $mCuaHang->selectOneNhanVien($id);
    $quanlyL = $mCuaHang->selectOneQL($id);

    if (!empty($nhanvienL)) {
        $nhanvien = $mCuaHang->selectOneNhanVien($id);
    } 

    if (!empty($quanlyL)) {
        $nhanvien = $mCuaHang->selectOneQL($id);
    }

    if ($nhanvien) {
        echo json_encode([
            'success' => true,
            'data' => $nhanvien
        ]);
    }
}