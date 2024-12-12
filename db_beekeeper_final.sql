-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 12, 2024 lúc 05:29 PM
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
-- Cơ sở dữ liệu: `db_beekeeper`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ban`
--

CREATE TABLE `ban` (
  `ID_Ban` int(10) NOT NULL,
  `ID_CuaHang` int(10) NOT NULL,
  `TenBan` varchar(10) NOT NULL,
  `TinhTrang` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ban`
--

INSERT INTO `ban` (`ID_Ban`, `ID_CuaHang`, `TenBan`, `TinhTrang`) VALUES
(1, 1, 'QT02', 0),
(2, 1, 'QT03', 0),
(3, 1, 'QT04', 0),
(4, 1, 'QT05', 0),
(5, 1, 'QT06', 0),
(6, 1, 'QT07', 0),
(7, 1, 'QT08', 0),
(8, 1, 'QT09', 0),
(9, 1, 'QT10', 0),
(10, 1, 'QT01', 1),
(11, 1, 'QT11', 0),
(12, 1, 'QT12', 0),
(13, 2, 'LQD01', 0),
(14, 2, 'LQD02', 0),
(15, 2, 'LQD03', 0),
(16, 2, 'LQD04', 0),
(17, 2, 'LQD05', 0),
(18, 2, 'LQD06', 0),
(19, 2, 'LQD07', 0),
(20, 2, 'LQD08', 0),
(21, 2, 'LQD09', 0),
(22, 2, 'LQD10', 0),
(23, 2, 'LQD11', 0),
(24, 2, 'LQD12', 0),
(26, 3, 'DBP02', 0),
(27, 3, 'DBP03', 0),
(28, 3, 'DBP04', 0),
(29, 3, 'DBP05', 0),
(30, 3, 'DBP06', 0),
(31, 3, 'DBP07', 0),
(32, 3, 'DBP08', 0),
(33, 3, 'DBP09', 0),
(34, 3, 'DBP10', 0),
(35, 3, 'DBP11', 0),
(36, 3, 'DBP12', 0),
(37, 4, 'CMT03', 0),
(38, 4, 'CMT02', 0),
(39, 4, 'CMT06', 0),
(40, 4, 'CMT05', 0),
(41, 4, 'CMT04', 0),
(42, 4, 'CMT09', 0),
(43, 4, 'CMT10', 0),
(44, 4, 'CMT11', 0),
(45, 4, 'CMT12', 0),
(46, 4, 'CMT01', 0),
(47, 4, 'CMT08', 0),
(48, 4, 'CMT07', 0),
(49, 5, 'NKKN01', 0),
(50, 5, 'NKKN12', 0),
(51, 5, 'NKKN02', 0),
(52, 5, 'NKKN09', 0),
(53, 5, 'NKKN10', 0),
(54, 5, 'NKKN11', 0),
(55, 5, 'NKKN03', 0),
(56, 5, 'NKKN04', 0),
(57, 5, 'NKKN05', 0),
(58, 5, 'NKKN06', 0),
(59, 5, 'NKKN07', 0),
(60, 5, 'NKKN08', 0),
(62, 3, 'DBP01', 0),
(63, 3, 'DBP13', 0),
(64, 1, 'QT13', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chamcong`
--

CREATE TABLE `chamcong` (
  `id` int(11) NOT NULL,
  `ID_NhanVien` int(10) NOT NULL,
  `NgayChamCong` date NOT NULL,
  `Checkin` time DEFAULT NULL,
  `CheckOut` time DEFAULT NULL,
  `SoGioLam` float DEFAULT NULL,
  `TrangThai` varchar(20) NOT NULL,
  `Thu` varchar(10) NOT NULL,
  `Tuan` int(11) NOT NULL,
  `TenCa` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chamcong`
--

INSERT INTO `chamcong` (`id`, `ID_NhanVien`, `NgayChamCong`, `Checkin`, `CheckOut`, `SoGioLam`, `TrangThai`, `Thu`, `Tuan`, `TenCa`) VALUES
(1, 50, '2024-12-16', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Hai', 51, 'Ca A'),
(2, 50, '2024-12-17', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Ba', 51, 'Ca A'),
(3, 50, '2024-12-18', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Tư', 51, 'Ca A'),
(4, 50, '2024-12-19', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Năm', 51, 'Ca A'),
(5, 50, '2024-12-20', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Sáu', 51, 'Ca A'),
(6, 50, '2024-12-21', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Bảy', 51, 'Ca A'),
(7, 50, '2024-12-22', NULL, NULL, NULL, 'Đăng ký ca', 'Chủ Nhật', 51, 'Ca A'),
(8, 50, '2024-12-16', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Hai', 51, 'Ca B'),
(9, 50, '2024-12-17', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Ba', 51, 'Ca B'),
(10, 50, '2024-12-18', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Tư', 51, 'Ca B'),
(11, 50, '2024-12-19', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Năm', 51, 'Ca B'),
(12, 50, '2024-12-20', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Sáu', 51, 'Ca B'),
(13, 50, '2024-12-21', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Bảy', 51, 'Ca B'),
(14, 50, '2024-12-22', NULL, NULL, NULL, 'Đăng ký ca', 'Chủ Nhật', 51, 'Ca B'),
(15, 57, '2024-12-16', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Hai', 51, 'Ca A'),
(16, 57, '2024-12-17', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Ba', 51, 'Ca A'),
(17, 57, '2024-12-18', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Tư', 51, 'Ca A'),
(18, 57, '2024-12-20', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Sáu', 51, 'Ca A'),
(19, 57, '2024-12-22', NULL, NULL, NULL, 'Đăng ký ca', 'Chủ Nhật', 51, 'Ca A'),
(20, 57, '2024-12-16', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Hai', 51, 'Ca B'),
(21, 57, '2024-12-17', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Ba', 51, 'Ca B'),
(22, 57, '2024-12-19', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Năm', 51, 'Ca B'),
(23, 57, '2024-12-21', NULL, NULL, NULL, 'Đăng ký ca', 'Thứ Bảy', 51, 'Ca B');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdattiec`
--

CREATE TABLE `chitietdattiec` (
  `ID_DatTiec` int(10) NOT NULL,
  `ID_MonAn` int(10) NOT NULL,
  `SoLuong` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdattiec`
--

INSERT INTO `chitietdattiec` (`ID_DatTiec`, `ID_MonAn`, `SoLuong`) VALUES
(5, 20, 5),
(5, 18, 8),
(5, 2, 9),
(5, 3, 10),
(6, 19, 5),
(6, 16, 7),
(6, 15, 6),
(6, 6, 6),
(7, 4, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdonhang`
--

CREATE TABLE `chitietdonhang` (
  `ID_DonHang` int(10) NOT NULL,
  `ID_MonAn` int(10) NOT NULL,
  `SoLuong` int(10) NOT NULL,
  `Ghichu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`ID_DonHang`, `ID_MonAn`, `SoLuong`, `Ghichu`) VALUES
(13, 17, 4, ''),
(13, 18, 3, ''),
(13, 14, 1, ''),
(14, 18, 1, ''),
(14, 14, 1, ''),
(14, 10, 1, ''),
(15, 13, 1, ''),
(15, 14, 1, ''),
(15, 15, 1, ''),
(15, 11, 1, ''),
(16, 17, 5, ''),
(16, 2, 3, ''),
(16, 8, 1, ''),
(17, 17, 1, ''),
(18, 17, 1, ''),
(19, 2, 2, ''),
(19, 3, 3, ''),
(19, 4, 1, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietmonan`
--

CREATE TABLE `chitietmonan` (
  `ID` int(11) NOT NULL,
  `ID_MonAn` int(10) NOT NULL,
  `ID_NguyenLieu` int(10) NOT NULL,
  `SoLuongNguyenLieu` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietmonan`
--

INSERT INTO `chitietmonan` (`ID`, `ID_MonAn`, `ID_NguyenLieu`, `SoLuongNguyenLieu`) VALUES
(1, 1, 22, 1),
(2, 1, 21, 1),
(3, 2, 22, 1),
(4, 2, 19, 1),
(5, 3, 22, 1),
(6, 3, 21, 1),
(7, 4, 10, 1),
(8, 4, 6, 1),
(9, 5, 10, 1),
(10, 5, 21, 1),
(11, 6, 10, 1),
(12, 6, 21, 1),
(13, 7, 10, 1),
(14, 7, 6, 1),
(15, 8, 7, 1),
(16, 9, 7, 1),
(17, 9, 6, 1),
(18, 10, 7, 1),
(19, 10, 21, 1),
(20, 11, 7, 1),
(21, 11, 3, 2),
(22, 12, 6, 1),
(23, 13, 6, 2),
(24, 14, 6, 3),
(25, 15, 3, 3),
(26, 16, 3, 5),
(27, 17, 9, 1),
(28, 18, 9, 1),
(29, 19, 2, 1),
(30, 19, 8, 1),
(31, 20, 16, 1),
(32, 20, 14, 1),
(33, 20, 18, 1),
(34, 19, 1, 1),
(35, 1, 15, 1),
(36, 2, 15, 1),
(37, 3, 15, 1),
(38, 4, 2, 1),
(39, 5, 2, 1),
(40, 6, 2, 1),
(41, 7, 2, 1),
(42, 10, 5, 1),
(43, 11, 5, 1),
(44, 1, 13, 1),
(45, 2, 13, 1),
(46, 3, 13, 1),
(47, 4, 12, 1),
(48, 5, 12, 1),
(49, 6, 12, 1),
(50, 7, 12, 1),
(51, 19, 11, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietnguyenlieu`
--

CREATE TABLE `chitietnguyenlieu` (
  `ID_ChiTietNguyenLieu` int(11) NOT NULL,
  `ID_NguyenLieu` int(10) NOT NULL,
  `ID_CuaHang` int(10) NOT NULL,
  `SoLuong` int(10) NOT NULL,
  `NgayNhap` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietnguyenlieu`
--

INSERT INTO `chitietnguyenlieu` (`ID_ChiTietNguyenLieu`, `ID_NguyenLieu`, `ID_CuaHang`, `SoLuong`, `NgayNhap`) VALUES
(1, 1, 1, 0, '2024-11-30'),
(2, 1, 2, 0, '2024-11-30'),
(3, 1, 3, 0, '2024-11-30'),
(4, 1, 4, 0, '2024-11-30'),
(5, 1, 5, 0, '2024-11-30'),
(6, 2, 1, 10, '2024-12-11'),
(7, 2, 2, 0, '2024-11-30'),
(8, 2, 3, 0, '2024-11-30'),
(9, 2, 4, 0, '2024-11-30'),
(10, 2, 5, 0, '2024-11-30'),
(11, 3, 1, 0, '2024-11-30'),
(12, 3, 2, 0, '2024-11-30'),
(13, 3, 3, 0, '2024-11-30'),
(14, 3, 4, 0, '2024-11-30'),
(15, 3, 5, 0, '2024-11-30'),
(16, 4, 1, 0, '2024-11-30'),
(17, 4, 2, 0, '2024-11-30'),
(18, 4, 3, 0, '2024-11-30'),
(19, 4, 4, 0, '2024-11-30'),
(20, 4, 5, 0, '2024-11-30'),
(21, 5, 1, 0, '2024-11-30'),
(22, 5, 2, 0, '2024-11-30'),
(23, 5, 3, 0, '2024-11-30'),
(24, 5, 4, 0, '2024-11-30'),
(25, 5, 5, 0, '2024-11-30'),
(26, 6, 1, 10, '2024-12-11'),
(27, 6, 2, 0, '2024-11-30'),
(28, 6, 3, 0, '2024-11-30'),
(29, 6, 4, 0, '2024-11-30'),
(30, 6, 5, 0, '2024-11-30'),
(31, 7, 1, 0, '2024-12-10'),
(32, 7, 2, 0, '2024-11-30'),
(33, 7, 3, 0, '2024-11-30'),
(34, 7, 4, 0, '2024-11-30'),
(35, 7, 5, 0, '2024-11-30'),
(36, 8, 1, 0, '2024-11-30'),
(37, 8, 2, 0, '2024-11-30'),
(38, 8, 3, 0, '2024-11-30'),
(39, 8, 4, 0, '2024-11-30'),
(40, 8, 5, 0, '2024-11-30'),
(41, 9, 1, 0, '2024-11-30'),
(42, 9, 2, 0, '2024-11-30'),
(43, 9, 3, 0, '2024-11-30'),
(44, 9, 4, 0, '2024-11-30'),
(45, 9, 5, 0, '2024-11-30'),
(46, 10, 1, 10, '2024-12-11'),
(47, 10, 2, 0, '2024-11-30'),
(48, 10, 3, 0, '2024-11-30'),
(49, 10, 4, 0, '2024-11-30'),
(50, 10, 5, 0, '2024-11-30'),
(51, 11, 1, 0, '2024-11-30'),
(52, 11, 2, 0, '2024-11-30'),
(53, 11, 3, 0, '2024-11-30'),
(54, 11, 4, 0, '2024-11-30'),
(55, 11, 5, 0, '2024-11-30'),
(56, 12, 1, 10, '2024-12-11'),
(57, 12, 2, 0, '2024-11-30'),
(58, 12, 3, 0, '2024-11-30'),
(59, 12, 4, 0, '2024-11-30'),
(60, 12, 5, 0, '2024-11-30'),
(61, 13, 1, 30, '2024-12-11'),
(62, 13, 2, 18, '2024-12-11'),
(63, 13, 3, 0, '2024-12-05'),
(64, 13, 4, -5, '2024-11-30'),
(65, 13, 5, -6, '2024-11-30'),
(66, 14, 1, 0, '2024-11-30'),
(67, 14, 2, 0, '2024-11-30'),
(68, 14, 3, 0, '2024-11-30'),
(69, 14, 4, 0, '2024-11-30'),
(70, 14, 5, 0, '2024-11-30'),
(71, 15, 1, 30, '2024-12-11'),
(72, 15, 2, 18, '2024-12-11'),
(73, 15, 3, 0, '2024-12-05'),
(74, 15, 4, -5, '2024-11-30'),
(75, 15, 5, -6, '2024-11-30'),
(76, 16, 1, 0, '2024-11-30'),
(77, 16, 2, 0, '2024-11-30'),
(78, 16, 3, 0, '2024-11-30'),
(79, 16, 4, 0, '2024-11-30'),
(80, 16, 5, 0, '2024-11-30'),
(81, 17, 1, 0, '2024-11-30'),
(82, 17, 2, 0, '2024-11-30'),
(83, 17, 3, 0, '2024-11-30'),
(84, 17, 4, 0, '2024-11-30'),
(85, 17, 5, 0, '2024-11-30'),
(86, 18, 1, 0, '2024-11-30'),
(87, 18, 2, 0, '2024-11-30'),
(88, 18, 3, 0, '2024-11-30'),
(89, 18, 4, 0, '2024-11-30'),
(90, 18, 5, 0, '2024-11-30'),
(91, 19, 1, 7, '2024-12-11'),
(92, 19, 2, 3, '2024-12-11'),
(93, 19, 3, 0, '2024-12-05'),
(94, 19, 4, 0, '2024-11-30'),
(95, 19, 5, 0, '2024-11-30'),
(96, 20, 1, 0, '2024-11-30'),
(97, 20, 2, 0, '2024-11-30'),
(98, 20, 3, 0, '2024-11-30'),
(99, 20, 4, 0, '2024-11-30'),
(100, 20, 5, 0, '2024-11-30'),
(101, 21, 1, 23, '2024-12-11'),
(102, 21, 2, 15, '2024-12-11'),
(103, 21, 3, 0, '2024-12-05'),
(104, 21, 4, -5, '2024-11-30'),
(105, 21, 5, -6, '2024-11-30'),
(106, 22, 1, 30, '2024-12-11'),
(107, 22, 2, 18, '2024-12-11'),
(108, 22, 3, 0, '2024-12-05'),
(109, 22, 4, -5, '2024-11-30'),
(110, 22, 5, -6, '2024-11-30');

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
-- Cấu trúc bảng cho bảng `danhsachdexuatmonmoi`
--

CREATE TABLE `danhsachdexuatmonmoi` (
  `ID_MonMoi` int(10) NOT NULL,
  `ID_NhanVien` int(10) NOT NULL,
  `TenMon` varchar(50) NOT NULL,
  `NguyenLieu` text NOT NULL,
  `MoTa` text NOT NULL,
  `Gia` double NOT NULL,
  `TrangThai` int(2) NOT NULL,
  `Ngay` date NOT NULL,
  `NgayDuyet` date DEFAULT NULL,
  `HinhAnh` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhsachdexuatmonmoi`
--

INSERT INTO `danhsachdexuatmonmoi` (`ID_MonMoi`, `ID_NhanVien`, `TenMon`, `NguyenLieu`, `MoTa`, `Gia`, `TrangThai`, `Ngay`, `NgayDuyet`, `HinhAnh`) VALUES
(22, 56, 'Chân gà sốt thái', 'nfgbasads', 'ádavsva', 50000, 1, '2024-12-10', '2024-12-11', 'chn_g_st_thi.jpg'),
(23, 50, 'gà sốt núi lữa', 'càng nhiều ớt càng tốt', 'rất cay', 50000, 1, '2024-12-11', '2024-12-11', 'g_st_ni_la.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhsachyeucaubosungnguyenlieu`
--

CREATE TABLE `danhsachyeucaubosungnguyenlieu` (
  `ID_YeuCau` int(11) NOT NULL,
  `ID_CuaHangGui` int(10) DEFAULT NULL,
  `ID_CuaHangNhan` int(10) NOT NULL,
  `ID_MonAn` int(10) NOT NULL,
  `TrangThai` int(2) NOT NULL,
  `SoLuong` int(10) NOT NULL,
  `NgayGui` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhsachyeucaubosungnguyenlieu`
--

INSERT INTO `danhsachyeucaubosungnguyenlieu` (`ID_YeuCau`, `ID_CuaHangGui`, `ID_CuaHangNhan`, `ID_MonAn`, `TrangThai`, `SoLuong`, `NgayGui`) VALUES
(32, NULL, 1, 1, 0, 5, '2024-12-09'),
(33, NULL, 2, 1, 0, 100, '2024-12-10'),
(34, 5, 2, 1, 1, 6, '2024-12-10'),
(37, 1, 2, 1, 1, 10, '2024-12-11'),
(38, 1, 2, 2, 1, 3, '2024-12-11'),
(39, 1, 2, 1, 1, 5, '2024-12-11'),
(40, NULL, 1, 1, 0, 5, '2024-12-11'),
(41, NULL, 1, 8, 0, 6, '2024-12-11'),
(42, NULL, 1, 10, 0, 7, '2024-12-11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `ID_DonHang` int(10) NOT NULL,
  `ID_CuaHang` int(10) NOT NULL,
  `ID_KhachHang` int(10) DEFAULT NULL,
  `ID_NhanVien` int(10) DEFAULT NULL,
  `NgayDat` date NOT NULL,
  `DiaChiGiaoHang` varchar(50) NOT NULL,
  `TrangThai` varchar(50) NOT NULL,
  `PhuongThucThanhToan` int(2) NOT NULL,
  `AnhThanhToan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`ID_DonHang`, `ID_CuaHang`, `ID_KhachHang`, `ID_NhanVien`, `NgayDat`, `DiaChiGiaoHang`, `TrangThai`, `PhuongThucThanhToan`, `AnhThanhToan`) VALUES
(13, 1, NULL, 56, '2024-12-10', 'Ăn tại quầy', 'Đã thanh toán', 0, NULL),
(14, 1, NULL, 56, '2024-12-10', 'Ăn tại quầy', 'Đã thanh toán', 0, NULL),
(15, 1, NULL, 56, '2024-12-10', 'Ăn tại quầy', 'Đã thanh toán', 1, NULL),
(16, 2, NULL, 50, '2024-12-11', 'Ăn tại quầy', 'Đã thanh toán', 0, NULL),
(17, 2, NULL, 50, '2024-12-11', 'Ăn tại quầy', 'Đã thanh toán', 0, NULL),
(18, 2, NULL, 50, '2024-12-11', 'Ăn tại quầy', 'Đã thanh toán', 0, NULL),
(19, 1, 26, NULL, '2024-12-11', 'Số 12 Nguyễn Văn Bảo, Phường 4, Quận Gò Vấp, Thành', 'Đã hủy', 0, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dontiec`
--

CREATE TABLE `dontiec` (
  `ID_DatTiec` int(10) NOT NULL,
  `ID_KhachHang` int(10) DEFAULT NULL,
  `ID_CuaHang` int(10) NOT NULL,
  `GioHen` date NOT NULL,
  `ID_LoaiTrangTri` int(11) NOT NULL,
  `SoNguoi` int(10) NOT NULL,
  `GhiChu` text DEFAULT NULL,
  `TrangThai` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dontiec`
--

INSERT INTO `dontiec` (`ID_DatTiec`, `ID_KhachHang`, `ID_CuaHang`, `GioHen`, `ID_LoaiTrangTri`, `SoNguoi`, `GhiChu`, `TrangThai`) VALUES
(5, 26, 1, '2024-12-13', 1, 10, '', 3),
(6, 26, 1, '2024-12-15', 2, 5, 'nhiều con nít', 1),
(7, 26, 1, '2024-12-12', 4, 1, '', 1);

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
  `DiaChi` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`ID_KhachHang`, `ID_TaiKhoan`, `HoTen`, `SoDienThoai`, `Email`, `DiaChi`) VALUES
(26, 14, 'Tài nè', '0384902203', 'trantantai@gmail.com', '12 Nguyễn Văn Bảo, Phường 4, Gò Vấp, Hồ Chí Minh');

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
-- Cấu trúc bảng cho bảng `loaitrangtri`
--

CREATE TABLE `loaitrangtri` (
  `ID_LoaiTrangTri` int(11) NOT NULL,
  `TenTrangTri` varchar(50) NOT NULL,
  `Gia` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `loaitrangtri`
--

INSERT INTO `loaitrangtri` (`ID_LoaiTrangTri`, `TenTrangTri`, `Gia`) VALUES
(1, 'Đèn Led', 50000),
(2, 'Phông nền', 30000),
(3, 'Bóng bay', 30000),
(4, 'Không trang trí', 0);

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
  `TongLuong` double NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `luong`
--

INSERT INTO `luong` (`ID_Luong`, `ID_NhanVien`, `TongGioLam`, `LuongTheoGio`, `Thuong`, `TongLuong`, `start_date`, `end_date`) VALUES
(1, 50, 0.000555556, 30000, 0, 16.666666666667, '2024-12-10', '2024-12-10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `ID_FeedBack` int(11) NOT NULL,
  `ID_KhachHang` int(11) NOT NULL,
  `FeedBack` text NOT NULL,
  `NgayFeedBack` date NOT NULL DEFAULT current_timestamp(),
  `TrangThai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`ID_FeedBack`, `ID_KhachHang`, `FeedBack`, `NgayFeedBack`, `TrangThai`) VALUES
(16, 26, 'Tài trần đẹp trai quá cả lò\r\n', '2024-12-10', 1),
(17, 26, 'vsdvasdv', '2024-12-11', 0),
(18, 26, 'adfabsdv', '2024-12-11', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `monan`
--

CREATE TABLE `monan` (
  `ID_MonAn` int(10) NOT NULL,
  `ID_LoaiMon` int(10) NOT NULL,
  `TenMonAn` varchar(50) NOT NULL,
  `MoTa` text NOT NULL,
  `TongNguyenLieu` int(11) DEFAULT NULL,
  `Gia` double NOT NULL,
  `GiamGia` int(11) NOT NULL,
  `HinhAnh` varchar(50) NOT NULL,
  `TinhTrang` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `monan`
--

INSERT INTO `monan` (`ID_MonAn`, `ID_LoaiMon`, `TenMonAn`, `MoTa`, `TongNguyenLieu`, `Gia`, `GiamGia`, `HinhAnh`, `TinhTrang`) VALUES
(1, 2, 'Burger Gà Quay Flava', '', 4, 54000, 40, 'burger_ga_quay_flava.jpg', 0),
(2, 2, 'Burger Tôm', '', 5, 45000, 50, 'burger_tom.jpg', 0),
(3, 2, 'Burger Zinger', '', 4, 54000, 50, 'burger_zinger.jpg', 0),
(4, 3, 'Mì Ý Gà Rán', '', 4, 64000, 50, 'mi_y_ga_ran.jpg', 0),
(5, 3, 'Mì Ý Gà Viên', '', 4, 40000, 50, 'mi_y_ga_vien.jpg', 0),
(6, 3, 'Mì Ý Gà Zinger', '', 4, 58000, 50, 'mi_y_ga_zinger.jpg', 0),
(7, 3, 'Mì Ý Phi Lê Gà Quay', '', 4, 61000, 50, 'mi_y_phi_le_ga_quay.jpg', 0),
(8, 4, 'Cơm', '', 1, 12000, 50, 'com.jpg', 0),
(9, 4, 'Cơm Gà Rán', '', 2, 48000, 50, 'com_ga_ran.jpg', 0),
(10, 4, 'Cơm Phi Lê Gà Quay', '', 3, 61000, 50, 'com_phi_le_ga_quay.jpg', 0),
(11, 4, 'Cơm Gà Teriyaki', '', 3, 45000, 50, 'com_ga_teriyaki.jpg', 0),
(12, 5, '1 Miếng Gà Rán', '', 1, 35000, 50, '1_mieng_ga_ran.jpg', 0),
(13, 5, '2 Miếng Gà Rán', '', 1, 70000, 50, '2_mieng_ga_ran.jpg', 0),
(14, 5, '3 Miếng Gà Rán', '', 1, 100000, 50, '3_mieng_ga_ran.jpg', 0),
(15, 5, '3 Cánh Gà Hot Wings', '', 1, 54000, 50, '3_canh_ga_hot_wings.jpg', 0),
(16, 5, '5 Cánh Gà Hot Wings', '', 1, 86000, 50, '5_canh_ga_hot_wings.jpg', 0),
(17, 1, 'Khoai Tây Chiên', '', 1, 28000, 50, 'khoai_tay_chien.jpg', 0),
(18, 1, 'Khoai Tây Nghiền', '', 1, 22000, 50, 'khoai_tay_nghien.jpg', 0),
(19, 1, 'Bắp Cải Trộn', '', 4, 22000, 50, 'bap_cai_tron.jpg', 0),
(20, 1, 'Súp Rong Biển', '', 3, 19000, 50, 'sup_rong_bien.jpg', 1);

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
(1, 'Bắp cải', 30000, 'bap_cai.jpg', '100 gam', 1),
(2, 'Cà chua', 60000, 'ca_chua.jpg', '100 gam', 1),
(3, 'Cánh gà', 105000, 'canh_ga.jpg', 'cánh', 1),
(4, 'Đậu hũ non', 13000, 'dau_hu_non.jpg', 'hộp', 1),
(5, 'Dưa leo', 30000, 'dua_leo.jpg', '100 gam', 1),
(6, 'Đùi gà', 103000, 'dui_ga.jpg', 'Đùi', 1),
(7, 'Gạo', 28000, 'gao.jpg', '100 gam', 1),
(8, 'Hành tây', 25000, 'hanh_tay.jpg', '100 gam', 1),
(9, 'Khoai tây', 30000, 'khoai_tay.jpg', '100 gam', 1),
(10, 'Mỳ ý', 36000, 'my_y.jpg', 'gói', 1),
(11, 'Ớt chuông', 60000, 'ot_chuong.jpg', '100 gam', 1),
(12, 'Phô mai sợi', 48000, 'pho_mai_soi.jpg', 'gói', 1),
(13, 'Phô mai lát', 60000, 'pho_mai_lat.jpg', 'gói', 1),
(14, 'Rau mùi thơm', 55000, 'rau_mui_thom.jpg', '100 gam', 1),
(15, 'Rau xà lách', 40000, 'rau_xa_lach.jpg', '100 gam', 1),
(16, 'Rong biển', 110000, 'rong_bien.jpg', 'gói', 1),
(17, 'Thịt bò', 200000, 'thit_bo.jpg', '100 gam', 1),
(18, 'Thịt heo', 120000, 'thit_heo.jpg', '100 gam', 1),
(19, 'Tôm', 185000, 'tom.jpg', '100 gam', 1),
(20, 'Trứng gà', 25000, 'trung_ga.jpg', 'trứng', 1),
(21, 'Ức gà', 80000, 'uc_ga.jpg', 'ức', 1),
(22, 'Vỏ bánh mì', 50000, 'vo_banh_mi.jpg', 'gói', 1);

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
(49, 8, 1, 'Nguyễn Văn Quảng', '0901234567', 'nguyenvanquang@gmail.com', 0),
(50, 9, 2, 'Phạm Kim Dung', '0912345678', 'phamkimdung@gmail.com', 0),
(51, 10, 3, 'Phạm Văn A', '0982551552', 'phamvana@gmail.com', 0),
(52, 11, 4, 'Đình Văn Minh', '0978332114', 'dinhvanminh@gmail.com', 1),
(53, 7, 5, 'Trần Văn Hiếu ', '0870335554', 'tranvanhieu@gmail.com', 0),
(54, 12, 2, 'Trần Văn Hải', '0123456789', 'tranvanhai@gmail.com', 0),
(56, 16, 1, 'Trần Tấn Tài', '0384902203', 'trantai@gmail.com', 1),
(57, 17, 1, 'Tài ', '0988023123', 'trantai@gmail.com', 0);

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
  `Email` varchar(50) NOT NULL,
  `TrangThai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `quanlycuahang`
--

INSERT INTO `quanlycuahang` (`ID_TaiKhoan`, `ID_CuaHang`, `ID_QuanLyCuaHang`, `HoTen`, `SoDienThoai`, `Email`, `TrangThai`) VALUES
(2, 1, 11, 'Phạm Thị Lan', '0123456789', 'phamthilan@gmail.com', 0),
(3, 2, 12, 'Nguyễn Minh Cường', '0923456789', 'minhcuong@gmail.com', 0),
(4, 3, 13, 'Trần Văn Khang', '0982311552', 'tranvankhang@gmail.com', 0),
(5, 4, 14, 'Vũ Văn Hùng', '0123456792', 'vuvanhung@gmail.com', 0),
(6, 5, 17, 'Phan Thắng Huy', '0901234567', 'phanthanghuy@gmail.com', 0);

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
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 1),
(2, 'Mng-B1', 'e10adc3949ba59abbe56e057f20f883e', 2),
(3, 'Mng-B2', 'e10adc3949ba59abbe56e057f20f883e', 2),
(4, 'Mng-B3', 'e10adc3949ba59abbe56e057f20f883e', 2),
(5, 'Mng-B4', 'e10adc3949ba59abbe56e057f20f883e', 2),
(6, 'Mng-B5', 'e10adc3949ba59abbe56e057f20f883e', 2),
(7, 'TranVanHieu', 'e10adc3949ba59abbe56e057f20f883e', 3),
(8, 'NguyenVanQuang', 'e10adc3949ba59abbe56e057f20f883e', 3),
(9, 'PhamKimDung', 'e10adc3949ba59abbe56e057f20f883e', 3),
(10, 'PhanVanA', 'e10adc3949ba59abbe56e057f20f883e', 3),
(11, 'DinhVanMinh', 'e10adc3949ba59abbe56e057f20f883e', 3),
(12, 'TranVanHai', 'e10adc3949ba59abbe56e057f20f883e', 4),
(13, 'trantantai.3013@gmail.com', '7c23e5f76e091549ef8387b9d0a36888', 5),
(14, 'trantantai@gmail.com', '7c23e5f76e091549ef8387b9d0a36888', 5),
(15, 'anhhuu21072003@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 3),
(16, 'taitran', 'd8578edf8458ce06fbc5bb76a58c5ca4', 3),
(17, 'nvCH1', 'e10adc3949ba59abbe56e057f20f883e', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thucdon`
--

CREATE TABLE `thucdon` (
  `id` int(11) NOT NULL,
  `ID_CuaHang` int(10) NOT NULL,
  `ID_MonAn` int(10) NOT NULL,
  `SoLuongTon` int(10) NOT NULL,
  `NgayNhap` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thucdon`
--

INSERT INTO `thucdon` (`id`, `ID_CuaHang`, `ID_MonAn`, `SoLuongTon`, `NgayNhap`) VALUES
(1, 1, 1, 13, '2024-12-11'),
(2, 1, 2, 7, '2024-12-11'),
(3, 1, 3, 10, '2024-12-11'),
(4, 1, 4, 10, '2024-12-11'),
(5, 1, 5, 0, '2024-12-11'),
(6, 1, 6, 0, '2024-12-11'),
(7, 1, 7, 0, '2024-12-11'),
(8, 1, 8, 0, '2024-12-11'),
(9, 1, 9, 0, '2024-12-11'),
(10, 1, 10, 0, '2024-12-11'),
(11, 1, 11, 0, '2024-12-11'),
(12, 1, 12, 0, '2024-12-11'),
(13, 1, 13, 0, '2024-12-11'),
(14, 1, 14, 0, '2024-12-11'),
(15, 1, 15, 0, '2024-12-11'),
(16, 1, 16, 0, '2024-12-11'),
(17, 1, 17, 0, '2024-12-11'),
(18, 1, 18, 0, '2024-12-11'),
(19, 1, 19, 0, '2024-12-11'),
(20, 1, 20, 0, '2024-12-11'),
(21, 2, 1, 15, '2024-12-11'),
(22, 2, 2, 3, '2024-12-11'),
(23, 2, 3, 0, '2024-12-11'),
(24, 2, 4, 0, '2024-12-11'),
(25, 2, 5, 0, '2024-12-11'),
(26, 2, 6, 0, '2024-12-11'),
(27, 2, 7, 0, '2024-12-11'),
(28, 2, 8, 0, '2024-12-11'),
(29, 2, 9, 0, '2024-12-11'),
(30, 2, 10, 0, '2024-12-11'),
(31, 2, 11, 0, '2024-12-11'),
(32, 2, 12, 0, '2024-12-11'),
(33, 2, 13, 0, '2024-12-11'),
(34, 2, 14, 0, '2024-12-11'),
(35, 2, 15, 0, '2024-12-11'),
(36, 2, 16, 0, '2024-12-11'),
(37, 2, 17, 0, '2024-12-11'),
(38, 2, 18, 0, '2024-12-11'),
(39, 2, 19, 0, '2024-12-11'),
(40, 2, 20, 0, '2024-12-11'),
(41, 3, 1, 0, '2024-12-11'),
(42, 3, 2, 0, '2024-12-11'),
(43, 3, 3, 0, '2024-12-11'),
(44, 3, 4, 0, '2024-12-11'),
(45, 3, 5, 0, '2024-12-11'),
(46, 3, 6, 0, '2024-12-11'),
(47, 3, 7, 0, '2024-12-11'),
(48, 3, 8, 0, '2024-12-11'),
(49, 3, 9, 0, '2024-12-11'),
(50, 3, 10, 0, '2024-12-11'),
(51, 3, 11, 0, '2024-12-11'),
(52, 3, 12, 0, '2024-12-11'),
(53, 3, 13, 0, '2024-12-11'),
(54, 3, 14, 0, '2024-12-11'),
(55, 3, 15, 0, '2024-12-11'),
(56, 3, 16, 0, '2024-12-11'),
(57, 3, 17, 0, '2024-12-11'),
(58, 3, 18, 0, '2024-12-11'),
(59, 3, 19, 0, '2024-12-11'),
(60, 3, 20, 0, '2024-12-11'),
(61, 4, 1, 0, '2024-12-11'),
(62, 4, 2, 0, '2024-12-11'),
(63, 4, 3, 0, '2024-12-11'),
(64, 4, 4, 0, '2024-12-11'),
(65, 4, 5, 0, '2024-12-11'),
(66, 4, 6, 0, '2024-12-11'),
(67, 4, 7, 0, '2024-12-11'),
(68, 4, 8, 0, '2024-12-11'),
(69, 4, 9, 0, '2024-12-11'),
(70, 4, 10, 0, '2024-12-11'),
(71, 4, 11, 0, '2024-12-11'),
(72, 4, 12, 0, '2024-12-11'),
(73, 4, 13, 0, '2024-12-11'),
(74, 4, 14, 0, '2024-12-11'),
(75, 4, 15, 0, '2024-12-11'),
(76, 4, 16, 0, '2024-12-11'),
(77, 4, 17, 0, '2024-12-11'),
(78, 4, 18, 0, '2024-12-11'),
(79, 4, 19, 0, '2024-12-11'),
(80, 4, 20, 0, '2024-12-11'),
(81, 5, 1, 0, '2024-12-11'),
(82, 5, 2, 0, '2024-12-11'),
(83, 5, 3, 0, '2024-12-11'),
(84, 5, 4, 0, '2024-12-11'),
(85, 5, 5, 0, '2024-12-11'),
(86, 5, 6, 0, '2024-12-11'),
(87, 5, 7, 0, '2024-12-11'),
(88, 5, 8, 0, '2024-12-11'),
(89, 5, 9, 0, '2024-12-11'),
(90, 5, 10, 0, '2024-12-11'),
(91, 5, 11, 0, '2024-12-11'),
(92, 5, 12, 0, '2024-12-11'),
(93, 5, 13, 0, '2024-12-11'),
(94, 5, 14, 0, '2024-12-11'),
(95, 5, 15, 0, '2024-12-11'),
(96, 5, 16, 0, '2024-12-11'),
(97, 5, 17, 0, '2024-12-11'),
(98, 5, 18, 0, '2024-12-11'),
(99, 5, 19, 0, '2024-12-11'),
(100, 5, 20, 0, '2024-12-11');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `chamcong_nhanvien` (`ID_NhanVien`);

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
  ADD PRIMARY KEY (`ID`),
  ADD KEY `chitietmonan_monan` (`ID_MonAn`),
  ADD KEY `chitietmonan_nguyenlieu` (`ID_NguyenLieu`);

--
-- Chỉ mục cho bảng `chitietnguyenlieu`
--
ALTER TABLE `chitietnguyenlieu`
  ADD PRIMARY KEY (`ID_ChiTietNguyenLieu`),
  ADD KEY `chitietnguyenlieu_nguyenlieu` (`ID_NguyenLieu`),
  ADD KEY `chitetnguyenlieu_cuahang` (`ID_CuaHang`);

--
-- Chỉ mục cho bảng `cuahang`
--
ALTER TABLE `cuahang`
  ADD PRIMARY KEY (`ID_CuaHang`);

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
  ADD PRIMARY KEY (`ID_YeuCau`),
  ADD KEY `nhan` (`ID_CuaHangNhan`),
  ADD KEY `gui` (`ID_CuaHangGui`),
  ADD KEY `monan` (`ID_MonAn`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`ID_DonHang`),
  ADD KEY `donhang_cuahang` (`ID_CuaHang`),
  ADD KEY `donhang_khachhang` (`ID_KhachHang`),
  ADD KEY `donhang_nhanvien` (`ID_NhanVien`);

--
-- Chỉ mục cho bảng `dontiec`
--
ALTER TABLE `dontiec`
  ADD PRIMARY KEY (`ID_DatTiec`),
  ADD KEY `dattiec_cuahang` (`ID_CuaHang`),
  ADD KEY `dattiec_khachhang` (`ID_KhachHang`),
  ADD KEY `dontiec_loaitrangtri` (`ID_LoaiTrangTri`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`ID_KhachHang`),
  ADD KEY `khachhang_taikhoan` (`ID_TaiKhoan`);

--
-- Chỉ mục cho bảng `loaimonan`
--
ALTER TABLE `loaimonan`
  ADD PRIMARY KEY (`ID_LoaiMon`);

--
-- Chỉ mục cho bảng `loaitrangtri`
--
ALTER TABLE `loaitrangtri`
  ADD PRIMARY KEY (`ID_LoaiTrangTri`);

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
  ADD PRIMARY KEY (`ID_FeedBack`),
  ADD KEY `fb_kh` (`ID_KhachHang`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `thucdon_cuahang` (`ID_CuaHang`),
  ADD KEY `thucdon_monan` (`ID_MonAn`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `ban`
--
ALTER TABLE `ban`
  MODIFY `ID_Ban` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT cho bảng `chamcong`
--
ALTER TABLE `chamcong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `chitietmonan`
--
ALTER TABLE `chitietmonan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT cho bảng `chitietnguyenlieu`
--
ALTER TABLE `chitietnguyenlieu`
  MODIFY `ID_ChiTietNguyenLieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT cho bảng `cuahang`
--
ALTER TABLE `cuahang`
  MODIFY `ID_CuaHang` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `danhsachdexuatmonmoi`
--
ALTER TABLE `danhsachdexuatmonmoi`
  MODIFY `ID_MonMoi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `danhsachyeucaubosungnguyenlieu`
--
ALTER TABLE `danhsachyeucaubosungnguyenlieu`
  MODIFY `ID_YeuCau` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT cho bảng `donhang`
--
ALTER TABLE `donhang`
  MODIFY `ID_DonHang` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `dontiec`
--
ALTER TABLE `dontiec`
  MODIFY `ID_DatTiec` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `ID_KhachHang` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `loaimonan`
--
ALTER TABLE `loaimonan`
  MODIFY `ID_LoaiMon` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `loaitrangtri`
--
ALTER TABLE `loaitrangtri`
  MODIFY `ID_LoaiTrangTri` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `luong`
--
ALTER TABLE `luong`
  MODIFY `ID_Luong` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `ID_FeedBack` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
  MODIFY `ID_NhanVien` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT cho bảng `quanlychuoi`
--
ALTER TABLE `quanlychuoi`
  MODIFY `ID_QuanLyChuoi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `quanlycuahang`
--
ALTER TABLE `quanlycuahang`
  MODIFY `ID_QuanLyCuaHang` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `ID_TaiKhoan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `thucdon`
--
ALTER TABLE `thucdon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

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
  ADD CONSTRAINT `chamcong_nhanvien` FOREIGN KEY (`ID_NhanVien`) REFERENCES `nhanvien` (`ID_NhanVien`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chitietdattiec`
--
ALTER TABLE `chitietdattiec`
  ADD CONSTRAINT `chitietdattiec_dattiec` FOREIGN KEY (`ID_DatTiec`) REFERENCES `dontiec` (`ID_DatTiec`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chitietdattiec_monan` FOREIGN KEY (`ID_MonAn`) REFERENCES `monan` (`ID_MonAn`) ON DELETE CASCADE ON UPDATE CASCADE,
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
  ADD CONSTRAINT `chitietnguyenlieu_nguyenlieu` FOREIGN KEY (`ID_NguyenLieu`) REFERENCES `nguyenlieu` (`ID_NguyenLieu`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `monan` FOREIGN KEY (`ID_MonAn`) REFERENCES `monan` (`ID_MonAn`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nhan` FOREIGN KEY (`ID_CuaHangNhan`) REFERENCES `cuahang` (`ID_CuaHang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_cuahang` FOREIGN KEY (`ID_CuaHang`) REFERENCES `cuahang` (`ID_CuaHang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_khachhang` FOREIGN KEY (`ID_KhachHang`) REFERENCES `khachhang` (`ID_KhachHang`),
  ADD CONSTRAINT `donhang_nhanvien` FOREIGN KEY (`ID_NhanVien`) REFERENCES `nhanvien` (`ID_NhanVien`);

--
-- Các ràng buộc cho bảng `dontiec`
--
ALTER TABLE `dontiec`
  ADD CONSTRAINT `dattiec_cuahang` FOREIGN KEY (`ID_CuaHang`) REFERENCES `cuahang` (`ID_CuaHang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dattiec_khachhang` FOREIGN KEY (`ID_KhachHang`) REFERENCES `khachhang` (`ID_KhachHang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dontiec_cuahang` FOREIGN KEY (`ID_CuaHang`) REFERENCES `cuahang` (`ID_CuaHang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dontiec_khachhang` FOREIGN KEY (`ID_KhachHang`) REFERENCES `khachhang` (`ID_KhachHang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dontiec_loaitrangtri` FOREIGN KEY (`ID_LoaiTrangTri`) REFERENCES `loaitrangtri` (`ID_LoaiTrangTri`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Các ràng buộc cho bảng `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fb_kh` FOREIGN KEY (`ID_KhachHang`) REFERENCES `khachhang` (`ID_KhachHang`);

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
