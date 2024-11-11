<?php
<<<<<<< HEAD
class clsketnoi{
    public function moKetNoi(){
        $con = mysqli_connect("localhost", "root", "", "db_beekeeper_6");
        mysqli_set_charset($con,'utf8');
=======

class clsketnoi {
    public function moKetNoi() {
        $con = mysqli_connect("localhost", "root", "", "db_beekeeper_4");
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($con, 'utf8');
>>>>>>> f0c0cb66d2f42d7c919cc89bff6f5f9129d1edd9
        return $con;
    }
    
    public function dongKetNoi($con) {
        mysqli_close($con);
    }
}
?>