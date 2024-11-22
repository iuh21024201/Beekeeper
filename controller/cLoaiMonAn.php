<?php
    require_once __DIR__ . '/../model/mLoaiMonAn.php';
    class controlLoaiMon{
        public function getAllLoaiMon(){
            $p=new modelLoaiMon();
            $tbl= $p-> selectAllLoaiMon();
            if(mysqli_num_rows($tbl)){
                return $tbl;
            }else{
                return false;
            }
            
        }

        public function getOneLoaiMon($maLM){
            $p = new modelLoaiMon();
            $kq = $p -> selectOneLoaiMon($maLM);
            if(mysqli_num_rows($kq)>0){
                return $kq;
            }else{
                return false;
            }
        }

        public function insertLoaiMon($tenLM, $trangThai){
            $p = new modelLoaiMon();
            $kq = $p -> insertLoaiMon($tenLM, $trangThai);
            if($kq){
                return $kq;
            }else{
                return false;
            }
        }
        public function updateLoaiMon($maLM, $tenLM, $trangThai){
            $p = new modelLoaiMon();
            $kq = $p -> updateLoaiMon($maLM, $tenLM, $trangThai);
            if($kq){
                return $kq;
            } else {
                return false;
            }
        }

        public function updateTinhTrangLoaiMon($maLoaiMon) {
            $p = new modelLoaiMon();
            $kq = $p->updateTinhTrangLoaiMon($maLoaiMon); 
            
            return $kq;
        }
        
    }
?>