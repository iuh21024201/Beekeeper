<?php
    include_once("ketnoi.php");
    class mMonMoi{
        public function SelectAllMonMoi(){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "select * from danhsachdexuatmonmoi";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
        public function selectInfoMonMoi($idMonMoi){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "select ds.TenMon, ds.Gia, ds.MoTa, n.HoTen, ds.NguyenLieu, ds.Ngay, ds.HinhAnh, ds.TrangThai from danhsachdexuatmonmoi as ds INNER join nhanvien as n on ds.ID_NhanVien = n.ID_NhanVien where ID_MonMoi ='$idMonMoi'";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
        public function changeStatusTo1($idMonMoi)
        {
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            $date = date('Y-m-d');
            if($conn){
                $str = "UPDATE danhsachdexuatmonmoi SET TrangThai= 1, NgayDuyet = '$date' WHERE ID_MonMoi = '$idMonMoi'";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return 1;
            }else{
                return false;
            }
        }
        public function changeStatusTo2($idMonMoi)
        {
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');

            if ($conn) {
                // Truy vấn lấy tên hình ảnh
                $str = "SELECT HinhAnh FROM danhsachdexuatmonmoi WHERE ID_MonMoi = '$idMonMoi'";
                $result = $conn->query($str);
                $monMoi = $result->fetch_assoc();

                // Kiểm tra nếu có tên hình ảnh và hình ảnh tồn tại trên server
                if ($monMoi && !empty($monMoi['HinhAnh'])) {
                    $imagePath = "../../image/monmoi/" . $monMoi['HinhAnh'];

                    // Kiểm tra và xóa hình ảnh
                    if (file_exists($imagePath)) {
                        unlink($imagePath); // Xóa file hình ảnh
                    }
                }

                // Cập nhật trạng thái món mới thành "Xóa" (2)
                $updateStr = "UPDATE danhsachdexuatmonmoi SET TrangThai = 2 WHERE ID_MonMoi = '$idMonMoi'";
                $tbl = $conn->query($updateStr);
                $p->dongKetNoi($conn);

                return $tbl ? 1 : false; // Trả về 1 nếu thành công, false nếu thất bại
            }

            return false; // Kết nối thất bại      
        }

    }
?>