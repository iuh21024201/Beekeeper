<?php
    include_once("Controller/cThuongHieu.php");
    $p = new controlThuongHieu();
    $kq = $p -> getAllThuongHieu();
    if(!$kq){
        echo "No data!";
    }else{
        echo "<div id='menu'>";
        echo "<ul>";
        while($r = mysqli_fetch_assoc($kq)){
            echo "<li><a href='?th=".$r['typeofpro_id']."'>".$r['type_name']."</a></li>";
        }
        echo "</ul>";
        echo "</div>";
    }
?>