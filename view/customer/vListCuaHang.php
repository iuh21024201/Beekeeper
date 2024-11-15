<?php
	include_once("../../controller/cCuaHang.php");

		$p = new cCuaHang();	
		$kq = $p -> getAllStore();
			if($kq){
				echo "<ul>";
				while($r = mysqli_fetch_assoc($kq)){
					echo "<li>
							<a href='?store=".$r['ID_CuaHang']."'>" .$r["TenCuaHang"]. "</a>
						</li>";
				}
				echo "</ul>";
			}else{
				echo "<script>alert('Khong co du lieu!')</script>";
			}	
	
	
	
?>