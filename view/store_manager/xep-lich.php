<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xếp lịch làm việc</title>
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .table th, .table td {
            vertical-align: middle;
            padding: 0.5rem;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2>Xếp lịch làm việc cho nhân viên</h2>

    <!-- Form chọn tuần -->
    <form id="filter-form" class="mb-4">
        <label for="week">Chọn tuần:</label>
        <input type="number" id="week" name="week" value="<?php echo date('W'); ?>" class="form-control w-25 d-inline-block">
        <button type="button" id="filter-button" class="btn btn-primary">Xem lịch</button>
    </form>

    <!-- Bảng xếp lịch -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th rowspan="2" class="align-middle">Ngày</th>
                <th colspan="2" class="text-center">Ca sáng</th>
                <th colspan="2" class="text-center">Ca chiều</th>
            </tr>
            <tr>
                <th class="text-center">Đã duyệt</th>
                <th class="text-center">Chưa duyệt</th>
                <th class="text-center">Đã duyệt</th>
                <th class="text-center">Chưa duyệt</th>
            </tr>
        </thead>
        <tbody id="schedule-table">
            <!-- This will be populated by JavaScript -->
        </tbody>
    </table>
</div>

<script src="../../asset/js/duyetca.js"></script>
</body>
</html>