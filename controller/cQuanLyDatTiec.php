<?php


class cQuanLyDatTiec {
    private $conn;

    public function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "db_beekeeper_7";

        $this->conn = new mysqli($servername, $username, $password, $database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getBookingDetails($id) {
        $idCuaHang = $_SESSION['ID_CuaHang'];
        $stmt = $this->conn->prepare("SELECT * FROM DatTiec WHERE ID_DatTiec = ? AND ID_CuaHang = ?");
        $stmt->bind_param("ii", $id, $idCuaHang);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if ($data) {
            $data['dishes'] = $this->getDishesByBooking($id);
        }

        $stmt->close();
        return json_encode($data);
    }

    public function getDishesByBooking($id) {
        $stmt = $this->conn->prepare("SELECT MonAn.ID_MonAn, MonAn.TenMonAn, MonAn.Gia, ChiTietDatTiec.SoLuong FROM ChiTietDatTiec JOIN MonAn ON ChiTietDatTiec.ID_MonAn = MonAn.ID_MonAn WHERE ChiTietDatTiec.ID_DatTiec = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $dishes = [];

        while ($row = $result->fetch_assoc()) {
            $dishes[] = $row;
        }

        $stmt->close();
        return $dishes;
    }

    public function updateBooking($id, $data) {
        $idCuaHang = $_SESSION['ID_CuaHang'];
        $stmt = $this->conn->prepare("UPDATE DatTiec SET GioHen = ?, ID_LoaiTrangTri = ?, SoNguoi = ?, TongTien = ?, TienCoc = ?, TienConLai = ?, GhiChu = ? WHERE ID_DatTiec = ? AND ID_CuaHang = ?");
        $stmt->bind_param("siiddisii", $data['GioHen'], $data['ID_LoaiTrangTri'], $data['SoNguoi'], $data['TongTien'], $data['TienCoc'], $data['TienConLai'], $data['GhiChu'], $id, $idCuaHang);
        $success = $stmt->execute();
        $stmt->close();

        if ($success) {
            $this->updateDishes($id, $data['dishes']);
        }

        return $success;
    }

    public function updateDishes($bookingId, $dishes) {
        $this->conn->query("DELETE FROM ChiTietDatTiec WHERE ID_DatTiec = $bookingId");

        $stmt = $this->conn->prepare("INSERT INTO ChiTietDatTiec (ID_DatTiec, ID_MonAn, SoLuong) VALUES (?, ?, ?)");
        foreach ($dishes as $dish) {
            $stmt->bind_param("iii", $bookingId, $dish['id'], $dish['quantity']);
            $stmt->execute();
        }
        $stmt->close();
    }

    public function deleteBooking($id) {
        $idCuaHang = $_SESSION['ID_CuaHang'];
        $stmt = $this->conn->prepare("DELETE FROM DatTiec WHERE ID_DatTiec = ? AND ID_CuaHang = ?");
        $stmt->bind_param("ii", $id, $idCuaHang);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function getAvailableDishes() {
        $idCuaHang = $_SESSION['ID_CuaHang'];
        $stmt = $this->conn->prepare("SELECT ID_MonAn, TenMonAn, Gia FROM MonAn WHERE ID_CuaHang = ?");
        $stmt->bind_param("i", $idCuaHang);
        $stmt->execute();
        $result = $stmt->get_result();
        $dishes = [];

        while ($row = $result->fetch_assoc()) {
            $dishes[] = $row;
        }

        $stmt->close();
        return json_encode($dishes);
    }
}

$action = $_GET['action'] ?? null;
$controller = new cQuanLyDatTiec();

switch ($action) {
    case 'getBookingDetails':
        echo $controller->getBookingDetails($_GET['id']);
        break;
    case 'updateBooking':
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode(['success' => $controller->updateBooking($data['id'], $data)]);
        break;
    case 'deleteBooking':
        echo json_encode(['success' => $controller->deleteBooking($_POST['id'])]);
        break;
    case 'getDishes':
        echo $controller->getAvailableDishes();
        break;
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
        break;
}
