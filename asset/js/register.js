document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("fullname").addEventListener("blur", function() {
        const fullName = this.value.trim();
        const fullNameRegex = /^([A-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠƯẠ-ỹ]{1}[a-zàáâãèéêìíòóôõùúăđĩũơưạ-ỹ]+)(\s([A-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠƯẠ-ỹ]{1}[a-zàáâãèéêìíòóôõùúăđĩũơưạ-ỹ]+))*$/;
        const errorFullname = document.getElementById("errorFullname");

        if (fullName === "") {
            errorFullname.textContent = "* Bắt buộc nhập";
        } else if (!fullNameRegex.test(fullName)) {
            errorFullname.textContent = "* Chữ cái đầu phải viết hoa và có ít nhất 2 ký tự";
        } else {
            errorFullname.textContent = "*";
        }
    });

    document.getElementById("phone").addEventListener("blur", function() {
        const phone = this.value.trim();
        const phoneRegex = /^0\d{9}$/;
        const errorPhone = document.getElementById("errorPhone");

        if (phone === "") {
            errorPhone.textContent = "* Bắt buộc nhập";
        } else if (!phoneRegex.test(phone)) {
            errorPhone.textContent = "* Bắt đầu bằng số 0 và có đúng 10 chữ số";
        } else {
            errorPhone.textContent = "*";
        }
    });

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

    document.getElementById("confirmPassword").addEventListener("blur", function() {
        const password = document.getElementById("password").value;
        const confirmPassword = this.value;
        const errorConfirmPassword = document.getElementById("errorConfirmPassword");

        if (confirmPassword === "") {
            errorConfirmPassword.textContent = "* Bắt buộc nhập";
        } else if (password !== confirmPassword) {
            errorConfirmPassword.textContent = "* Mật khẩu không khớp";
        } else {
            errorConfirmPassword.textContent = "*";
        }
    });
});