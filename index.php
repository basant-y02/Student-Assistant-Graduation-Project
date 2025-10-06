<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SignIn&SignUp</title>
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body,
        input {
            font-family: "Poppins", sans-serif;
        }

        .container {
            position: relative;
            width: 100%;
            background-color: #fff;
            min-height: 100vh;
            overflow: hidden;
        }

        .forms-container {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .signin-signup {
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%);
            left: 75%;
            width: 50%;
            transition: 1s 0.7s ease-in-out;
            display: grid;
            grid-template-columns: 1fr;
            z-index: 5;
        }

        form {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0rem 5rem;
            transition: all 0.2s 0.7s;
            overflow: hidden;
            grid-column: 1 / 2;
            grid-row: 1 / 2;
        }

        form.sign-up-form {
            opacity: 0;
            z-index: 1;
        }

        form.sign-in-form {
            z-index: 2;
        }

        .title {
            font-size: 2.2rem;
            color: #444;
            margin-bottom: 10px;
        }

        .input-field {
            max-width: 380px;
            width: 100%;
            background-color: #f0f0f0;
            margin: 10px 0;
            height: 55px;
            border-radius: 55px;
            display: grid;
            grid-template-columns: 15% 85%;
            padding: 0 0.4rem;
            position: relative;
        }

        .input-field i {
            text-align: center;
            line-height: 55px;
            color: #acacac;
            transition: 0.5s;
            font-size: 1.1rem;
        }

        .input-field input {
            background: none;
            outline: none;
            border: none;
            line-height: 1;
            font-weight: 600;
            font-size: 1.1rem;
            color: #333;
        }
        .forget_password a{
            color: #B39CD0;
    text-decoration: none;
    font-weight: 700;
    font-size: 20px;
    cursor: pointer;

        }

        .input-field input::placeholder {
            color: #aaa;
            font-weight: 500;
        }

        .social-text {
            padding: 0.7rem 0;
            font-size: 1rem;
        }

        .social-media {
            display: flex;
            justify-content: center;
        }

        .social-icon {
            height: 46px;
            width: 46px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 0.45rem;
            color: #333;
            border-radius: 50%;
            border: 1px solid #333;
            text-decoration: none;
            font-size: 1.1rem;
            transition: 0.3s;
        }

        .social-icon:hover {
            color: #4481eb;
            border-color: #4481eb;
        }

        .btn {
            width: 150px;
            background-color: #320943;
            border: none;
            outline: none;
            height: 49px;
            border-radius: 49px;
            color: #fff;
            text-transform: uppercase;
            font-weight: 600;
            margin: 10px 0;
            cursor: pointer;
            transition: 0.5s;
        }

        .btn:hover {
            background-color: #B39CD0;
        }

        .panels-container {
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            left: 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
        }

        .container:before {
            content: "";
    position: absolute;
    height: 2000px;
    width: 2000px;
    top: -10%;
    right: 48%;
    transform: translateY(-50%);
    background-image: linear-gradient(-45deg, #320943 0%, #320943 100%);
    transition: 1.8s ease-in-out;
    border-radius: 50%;
    z-index: 6;
        }

        .image {
            width: 100%;
            transition: transform 1.1s ease-in-out;
            transition-delay: 0.4s;
        }

        .panel {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: space-around;
            text-align: center;
            z-index: 6;
        }

        .left-panel {
            pointer-events: all;
            padding: 3rem 17% 2rem 12%;
        }

        .right-panel {
            pointer-events: none;
            padding: 3rem 12% 2rem 17%;
        }

        .panel .content {
            color: #fff;
            transition: transform 0.9s ease-in-out;
            transition-delay: 0.6s;
        }

        .panel h3 {
            font-weight: 600;
            line-height: 1;
            font-size: 1.5rem;
        }

        .panel p {
            font-size: 0.95rem;
            padding: 0.7rem 0;
        }

        .btn.transparent {
            margin: 0;
            background: none;
            border: 2px solid #fff;
            width: 130px;
            height: 41px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .right-panel .image,
        .right-panel .content {
            transform: translateX(800px);
        }

        /* ANIMATION */

        .container.sign-up-mode:before {
            transform: translate(100%, -50%);
            right: 52%;
        }

        .container.sign-up-mode .left-panel .image,
        .container.sign-up-mode .left-panel .content {
            transform: translateX(-800px);
        }

        .container.sign-up-mode .signin-signup {
            left: 25%;
        }

        .container.sign-up-mode form.sign-up-form {
            opacity: 1;
            z-index: 2;
        }

        .container.sign-up-mode form.sign-in-form {
            opacity: 0;
            z-index: 1;
        }

        .container.sign-up-mode .right-panel .image,
        .container.sign-up-mode .right-panel .content {
            transform: translateX(0%);
        }

        .container.sign-up-mode .left-panel {
            pointer-events: none;
        }

        .container.sign-up-mode .right-panel {
            pointer-events: all;
        }


        .container label {
            display: flex;
            cursor: pointer;
            font-weight: 500;
            position: relative;
            overflow: hidden;
            margin-bottom: 0.375em;
        }

        .container label input {
            position: absolute;
            left: -9999px;
        }

        .container label input:checked+span {
            background-color: #320943;
            color: white;
        }

        .container label input:checked+span:before {
            box-shadow: inset 0 0 0 0.4375em #000;
        }

        .container label span {
            display: flex;
            align-items: center;
            padding: 0.375em 0.75em 0.375em 0.375em;
            border-radius: 99em;
            transition: 0.25s ease;
            color: #000;
        }

        .container label span:hover {
            background-color: #d6d6e5;
        }

        .container label span:before {
            display: flex;
            flex-shrink: 0;
            content: "";
            background-color: #fff;
            width: 1.5em;
            height: 1.5em;
            border-radius: 50%;
            margin-right: 0.375em;
            transition: 0.25s ease;
            box-shadow: inset 0 0 0 0.125em #00005c;
        }


        @media (max-width: 870px) {
            .container {
                min-height: 800px;
                height: 100vh;
            }

            .signin-signup {
                width: 100%;
                top: 95%;
                transform: translate(-50%, -100%);
                transition: 1s 0.8s ease-in-out;
            }

            .signin-signup,
            .container.sign-up-mode .signin-signup {
                left: 50%;
            }

            .panels-container {
                grid-template-columns: 1fr;
                grid-template-rows: 1fr 2fr 1fr;
            }

            .panel {
                flex-direction: row;
                justify-content: space-around;
                align-items: center;
                padding: 2.5rem 8%;
                grid-column: 1 / 2;
            }

            .right-panel {
                grid-row: 3 / 4;
            }

            .left-panel {
                grid-row: 1 / 2;
            }

            .image {
                width: 200px;
                transition: transform 0.9s ease-in-out;
                transition-delay: 0.6s;
            }

            .panel .content {
                padding-right: 15%;
                transition: transform 0.9s ease-in-out;
                transition-delay: 0.8s;
            }

            .panel h3 {
                font-size: 1.2rem;
            }

            .panel p {
                font-size: 0.7rem;
                padding: 0.5rem 0;
            }

            .btn.transparent {
                width: 110px;
                height: 35px;
                font-size: 0.7rem;
            }

            .container:before {
                width: 1500px;
                height: 1500px;
                transform: translateX(-50%);
                left: 30%;
                bottom: 68%;
                right: initial;
                top: initial;
                transition: 2s ease-in-out;
            }

            .container.sign-up-mode:before {
                transform: translate(-50%, 100%);
                bottom: 32%;
                right: initial;
            }

            .container.sign-up-mode .left-panel .image,
            .container.sign-up-mode .left-panel .content {
                transform: translateY(-300px);
            }

            .container.sign-up-mode .right-panel .image,
            .container.sign-up-mode .right-panel .content {
                transform: translateY(0px);
            }

            .right-panel .image,
            .right-panel .content {
                transform: translateY(300px);
            }

            .container.sign-up-mode .signin-signup {
                top: 5%;
                transform: translate(-50%, 0);
            }
        }

        @media (max-width: 570px) {
            form {
                padding: 0 1.5rem;
            }

            .image {
                display: none;
            }

            .panel .content {
                padding: 0.5rem 1rem;
            }

            .container {
                padding: 1.5rem;
            }

            .container:before {
                bottom: 72%;
                left: 50%;
            }

            .container.sign-up-mode:before {
                bottom: 28%;
                left: 50%;
            }
        }
    </style>


</head>

<body>

    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="php/login.php" class="sign-in-form" method="post">
                    <h2 class="title">Sign In</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Username" name="username" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="password" required />
                    </div>
                    <div class="contaner">
                        <label>
                            <input type="radio" value="admin" name="role" checked>
                            <span>Admin</span>
                        </label>
                        <label>
                            <input type="radio" value="student" name="role">
                            <span>Student</span>
                        </label>
                    </div>
                    <input type="submit" name="login" value="Login" class="btn solid" />
                    <div class="forget_password">
                        <a id="forget-password-link">Forget Password</a>
                    </div>
                    
                </form>


                <form action="php/sign-up.php" class="sign-up-form" method="post">
                    <h2 class="title">Sign Up</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="First Name" name="first_name" />
                    </div>
                    <div class="input-field">

                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Last Name" name="last_name" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Username" name="username" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Email" name="email" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="password" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Confirm Password" name="confirmPassword" />
                    </div>
                    <input type="submit" name="submit" value="Sign Up" class="btn solid" />
                    

                    
                </form>
            </div>
        </div>
        <div class="panels-container">

            <div class="panel left-panel">
                <div class="content">
                    <h3>New here?</h3>
                    <p>Your Gateway to Academic Excellence - Register for Student Assistance Today!</p>
                    <button class="btn transparent" id="sign-up-btn">Sign Up</button>
                </div>
                <img src="./img/log.svg" class="image" alt="">
            </div>

            <div class="panel right-panel">
                <div class="content">
                    <h3>One of us?</h3>
                    <p>Your Gateway to Academic Excellence - Register for Student Assistance Today!</p>
                    <button class="btn transparent" id="sign-in-btn">Sign In</button>
                </div>
                <img src="./img/register.svg" class="image" alt="">
            </div>
        </div>
    </div>
    <script>
        const sign_in_btn = document.querySelector("#sign-in-btn");
        const sign_up_btn = document.querySelector("#sign-up-btn");
        const container = document.querySelector(".container");

        sign_up_btn.addEventListener('click', () => {
            container.classList.add("sign-up-mode");
        });

        sign_in_btn.addEventListener('click', () => {
            container.classList.remove("sign-up-mode");
        });

        function getQueryParam(param) {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        const error = getQueryParam('error');
        const success = getQueryParam('success');
        let signUpErrors = [
            'Password and Confirm Password should be the same!',
            'All fields cannot be empty!',
            'Invalid Email!',
            'Password should be at least 4 characters!',
            'Username or Email already exists!',
            'Error occurred! Please try again.'
        ];

        if (signUpErrors.includes(error)) {
            container.classList.add("sign-up-mode");
        } else {
            container.classList.remove("sign-up-mode");
        }
        if (error) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: error,
                showConfirmButton: false,
                timer: 2200,
            });
        }
        if (success == 'Login Successfull!') {
            let role = getQueryParam('role');
            const Toast = Swal.mixin({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "Signed in successfully"
            }).then(() => {
                if (role === 'admin') {
                    window.location.href = "PAGES/dashboardAdmin.php";

                } else if (role === 'student') {

                    window.location.href = "PAGES/dashboard.php";
                }
            });
        } else if (success) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: success,
                showConfirmButton: false,
                timer: 3200
            });

        }




        const loginUsername = getQueryParam('susername');
        const loginRole = getQueryParam('rolesignin');
        const loginpassword = getQueryParam('spassword');
        const forget_password_link = document.querySelector("#forget-password-link");


        if (loginUsername) {
            document.querySelector('.sign-in-form input[name="username"]').value = loginUsername;
        }
        if (loginRole === 'student') {
            const loginRole = "student";
            document.querySelector(`.sign-in-form input[value="${loginRole}"]`).checked = true;
        }
        if (loginRole === 'admin') {
            const loginRole = "admin";
            document.querySelector(`.sign-in-form input[value="${loginRole}"]`).checked = true;
        }
        if (loginpassword) {
            document.querySelector('.sign-in-form input[name="password"]').value = loginpassword;
        }
        const firstName = getQueryParam('first_name');
        const lastName = getQueryParam('last_name');
        const signUpUsername = getQueryParam('username');
        const email = getQueryParam('email');
        const password = getQueryParam('password');
        const confirmPassword = getQueryParam('confirmPassword');

        if (firstName) {
            document.querySelector('.sign-up-form input[name="first_name"]').value = firstName;
        }
        if (lastName) {
            document.querySelector('.sign-up-form input[name="last_name"]').value = lastName;
        }
        if (signUpUsername) {
            document.querySelector('.sign-up-form input[name="username"]').value = signUpUsername;
        }
        if (email) {
            document.querySelector('.sign-up-form input[name="email"]').value = email;
        }
        if (password) {
            document.querySelector('.sign-up-form input[name="password"]').value = password;
        }
        if (confirmPassword) {
            document.querySelector('.sign-up-form input[name="confirmPassword"]').value = confirmPassword;
        }

        forget_password_link.addEventListener('click', () => {
            Swal.fire({
                title: 'Reset Password',
                html: `
                    <input type="text" id="swal-input1" class="swal2-input" placeholder="Email or Username">
                    <input type="password" id="swal-input2" class="swal2-input" placeholder="Password">
                    <input type="password" id="swal-input3" class="swal2-input" placeholder="Confirm Password">`,
                focusConfirm: false,
                showCancelButton: true,
                preConfirm: () => {
                    const emailOrUsername = document.getElementById('swal-input1').value;
                    const password = document.getElementById('swal-input2').value;
                    const confirmPassword = document.getElementById('swal-input3').value;
                    if (!emailOrUsername || !password || !confirmPassword) {
                        Swal.showValidationMessage(`Please enter all fields`);
                    } else if (password !== confirmPassword) {
                        Swal.showValidationMessage(`Passwords do not match`);
                    } else {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Password reset successfully",
                            showConfirmButton: false,
                            timer: 3200
                        });
                    }
                }
            });
        });
    </script>

</body>

</html>