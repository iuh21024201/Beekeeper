<div id="nav" class="container">
    <h2>Liên hệ</h2>
    <table class="table table-borderless">
        <tr>
            <td>
                <h3>Thông tin liên hệ:</h3>
                    <table class="table">
                        <tr>
                            <td><i class="fa-solid fa-cart-shopping" style="color: #ff0000;"></i></td>
                            <td>Beekeper</td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-phone" style="color: #ff0000;"></i></td>
                            <td>0123456789</td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-location-dot" style="color: #ff0000;"></i></td>
                            <td>12 Nguyễn Văn Bảo, Phường 4, Gò Vấp, Hồ Chí Minh</td>
                        </tr>
                    </table>
                <h3>Gửi tin nhắn cho chúng tôi</h3>
                <!-- Form gửi tin nhắn -->
                <form action="../../model/msubmit.php" method="post" onsubmit="return validateForm()">
    <table class="table table-borderless">
        <tr>
            <td>
                <input type="text" class="form-control" placeholder="Họ tên" name="name" id="name" required>
            </td>
            <td>
                <input type="text" class="form-control" placeholder="Số điện thoại" name="numberPhone" id="numberPhone" required>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="email" class="form-control" placeholder="Email" name="email" id="email" required>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <textarea class="form-control" rows="5" placeholder="Tin nhắn" name="message" id="message" required></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <button type="submit" class="btn btn-danger">Gửi</button>
            </td>
        </tr>
    </table>
</form>

<!-- JavaScript Validation -->
<script>
    function validateForm() {
        // Kiểm tra họ tên (Viết hoa chữ cái đầu)
        const name = document.getElementById("name").value;
        const namePattern = /^[A-ZÁÀẢÃẠÂẤẦẨẪĂẮẰẲẴ][a-záàạảãâấầẩẫăắằẳẵ]*([\s][A-ZÁÀẢÃẠÂẤẦẨẪĂẮẰẲẴ][a-záàạảãâấầẩẫăắằẳẵ]*)*$/;
        if (!namePattern.test(name)) {
            alert("Họ tên phải viết hoa chữ cái đầu.");
            return false;
        }

        // Kiểm tra số điện thoại (Chỉ gồm 10 số)
        const numberPhone = document.getElementById("numberPhone").value;
        const phonePattern = /^\d{10}$/;
        if (!phonePattern.test(numberPhone)) {
            alert("Số điện thoại phải gồm 10 chữ số.");
            return false;
        }

        // Kiểm tra email (Đuôi @gmail.com)
        const email = document.getElementById("email").value;
        const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
        if (!emailPattern.test(email)) {
            alert("Email phải có đuôi @gmail.com.");
            return false;
        }

        // Kiểm tra tin nhắn (Không để trống)
        const message = document.getElementById("message").value;
        if (message.trim() === "") {
            alert("Tin nhắn không được để trống.");
            return false;
        }

        // Hiển thị thông báo thành công
        alert("Gửi thành công!");
        return true;
    }
</script>

            </td>
            <td>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.858169091082!2d106.68427047570354!3d10.822164158347038!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174deb3ef536f31%3A0x8b7bb8b7c956157b!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2hp4buHcCBUUC5IQ00!5e0!3m2!1svi!2s!4v1730039053057!5m2!1svi!2s" width="600" height="650" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </td>
        </tr>
    </table>
    <?php


        // Hiển thị thông báo nếu có trong session
        if (isset($_SESSION['message'])) {
            echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']); // Xóa thông báo sau khi hiển thị
        }
    ?>
</div>