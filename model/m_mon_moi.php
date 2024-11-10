<?php
    include_once("ketnoi.php");
    class mMonMoi{
        public function SelectAllMonMoi(){
            $p = new clsketnoi();
            $conn = $p->moKetNoi();
            $conn->set_charset('utf8');
            if($conn){
                $str = "select * from danhsachdexuatmonmoi";
                $tbl = $conn->query($str);
                $p->dongKetNoi($conn);
                return $tbl;
            }else{
                return false;
            }
        }
    }
?>