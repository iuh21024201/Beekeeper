<?php

class clsketnoi {
    public function moKetNoi() {
        $con = mysqli_connect("localhost", "root", "", "db_beekeeper_1");
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($con, 'utf8');
        return $con;
    }
    
    public function dongKetNoi($con) {
        mysqli_close($con);
    }
}
?>