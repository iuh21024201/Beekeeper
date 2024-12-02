<?php
    include_once("../../model/mCuaHang.php");
    class cCuaHang{
        public function getAllStore(){
            $p = new MCuaHang();
            $tblSP = $p->SelectAllStore();
            if(!$tblSP){
                return -1;
            }else{
                if($tblSP->num_rows > 0){
                    return $tblSP;
                }else{
                    return 0; // không có dòng dữ liệu
                }
            }
        }
        public function getStoreByID($id){
			// lấy toàn bộ sản phẩm
			$p = new MCuaHang();
			$tblSP = $p->SelectStoreByID($id);
			if($tblSP){
                if($tblSP->num_rows>0){
                    return $tblSP;
                }else{
                    return null; 
                }
            }else{
                return false;
            }
		}
    }
?>