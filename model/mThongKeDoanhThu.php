<?php
include_once("ketnoi.php");

class MThongKeDoanhThu {
    
    // Phương thức lấy doanh thu theo cửa hàng hoặc thời gian
    public function getDoanhThu($filterType, $startDate = null, $endDate = null) {
        $p = new clsketnoi();
        $con = $p->moKetNoi();  // Mở kết nối cơ sở dữ liệu
        
        // Điều kiện lọc theo ngày
        $donHangCondition = $startDate && $endDate ? "AND dh.NgayDat BETWEEN ? AND ?" : "";
        $datTiecCondition = $startDate && $endDate ? "AND dt.GioHen BETWEEN ? AND ?" : "";
    
        // Lựa chọn truy vấn tùy theo lọc theo cửa hàng hay thời gian
        if ($filterType === 'store') {
            $truyvan = "SELECT ch.TenCuaHang, 
                               IFNULL(dh_tong.DoanhThuDonHang, 0) AS DoanhThuDonHang,
                               IFNULL(dt_tong.DoanhThuDatTiec, 0) AS DoanhThuDatTiec,
                               (IFNULL(dh_tong.DoanhThuDonHang, 0) + IFNULL(dt_tong.DoanhThuDatTiec, 0)) AS TongDoanhThu
                        FROM CuaHang ch
                        LEFT JOIN (
                            SELECT dh.ID_CuaHang, SUM(ct.Soluong * m.Gia) AS DoanhThuDonHang
                            FROM DonHang dh
                            JOIN ChiTietDonHang ct ON dh.ID_DonHang = ct.ID_DonHang
                            JOIN MonAn m ON ct.ID_MonAn = m.ID_MonAn
                            WHERE dh.TrangThai = 'Đã thanh toán' $donHangCondition
                            GROUP BY dh.ID_CuaHang
                        ) dh_tong ON ch.ID_CuaHang = dh_tong.ID_CuaHang
                        LEFT JOIN (
                            SELECT dt.ID_CuaHang, 
                                   (IFNULL(SUM(m.Gia * ctdt.SoLuong), 0) + IFNULL(SUM(lt.Gia), 0)) AS DoanhThuDatTiec
                            FROM dontiec dt
                            JOIN ChiTietDatTiec ctdt ON dt.ID_DatTiec = ctdt.ID_DatTiec
                            JOIN MonAn m ON ctdt.ID_MonAn = m.ID_MonAn
                            LEFT JOIN LoaiTrangTri lt ON dt.ID_LoaiTrangTri = lt.ID_LoaiTrangTri
                            WHERE dt.TrangThai = 3 $datTiecCondition
                            GROUP BY dt.ID_CuaHang
                        ) dt_tong ON ch.ID_CuaHang = dt_tong.ID_CuaHang
                        ORDER BY TongDoanhThu DESC";
        } else {
            $truyvan = "SELECT DATE(dh.NgayDat) AS Ngay, 
                               SUM(ct.Soluong * m.Gia) AS DoanhThuDonHang,
                               0 AS DoanhThuDatTiec
                        FROM DonHang dh
                        JOIN ChiTietDonHang ct ON dh.ID_DonHang = ct.ID_DonHang
                        JOIN MonAn m ON ct.ID_MonAn = m.ID_MonAn
                        WHERE dh.TrangThai = 'Đã thanh toán' $donHangCondition
                        GROUP BY DATE(dh.NgayDat)
                        UNION ALL
                        SELECT DATE(dt.GioHen) AS Ngay, 
                               0 AS DoanhThuDonHang,
                               SUM(m.Gia * ctdt.SoLuong) + IFNULL(SUM(lt.Gia), 0) AS DoanhThuDatTiec
                        FROM dontiec dt
                        JOIN ChiTietDatTiec ctdt ON dt.ID_DatTiec = ctdt.ID_DatTiec
                        JOIN MonAn m ON ctdt.ID_MonAn = m.ID_MonAn
                        LEFT JOIN LoaiTrangTri lt ON dt.ID_LoaiTrangTri = lt.ID_LoaiTrangTri
                        WHERE dt.TrangThai = 3 $datTiecCondition
                        GROUP BY DATE(dt.GioHen)
                        ORDER BY Ngay";
        }
    
        // Thực thi truy vấn
        $stmt = $con->prepare($truyvan);
    
        if ($startDate && $endDate) {
            $stmt->bind_param("ssss", $startDate, $endDate, $startDate, $endDate);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Lấy dữ liệu kết quả
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    
        // Đóng kết nối và trả về kết quả
        $stmt->close();
        $p->dongKetNoi($con);
    
        return $data;
    }
    
    public function getDoanhThu1CuaHangByCuaHang( $startDate = null, $endDate = null, $idCuaHang = null) {
        $p = new clsketnoi();
        $con = $p->moKetNoi();  // Mở kết nối cơ sở dữ liệu
        
        // Điều kiện lọc theo ngày
        $donHangCondition = $startDate && $endDate ? "AND dh.NgayDat BETWEEN ? AND ?" : "";
        $datTiecCondition = $startDate && $endDate ? "AND dt.GioHen BETWEEN ? AND ?" : "";

        // Lựa chọn truy vấn tùy theo lọc theo cửa hàng hay thời gian
        $sql = "SELECT ch.TenCuaHang, 
                               IFNULL(dh_tong.DoanhThuDonHang, 0) AS DoanhThuDonHang,
                               IFNULL(dt_tong.DoanhThuDatTiec, 0) AS DoanhThuDatTiec,
                               (IFNULL(dh_tong.DoanhThuDonHang, 0) + IFNULL(dt_tong.DoanhThuDatTiec, 0)) AS TongDoanhThu
                        FROM CuaHang ch
                        LEFT JOIN (
                            SELECT dh.ID_CuaHang, SUM(ct.Soluong * m.Gia) AS DoanhThuDonHang
                            FROM DonHang dh
                            JOIN ChiTietDonHang ct ON dh.ID_DonHang = ct.ID_DonHang
                            JOIN MonAn m ON ct.ID_MonAn = m.ID_MonAn
                            WHERE dh.ID_CuaHang = ? 
                                AND dh.TrangThai = 'Đã thanh toán' $donHangCondition
                            GROUP BY dh.ID_CuaHang
                        ) dh_tong ON ch.ID_CuaHang = dh_tong.ID_CuaHang
                        LEFT JOIN (
                            SELECT dt.ID_CuaHang, 
                                   (IFNULL(SUM(m.Gia * ctdt.SoLuong), 0) + IFNULL(SUM(lt.Gia), 0)) AS DoanhThuDatTiec
                            FROM DonTiec dt
                            JOIN ChiTietDatTiec ctdt ON dt.ID_DatTiec = ctdt.ID_DatTiec
                            JOIN MonAn m ON ctdt.ID_MonAn = m.ID_MonAn
                            LEFT JOIN LoaiTrangTri lt ON dt.ID_LoaiTrangTri = lt.ID_LoaiTrangTri
                            WHERE dt.ID_CuaHang = ? 
                                AND dt.TrangThai = 3 $datTiecCondition
                            GROUP BY dt.ID_CuaHang
                        ) dt_tong ON ch.ID_CuaHang = dt_tong.ID_CuaHang
                        WHERE ch.ID_CuaHang = ? 
                        ORDER BY TongDoanhThu DESC";
        // Thực thi truy vấn
        $stmt = $con->prepare($sql);

        // Gán tham số
        if ($startDate && $endDate) {
            $stmt->bind_param("ississ", $idCuaHang, $startDate, $endDate, $idCuaHang, $startDate, $endDate);
        } else {
            $stmt->bind_param("iii", $idCuaHang, $idCuaHang, $idCuaHang);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Lấy dữ liệu kết quả
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Đóng kết nối và trả về kết quả
        $stmt->close();
        $p->dongKetNoi($con);

        return $data;
    }
    public function getDoanhThu1CuaHangByThoiGian($startDate = null, $endDate = null, $idCuaHang = null) {
        $p = new clsketnoi();
        $con = $p->moKetNoi();  // Mở kết nối cơ sở dữ liệu
    
        $donHangCondition = $startDate && $endDate ? "AND dh.NgayDat BETWEEN ? AND ?" : "";
        $datTiecCondition = $startDate && $endDate ? "AND dt.GioHen BETWEEN ? AND ?" : "";
    
        $sql = "SELECT DATE(dh.NgayDat) AS Ngay, 
                       SUM(IFNULL(ct.Soluong * m.Gia, 0)) AS DoanhThuDonHang,
                       0 AS DoanhThuDatTiec
                FROM DonHang dh
                JOIN ChiTietDonHang ct ON dh.ID_DonHang = ct.ID_DonHang
                JOIN MonAn m ON ct.ID_MonAn = m.ID_MonAn
                WHERE dh.ID_CuaHang = ? 
                    AND dh.TrangThai = 'Đã thanh toán' $donHangCondition
                GROUP BY DATE(dh.NgayDat)
                UNION ALL
                SELECT DATE(dt.GioHen) AS Ngay, 
                       0 AS DoanhThuDonHang,
                       SUM(IFNULL(m.Gia * ctdt.SoLuong, 0)) + IFNULL(SUM(lt.Gia), 0) AS DoanhThuDatTiec
                FROM DonTiec dt
                JOIN ChiTietDatTiec ctdt ON dt.ID_DatTiec = ctdt.ID_DatTiec
                JOIN MonAn m ON ctdt.ID_MonAn = m.ID_MonAn
                LEFT JOIN LoaiTrangTri lt ON dt.ID_LoaiTrangTri = lt.ID_LoaiTrangTri
                WHERE dt.ID_CuaHang = ? 
                    AND dt.TrangThai = 3 $datTiecCondition
                GROUP BY DATE(dt.GioHen)
                ORDER BY Ngay";
    
        $stmt = $con->prepare($sql);
    
        // Gán tham số
        if ($startDate && $endDate) {
            $stmt->bind_param("ississ", $idCuaHang, $startDate, $endDate, $idCuaHang, $startDate, $endDate);
        } else {
            $stmt->bind_param("ii", $idCuaHang, $idCuaHang);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    
        $stmt->close();
        $p->dongKetNoi($con);
    
        return $data;
    }
    
}
?>
