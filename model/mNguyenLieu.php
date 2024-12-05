<?php
    include_once("ketnoi.php");
    class modelNguyenLieu{
        public function selectAllNguyenLieu(){
            $p= new clsketnoi();
            $con= $p->moKetNoi(); 
            $truyvan="select * from nguyenlieu";
            $tbl =mysqli_query($con,$truyvan);
            $p ->dongKetNoi($con);
            return $tbl;
        }
        public function selectAllNguyenLieuByCuaHang($txt) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            if($con){
                $str = "SELECT * FROM nguyenlieu ngl
                        JOIN chitietnguyenlieu ct ON ngl.ID_NguyenLieu = ct.ID_NguyenLieu
                        WHERE ct.ID_CuaHang = $txt";
                $tbl = $con->query($str);
                $p->dongKetNoi($con);
                return $tbl;
            }else{
                return false;
            }
        }
        public function layMotNguyenLieu($idNL){
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            if($con){
                $str = "SELECT * FROM nguyenlieu ngl
                        JOIN chitietnguyenlieu ct ON ngl.ID_NguyenLieu = ct.ID_NguyenLieu
                        WHERE ngl.ID_NguyenLieu = $idNL";
                $tbl = $con->query($str);
                $p->dongKetNoi($con);
                return $tbl;
            }else{
                return false;
            }
        }
        public function selectIngredientsByOrder($idDH) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            if ($con) {
                $str = "SELECT t.ID_NguyenLieu, t.SoLuongNguyenLieu * c.SoLuong AS SoLuongCanTru
                        FROM ChiTietDonHang c
                        JOIN ChiTietMonAn t ON c.ID_MonAn = t.ID_MonAn
                        WHERE c.ID_DonHang = $idDH";
                $tbl = $con->query($str);
                $p->dongKetNoi($con);
                return $tbl;
            } else {
                return false;
            }
        }
    
        // Cập nhật số lượng nguyên liệu trong kho của cửa hàng
        public function updateIngredientsStock($idNguyenLieu, $soLuongCanTru, $idCuaHang) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            
            if ($con) {
                // Lấy ngày hiện tại theo định dạng chuẩn YYYY-MM-DD
                $ngayHienTai = date('Y-m-d'); 
                
                // Kiểm tra nếu $idCuaHang là NULL
                if ($idCuaHang === NULL) {
                    return false; // Hoặc xử lý thông báo lỗi
                }
        
                // Câu lệnh SQL để cập nhật số lượng nguyên liệu
                $str = "UPDATE ChiTietNguyenLieu
                        SET SoLuong = SoLuong - $soLuongCanTru
                        WHERE ID_NguyenLieu = $idNguyenLieu 
                        AND ID_CuaHang = $idCuaHang
                        AND NgayNhap = '$ngayHienTai'"; // Điều kiện so sánh với ngày hiện tại
                
                // Thực thi câu lệnh SQL
                $tbl = $con->query($str);
                $p->dongKetNoi($con);
                
                return $tbl;
            } else {
                return false;
            }
        }
    }
?>