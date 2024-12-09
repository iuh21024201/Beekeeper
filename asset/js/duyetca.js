$(document).ready(function () {
    console.log("Document ready");
    const currentWeek = $('#week').val();
    console.log("Current week:", currentWeek);
    loadSchedule(currentWeek, storeId);

    // Xử lý lọc theo tuần
    $('#filter-button').click(function () {
        console.log("Filter button clicked");
        const week = $('#week').val();
        if (!week) {
            $('#error-message').text('Vui lòng chọn tuần').show();
            return;
        }
        $('#error-message').hide();
        loadSchedule(week, storeId);
    });

    function loadSchedule(week, storeId) {
        console.log("Loading schedule for week:", week, "and store:", storeId);
        $.ajax({
            url: '../../controller/cDuyetCa.php',
            method: 'GET',
            data: { ajax: 'filter-week', week: week, store_id: storeId },
            success: function (response) {
                console.log("Schedule response:", response);
                $('#schedule-table').html(response);
                loadEmployees(week, storeId);
            },
            error: function (xhr, status, error) {
                console.error("Error loading schedule:", error);
                $('#error-message').text('Lỗi khi tải dữ liệu lịch làm việc: ' + error).show();
            }
        });
    }

    function loadEmployees(week, storeId) {
        console.log("Loading employees for week:", week, "and store:", storeId);
        $('.approved-employees, .pending-employees').each(function () {
            const [status, day, shift] = this.id.split('-');
            fetchEmployees(day, shift, week, storeId);
        });
    }

    function fetchEmployees(day, shift, week, storeId) {
        console.log("Fetching employees for day:", day, "shift:", shift, "week:", week, "store:", storeId);
        $.ajax({
            url: '../../controller/cDuyetCa.php',
            method: 'GET',
            data: { ajax: 'fetch-employees', day: day, shift: shift, week: week, store_id: storeId },
            success: function (response) {
                console.log("Employees response:", response);
                try {
                    const data = JSON.parse(response);
                    updateEmployeeList('approved', day, shift, data.approved);
                    updateEmployeeList('pending', day, shift, data.pending);
                } catch (e) {
                    console.error("Error parsing employee data:", e);
                    $('#error-message').text('Lỗi khi xử lý dữ liệu nhân viên: ' + e).show();
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching employees:", error);
                $('#error-message').text('Lỗi khi tải danh sách nhân viên: ' + error).show();
            }
        });
    }

    function updateEmployeeList(status, day, shift, employees) {
        console.log("Updating employee list:", status, day, shift, employees);
        const container = $(`#${status}-${day}-${shift}`);
        container.empty();

        if (employees.length === 0) {
            console.log("No employees for:", status, day, shift);
            return;
        }

        employees.forEach(employee => {
            const employeeElement = $('<span>').text(employee.HoTen);
            if (status === 'pending') {
                const approveButton = $('<button>') 
                    .addClass('btn btn-success btn-sm approve-shift ml-2')
                    .text('Duyệt')
                    .data({
                        id: employee.ID_NhanVien,
                        day: day,
                        shift: shift,
                        week: $('#week').val(),
                        store_id: storeId
                    });
                employeeElement.append(approveButton);
            }
            container.append(employeeElement);
        });
    }

    // Duyệt ca cho nhân viên
    $(document).on('click', '.approve-shift', function () {
        console.log("Approve shift button clicked");
        const button = $(this);
        const employeeId = button.data('id');
        const day = button.data('day');
        const shift = button.data('shift');
        const week = button.data('week');
        const storeId = button.data('store_id');

        // Gửi yêu cầu duyệt ca nhân viên
        $.ajax({
            url: '../../controller/cDuyetCa.php',
            method: 'GET',
            data: { ajax: 'approve-shift', id: employeeId, day: day, shift: shift, week: week, store_id: storeId },
            success: function (response) {
                console.log("Approve shift response:", response);
                if (response === 'success') {
                    fetchEmployees(day, shift, week, storeId);
                } else {
                    $('#error-message').text('Lỗi khi duyệt ca: ' + response).show();
                }
            },
            error: function (xhr, status, error) {
                console.error("Error approving shift:", error);
                $('#error-message').text('Lỗi khi duyệt ca: ' + error).show();
            }
        });
    });
});

