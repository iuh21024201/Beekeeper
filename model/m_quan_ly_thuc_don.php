<?php
include_once("ketnoi.php");
class mThucDon{
    public function selectThucDon($cuahang){
        $p = new clsketnoi();
        $conn = $p->moKetNoi();
        $conn->set_charset('utf8');
        if($conn){
            $str = "SELECT ma.ID_MonAn, ma.TenMonAn, td.SoLuongTon FROM thucdon td INNER JOIN monan ma on td.ID_MonAn = ma.ID_MonAn WHERE td.ID_CuaHang = $cuahang";
            $tbl = $conn->query($str);
            $p->dongKetNoi($conn);
            return $tbl;
        }else{
            return false;
        }
    }
}
?>