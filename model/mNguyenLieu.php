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
        //lấy tất cả nguyên liệu  và sắp xếp
        public function selectAllNguyenLieuSX(){
            $p= new clsketnoi();
            $con= $p->moKetNoi(); 
            $truyvan="select * from nguyenlieu
                        ORDER BY 
                        CASE  -- Trạng thái 2 xếp cuối cùng
                            WHEN TrangThai = 1 THEN 1  -- Trạng thái 1 xếp trước trạng thái 2
                            ELSE 0  -- Các trạng thái khác xếp lên đầu
                        END, 
                        ID_NguyenLieu DESC; ";
            $tbl =mysqli_query($con,$truyvan);
            $p ->dongKetNoi($con);
            return $tbl;
        }
        //lấy tất cả nguyên liệu theo cửa hàng
        public function selectAllNguyenLieuByCuaHang($txt) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            if($con){
                $str = "SELECT * FROM nguyenlieu ngl
                        JOIN chitietnguyenlieu ct ON ngl.ID_NguyenLieu = ct.ID_NguyenLieu
                        WHERE ct.ID_CuaHang = $txt
                        ORDER BY 
                        CASE 
                            WHEN ngl.TrangThai = 1 THEN 1  -- Trạng thái 1 xếp trước trạng thái 2
                            ELSE 0  -- Các trạng thái khác xếp lên đầu
                        END, 
                        ct.ID_ChiTietNguyenLieu DESC;";
                $tbl = $con->query($str);
                $p->dongKetNoi($con);
                return $tbl;
            }else{
                return false;
            }
        }
        //lấy nguyên liệu 1 cửa hàng theo tên
        public function selectAllNguyenLieuByNameByCuaHang($txt, $idCuaHang){
            $p = new clsketnoi();
            $truyvan = " SELECT * FROM nguyenlieu ngl 
                        JOIN chitietnguyenlieu ct ON ngl.ID_NguyenLieu = ct.ID_NguyenLieu
                        WHERE ngl.TenNguyenLieu like N'%$txt%' and ct.ID_CuaHang = $idCuaHang";
            $con = $p -> moKetNoi();
            $kq = mysqli_query($con, $truyvan);
            $p -> dongKetNoi($con);
            return $kq;
        }
        //lấy nguyên liệu theo tên của tất cả cửa hàng
        public function selectAllCTNLByName($txt){
            $p = new clsketnoi();
            $truyvan = " SELECT * FROM nguyenlieu ngl 
                        JOIN chitietnguyenlieu ct ON ngl.ID_NguyenLieu = ct.ID_NguyenLieu
                        WHERE ngl.TenNguyenLieu like N'%$txt%'";
            $con = $p -> moKetNoi();
            $kq = mysqli_query($con, $truyvan);
            $p -> dongKetNoi($con);
            return $kq;
        }
        //lấy nguyên liệu theo tên của tất cả cửa hàng
        public function selectAllNLByName($txt){
            $p = new clsketnoi();
            $truyvan = " SELECT * FROM nguyenlieu 
                        WHERE TenNguyenLieu like N'%$txt%'";
            $con = $p -> moKetNoi();
            $kq = mysqli_query($con, $truyvan);
            $p -> dongKetNoi($con);
            return $kq;
        }
        //lấy một nguyên liệu theo chi tiết nguyên liệu
        public function layMotNguyenLieuByCTNL($idCTNL){
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            if($con){
                $str = "SELECT * FROM nguyenlieu ngl
                        JOIN chitietnguyenlieu ct ON ngl.ID_NguyenLieu = ct.ID_NguyenLieu
                        WHERE ct.ID_ChiTietNguyenLieu = $idCTNL";
                $tbl = $con->query($str);
                $p->dongKetNoi($con);
                return $tbl;
            }else{
                return false;
            }
        }
        //lấy một nguyên liệu theo chi tiết nguyên liệu
        public function layMotNguyenLieuByNL($idNL){
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            if($con){
                $str = "SELECT * FROM nguyenlieu ngl
                        JOIN chitietnguyenlieu ct ON ngl.ID_NguyenLieu = ct.ID_NguyenLieu
                        JOIN cuahang ch ON ch.ID_CuaHang = ct.ID_CuaHang
                        WHERE ngl.ID_NguyenLieu = $idNL";
                $tbl = $con->query($str);
                $p->dongKetNoi($con);
                return $tbl;
            }else{
                return false;
            }
        }
        //update trạng thái nguyên liệu thành không sử dụng
        public function updateTrangThaiNguyenLieu($idCTNL) {
            $p = new clsketnoi();
            // Truy vấn cập nhật trạng thái nguyên liệu
            $truyvan = "UPDATE nguyenlieu ngl
                        JOIN chitietnguyenlieu ct ON ngl.ID_NguyenLieu = ct.ID_NguyenLieu
                        SET 
                            ngl.TrangThai = 1,  -- Cập nhật trạng thái thành 1 (hết hàng)
                            ct.SoLuong = 0      -- Đặt số lượng thành 0
                        WHERE ct.ID_ChiTietNguyenLieu = $idCTNL";
            $con = $p->moKetNoi();
            $kq = mysqli_query($con, $truyvan);
            $p->dongKetNoi($con);
        
            return $kq;
        }     
        //thêm nguyên liệu
        public function insertNL($tenNL, $gia, $donVi, $hinhanh, $trangthai) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            $sql = "INSERT INTO nguyenlieu (TenNguyenLieu, GiaMua, DonViTinh, HinhAnh, TrangThai) 
                    VALUES ('$tenNL', '$gia', '$donVi', '$hinhanh', $trangthai)";
            $tbl = mysqli_query($con,$sql);
            if ($tbl) {
                $lastId = mysqli_insert_id($con); // Lấy ID_DonHang vừa được tự động sinh
            } else {
                $lastId = false;
            }
            $p ->dongKetNoi($con);
            return $lastId;
        }
        //thêm chi tiết nguyên liệu
        public function insertCTNL($idNL, $idCuaHang, $soLuong) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            $sql = "INSERT INTO chitietnguyenlieu (ID_NguyenLieu, ID_CuaHang, SoLuong) 
                    VALUES ($idNL, $idCuaHang, $soLuong)";
            $tbl =mysqli_query($con,$sql);
            $p ->dongKetNoi($con);
            return $tbl;
        }
        //update nguyên liệu
        public function updateNL($idNL, $tenNL, $gia, $donVi, $hinhanh, $trangThai) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            $sql = "UPDATE nguyenlieu SET TenNguyenLieu = '$tenNL', GiaMua = '$gia', 
                    DonViTinh = '$donVi', HinhAnh = '$hinhanh', TrangThai = '$trangThai' 
                    WHERE ID_NguyenLieu = '$idNL'";
            $kq = mysqli_query($con, $sql);
            $p -> dongKetNoi($con);
            return $kq;
        }
        //update chi tiết nguyên liệu 1 nguyên liệu theo chi tiết nguyên liệu
        public function updateCTNLByCTNL($idCTNL, $idCuaHang, $soluong) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            $sql = "UPDATE chitietnguyenlieu SET ID_CuaHang = '$idCuaHang', SoLuong = '$soluong' 
                    WHERE ID_ChiTietNguyenLieu = '$idCTNL'";
            $kq = mysqli_query($con, $sql);
            $p -> dongKetNoi($con);
            return $kq;
        }
        //update chi tiết nguyên liệu 1 nguyên liệu theo nguyên liệu
        public function updateCTNL($idNL, $idCuaHang, $soluong) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            $checkQuery = "SELECT * FROM chitietnguyenlieu WHERE ID_NguyenLieu = '$idNL' AND ID_CuaHang = '$idCuaHang'";
            $result = mysqli_query($con, $checkQuery);

            if (mysqli_num_rows($result) > 0) {
                // Bản ghi tồn tại => Cập nhật
                $query = "UPDATE chitietnguyenlieu 
                        SET SoLuong = '$soluong' 
                        WHERE ID_NguyenLieu = '$idNL' AND ID_CuaHang = '$idCuaHang'";
            } else {
                // Thêm mới nếu không tồn tại
                $query = "INSERT INTO chitietnguyenlieu (ID_NguyenLieu, ID_CuaHang, SoLuong) 
                        VALUES ('$idNL', '$idCuaHang', '$soluong')";
            }
            $kq = mysqli_query($con, $query);
            $p -> dongKetNoi($con);
            return $kq;
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
                return $tbl ?: false; // Trả về false nếu truy vấn lỗi
            }
            return false;
        }
    
        // Cập nhật số lượng nguyên liệu trong kho của cửa hàng
        public function updateIngredientsStock($idNguyenLieu, $soLuongCanTru, $idCuaHang) {
            $p = new clsketnoi();
            $con = $p->moKetNoi();
            if ($con) {
                // Lấy ngày hiện tại theo định dạng YYYY-MM-DD
                $ngayHienTai = date('Y-m-d');
                
                // Câu lệnh SQL để trừ số lượng nguyên liệu theo ngày hiện tại
                $str = "UPDATE ChiTietNguyenLieu
                        SET SoLuong = SoLuong - $soLuongCanTru
                        WHERE ID_NguyenLieu = $idNguyenLieu 
                          AND ID_CuaHang = $idCuaHang
                          AND NgayNhap = '$ngayHienTai'"; // Điều kiện ngày hiện tại
                
                // Thực thi câu lệnh SQL
                $result = $con->query($str);
                $p->dongKetNoi($con);
                
                return $result; // Trả về true/false dựa trên kết quả
            }
            return false;
        }
    }
?>