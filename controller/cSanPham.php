<?php
    include_once("../../model/mSanPham.php");
    class cSanPham{
        public function getAllSP(){
            $p = new MSanPham();
            $tblSP = $p->selectAllSP();
            if(!$tblSP){
                return -1;
            }else{
                if($tblSP->num_rows > 0){
                    return $tblSP;
                }else{
                    return 0; // không có dữ liệu trong bảng
                }
            }
        }
        public function getAllSPByCate($cate){
			// lấy toàn bộ sản phẩm
			$p = new MSanPham();
			$tblSP = $p->selectAllSPByCate($cate);
			if($tblSP){
                if($tblSP->num_rows>0){
                    return $tblSP;
                }else{
                    return -1; 
                }
            }else{
                return false;
            }
		}
        public function getAllSPByStore($id) {
            $p = new MSanPham();
            $tblSP = $p->SelectAllSPByStore($id);
        
            if ($tblSP && $tblSP !== -1) {
                return $tblSP;
            } else {
                echo "Không tìm thấy sản phẩm nào cho cửa hàng ID: $id";
                return false;
            }
        }
        public function getAllSPByName($name){
			$p = new MSanPham();
			$tblSP = $p->selectAllSPByName($name);
			if($tblSP){
                if($tblSP->num_rows>0){
                    return $tblSP;
                }else{
                    return -1;
                }
            }else{
                return false;
            }
		}
        public function getSPChiTiet($id){
			$p = new MSanPham();
			$tblSP = $p->SelectAllSPChiTiet($id);
			if($tblSP){
                if($tblSP->num_rows>0){
                    return $tblSP;
                }else{
                    return -1;
                }
            }else{
                return false;
            }
		}
        public function getAllSPByPrice($price) {
            $p = new MSanPham();
            $tblSP = $p->SelectAllSPByPrice($price);
            if(!$tblSP){
                return -1;
            } else {
                if($tblSP->num_rows > 0){
                    return $tblSP;
                } else {
                    return 0; // không có dòng dữ liệu
                }
            }
        }
        public function getSPByID($id){
			$p = new MSanPham();
			$tblSP = $p->SelectSPByID($id);
			if($tblSP){
                if($tblSP->num_rows>0){
                    return $tblSP;
                }else{
                    return -1; 
                }
            }else{
                return false;
            }
		}
        public function getCTSPByID($id){
			$p = new MSanPham();
			$tblSP = $p->SelectCTSPByID($id);
			if($tblSP){
                if($tblSP->num_rows>0){
                    return $tblSP;
                }else{
                    return -1; 
                }
            }else{
                return false;
            }
		}
    }
?>