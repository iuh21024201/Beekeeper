<?php
include("../../model/m_mon_moi.php");

class cInfoMonMoi
{
    private $model;

    public function __construct()
    {
        $this->model = new mMonMoi();
    }

    // Lấy thông tin món mới theo ID
    public function getInfoMonMoi($idMonMoi)
    {
        $result = $this->model->selectInfoMonMoi($idMonMoi);

        if ($result === false) {
            return false; // Truy vấn thất bại
        }

        return ($result->num_rows > 0) ? $result : -1; // -1: Không có dữ liệu
    }

    // Thay đổi trạng thái món mới sang "Duyệt"
    public function statusChange($idMonMoi)
    {
        return $this->model->changeStatusTo1($idMonMoi) ? true : false;
    }

    // Thay đổi trạng thái món mới sang "Xóa"
    public function statusChange_1($idMonMoi){
        $p = new mMonMoi();
        $tbl = $p->changeStatusTo2($idMonMoi); // Đảm bảo gọi đúng phương thức đã thay đổi
        if($tbl){
            return $tbl;
        }else{
            return false;
        }
    }    
}
?>
