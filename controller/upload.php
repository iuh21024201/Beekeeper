<?php
class UploadAnh {
    public function uploadAnhMonAn($file, $filename, &$hinh) {
        $size = $file['size'];
        $ten = $file['name'];
        $loai = $file['type'];
        $temp = $file['tmp_name'];

        // Kiểm tra kích thước và loại tệp
        if (!$this->checkSize($size)) {
            return false;
        }
        if (!$this->checkType($loai)) {
            return false;
        }

        // Đường dẫn thư mục
        $folder = __DIR__ . "/image/monan/";  // Absolute path to the directory

        // Ensure the directory exists, if not create it
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true); // Create directory with appropriate permissions
        }

        // Lấy phần mở rộng của tệp
        $name_arr = explode(".", $file["name"]);
        $ext = "." . strtolower($name_arr[count($name_arr) - 1]);  // chuyển phần mở rộng thành chữ thường

        // Thay đổi tên tệp
        $hinh = $this->changeName($filename) . $ext;

        // Đường dẫn đích
        $des = $folder . $hinh;

        // Kiểm tra và di chuyển tệp
        if (is_uploaded_file($temp)) {  // Check if the file was uploaded via HTTP POST
            if (move_uploaded_file($temp, $des)) {
                return true;  // File uploaded successfully
            } else {
                echo "Failed to move the uploaded file to destination.";
                return false;  // Failed to move the file
            }
        } else {
            echo "No file uploaded.";
            return false;  // No file uploaded
        }
    }

    // Kiểm tra loại tệp
    public function checkType($loai) {
        $arrType = array("image/jpeg", "image/png", "image/jpg");

        if (in_array($loai, $arrType)) {
            return true;
        } else {
            echo "<script>alert('Chỉ được phép tải lên các tệp hình ảnh (JPEG, PNG, JPG).');</script>";
            return false;
        }
    }

    // Kiểm tra kích thước tệp
    public function checkSize($size) {
        if ($size < 3 * 1024 * 1024) { // 3MB
            return true;
        } else {
            echo "File size exceeds the maximum allowed size (3MB).";
            return false;
        }
    }

    // Thay đổi tên tệp
    public function changeName($ten) {
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );

        // Thay thế kí tự Unicode => bỏ dấu tiếng Việt
        foreach ($unicode as $nonUnicode => $uni) {
            $ten = preg_replace("/($uni)/i", $nonUnicode, $ten);
        }

        // Thay thế khoảng trắng thành dấu _
        $ten = str_replace(' ', '_', $ten);
        return $ten;
    }
}
?>
