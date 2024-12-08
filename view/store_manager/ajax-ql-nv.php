<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Beekeeper_4/model/mQuanLyCuaHang.php');

$mCuaHang = new mQuanLyCuaHang();

if (isset($_POST['storeID'])) {
    $storeID = $_POST['storeID'];
    $nhanvienlist = $mCuaHang->getEmployeesByStore($storeID);

    // In lại bảng nhân viên
    if (!empty($nhanvienlist)) {
        foreach ($nhanvienlist as $nv) {
            $chucVu = ($nv['PhanQuyen'] == 2) ? 'Nhân viên' : 'Nhân viên bếp';
            $status = ($nv['TrangThai'] == 1) ? 'Hoạt động' : 'Không hoạt động';
            echo "<tr>
                    <td>{$nv['ID_NhanVien']}</td>
                    <td>{$nv['HoTen']}</td>
                    <td>{$nv['username']}</td>
                    <td>{$nv['Email']}</td>
                    <td>{$nv['SoDienThoai']}</td>
                    <td>********</td>
                    <td>{$chucVu}</td>
                    <td>{$nv['TenCuaHang']}</td>
                    <td>{$status}</td>
                    <td>
                        <form action='' method='POST'>
                            <input type='hidden' name='id' value='{$nv['ID_NhanVien']}'>
                            <button type='submit' class='btn btn-warning'>Thay đổi trạng thái</button>
                        </form>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='10'>Không có nhân viên nào.</td></tr>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nhanvien = $mCuaHang->selectOneNhanVien($id);

    if ($nhanvien) {
        echo json_encode([
            'success' => true,
            'data' => $nhanvien
        ]);
    }
}