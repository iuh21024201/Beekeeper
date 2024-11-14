-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 06, 2024 lúc 06:00 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_beekeeper_1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ban`
--

CREATE TABLE `ban` (
  `ID_Ban` int(10) NOT NULL,
  `ID_CuaHang` int(10) NOT NULL,
  `TinhTrang` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ban`
--

INSERT INTO `ban` (`ID_Ban`, `ID_CuaHang`, `TinhTrang`) VALUES
(1, 1, 0),
(2, 1, 0),
(3, 1, 0),
(4, 1, 0),
(5, 1, 0),
(6, 1, 0),
(7, 1, 0),
(8, 1, 0),
(9, 1, 0),
(10, 1, 0),
(11, 1, 0),
(12, 1, 0),
(13, 2, 0),
(14, 2, 0),
(15, 2, 0),
(16, 2, 0),
(17, 2, 0),
(18, 2, 0),
(19, 2, 0),
(20, 2, 0),
(21, 2, 0),
(22, 2, 0),
(23, 2, 0),
(24, 2, 0),
(25, 3, 0),
(26, 3, 0),
(27, 3, 0),
(28, 3, 0),
(29, 3, 0),
(30, 3, 0),
(31, 3, 0),
(32, 3, 0),
(33, 3, 0),
(34, 3, 0),
(35, 3, 0),
(36, 3, 0),
(37, 4, 0),
(38, 4, 0),
(39, 4, 0),
(40, 4, 0),
(41, 4, 0),
(42, 4, 0),
(43, 4, 0),
(44, 4, 0),
(45, 4, 0),
(46, 4, 0),
(47, 4, 0),
(48, 4, 0),
(49, 5, 0),
(50, 5, 0),
(51, 5, 0),
(52, 5, 0),
(53, 5, 0),
(54, 5, 0),
(55, 5, 0),
(56, 5, 0),
(57, 5, 0),
(58, 5, 0),
(59, 5, 0),
(60, 5, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chamcong`
--

CREATE TABLE `chamcong` (
  `ID_NhanVien` int(10) NOT NULL,
  `ID_Lich` int(10) NOT NULL,
  `NgayChamCong` date NOT NULL,
  `Checkin` time NOT NULL,
  `CheckOut` time NOT NULL,
  `SoGioLam` float NOT NULL,
  `TrangThai` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdattiec`
--

CREATE TABLE `chitietdattiec` (
  `ID_DatTiec` int(10) NOT NULL,
  `ID_MonAn` int(10) NOT NULL,
  `Gia` double NOT NULL,
  `SoLuong` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdonhang`
--

CREATE TABLE `chitietdonhang` (
  `ID_DonHang` int(10) NOT NULL,
  `ID_MonAn` int(10) NOT NULL,
  `SoLuong` int(10) NOT NULL,
  `Ghichu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`ID_DonHang`, `ID_MonAn`, `SoLuong`, `Ghichu`) VALUES
(2, 8, 3, ''),
(2, 19, 1, ''),
(2, 2, 2, 'không cay'),
(3, 15, 1, 'thêm sốt'),
(4, 18, 2, ''),
(4, 11, 2, 'nhiều cơm'),
(5, 4, 5, ''),
(5, 20, 2, ''),
(5, 12, 1, '2 gói tương cà');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietmonan`
--

CREATE TABLE `chitietmonan` (
  `ID_MonAn` int(10) NOT NULL,
  `ID_NguyenLieu` int(10) NOT NULL,
  `SoLuongNguyenLieu` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietmonan`
--

INSERT INTO `chitietmonan` (`ID_MonAn`, `ID_NguyenLieu`, `SoLuongNguyenLieu`) VALUES
(1, 22, 1),
(1, 21, 1),
(2, 22, 1),
(2, 19, 1),
(3, 22, 1),
(3, 21, 1),
(4, 10, 1),
(4, 6, 1),
(5, 10, 1),
(5, 21, 1),
(6, 10, 1),
(6, 21, 1),
(7, 10, 1),
(7, 6, 1),
(8, 7, 1),
(9, 7, 1),
(9, 6, 1),
(10, 7, 1),
(10, 21, 1),
(11, 7, 1),
(11, 3, 2),
(12, 6, 1),
(13, 6, 2),
(14, 6, 3),
(15, 3, 3),
(16, 3, 5),
(17, 9, 1),
(18, 9, 1),
(19, 2, 1),
(19, 8, 1),
(20, 16, 1),
(20, 14, 1),
(20, 18, 1),
(19, 1, 1),
(1, 15, 1),
(2, 15, 1),
(3, 15, 1),
(4, 2, 1),
(5, 2, 1),
(6, 2, 1),
(7, 2, 1),
(10, 5, 1),
(11, 5, 1),
(1, 13, 1),
(2, 13, 1),
(3, 13, 1),
(4, 12, 1),
(5, 12, 1),
(6, 12, 1),
(7, 12, 1),
(19, 11, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietnguyenlieu`
--

CREATE TABLE `chitietnguyenlieu` (
  `ID_NguyenLieu` int(10) NOT NULL,
  `ID_PhieuDat` int(10) NOT NULL,
  `ID_CuaHang` int(10) NOT NULL,
  `SoLuong` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cuahang`
--

CREATE TABLE `cuahang` (
  `ID_CuaHang` int(10) NOT NULL,
  `TenCuaHang` varchar(50) NOT NULL,
  `DiaChi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cuahang`
--

INSERT INTO `cuahang` (`ID_CuaHang`, `TenCuaHang`, `DiaChi`) VALUES
(1, 'Quang Trung', '275 Quang Trung phường 10 Quận Gò Vấp'),
(2, 'Lê Quang Định ', '133 Lê Quang Định Phường 14 Quận Bình Thạnh'),
(3, 'Điện Biên Phủ', '25 Điện Biên Phủ Phường 15 Quận Bình Thạnh'),
(4, 'Cách Mạng Tháng 8', '201 Cách Mạng Tháng 8 Phường 4 Quận 3'),
(5, 'Nam Kì Khởi Nghĩa', '103 Nam Kì Khởi Nghĩa Khu Phố 1 Quận 1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dangkyca`
--

CREATE TABLE `dangkyca` (
  `ID_Ca` int(10) NOT NULL,
  `ID_NhanVien` int(10) NOT NULL,
  `TenCa` varchar(50) NOT NULL,
  `ThoiGian` date NOT NULL,
  `Tuan` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhsachdexuatmonmoi`
--

CREATE TABLE `danhsachdexuatmonmoi` (
  `ID_MonMoi` int(10) NOT NULL,
  `ID_NhanVien` int(10) NOT NULL,
  `TenMon` varchar(50) NOT NULL,
  `NguyenLieu` text NOT NULL,
  `MoTa` text NOT NULL,
  `Gia` double NOT NULL,
  `TrangThai` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhsachdexuatmonmoi`
--

INSERT INTO `danhsachdexuatmonmoi` (`ID_MonMoi`, `ID_NhanVien`, `TenMon`, `NguyenLieu`, `MoTa`, `Gia`, `TrangThai`) VALUES
(1, 1, 'Burger Phô Mai Bò Nướng', 'Thịt bò, phô mai, bánh mì, xà lách, cà chua', 'Burger với thịt bò nướng kèm phô mai tan chảy', 65000, 0),
(2, 1, 'Mì Ý Sốt Kem Gà', 'Mì Ý, sốt kem, gà, nấm, phô mai', 'Mì Ý kèm sốt kem béo ngậy và thịt gà', 70000, 0),
(3, 2, 'Salad Trái Cây Tươi', 'Dưa hấu, xoài, nho, cam, sốt chanh dây', 'Salad trái cây tươi mát và giàu vitamin', 45000, 0),
(4, 5, 'Gà Rán Sốt Tỏi Mật Ong', 'Gà rán, tỏi, mật ong, tiêu, hành lá', 'Gà rán phủ sốt tỏi mật ong thơm ngon', 55000, 0),
(5, 4, 'Súp Miso Rong Biển', 'Rong biển, đậu hũ, hành lá, miso, nước dùng', 'Súp miso Nhật Bản thanh đạm và bổ dưỡng', 30000, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhsachyeucaubosungnguyenlieu`
--

CREATE TABLE `danhsachyeucaubosungnguyenlieu` (
  `ID_YeuCau` int(10) NOT NULL,
  `ID_CuaHangGui` int(10) NOT NULL,
  `ID_CuaHangNhan` int(10) NOT NULL,
  `ID_NguyenLieu` int(10) NOT NULL,
  `TrangThai` int(2) NOT NULL,
  `SoLuong` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `ID_DonHang` int(10) NOT NULL,
  `ID_CuaHang` int(10) NOT NULL,
  `ID_KhachHang` int(10) NOT NULL,
  `NgayDat` date NOT NULL,
  `DiaChiGiaoHang` varchar(50) NOT NULL,
  `TrangThai` varchar(50) NOT NULL,
  `PhuongThucThanhToan` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`ID_DonHang`, `ID_CuaHang`, `ID_KhachHang`, `NgayDat`, `DiaChiGiaoHang`, `TrangThai`, `PhuongThucThanhToan`) VALUES
(2, 1, 22, '2024-10-08', '12 Nguyễn Văn Lượng ', 'Đã giao hàng', 1),
(3, 2, 21, '2024-09-11', '638 Phạm Văn Đồng ', 'Đặt thành công và thu tiền mặt', 0),
(4, 4, 23, '2024-11-03', '35 Ung Văn Khiêm ', 'Đặt thành công và chuyển khoản', 1),
(5, 3, 24, '2024-11-01', '3 Phạm Ngọc Thạch', 'Đã thanh toán', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dontiec`
--

CREATE TABLE `dontiec` (
  `ID_DatTiec` int(10) NOT NULL,
  `ID_KhachHang` int(10) NOT NULL,
  `ID_CuaHang` int(10) NOT NULL,
  `GioHen` date NOT NULL,
  `TrangTri` varchar(50) NOT NULL,
  `SoNguoi` int(10) NOT NULL,
  `TongTien` double NOT NULL,
  `TienCoc` double NOT NULL,
  `TienConLai` double NOT NULL,
  `GhiChu` text NOT NULL,
  `TrangThai` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `ID_KhachHang` int(10) NOT NULL,
  `ID_TaiKhoan` int(10) NOT NULL,
  `HoTen` varchar(50) NOT NULL,
  `SoDienThoai` varchar(10) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `DiaChi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`ID_KhachHang`, `ID_TaiKhoan`, `HoTen`, `SoDienThoai`, `Email`, `DiaChi`) VALUES
(21, 16, 'Trần Minh Hiếu', '0912345678', 'hieutran@gmail.', '123 Đường A, Quận 1, TP. HCM'),
(22, 15, 'Trần Tấn Tài ', '0912345678', 'trantantai.3013@gmail.', '789 Đường C, Quận 3, TP. HCM'),
(23, 13, 'Bùi Thanh Bình ', '0945678901', 'thanhbinh@gmail.', '321 Đường D, Quận 4, TP. HCM'),
(24, 14, 'Nguyễn Tuấn Dũng', '0956789012', 'tuandung@gmail.', '987 Đường F, Quận 6, TP. HCM');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lichlamviec`
--

CREATE TABLE `lichlamviec` (
  `ID_Lich` int(10) NOT NULL,
  `ID_NhanVien` int(10) NOT NULL,
  `TenCa` varchar(50) NOT NULL,
  `ThoiGian` date NOT NULL,
  `Tuan` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaimonan`
--

CREATE TABLE `loaimonan` (
  `ID_LoaiMon` int(10) NOT NULL,
  `TenLoaiMon` varchar(50) NOT NULL,
  `HinhLoaiMon` varchar(50) NOT NULL,
  `TrangThai` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `loaimonan`
--

INSERT INTO `loaimonan` (`ID_LoaiMon`, `TenLoaiMon`, `HinhLoaiMon`, `TrangThai`) VALUES
(1, 'Thức Ăn Nhẹ', 'thuc_an_nhe.png', 0),
(2, 'Burger', 'burger.png', 0),
(3, 'Mì Ý', 'mi_y.png', 0),
(4, 'Cơm', 'com.png', 0),
(5, 'Gà Rán', 'ga_ran.png', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `luong`
--

CREATE TABLE `luong` (
  `ID_Luong` int(10) NOT NULL,
  `ID_NhanVien` int(10) NOT NULL,
  `TongGioLam` float NOT NULL,
  `LuongTheoGio` double NOT NULL,
  `Thuong` double NOT NULL,
  `TongLuong` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `numberPhone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `monan`
--

CREATE TABLE `monan` (
  `ID_MonAn` int(10) NOT NULL,
  `ID_LoaiMon` int(10) NOT NULL,
  `TenMonAn` varchar(50) NOT NULL,
  `MoTa` text NOT NULL,
  `Gia` double NOT NULL,
  `HinhAnh` varchar(50) NOT NULL,
  `TinhTrang` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `monan`
--

INSERT INTO `monan` (`ID_MonAn`, `ID_LoaiMon`, `TenMonAn`, `MoTa`, `Gia`, `HinhAnh`, `TinhTrang`) VALUES
(1, 2, 'Burger Gà Quay Flava', '', 54000, 'burger_ga_quay_flava.jpg', 0),
(2, 2, 'Burger Tôm', '', 45000, 'burger_tom.jpg', 0),
(3, 2, 'Burger Zinger', '', 54000, 'burger_zinger.jpg', 0),
(4, 3, 'Mì Ý Gà Rán', '', 64000, 'mi_y_ga_ran.jpg', 0),
(5, 3, 'Mì Ý Gà Viên', '', 40000, 'mi_y_ga_vien.jpg', 0),
(6, 3, 'Mì Ý Gà Zinger', '', 58000, 'mi_y_ga_zinger.jpg', 0),
(7, 3, 'Mì Ý Phi Lê Gà Quay', '', 61000, 'mi_y_phi_le_ga_quay.jpg', 0),
(8, 4, 'Cơm', '', 12000, 'com.jpg', 0),
(9, 4, 'Cơm Gà Rán', '', 48000, 'com_ga_ran.jpg', 0),
(10, 4, 'Cơm Phi Lê Gà Quay', '', 61000, 'com_phi_le_ga_quay.jpg', 0),
(11, 4, 'Cơm Gà Teriyaki', '', 45000, 'com_ga_teriyaki.jpg', 0),
(12, 5, '1 Miếng Gà Rán', '', 35000, '1_mieng_ga_ran.jpg', 0),
(13, 5, '2 Miếng Gà Rán', '', 70000, '2_mieng_ga_ran.jpg', 0),
(14, 5, '3 Miếng Gà Rán', '', 100000, '3_mieng_ga_ran.jpg', 0),
(15, 5, '3 Cánh Gà Hot Wings', '', 54000, '3_canh_ga_hot_wings.jpg', 0),
(16, 5, '5 Cánh Gà Hot Wings', '', 86000, '5_canh_ga_hot_wings.jpg', 0),
(17, 1, 'Khoai Tây Chiên', '', 28000, 'khoai_tay_chien.jpg', 0),
(18, 1, 'Khoai Tây Nghiền', '', 22000, 'khoai_tay_nghien.jpg', 0),
(19, 1, 'Bắp Cải Trộn', '', 22000, 'bap_cai_tron.jpg', 0),
(20, 1, 'Súp Rong Biển', '', 19000, 'sup_rong_bien.jpg', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguyenlieu`
--

CREATE TABLE `nguyenlieu` (
  `ID_NguyenLieu` int(10) NOT NULL,
  `TenNguyenLieu` varchar(50) NOT NULL,
  `GiaMua` double NOT NULL,
  `HinhAnh` varchar(50) NOT NULL,
  `DonViTinh` varchar(50) NOT NULL,
  `TrangThai` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nguyenlieu`
--

INSERT INTO `nguyenlieu` (`ID_NguyenLieu`, `TenNguyenLieu`, `GiaMua`, `HinhAnh`, `DonViTinh`, `TrangThai`) VALUES
(1, 'Bắp cải', 30000, 'bap_cai.jpg', 'đ/kg', 0),
(2, 'Cà chua', 60000, 'ca_chua.jpg', 'đ/kg', 0),
(3, 'Cánh gà', 105000, 'canh_ga.jpg', 'đ/kg', 0),
(4, 'Đậu hũ non', 13000, 'dau_hu_non.jpg', 'đ/hộp', 0),
(5, 'Dưa leo', 30000, 'dua_leo.jpg', 'đ/kg', 0),
(6, 'Đùi gà', 103000, 'dui_ga.jpg', 'đ/kg', 0),
(7, 'Gạo', 28000, 'gao.jpg', 'đ/kg', 0),
(8, 'Hành tây', 25000, 'hanh_tay.jpg', 'đ/kg', 0),
(9, 'Khoai tây', 30000, 'khoai_tay.jpg', 'đ/kg', 0),
(10, 'Mỳ ý', 36000, 'my_y.jpg', 'đ/gói', 0),
(11, 'Ớt chuông', 60000, 'ot_chuong.jpg', 'đ/kg', 0),
(12, 'Phô mai sợi', 48000, 'pho_mai_soi.jpg', 'đ/gói', 0),
(13, 'Phô mai lát', 60000, 'pho_mai_lat.jpg', 'đ/gói', 0),
(14, 'Rau mùi thơm', 55000, 'rau_mui_thom.jpg', 'đ/kg', 0),
(15, 'Rau xà lách', 40000, 'rau_xa_lach.jpg', 'đ/kg', 0),
(16, 'Rong biển', 110000, 'rong_bien.jpg', 'đ/gói', 0),
(17, 'Thịt bò', 200000, 'thit_bo.jpg', 'đ/kg', 0),
(18, 'Thịt heo', 120000, 'thit_heo.jpg', 'đ/kg', 0),
(19, 'Tôm', 185000, 'tom.jpg', 'đ/kg', 0),
(20, 'Trứng gà', 25000, 'trung_ga.jpg', 'đ/hộp', 0),
(21, 'Ức gà', 80000, 'uc_ga.jpg', 'đ/kg', 0),
(22, 'Vỏ bánh mì', 50000, 'vo_banh_mi.jpg', 'đ/gói', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `ID_NhanVien` int(10) NOT NULL,
  `ID_TaiKhoan` int(10) NOT NULL,
  `ID_CuaHang` int(10) NOT NULL,
  `HoTen` varchar(50) NOT NULL,
  `SoDienThoai` varchar(10) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `TrangThai` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`ID_NhanVien`, `ID_TaiKhoan`, `ID_CuaHang`, `HoTen`, `SoDienThoai`, `Email`, `TrangThai`) VALUES
(1, 7, 1, 'Nguyễn Văn Hoàng', '0123456789', 'nguyenvanhoang@gmail.com\r\n', 0),
(2, 8, 2, 'Trần Thị Mai', '0123456790', 'tranthimai@gmail.com', 0),
(3, 9, 3, 'Lê Văn Phúc', '0123456789', 'levanphuc@gmail.com', 0),
(4, 10, 4, 'Phạm Thị Lan', '0123456792', 'phamthilan@gmail.com', 0),
(5, 68, 5, 'Vũ Văn Hùng', '0123456793', 'vuvanhung@gmail.com', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieudathang`
--

CREATE TABLE `phieudathang` (
  `ID_PhieuDatHang` int(10) NOT NULL,
  `ID_CuaHang` int(10) NOT NULL,
  `TongTien` double NOT NULL,
  `NgayDat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quanlychuoi`
--

CREATE TABLE `quanlychuoi` (
  `ID_TaiKhoan` int(10) NOT NULL,
  `ID_QuanLyChuoi` int(10) NOT NULL,
  `HoTen` varchar(50) NOT NULL,
  `SoDienThoai` varchar(10) NOT NULL,
  `Email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `quanlychuoi`
--

INSERT INTO `quanlychuoi` (`ID_TaiKhoan`, `ID_QuanLyChuoi`, `HoTen`, `SoDienThoai`, `Email`) VALUES
(1, 2, 'Nguyễn Thanh Tùng', '0385902205', 'thanhtung@gmail.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quanlycuahang`
--

CREATE TABLE `quanlycuahang` (
  `ID_TaiKhoan` int(10) NOT NULL,
  `ID_CuaHang` int(10) NOT NULL,
  `ID_QuanLyCuaHang` int(10) NOT NULL,
  `HoTen` varchar(50) NOT NULL,
  `SoDienThoai` varchar(10) NOT NULL,
  `Email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `quanlycuahang`
--

INSERT INTO `quanlycuahang` (`ID_TaiKhoan`, `ID_CuaHang`, `ID_QuanLyCuaHang`, `HoTen`, `SoDienThoai`, `Email`) VALUES
(2, 1, 6, 'Phan Thắng Huy', '0901234567', 'thanghuy@gmail.com'),
(3, 2, 7, 'Nguyễn Minh Cường', '0912345678', 'minhcuong@gmail.com'),
(4, 3, 8, 'Trần Quang Hiếu', '0934567890', 'quanghieu@gmail.com'),
(5, 4, 9, 'Nguyễn Việt ', '0923456789', 'hoangviet@gmail.com'),
(6, 5, 10, 'Trần Minh Hiếu ', '0945678901', 'minhhieu@gmail.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `ID_TaiKhoan` int(10) NOT NULL,
  `TenTaiKhoan` varchar(50) NOT NULL,
  `MatKhau` varchar(50) NOT NULL,
  `PhanQuyen` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `taikhoan`
--

INSERT INTO `taikhoan` (`ID_TaiKhoan`, `TenTaiKhoan`, `MatKhau`, `PhanQuyen`) VALUES
(1, 'quanlichuoi', 'e10adc3949ba59abbe56e057f20f883e', 1),
(2, 'quanlicuahang1', 'e10adc3949ba59abbe56e057f20f883e', 2),
(3, 'quanlicuahang2', 'e10adc3949ba59abbe56e057f20f883e', 2),
(4, 'quanlicuahang3', 'e10adc3949ba59abbe56e057f20f883e', 2),
(5, 'quanlicuahang4', 'e10adc3949ba59abbe56e057f20f883e', 2),
(6, 'quanlicuahang5', 'e10adc3949ba59abbe56e057f20f883e', 2),
(7, 'nhanvien1', 'e10adc3949ba59abbe56e057f20f883e', 3),
(8, 'nhanvien2', 'e10adc3949ba59abbe56e057f20f883e', 3),
(9, 'nhanvien3', 'e10adc3949ba59abbe56e057f20f883e', 3),
(10, 'nhanvien4', 'e10adc3949ba59abbe56e057f20f883e', 3),
(11, 'nhanvienbep1', 'e10adc3949ba59abbe56e057f20f883e', 4),
(12, 'nhanvienbep2', 'e10adc3949ba59abbe56e057f20f883e', 4),
(13, 'thanhbinh', 'e10adc3949ba59abbe56e057f20f883e', 5),
(14, 'tuandung', 'e10adc3949ba59abbe56e057f20f883e', 5),
(15, 'tantai', 'e10adc3949ba59abbe56e057f20f883e', 5),
(16, 'hieuthuhai', 'e10adc3949ba59abbe56e057f20f883e', 5),
(67, 'nhanvien5', 'e10adc3949ba59abbe56e057f20f883e', 3),
(68, 'nhanvien5', 'e10adc3949ba59abbe56e057f20f883e', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thucdon`
--

CREATE TABLE `thucdon` (
  `ID_CuaHang` int(10) NOT NULL,
  `ID_MonAn` int(10) NOT NULL,
  `GiamGia` int(10) NOT NULL,
  `SoLuongTon` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thucdon`
--

INSERT INTO `thucdon` (`ID_CuaHang`, `ID_MonAn`, `GiamGia`, `SoLuongTon`) VALUES
(1, 1, 0, 0),
(1, 2, 0, 0),
(1, 3, 0, 0),
(1, 4, 0, 0),
(1, 5, 0, 0),
(1, 6, 0, 0),
(1, 7, 0, 0),
(1, 8, 0, 0),
(1, 9, 0, 0),
(1, 10, 0, 0),
(1, 11, 0, 0),
(1, 12, 0, 0),
(1, 13, 0, 0),
(1, 14, 0, 0),
(1, 15, 0, 0),
(1, 16, 0, 0),
(1, 17, 0, 0),
(1, 18, 0, 0),
(1, 19, 0, 0),
(1, 20, 0, 0),
(2, 1, 0, 0),
(2, 2, 0, 0),
(2, 3, 0, 0),
(2, 4, 0, 0),
(2, 5, 0, 0),
(2, 6, 0, 0),
(2, 7, 0, 0),
(2, 8, 0, 0),
(2, 9, 0, 0),
(2, 10, 0, 0),
(2, 11, 0, 0),
(2, 12, 0, 0),
(2, 13, 0, 0),
(2, 14, 0, 0),
(2, 15, 0, 0),
(2, 16, 0, 0),
(2, 17, 0, 0),
(2, 18, 0, 0),
(2, 19, 0, 0),
(2, 20, 0, 0),
(3, 1, 0, 0),
(3, 2, 0, 0),
(3, 3, 0, 0),
(3, 4, 0, 0),
(3, 5, 0, 0),
(3, 6, 0, 0),
(3, 7, 0, 0),
(3, 8, 0, 0),
(3, 9, 0, 0),
(3, 10, 0, 0),
(3, 11, 0, 0),
(3, 12, 0, 0),
(3, 13, 0, 0),
(3, 14, 0, 0),
(3, 15, 0, 0),
(3, 16, 0, 0),
(3, 17, 0, 0),
(3, 18, 0, 0),
(3, 19, 0, 0),
(3, 20, 0, 0),
(4, 1, 0, 0),
(4, 2, 0, 0),
(4, 3, 0, 0),
(4, 4, 0, 0),
(4, 5, 0, 0),
(4, 6, 0, 0),
(4, 7, 0, 0),
(4, 8, 0, 0),
(4, 9, 0, 0),
(4, 10, 0, 0),
(4, 11, 0, 0),
(4, 12, 0, 0),
(4, 13, 0, 0),
(4, 14, 0, 0),
(4, 15, 0, 0),
(4, 16, 0, 0),
(4, 17, 0, 0),
(4, 18, 0, 0),
(4, 19, 0, 0),
(4, 20, 0, 0),
(5, 1, 0, 0),
(5, 2, 0, 0),
(5, 3, 0, 0),
(5, 4, 0, 0),
(5, 5, 0, 0),
(5, 6, 0, 0),
(5, 7, 0, 0),
(5, 8, 0, 0),
(5, 9, 0, 0),
(5, 10, 0, 0),
(5, 11, 0, 0),
(5, 12, 0, 0),
(5, 13, 0, 0),
(5, 14, 0, 0),
(5, 15, 0, 0),
(5, 16, 0, 0),
(5, 17, 0, 0),
(5, 18, 0, 0),
(5, 19, 0, 0),
(5, 20, 0, 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `ban`
--
ALTER TABLE `ban`
  ADD PRIMARY KEY (`ID_Ban`),
  ADD KEY `cuahang_ban` (`ID_CuaHang`);

--
-- Chỉ mục cho bảng `chamcong`
--
ALTER TABLE `chamcong`
  ADD KEY `chamcong_nhanvien` (`ID_NhanVien`),
  ADD KEY `chamcong_lich` (`ID_Lich`);

--
-- Chỉ mục cho bảng `chitietdattiec`
--
ALTER TABLE `chitietdattiec`
  ADD KEY `chitietdontiec_monan` (`ID_MonAn`),
  ADD KEY `chitietdontiec_dattiec` (`ID_DatTiec`);

--
-- Chỉ mục cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD KEY `chitietdonhang_donhang` (`ID_DonHang`),
  ADD KEY `chitietdonhang_monan` (`ID_MonAn`);

--
-- Chỉ mục cho bảng `chitietmonan`
--
ALTER TABLE `chitietmonan`
  ADD KEY `chitietmonan_monan` (`ID_MonAn`),
  ADD KEY `chitietmonan_nguyenlieu` (`ID_NguyenLieu`);

--
-- Chỉ mục cho bảng `chitietnguyenlieu`
--
ALTER TABLE `chitietnguyenlieu`
  ADD KEY `chitietnguyenlieu_phieudat` (`ID_PhieuDat`),
  ADD KEY `chitietnguyenlieu_nguyenlieu` (`ID_NguyenLieu`),
  ADD KEY `chitetnguyenlieu_cuahang` (`ID_CuaHang`);

--
-- Chỉ mục cho bảng `cuahang`
--
ALTER TABLE `cuahang`
  ADD PRIMARY KEY (`ID_CuaHang`);

--
-- Chỉ mục cho bảng `dangkyca`
--
ALTER TABLE `dangkyca`
  ADD PRIMARY KEY (`ID_Ca`),
  ADD KEY `nhanvien_ca` (`ID_NhanVien`);

--
-- Chỉ mục cho bảng `danhsachdexuatmonmoi`
--
ALTER TABLE `danhsachdexuatmonmoi`
  ADD PRIMARY KEY (`ID_MonMoi`),
  ADD KEY `monmoi_nhanvien` (`ID_NhanVien`);

--
-- Chỉ mục cho bảng `danhsachyeucaubosungnguyenlieu`
--
ALTER TABLE `danhsachyeucaubosungnguyenlieu`
  ADD KEY `nhan` (`ID_CuaHangNhan`),
  ADD KEY `gui` (`ID_CuaHangGui`),
  ADD KEY `nguyenlieu` (`ID_NguyenLieu`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`ID_DonHang`),
  ADD KEY `donhang_cuahang` (`ID_CuaHang`),
  ADD KEY `donhang_khachhang` (`ID_KhachHang`);

--
-- Chỉ mục cho bảng `dontiec`
--
ALTER TABLE `dontiec`
  ADD PRIMARY KEY (`ID_DatTiec`),
  ADD KEY `dattiec_cuahang` (`ID_CuaHang`),
  ADD KEY `dattiec_khachhang` (`ID_KhachHang`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`ID_KhachHang`),
  ADD KEY `khachhang_taikhoan` (`ID_TaiKhoan`);

--
-- Chỉ mục cho bảng `lichlamviec`
--
ALTER TABLE `lichlamviec`
  ADD PRIMARY KEY (`ID_Lich`);

--
-- Chỉ mục cho bảng `loaimonan`
--
ALTER TABLE `loaimonan`
  ADD PRIMARY KEY (`ID_LoaiMon`);

--
-- Chỉ mục cho bảng `luong`
--
ALTER TABLE `luong`
  ADD PRIMARY KEY (`ID_Luong`),
  ADD KEY `luong_nhanvien` (`ID_NhanVien`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `monan`
--
ALTER TABLE `monan`
  ADD PRIMARY KEY (`ID_MonAn`),
  ADD KEY `monan_loaimonan` (`ID_LoaiMon`);

--
-- Chỉ mục cho bảng `nguyenlieu`
--
ALTER TABLE `nguyenlieu`
  ADD PRIMARY KEY (`ID_NguyenLieu`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`ID_NhanVien`),
  ADD KEY `nhanvien_cuahang` (`ID_CuaHang`),
  ADD KEY `nhanvien_taikhoan` (`ID_TaiKhoan`);

--
-- Chỉ mục cho bảng `phieudathang`
--
ALTER TABLE `phieudathang`
  ADD PRIMARY KEY (`ID_PhieuDatHang`),
  ADD KEY `phieudat_cuahang` (`ID_CuaHang`);

--
-- Chỉ mục cho bảng `quanlychuoi`
--
ALTER TABLE `quanlychuoi`
  ADD PRIMARY KEY (`ID_QuanLyChuoi`),
  ADD KEY `quanlychuoi_taikhoan` (`ID_TaiKhoan`);

--
-- Chỉ mục cho bảng `quanlycuahang`
--
ALTER TABLE `quanlycuahang`
  ADD PRIMARY KEY (`ID_QuanLyCuaHang`),
  ADD KEY `quanlycuahang_taikhoan` (`ID_TaiKhoan`),
  ADD KEY `quanlycuahang` (`ID_CuaHang`);

--
-- Chỉ mục cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`ID_TaiKhoan`);

--
-- Chỉ mục cho bảng `thucdon`
--
ALTER TABLE `thucdon`
  ADD KEY `thucdon_cuahang` (`ID_CuaHang`),
  ADD KEY `thucdon_monan` (`ID_MonAn`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `ban`
--
ALTER TABLE `ban`
  MODIFY `ID_Ban` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT cho bảng `cuahang`
--
ALTER TABLE `cuahang`
  MODIFY `ID_CuaHang` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `dangkyca`
--
ALTER TABLE `dangkyca`
  MODIFY `ID_Ca` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `danhsachdexuatmonmoi`
--
ALTER TABLE `danhsachdexuatmonmoi`
  MODIFY `ID_MonMoi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `donhang`
--
ALTER TABLE `donhang`
  MODIFY `ID_DonHang` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `dontiec`
--
ALTER TABLE `dontiec`
  MODIFY `ID_DatTiec` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `ID_KhachHang` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `lichlamviec`
--
ALTER TABLE `lichlamviec`
  MODIFY `ID_Lich` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `loaimonan`
--
ALTER TABLE `loaimonan`
  MODIFY `ID_LoaiMon` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `luong`
--
ALTER TABLE `luong`
  MODIFY `ID_Luong` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `monan`
--
ALTER TABLE `monan`
  MODIFY `ID_MonAn` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT cho bảng `nguyenlieu`
--
ALTER TABLE `nguyenlieu`
  MODIFY `ID_NguyenLieu` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `ID_NhanVien` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `phieudathang`
--
ALTER TABLE `phieudathang`
  MODIFY `ID_PhieuDatHang` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `quanlychuoi`
--
ALTER TABLE `quanlychuoi`
  MODIFY `ID_QuanLyChuoi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `quanlycuahang`
--
ALTER TABLE `quanlycuahang`
  MODIFY `ID_QuanLyCuaHang` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `ID_TaiKhoan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `ban`
--
ALTER TABLE `ban`
  ADD CONSTRAINT `cuahang_ban` FOREIGN KEY (`ID_CuaHang`) REFERENCES `cuahang` (`ID_CuaHang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chamcong`
--
ALTER TABLE `chamcong`
  ADD CONSTRAINT `chamcong_lich` FOREIGN KEY (`ID_Lich`) REFERENCES `lichlamviec` (`ID_Lich`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chamcong_nhanvien` FOREIGN KEY (`ID_NhanVien`) REFERENCES `nhanvien` (`ID_NhanVien`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chitietdattiec`
--
ALTER TABLE `chitietdattiec`
  ADD CONSTRAINT `chitietdontiec_dattiec` FOREIGN KEY (`ID_DatTiec`) REFERENCES `dontiec` (`ID_DatTiec`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chitietdontiec_monan` FOREIGN KEY (`ID_MonAn`) REFERENCES `monan` (`ID_MonAn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `chitietdonhang_donhang` FOREIGN KEY (`ID_DonHang`) REFERENCES `donhang` (`ID_DonHang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chitietdonhang_monan` FOREIGN KEY (`ID_MonAn`) REFERENCES `monan` (`ID_MonAn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chitietmonan`
--
ALTER TABLE `chitietmonan`
  ADD CONSTRAINT `chitietmonan_monan` FOREIGN KEY (`ID_MonAn`) REFERENCES `monan` (`ID_MonAn`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chitietmonan_nguyenlieu` FOREIGN KEY (`ID_NguyenLieu`) REFERENCES `nguyenlieu` (`ID_NguyenLieu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chitietnguyenlieu`
--
ALTER TABLE `chitietnguyenlieu`
  ADD CONSTRAINT `chitetnguyenlieu_cuahang` FOREIGN KEY (`ID_CuaHang`) REFERENCES `cuahang` (`ID_CuaHang`),
  ADD CONSTRAINT `chitietnguyenlieu_nguyenlieu` FOREIGN KEY (`ID_NguyenLieu`) REFERENCES `nguyenlieu` (`ID_NguyenLieu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chitietnguyenlieu_phieudat` FOREIGN KEY (`ID_PhieuDat`) REFERENCES `phieudathang` (`ID_PhieuDatHang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `dangkyca`
--
ALTER TABLE `dangkyca`
  ADD CONSTRAINT `nhanvien_ca` FOREIGN KEY (`ID_NhanVien`) REFERENCES `nhanvien` (`ID_NhanVien`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `danhsachdexuatmonmoi`
--
ALTER TABLE `danhsachdexuatmonmoi`
  ADD CONSTRAINT `monmoi_nhanvien` FOREIGN KEY (`ID_NhanVien`) REFERENCES `nhanvien` (`ID_NhanVien`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `danhsachyeucaubosungnguyenlieu`
--
ALTER TABLE `danhsachyeucaubosungnguyenlieu`
  ADD CONSTRAINT `gui` FOREIGN KEY (`ID_CuaHangGui`) REFERENCES `cuahang` (`ID_CuaHang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nguyenlieu` FOREIGN KEY (`ID_NguyenLieu`) REFERENCES `nguyenlieu` (`ID_NguyenLieu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nhan` FOREIGN KEY (`ID_CuaHangNhan`) REFERENCES `cuahang` (`ID_CuaHang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_cuahang` FOREIGN KEY (`ID_CuaHang`) REFERENCES `cuahang` (`ID_CuaHang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_khachhang` FOREIGN KEY (`ID_KhachHang`) REFERENCES `khachhang` (`ID_KhachHang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `dontiec`
--
ALTER TABLE `dontiec`
  ADD CONSTRAINT `dattiec_cuahang` FOREIGN KEY (`ID_CuaHang`) REFERENCES `cuahang` (`ID_CuaHang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dattiec_khachhang` FOREIGN KEY (`ID_KhachHang`) REFERENCES `khachhang` (`ID_KhachHang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD CONSTRAINT `khachhang_taikhoan` FOREIGN KEY (`ID_TaiKhoan`) REFERENCES `taikhoan` (`ID_TaiKhoan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `luong`
--
ALTER TABLE `luong`
  ADD CONSTRAINT `luong_nhanvien` FOREIGN KEY (`ID_NhanVien`) REFERENCES `nhanvien` (`ID_NhanVien`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `monan`
--
ALTER TABLE `monan`
  ADD CONSTRAINT `monan_loaimonan` FOREIGN KEY (`ID_LoaiMon`) REFERENCES `loaimonan` (`ID_LoaiMon`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_cuahang` FOREIGN KEY (`ID_CuaHang`) REFERENCES `cuahang` (`ID_CuaHang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nhanvien_taikhoan` FOREIGN KEY (`ID_TaiKhoan`) REFERENCES `taikhoan` (`ID_TaiKhoan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `phieudathang`
--
ALTER TABLE `phieudathang`
  ADD CONSTRAINT `phieudat_cuahang` FOREIGN KEY (`ID_CuaHang`) REFERENCES `cuahang` (`ID_CuaHang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `quanlychuoi`
--
ALTER TABLE `quanlychuoi`
  ADD CONSTRAINT `quanlychuoi_taikhoan` FOREIGN KEY (`ID_TaiKhoan`) REFERENCES `taikhoan` (`ID_TaiKhoan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `quanlycuahang`
--
ALTER TABLE `quanlycuahang`
  ADD CONSTRAINT `quanlycuahang` FOREIGN KEY (`ID_CuaHang`) REFERENCES `cuahang` (`ID_CuaHang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quanlycuahang_taikhoan` FOREIGN KEY (`ID_TaiKhoan`) REFERENCES `taikhoan` (`ID_TaiKhoan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `thucdon`
--
ALTER TABLE `thucdon`
  ADD CONSTRAINT `thucdon_cuahang` FOREIGN KEY (`ID_CuaHang`) REFERENCES `cuahang` (`ID_CuaHang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thucdon_monan` FOREIGN KEY (`ID_MonAn`) REFERENCES `monan` (`ID_MonAn`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
