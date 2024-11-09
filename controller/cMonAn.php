<?php
require_once __DIR__ . '/../model/mMonAn.php';
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
        $kq = $p -> selectAllMonAnByName($ten);
        if(mysqli_num_rows($kq)>0){
            return $kq;
        }else{
            return false;
        }
    }
}
?>