<?php
class clsketnoi{
    public function moKetNoi(){
        $con = mysqli_connect("localhost", "root", "", "beekeeper");
        mysqli_set_charset($con,'utf8');
        return $con;
    }
    public function dongKetNoi($con){
        mysqli_close($con);
    }
}
?>