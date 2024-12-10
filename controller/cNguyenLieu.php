<?php
    require_once __DIR__ . '/../model/mNguyenLieu.php';
    class controlNguyenLieu{
        public function getAllNguyenLieu(){
            $p=new modelNguyenLieu();
            $tbl= $p-> selectAllNguyenLieu();
            if(mysqli_num_rows($tbl)){
                return $tbl;
            }else{
                return false;
            }
            
        }     
        public function getAllNguyenLieuSX(){
            $p= new modelNguyenLieu();
            $tbl= $p-> selectAllNguyenLieuSX();
            if(mysqli_num_rows($tbl)){
                return $tbl;
            }else{
                return false;
            }
            
        } 
        public function getAllNguyenLieuByCuaHang($txt) {
            $p = new modelNguyenLieu();
            $kq = $p->selectAllNguyenLieuByCuaHang($txt);
            if (mysqli_num_rows($kq)) {
                return $kq;
            } else {
                return false;
            }
        }
        public function getAllNguyenLieuByNameByCuaHang($txt, $idCuaHang){
            $p = new modelNguyenLieu();
            $kq = $p->selectAllNguyenLieuByNameByCuaHang($txt, $idCuaHang);
            if(mysqli_num_rows($kq) > 0){
                return $kq;
            } else {
                return false;
            }
        }
        public function getAllCTNLByName($txt){
            $p = new modelNguyenLieu();
            $kq = $p->selectAllCTNLByName($txt);
            if(mysqli_num_rows($kq) > 0){
                return $kq;
            } else {
                return false;
            }
        }
        public function getAllNLByName($txt){
            $p = new modelNguyenLieu();
            $kq = $p->selectAllNLByName($txt);
            if(mysqli_num_rows($kq) > 0){
                return $kq;
            } else {
                return false;
            }
        }
        public function layMotNguyenLieuByCTNL($txt) {
            $p = new modelNguyenLieu();
            $kq = $p->layMotNguyenLieuByCTNL($txt);
            if (mysqli_num_rows($kq)) {
                return $kq;
            } else {
                return false;
            }
        }
        public function layMotNguyenLieuByNL($txt) {
            $p = new modelNguyenLieu();
            $kq = $p->layMotNguyenLieuByNL($txt);
            if (mysqli_num_rows($kq)) {
                return $kq;
            } else {
                return false;
            }
        }
        public function updateTrangThaiNguyenLieu($txt) {
            $p = new modelNguyenLieu();
            $kq = $p->updateTrangThaiNguyenLieu($txt);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }
        public function insertNL($tenNL, $gia,$dvt,$hinhanh,$trangthai){
            $p = new modelNguyenLieu();
            $kq = $p -> insertNL($tenNL, $gia,$dvt,$hinhanh,$trangthai);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }
        public function insertCTNL($idNL,$idCH, $soluong){
            $p = new modelNguyenLieu();
            $kq = $p -> insertCTNL($idNL,$idCH, $soluong);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }
        public function updateNL($idNL, $tenNL, $gia, $donVi, $hinhanh, $trangThai){
            $p = new modelNguyenLieu();
            $kq = $p -> updateNL($idNL, $tenNL, $gia, $donVi, $hinhanh, $trangThai);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }
        public function updateCTNLByCTNL($idCTNL, $idCuaHang, $soluong){
            $p = new modelNguyenLieu();
            $kq = $p -> updateCTNLByCTNL($idCTNL, $idCuaHang, $soluong);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }
        public function updateCTNL($idNL, $idCuaHang, $soluong){
            $p = new modelNguyenLieu();
            $kq = $p -> updateCTNL($idNL, $idCuaHang, $soluong);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }
        public function getIngredientsByOrder($idDH) {
            $p = new modelNguyenLieu();
            $tbl = $p->selectIngredientsByOrder($idDH);
            if (mysqli_num_rows($tbl)) {
                return $tbl;
            } else {
                return false;
            }
        }
    
        // Cập nhật số lượng nguyên liệu trong kho của cửa hàng
        public function updateIngredientsStock($idDonHang, $idCuaHang) {
            $p = new modelNguyenLieu();
            $ingredients = $p->selectIngredientsByOrder($idDonHang);
            if ($ingredients) {
                while ($row = $ingredients->fetch_assoc()) {
                    $idNguyenLieu = $row['ID_NguyenLieu'];
                    $soLuongCanTru = $row['SoLuongCanTru'];
                    $p->updateIngredientsStock($idNguyenLieu, $soLuongCanTru, $idCuaHang);
                }
                return true;
            }
            return false;
        }
        
    }
?>