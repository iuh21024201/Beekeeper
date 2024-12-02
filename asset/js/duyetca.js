$(document).ready(function () {
    const currentWeek = $('#week').val();
    loadSchedule(currentWeek);

    // Xử lý lọc theo tuần
    $('#filter-button').click(function () {
        const week = $('#week').val();
        loadSchedule(week);
    });

    function loadSchedule(week) {
        $.ajax({
            url: '../../controller/cDuyetCa.php',
            method: 'GET',
            data: { ajax: 'filter-week', week: week },
            success: function (response) {
                $('#schedule-table').html(response);
                loadEmployees(week);
            },
            error: function () {
                alert('Lỗi khi tải dữ liệu lịch làm việc.');
            }
        });
    }

    function loadEmployees(week) {
        $('.approved-employees, .pending-employees').each(function () {
            const [status, day, shift] = this.id.split('-');
            fetchEmployees(day, shift, week);
        });
    }

    function fetchEmployees(day, shift, week) {
        $.ajax({
            url: '../../controller/cDuyetCa.php',
            method: 'GET',
            data: { ajax: 'fetch-employees', day: day, shift: shift, week: week },
            success: function (response) {
                const data = JSON.parse(response);
                updateEmployeeList('approved', day, shift, data.approved);
                updateEmployeeList('pending', day, shift, data.pending);
            },
            error: function () {
                alert('Lỗi khi tải danh sách nhân viên.');
            }
        });
    }

    function updateEmployeeList(status, day, shift, employees) {
        const container = $(`#${status}-${day}-${shift}`);
        container.empty();

        if (employees.length === 0) {
            container.append('<div class="text-muted">Không có nhân viên.</div>');
            return;
        }

        employees.forEach(employee => {
            const employeeElement = $('<div>').text(employee.HoTen);
            if (status === 'pending') {
                const approveButton = $('<button>')
                    .addClass('btn btn-success btn-sm approve-shift ml-2')
                    .text('Duyệt')
                    .data({
                        id: employee.ID_NhanVien,
                        day: day,
                        shift: shift,
                        week: $('#week').val()
                    });
                employeeElement.append(approveButton);
            }
            container.append(employeeElement);
        });
    }

    // Duyệt ca cho nhân viên
    $(document).on('click', '.approve-shift', function () {
        const button = $(this);
        const employeeId = button.data('id');
        const day = button.data('day');
        const shift = button.data('shift');
        const week = button.data('week');

        // Gửi yêu cầu duyệt ca nhân viên
        $.ajax({
            url: '../../controller/cDuyetCa.php',
            method: 'GET',
            data: { ajax: 'approve-shift', id: employeeId, day: day, shift: shift, week: week },
            success: function (response) {
                if (response === 'success') {
                    fetchEmployees(day, shift, week);
                } else {
                    alert('Lỗi khi duyệt ca.');
                }
            },
            error: function () {
                alert('Lỗi khi duyệt ca.');
            }
        });
    });
});
