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
            // Lấy danh sách nguyên liệu cần trừ
            $ingredients = $p->selectIngredientsByOrder($idDonHang);
    
            if ($ingredients) {
                while ($row = $ingredients->fetch_assoc()) {
                    $idNguyenLieu = $row['ID_NguyenLieu'];
                    $soLuongCanTru = $row['SoLuongCanTru'];
                    // Cập nhật số lượng nguyên liệu trong kho của cửa hàng
                    $p->updateIngredientsStock($idNguyenLieu, $soLuongCanTru, $idCuaHang);
                }
                return true; // Nguyên liệu đã được trừ
            } else {
                return false;
            }
        }
    }
?>