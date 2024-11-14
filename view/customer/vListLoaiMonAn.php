<?php
	include_once("../../controller/cLoaiSanPham.php");

		$p = new cLoaiSanPham();	
		$kq = $p -> getAllLSP();
			if($kq){
				echo "<ul>";
				while($r = mysqli_fetch_assoc($kq)){
					echo "<li>
							<a href='?loaimonan=".$r['ID_LoaiMon']."'>" .$r["TenLoaiMon"]. "</a>
						</li>";
				}
				echo "</ul>";
			}else{
				echo "<script>alert('Khong co du lieu!')</script>";
			}	
	
	
	
?>