<!-- <?php
error_reporting(1);
if(isset($_GET['ThemNguyenLieu']))
{
include('them-nguyen-lieu.php');
}

?> -->
<h2 style="text-align: center;">Quản lý nguyên liệu</h2>
<hr>
<div class="container-fluid">
<p ><a href="#" id="myBtn" class="btn btn-primary">Thêm nguyên liệu</a></p>
    <div class="card">
        <div class="card-header">
            <h4>Danh sách sản phẩm</h4>
        </div>
        <div class="card-body">
            <table class="table">
                <thead class="thead-dark">
                <tr >
                    <th>STT</th>
                    <th>Tên nguyên liệu</th>
                    <th>Đơn vị tính</th>
                    <th>Số lượng</th>
                    <th>Giá mua</th>
                    <th>Hình ảnh</th>
                    <th>Trạng thái</th>
                    <th>Chức năng</th>
                </tr >
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: center; vertical-align: middle;">
                            <ul class="edit">
                                <a href="#" id="editBtn">Sửa</a>/<a href="delete-item.php?id=<?php echo $item['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa món ăn này?');" id="deleteBtn">Xóa</a>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <div class="modal" id="myModal">  
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="btn-block">Thêm nguyên liệu</h4>
                    <button class="close" data-dismiss="modal">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên nguyên liệu</label>
                        <input type="text" id="txtTenSP" class="form-control" placeholder="Nhập tên món ăn">
                        <span class="text-danger" id="tbTenSP">(*)</span>
                    </div>
                    <div class="form-group">
                        <label>Giá mua</label>
                        <input type="text" id="txtGia" class="form-control" placeholder="Nhập giá món ăn">
                        <span class="text-danger" id="tbGia">(*)</span>
                    </div>
                    <div class="form-group">
                        <label>Số lượng</label>
                        <input type="text" class="form-control" id="txtSoLuong">
                        <span class="text-danger" id="tbSoLuong">(*)</span>
                    </div>
                    
                    <div class="form-group">
                        <label>Đơn vị tính</label>
                        <select id="txtDonVi" class="form-control">
                            <option value="Kg">Kg</option>
                            <option value="Gói">Gói</option>
                            <option value="Hộp">Hộp</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select id="txtTrangThai" class="form-control">
                            <option value="1">Còn hàng</option>
                            <option value="0">Hết hàng</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cửa hàng</label>
                        <select id="txtCuaHang" class="form-control">
                            <option value="1">Chọn cửa hàng</option>
                            <option value="1">Cửa hàng A</option>
                            <option value="0">Cửa hàng B</option>
                            <option value="0">Cửa hàng C</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh</label>
                        <input type="file" id="txtHinhAnh" class="form-control">
                        <span class="text-danger" id="tbHinhAnh">(*)</span>
                    </div>
                    
                    
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-block" id="btnSave">Thêm nguyên liệu</button>
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function() {
        $("#myBtn").on("click", function() {
            $("#myModal").modal("show");
        })
    })

</script>

<div class="modal" id="updateModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="btn-block">Cập nhật nguyên liệu</h4>
                <button class="close" data-dismiss="modal">x</button>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                        <label>Tên nguyên liệu</label>
                        <input type="text" id="txtTenSP" class="form-control" placeholder="Nhập tên món ăn">
                        <span class="text-danger" id="tbTenSP">(*)</span>
                    </div>
                    <div class="form-group">
                        <label>Giá mua</label>
                        <input type="text" id="txtGia" class="form-control" placeholder="Nhập giá món ăn">
                        <span class="text-danger" id="tbGia">(*)</span>
                    </div>
                    <div class="form-group">
                        <label>Số lượng</label>
                        <input type="text" class="form-control" id="txtSoLuong">
                        <span class="text-danger" id="tbSoLuong">(*)</span>
                    </div>
                    
                    <div class="form-group">
                        <label>Đơn vị tính</label>
                        <select id="txtDonVi" class="form-control">
                            <option value="Kg">Kg</option>
                            <option value="Gói">Gói</option>
                            <option value="Hộp">Hộp</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select id="txtTrangThai" class="form-control">
                            <option value="1">Còn hàng</option>
                            <option value="0">Hết hàng</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cửa hàng</label>
                        <select id="txtCuaHang" class="form-control">
                            <option value="1">Chọn cửa hàng</option>    
                            <option value="1">Cửa hàng A</option>
                            <option value="0">Cửa hàng B</option>
                            <option value="0">Cửa hàng C</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh</label>
                        <input type="file" id="txtHinhAnh" class="form-control">
                        <span class="text-danger" id="tbHinhAnh">(*)</span>
                    </div>      
                </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-block" id="btnUpdate">Cập nhật món ăn</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
        $("#editBtn").on("click", function() {
            $("#updateModal").modal("show");
        })
})
</script>