<?php
class clsketnoi{
    public function moKetNoi(){
<<<<<<< HEAD
        $con = mysqli_connect("localhost", "root", "", "db_beekeeper_8");
=======
        $con = mysqli_connect("localhost", "root", "", "db_beekeeper");
>>>>>>> a6c5a3a5c1f2e80b0824b9eb02f2e52cf94566c6
        mysqli_set_charset($con,'utf8');
        return $con;
    }
    public function dongKetNoi($con){
        mysqli_close($con);
    }
}
?>