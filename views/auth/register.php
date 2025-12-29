<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Sign Up - UniGuide</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/TuVanTuyenSinh/public/assets/css/fontawesome.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        body {
            background: linear-gradient(135deg, #f08b8b 0%, #7e98d5 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-container {
            display: flex;
            width: 850px;
            height: 550px; /* Tăng chiều cao một chút cho form đăng ký */
            background: #2d3436;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }

        /* Nửa bên trái - Hình ảnh (Đảo ngược vị trí so với trang Login để tạo sự khác biệt) */
        .info-side {
            flex: 1;
            background: url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
            padding: 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
        }

        .info-side::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .info-content {
            position: relative;
            z-index: 1;
        }

        .info-content h2 {
            font-size: 32px;
            margin-bottom: 15px;
            font-weight: 800;
        }

        .info-content p {
            font-size: 14px;
            line-height: 1.6;
            color: #dfe6e9;
            margin-bottom: 30px;
        }

        /* Nửa bên phải - Form Đăng ký */
        .register-side {
            flex: 1.2;
            padding: 40px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #2d3436;
        }

        .register-side h2 {
            color: #ef7e7e;
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .register-side p {
            color: #b2bec3;
            font-size: 13px;
            margin-bottom: 25px;
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #b2bec3;
        }

        .input-group input {
            width: 100%;
            padding: 10px 12px 10px 45px;
            background: transparent;
            border: 1px solid #636e72;
            border-radius: 25px;
            color: #fff;
            outline: none;
            transition: 0.3s;
            font-size: 14px;
        }

        .input-group input:focus {
            border-color: #ef7e7e;
        }

        .register-btn {
            background: linear-gradient(to right, #81ecec, #ef7e7e);
            border: none;
            padding: 12px;
            border-radius: 25px;
            color: #2d3436;
            font-weight: 800;
            cursor: pointer;
            margin-top: 15px;
            transition: 0.3s;
        }

        .register-btn:hover {
            transform: scale(1.02);
            opacity: 0.9;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #b2bec3;
            font-size: 13px;
        }

        .login-link a {
            color: #ef7e7e;
            text-decoration: none;
            font-weight: 600;
        }

        .alert-error {
            color: #ff7675;
            font-size: 12px;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="main-container">
        <div class="info-side">
            <div class="info-content">
                <h2>Welcome Back!</h2>
                <p>Để giữ kết nối với chúng tôi, vui lòng đăng nhập bằng thông tin cá nhân của bạn.</p>
                <a href="index.php?page=login" class="register-btn" style="text-decoration: none; display: inline-block; padding: 10px 40px; background: transparent; border: 2px solid #fff; color: #fff;">ĐĂNG NHẬP</a>
            </div>
        </div>

        <div class="register-side">
            <h2>Create Account</h2>
            <p>Hãy điền thông tin để đăng ký thành viên</p>

            <?php if(isset($error)): ?>
                <div class="alert-error"><?= $error ?></div>
            <?php endif; ?>

            <form action="index.php?page=register" method="POST" style="display: flex; flex-direction: column;">
                <div class="input-group">
                    <i class="fa fa-id-card"></i>
                    <input type="text" name="fullname" placeholder="Full Name" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-user"></i>
                    <input type="text" name="username" placeholder="Username" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-check-circle"></i>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                </div>
                
                <button type="submit" class="register-btn">SIGN UP</button>
            </form>

            <div class="login-link">
                Bạn đã có tài khoản? <a href="index.php?page=login">Đăng nhập tại đây</a>
            </div>
        </div>
    </div>

</body>
</html>