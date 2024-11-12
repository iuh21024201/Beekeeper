document.addEventListener("DOMContentLoaded", function() {
    // Validate email field
    document.getElementById("email").addEventListener("blur", function() {
        const email = this.value.trim();
        const errorEmail = document.getElementById("errorEmail");

        if (email === "") {
            errorEmail.textContent = "* Bắt buộc nhập";
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