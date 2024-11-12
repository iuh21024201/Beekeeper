<?php
<<<<<<< HEAD
class clsketnoi{
    public function moKetNoi(){
        $con = mysqli_connect("localhost", "root", "", "db_beekeeper_6");
        mysqli_set_charset($con,'utf8');
=======

class clsketnoi {
    public function moKetNoi() {
        $con = mysqli_connect("localhost", "root", "", "db_beekeeper_6");
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($con, 'utf8');

>>>>>>> 09a8f66afe8faabe62294fd02e65dcbe67698677
        return $con;
    }
    public function dongKetNoi($con){
        mysqli_close($con);
    }
}
?>