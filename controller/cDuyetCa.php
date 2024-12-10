<?php
require_once '../model/mDuyetCa.php';

class cDuyetCa {
    private $model;

    public function __construct() {
        $this->model = new mDuyetCa();
    }

    public function handleRequest() {
        if (isset($_GET['ajax'])) {
            try {
                switch ($_GET['ajax']) {
                    case 'filter-week':
                        $this->filterWeek();
                        break;
                    case 'fetch-employees':
                        $this->fetchEmployees();
                        break;
                    case 'approve-shift':
                        $this->approveShift();
                        break;
                    default:
                        throw new Exception("Invalid ajax request");
                }
            } catch (Exception $e) {
                error_log("Error in cDuyetCa: " . $e->getMessage());
                echo json_encode(['error' => $e->getMessage()]);
            }
        }
    }
 
    private function filterWeek() {
        $selectedWeek = intval($_GET['week']);
        $daysOfWeek = [
            "2" => "Thứ 2",
            "3" => "Thứ 3",
            "4" => "Thứ 4",
            "5" => "Thứ 5",
            "6" => "Thứ 6",
            "7" => "Thứ 7",
            "CN" => "Chủ nhật"
        ];
        $shifts = ["Ca A", "Ca B"];

        foreach ($daysOfWeek as $dayKey => $dayName) {
            echo "<tr>";
            echo "<td>$dayName</td>";
            foreach ($shifts as $shift) {
                echo "<td><div class='approved-employees' id='approved-$dayKey-$shift'></div></td>";
                echo "<td><div class='pending-employees' id='pending-$dayKey-$shift'></div></td>";
            }
            echo "</tr>";
        }
    }

    private function fetchEmployees() {
        if (!isset($_GET['day']) || !isset($_GET['shift']) || !isset($_GET['week']) || !isset($_GET['store_id'])) {
            throw new Exception("Missing required parameters");
        }
        $day = $_GET['day'];
        $shift = $_GET['shift'];
        $week = intval($_GET['week']);
        $storeId = intval($_GET['store_id']);

        $approvedEmployees = $this->model->getApprovedEmployees($day, $shift, $week, $storeId);
        $pendingEmployees = $this->model->getPendingEmployees($day, $shift, $week, $storeId);

        echo json_encode([
            'approved' => $approvedEmployees,
            'pending' => $pendingEmployees
        ]);
    }

    private function approveShift() {
        $employeeId = intval($_GET['id']);
        $day = $_GET['day'];
        $shift = $_GET['shift'];
        $week = intval($_GET['week']);
        $storeId = intval($_GET['store_id']);

        $result = $this->model->approveShift($employeeId, $day, $shift, $week, $storeId);
        echo $result ? "success" : "error";
    }
}

$controller = new cDuyetCa();
$controller->handleRequest();

