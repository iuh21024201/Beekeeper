<?php
    include("../../model/m_thuc_don.php");
    class cThucDon{
        public function getCuaHang($idTaiKhoan){
            $p = new mThucDon();
            $tbl = $p->selectCuaHang($idTaiKhoan);
            if($tbl){
                if($tbl->num_rows>0){
                    return $tbl;
                }else{
                    return -1;
                }
            }else{
                return false;
            }
        }

        public function getAllThucDon($idCuaHang){
            $p = new mThucDon();
            $tbl = $p->selectAllThucDon($idCuaHang);
            if($tbl){
                if($tbl->num_rows>0){
                    return $tbl;
                }else{
                    return -1;
                }
            }else{
                return false;
            }
        }

        public function setNL($idNguyenLieu, $soLuong, $idCuaHang){
            $p = new mThucDon();
            $affectedRows = $p->updateSLT($idNguyenLieu, $soLuong, $idCuaHang);
            if ($affectedRows !== false) {
                if ($affectedRows > 0) {
                    return true; // Thực hiện thành công
                } else {
                    return -1; // Không có dòng nào bị thay đổi
                }
            } else {
                return false; // Truy vấn thất bại
            }
        
        }

        public function setSLT_TD($idCuaHang, $idMonAn, $soLuong){
            $p = new mThucDon();
            $affectedRows = $p->updateSLT_TD($idCuaHang, $idMonAn, $soLuong);
            if ($affectedRows !== false) {
                if ($affectedRows > 0) {
                    return true; // Thực hiện thành công
                } else {
                    return -1; // Không có dòng nào bị thay đổi
                }
            } else {
                return false; // Truy vấn thất bại
            }
        }


        public function getNgayThucDon($idCuaHang){
            $p = new mThucDon();
            $tbl = $p->selectNgayThucDon($idCuaHang);
            if($tbl){
                if($tbl->num_rows>0){
                    return $tbl;
                }else{
                    return -1;
                }
            }else{
                return false;
            }
        }

        public function setSLT0($idMonAn,$idCuaHang){
            $p = new mThucDon();
            $affectedRows = $p->resetSLT($idMonAn,$idCuaHang);
            if ($affectedRows !== false) {
                if ($affectedRows > 0) {
                    return true; // Thực hiện thành công
                } else {
                    return -1; // Không có dòng nào bị thay đổi
                }
            } else {
                return false; // Truy vấn thất bại
            }
        }

        public function getchitietNL($ID_MonAn){
            $p = new mThucDon();
            $tbl = $p->selectChiTietNL($ID_MonAn);
            if($tbl){
                if($tbl->num_rows>0){
                    return $tbl;
                }else{
                    return -1;
                }
            }else{
                return false;
            }
        }

        public function setSL_NL0($idNL, $idCuaHang){
            $p = new mThucDon();
            $affectedRows = $p->resetSLNL($idNL,$idCuaHang);
            if ($affectedRows !== false) {
                if ($affectedRows > 0) {
                    return true; // Thực hiện thành công
                } else {
                    return -1; // Không có dòng nào bị thay đổi
                }
            } else {
                return false; // Truy vấn thất bại
            }
        }

        public function resetSoLuongTungNgayMoi($idCuaHang) {
            // Lấy ngày hiện tại
            $currentDate = date('Y-m-d');
            
            // Lấy thông tin thực đơn của cửa hàng
            $ngayTD = $this->getNgayThucDon($idCuaHang);
            
            // Kiểm tra nếu có thực đơn
            if ($ngayTD && $ngayTD->num_rows > 0) {
                // Duyệt qua từng món ăn trong thực đơn
                while ($row = $ngayTD->fetch_assoc()) {
                    $ngayNhap = $row['NgayNhap'];
                    $idMonAn = $row['ID_MonAn'];
                    
                    // Nếu ngày nhập của thực đơn không phải là ngày hiện tại
                    if ($ngayNhap != $currentDate) {
                        // Reset số lượng tồn của món ăn
                        $this->setSLT0($idMonAn, $idCuaHang); // Hàm này sẽ reset số lượng tồn của món ăn
                        
                        // Lấy chi tiết nguyên liệu của món ăn
                        $chiTietNguyenLieu = $this->getchitietNL($idMonAn);
                        
                        // Nếu có chi tiết nguyên liệu
                        if ($chiTietNguyenLieu && $chiTietNguyenLieu->num_rows > 0) {
                            // Duyệt qua chi tiết nguyên liệu và reset số lượng nguyên liệu
                            while ($rowCT = $chiTietNguyenLieu->fetch_assoc()) {
                                $this->setSL_NL0($rowCT['ID_NguyenLieu'], $idCuaHang); // Hàm này sẽ reset số lượng nguyên liệu
                            }
                        }
                    }
                }
            } else {
                echo "Không có thực đơn nào cho cửa hàng này.";
            }
        }
        
    }
?>