$(document).ready(function() {
    let dishes = [];

    $('.edit-booking').click(function() {
        const bookingId = $(this).data('id');
        $.ajax({
            url: '../../controller/cQuanLyDatTiec.php?action=getBookingDetails',
            method: 'GET',
            data: { id: bookingId },
            success: function(response) {
                const booking = JSON.parse(response);
                $('#bookingId').val(bookingId);
                $('#gioHen').val(booking.GioHen);
                $('#trangTri').val(booking.ID_LoaiTrangTri);
                $('#soNguoi').val(booking.SoNguoi);
                $('#tongTien').val(booking.TongTien);
                $('#tienCoc').val(booking.TienCoc);
                $('#tienConLai').val(booking.TienConLai);
                $('#ghiChu').val(booking.GhiChu);

                dishes = booking.dishes;
                updateDishesDisplay();

                $('#editModal').modal('show');
            },
            error: function() {
                alert('Không thể tải thông tin đơn tiệc.');
            }
        });
    });

    $('.delete-booking').click(function() {
        if (confirm('Bạn có chắc chắn muốn xóa đơn tiệc này không?')) {
            const bookingId = $(this).data('id');
            $.ajax({
                url: '../../controller/cQuanLyDatTiec.php',
                method: 'POST',
                data: { delete: true, id: bookingId },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Không thể xóa đơn tiệc.');
                }
            });
        }
    });

    $('#addDishBtn').click(function() {
        $.ajax({
            url: '../../controller/cQuanLyDatTiec.php?action=getDishes',
            method: 'GET',
            success: function(response) {
                const availableDishes = JSON.parse(response);
                let dishHtml = '<div class="dish-item mb-2">';
                dishHtml += '<select class="form-control dish-select">';
                availableDishes.forEach(dish => {
                    dishHtml += `<option value="${dish.ID_MonAn}" data-price="${dish.Gia}">${dish.TenMonAn}</option>`;
                });
                dishHtml += '</select>';
                dishHtml += '<input type="number" class="form-control dish-quantity" value="1" min="1">';
                dishHtml += '<button type="button" class="btn btn-danger remove-dish">Xóa</button>';
                dishHtml += '</div>';

                $('#dishesContainer').append(dishHtml);
                updateTotalAmount();
            },
            error: function() {
                alert('Không thể tải danh sách món ăn.');
            }
        });
    });

    $(document).on('click', '.remove-dish', function() {
        $(this).closest('.dish-item').remove();
        updateTotalAmount();
    });

    $(document).on('change', '.dish-select, .dish-quantity', function() {
        updateTotalAmount();
    });

    $('#tienCoc').on('input', function() {
        updateTotalAmount();
    });

    function updateTotalAmount() {
        let total = 0;
        $('.dish-item').each(function() {
            const price = $(this).find('.dish-select option:selected').data('price');
            const quantity = $(this).find('.dish-quantity').val();
            total += price * quantity;
        });

        $('#tongTien').val(total);
        const deposit = parseFloat($('#tienCoc').val()) || 0;
        $('#tienConLai').val(total - deposit);
    }

    function updateDishesDisplay() {
        $('#dishesContainer').empty();
        dishes.forEach(dish => {
            let dishHtml = '<div class="dish-item mb-2">';
            dishHtml += `<select class="form-control dish-select">
                            <option value="${dish.ID_MonAn}" data-price="${dish.Gia}" selected>${dish.TenMonAn}</option>
                         </select>`;
            dishHtml += `<input type="number" class="form-control dish-quantity" value="${dish.SoLuong}" min="1">`;
            dishHtml += '<button type="button" class="btn btn-danger remove-dish">Xóa</button>';
            dishHtml += '</div>';
            $('#dishesContainer').append(dishHtml);
        });
        updateTotalAmount();
    }

    $('#editForm').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        
        // Collect dishes data
        const dishes = [];
        $('.dish-item').each(function() {
            const dishId = $(this).find('.dish-select').val();
            const quantity = $(this).find('.dish-quantity').val();
            const price = $(this).find('.dish-select option:selected').data('price');
            dishes.push({id: dishId, quantity: quantity, price: price});
        });

        $.ajax({
            url: '../../controller/cQuanLyDatTiec.php?action=updateDishes',
            method: 'POST',
            data: {
                bookingId: $('#bookingId').val(),
                dishes: JSON.stringify(dishes)
            },
            success: function(response) {
                const result = JSON.parse(response);
                if (result.success) {
                    $.ajax({
                        url: 'cQuanLyDatTiec.php',
                        method: 'POST',
                        data: formData,
                        success: function(response) {
                            $('#editModal').modal('hide');
                            location.reload();
                        },
                        error: function() {
                            alert('Không thể cập nhật đơn tiệc.');
                        }
                    });
                } else {
                    alert('Không thể cập nhật món ăn.');
                }
            },
            error: function() {
                alert('Không thể cập nhật món ăn.');
            }
        });
    });
});
