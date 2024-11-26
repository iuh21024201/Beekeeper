<?php
    include_once("ketnoi.php");

    class mPhanHoi {
        public function selectAllPhanHoi() {
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if ($conn) {
                $str = "SELECT ID_FeedBack, TenKhachHang, SoDienThoai, Email, FeedBack, NgayFeedBack, TrangThai FROM messages";
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
                $selectStr = "SELECT TenKhachHang, SoDienThoai, Email, FeedBack, NgayFeedBack, TrangThai 
                              FROM messages WHERE ID_FeedBack = $idFB";
                $tbl = $conn->query($selectStr);

                $p->dongKetNoi($conn);
                return $tbl;
            } else {
                return false;
            }
        }
    }
?>
