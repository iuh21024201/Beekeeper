<?php
    include_once("Controller/cSanPham.php");
    $p = new controlSanPham();
    $kq= $p->getAllSanPham();
    if(isset($_REQUEST['th'])){
        $kq = $p -> getAllSanPhamByType($_REQUEST['th']);
    }elseif(isset($_REQUEST['btnTimKiem'])){
        $kq = $p -> getAllSanPhamByName($_REQUEST['txtname']);
    }else{
        $kq = $p -> getAllSanPham();
    }
    if(!$kq){
        echo "No data!";
    }else{
        echo "<table>";
            echo "<tr>";
            $dem = 0;
            while($r = mysqli_fetch_assoc($kq)){
                echo "<td>";
                    echo "<img src='image/".$r["img"]."'width='100px'/> <br>";
                    echo "<b><a href=''>".$r["ProductName"]."</a></b><br>";
                    if($r["discount"]==null){
                        echo number_format($r['price'],0,",",".")." VNĐ";
                    }else{
                        echo number_format($r['discount'],0,",",".")." VNĐ<br><s>".number_format($r['price'],0,",",".")." VNĐ"."</s>";
                    }
                echo "</td>";
                $dem++;
                if($dem%4==0){
                    echo "</tr><tr>";
                }
            }
            echo "</tr>";
        echo "</table>";
    }
?>
