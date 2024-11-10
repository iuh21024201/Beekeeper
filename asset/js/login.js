document.addEventListener("DOMContentLoaded", function() {
    // Validate email field
    document.getElementById("email").addEventListener("blur", function() {
        const email = this.value.trim();
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        const errorEmail = document.getElementById("errorEmail");

        if (email === "") {
            errorEmail.textContent = "* Bắt buộc nhập";
        } else if (!emailRegex.test(email)) {
            errorEmail.textContent = "* Nhập email hợp lệ (example@gmail.com)";
        } else {
            errorEmail.textContent = "*";
        }
    });

    // Validate password field
    document.getElementById("password").addEventListener("blur", function() {
        const password = this.value;
        const errorPassword = document.getElementById("errorPassword");

        if (password === "") {
            errorPassword.textContent = "* Bắt buộc nhập";
        } else if (password.length < 6) {
            errorPassword.textContent = "* Mật khẩu phải có ít nhất 6 ký tự";
        } else {
            errorPassword.textContent = "*";
        }
    });
});