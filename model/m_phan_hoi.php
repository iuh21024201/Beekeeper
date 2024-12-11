<?php
    include_once("ketnoi.php");

    class mPhanHoi {
        public function selectAllPhanHoi() {
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if ($conn) {
                $str = "SELECT m.ID_FeedBack, kh.HoTen, kh.SoDienThoai, kh.Email, m.FeedBack, m.NgayFeedBack, m.TrangThai FROM messages m INNER JOIN khachhang kh on m.ID_KhachHang = kh.ID_KhachHang";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            } else {
                return false;
            }
        }

        public function selectPH($idFB) {
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if ($conn) {
                // Cập nhật trạng thái trong bảng messages
                $updateStr = "UPDATE messages SET TrangThai = 1 WHERE ID_FeedBack = $idFB";
                $conn->query($updateStr);
                
                // Lấy thông tin phản hồi từ bảng messages
                $selectStr = "SELECT kh.HoTen, kh.SoDienThoai, kh.Email, m.FeedBack, m.NgayFeedBack, m.TrangThai 
                              FROM messages m INNER JOIN khachhang kh on m.ID_KhachHang = kh.ID_KhachHang WHERE ID_FeedBack = $idFB";
                $tbl = $conn->query($selectStr);

                $p->dongKetNoi($conn);
                return $tbl;
            } else {
                return false;
            }
        }
    }
?>
