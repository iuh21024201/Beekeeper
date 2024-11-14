<?php
require_once __DIR__ . '/../model/mMonAn.php';
require_once ('upload.php');

class controlMonAn {
    
    public function getAllMonAn() {
        $p = new modelMonAn();
        $kq = $p->selectAllMonAn();
        if (mysqli_num_rows($kq)) {
            return $kq;
        } else {
            return false;
        }
    }

    public function getAllMonAnByType($lm) {
        $p = new modelMonAn();
        $kq = $p->selectAllMonAnByType($lm);
        if (mysqli_num_rows($kq)) {
            return $kq;
        } else {
            return false;
        }
    }

    public function getAllMonAnByName($ten){
        $p = new modelMonAn();
        $kq = $p->selectAllMonAnByName($ten);
        if(mysqli_num_rows($kq) > 0){
            return $kq;
        } else {
            return false;
        }
    }

    public function getOneMonAn($maMonAn){
        $p = new modelMonAn();
        $kq = $p -> selectOneMonAn($maMonAn);
        if(mysqli_num_rows($kq)>0){
            return $kq;
        }else{
            return false;
        }
    }
    public function updateTinhTrangMonAn($maMonAn) {
        $p = new modelMonAn();
        $kq = $p->updateTinhTrangMonAn($maMonAn); // Call the model function to update status
    
        return $kq;
    }
    
}
?>
