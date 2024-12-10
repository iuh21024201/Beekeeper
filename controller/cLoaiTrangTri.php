<?php
    include_once("../../model/mLoaiTrangTri.php");
    class CLoaiTrangTri{
        public function getAllTrangTri(){
            $p = new MLoaiTrangTri();
            $tbl = $p->SelectAllTrangTri();
            if(!$tbl){
                return -1;
            }else{
                if($tbl->num_rows > 0){
                    return $tbl;
                }else{
                    return 0; // không có dòng dữ liệu
                }
            }
        }
        public function getDecorationById($id){
            $p = new MLoaiTrangTri();
            $tbl = $p->SelectDecorationById($id);
            if(!$tbl){
                return -1;
            }else{
                if($tbl->num_rows > 0){
                    return $tbl;
                }else{
                    return 0; // không có dòng dữ liệu
                }
            }
        }
        
    }
?>