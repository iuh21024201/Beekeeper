<?php
	// if(isset($_GET['ThemNguyenLieu']))
	// 	{
	// 		include("../../controller/cNguyenLieu.php");
	// 		$p = new CNguyenLieu();
	// 		$tblSP = $p->getAllTH();
	// 		if(!$tblSP)
	// 		{
	// 			echo 'Khong ket noi duoc';
	// 		}
	// 		elseif($tblSP==-1)
	// 		{
	// 			echo 'chua co du lieu';
	// 		}
	// 		else
	// 		{
	// 			echo '  ';
			
	
	// 		}
	// }
    if(isset($_POST["btnThem"])){
        $tensp=$_POST["tenSP"];
        $gia=$_POST["gia"];
        $thuonghieu=$_POST["thuonghieu"];
        $hinhanh=$_FILES["hinhanh"]["name"];
        if($gia > 0)
        {
            if($_FILES["hinhanh"]["type"]=="image/png" || $_FILES["hinhanh"]["type"]=="image/jpeg" || $_FILES["hinhanh"]["type"]=="image/jpg")
            {
                if(move_uploaded_file($_FILES["hinhanh"]["tmp_name"],"image/anhSanPham/".$hinhanh))
                {
                    include_once("controller/cSanPham.php");
                    $p = new CSanPham();
        
                    $result = $p->themSP($tensp,$gia,$hinhanh,$thuonghieu);
                    if ($result){
                        echo "Thêm thành công";
                    }else{
                        echo "Thêm thất bại";
                    }
                    
                }else
                    echo "Upload thất bại";
            }
            else{
                echo "Chỉ chấp nhận loąi file ảnh";
            }
        }
        else
            echo "Giá không được số âm";
        
        
    }
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4>Thêm nguyên liệu</h4>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data" action="">
                <div class="form-group">
                    <label for="">Tên nguyên liệu</label>
                    <input type="text" name="name" class="form-control" id="">
                </div>
                <div class="form-group">
                    <label for="">Giá mua</label>
                    <input type="text" name="gia" class="form-control" id="">
                </div>
                <div class="form-group">
                    <label for="">Số lượng</label>
                    <input type="number" name="soluong" class="form-control" id="">
                </div>
                <div class="form-group">
                    <label for="">Đơn vị tính</label>
                    <select name="donvi" class="form-control" id="">
                        <option value="Kg">Kg</option>
                        <option value="Gói">Gói</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <input type="number" name="status" class="form-control" id="">
                </div>
                <div class="form-group">
                    <label for="">Cửa hàng</label>
                    <input type="text" name="" class="form-control" id="">
                </div>
                <div class="form-group">
                    <label for="">Hình ảnh</label>
                    <input type="file" name="image" class="form-control" id="">
                </div>

                <button name="submit" class="btn btn-success" type="submit">Thêm</button>
            </form>
        </div>
    </div>
</div>
