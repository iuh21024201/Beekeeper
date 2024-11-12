<?php
include_once("ketnoi.php");
class modelMonAn {
    public function selectAllMonAn() {
        $p = new clsketnoi();
        $con = $p->moKetNoi();
        $truyvan = "SELECT * FROM monan m JOIN loaimonan lm ON m.id_loaimon = lm.id_loaimon ORDER BY id_monan DESC";
        
        $kq = mysqli_query($con, $truyvan);
        
        $p->dongKetNoi($con);
        return $kq;  
    }
    public function selectAllMonAnByType($lm) {
        $p = new clsketnoi();
        $con = $p->moKetNoi();
        $truyvan = "SELECT * FROM monan m 
                    JOIN loaimonan lm ON m.id_loaimon = lm.id_loaimon 
                    WHERE lm.id_loaimon = $lm";
        
        $kq = mysqli_query($con, $truyvan);
    
        $p->dongKetNoi($con);
        return $kq;
    }
   
    public function selectAllMonAnByName($ten){
        $p = new clsketnoi();
        $truyvan = " SELECT * FROM monan m 
                    JOIN loaimonan lm ON m.id_loaimon = lm.id_loaimon 
                    WHERE m.TenMonAn like N'%$ten%'";
        $con = $p -> moKetNoi();
        $kq = mysqli_query($con, $truyvan);
        $p -> dongKetNoi($con);
        return $kq;
    }
    public function selectOneMonAn($maMonAn){
        $p = new clsketnoi();
        $truyvan = "SELECT * FROM monan m 
                    JOIN loaimonan lm ON m.id_loaimon = lm.id_loaimon 
                    WHERE id_monan =$maMonAn";
        $con = $p -> moKetNoi();
        $kq = mysqli_query($con, $truyvan);
        $p -> dongKetNoi($con);
        return $kq;
     }
    public function updateTinhTrangMonAn($maMonAn) {
        $p = new clsketnoi();
        $truyvan = "UPDATE monan SET tinhtrang = 1 WHERE id_monan = $maMonAn AND tinhtrang = 0";
        $con = $p->moKetNoi();
        $kq = mysqli_query($con, $truyvan);
        $p->dongKetNoi($con);
        return $kq;
    }
}

?>