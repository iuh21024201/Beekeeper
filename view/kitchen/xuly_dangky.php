<?php
if (isset($_POST['xacnhan'])) {
    // Kết nối cơ sở dữ liệu
    session_start();

    // Kiểm tra quyền truy cập
    if (!isset($_SESSION["dn"]) || $_SESSION["dn"] != 4) {
        echo "<script>alert('Bạn không có quyền truy cập')</script>";
        header("refresh:0;url='../../index.php'");
        exit();
    }

    // Lấy ID_TaiKhoan từ session
    $idTaiKhoan = isset($_SESSION["ID_TaiKhoan"]) ? intval($_SESSION["ID_TaiKhoan"]) : 0;

    if ($idTaiKhoan > 0) {
        include_once('../../model/ketnoi.php');
        $p = new clsketnoi();
        $conn = $p->moKetNoi();

        // Câu lệnh SQL để lấy ID_NhanVien theo ID_TaiKhoan
        $sql = "SELECT ID_NhanVien FROM nhanvien WHERE ID_TaiKhoan = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idTaiKhoan); // Truyền tham số ID_TaiKhoan vào câu lệnh SQL
        $stmt->execute();
        $stmt->bind_result($idNhanVien); // Lấy kết quả trả về từ truy vấn
        $stmt->fetch(); // Lấy kết quả

        // Kiểm tra nếu tìm thấy ID_NhanVien
        if (!$idNhanVien) {
            echo "<script>alert('Không tìm thấy nhân viên với ID_TaiKhoan này.'); window.location.href='index.php?action=dang-ky-ca';</script>";
            exit();
        }

        // Đảm bảo kết quả truy vấn đã được xử lý
        $stmt->free_result(); // Giải phóng kết quả truy vấn sau khi sử dụng

        // Lấy dữ liệu từ form
        if (isset($_POST['ca_lam_viec']) && is_array($_POST['ca_lam_viec'])) {
            $ca_lam_viec = $_POST['ca_lam_viec'];

            // Lấy số tuần hiện tại
            $currentWeek = date('W') + 1;

            // Kiểm tra nếu đã có ca làm việc được đăng ký trong tuần hiện tại
            $sql = "SELECT * FROM chamcong WHERE ID_NhanVien = ? AND Tuan = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $idNhanVien, $currentWeek); // Thêm điều kiện lọc theo ID_NhanVien
            $stmt->execute();
            $result = $stmt->get_result();

            $is_new_registration = ($result->num_rows == 0); // Kiểm tra nếu không có ca nào đã đăng ký

            // Lưu lại danh sách ca đã đăng ký của nhân viên này
            $ca_dang_ky = [];
            while ($row = $result->fetch_assoc()) {
                $ca_dang_ky[] = $row['TenCa'] . " - " . date('d/m/Y', strtotime($row['ThoiGian']));
            }

            // So sánh danh sách ca đã đăng ký và danh sách ca hiện tại từ form
            $ca_can_xoa = array_diff($ca_dang_ky, $ca_lam_viec);

            // Xóa các ca làm việc không còn được chọn
            foreach ($ca_can_xoa as $ca) {
                list($ten_ca, $ngay_thu) = explode(" - ", $ca);
                $ngay_thu_array = explode("/", $ngay_thu);
                $ngay = $ngay_thu_array[0];
                $thang = $ngay_thu_array[1];
                $nam = $ngay_thu_array[2];
                // Xác định thứ từ ngày đã chọn
                $thu_array = ['Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy', 'Chủ Nhật'];
                $givenDate = "$nam-$thang-$ngay";
                $thu = $thu_array[date('N', strtotime($givenDate)) - 1];
                

                /// Xóa ca làm việc từ cơ sở dữ liệu
                $sql = "DELETE FROM chamcong WHERE TenCa = ? AND Thu = ? AND ThoiGian = ? AND Tuan = ? AND ID_NhanVien = ? AND TrangThai = ?";
                $stmt = $conn->prepare($sql);
                $trangThai = "Đăng ký ca"; // Giá trị Trạng thái

                // Đảm bảo rằng số lượng tham số khớp với chuỗi định dạng
                $stmt->bind_param("sssiis", $ten_ca, $thu, $givenDate , $currentWeek, $idNhanVien, $trangThai);

                // Thực thi câu lệnh
                $stmt->execute();

            }

            // 2. Thêm hoặc cập nhật các ca làm việc mới
            foreach ($ca_lam_viec as $ca) {
                // Tách dữ liệu ca làm việc và ngày
                list($ten_ca, $ngay_thu) = explode(" - ", $ca);
                $ngay_thu_array = explode("/", $ngay_thu);

                $ngay = $ngay_thu_array[0];
                $thang = $ngay_thu_array[1];
                $nam = $ngay_thu_array[2];

                // Xác định thứ từ ngày đã chọn
                $thu_array = ['Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy', 'Chủ Nhật'];
                $givenDate = "$nam-$thang-$ngay";
                $thu = $thu_array[date('N', strtotime($givenDate)) - 1];

                // Chuyển đổi ngày về định dạng SQL (YYYY-MM-DD)
                $ngay_lam_viec = "$nam-$thang-$ngay";

                // Tính số tuần trong năm từ ngày
                $so_tuan = date('W', strtotime($givenDate));

                // Kiểm tra nếu ca làm việc đã tồn tại trong cơ sở dữ liệu, nếu không thì thêm mới
                $sql = "SELECT * FROM chamcong WHERE TenCa = ? AND Thu= ?  AND ThoiGian = ? AND Tuan = ? AND ID_NhanVien = ? AND TrangThai = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssiis", $ten_ca, $thu, $ngay_lam_viec, $so_tuan, $idNhanVien, $trangThai);
                $trangThai = "Đăng ký ca"; // Giá trị Trạng thái
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 0) {
                    // Ca làm việc chưa tồn tại, thêm mới và lưu trạng thái "Đăng ký"
                    $sql = "INSERT INTO chamcong (TenCa, Thu, ThoiGian, Tuan, ID_NhanVien, TrangThai) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssiis", $ten_ca, $thu, $ngay_lam_viec, $so_tuan, $idNhanVien, $trangThai);
                    $trangThai = "Đăng ký ca"; // Giá trị Trạng thái
                    $stmt->execute();
                }
            }

            $stmt->close();
            $conn->close();

            // Thông báo dựa trên loại hành động (đăng ký mới hoặc cập nhật)
            if ($is_new_registration) {
                echo "<script>alert('Đăng ký ca làm việc thành công!'); window.location.href='index.php?action=dang-ky-ca';</script>";
            } else {
                echo "<script>alert('Cập nhật ca làm việc thành công!'); window.location.href='index.php?action=dang-ky-ca';</script>";
            }
        } else {
            // Thông báo lỗi
            echo "<script>alert('Vui lòng chọn ít nhất một ca làm việc!'); window.location.href='index.php?action=dang-ky-ca';</script>";
        }
    }
}
?>