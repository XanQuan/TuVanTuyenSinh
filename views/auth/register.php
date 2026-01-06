<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Sign Up - UniGuide</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
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
            width: 900px;
            height: 600px;
            background: #2d3436;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
        }

        /* Nửa bên trái */
        .info-side {
            flex: 1;
            background: url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
            padding: 50px;
            display: flex;
            align-items: center;
            text-align: center;
        }

        .info-side::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }

        .info-content {
            position: relative;
            z-index: 1;
            width: 100%;
        }

        .info-content h2 {
            font-size: 36px;
            margin-bottom: 20px;
            font-weight: 800;
            color: #fff;
        }

        .info-content p {
            font-size: 15px;
            line-height: 1.8;
            color: #dfe6e9;
            margin-bottom: 40px;
        }

        .login-btn-outline {
            text-decoration: none;
            display: inline-block;
            padding: 12px 45px;
            background: transparent;
            border: 2px solid #fff;
            color: #fff;
            border-radius: 30px;
            font-weight: 600;
            transition: 0.3s;
        }

        .login-btn-outline:hover {
            background: #fff;
            color: #2d3436;
        }

        /* Nửa bên phải */
        .register-side {
            flex: 1.2;
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #2d3436;
        }

        .register-side h2 {
            color: #ef7e7e;
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .register-side p {
            color: #b2bec3;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .input-group {
            position: relative;
            margin-bottom: 18px;
        }

        .input-group i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #ef7e7e;
            z-index: 2;
        }

        .input-group input, .input-group select {
            width: 100%;
            padding: 14px 15px 14px 50px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid #636e72;
            border-radius: 30px;
            color: #fff;
            outline: none;
            transition: 0.3s;
            font-size: 14px;
            appearance: none;
        }

        /* Tùy chỉnh riêng cho select để có mũi tên */
        .input-group select {
            cursor: pointer;
        }

        .select-wrapper::after {
            content: '\f107';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #b2bec3;
            pointer-events: none;
        }

        .input-group input:focus, .input-group select:focus {
            border-color: #ef7e7e;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 10px rgba(239, 126, 126, 0.2);
        }

        .register-btn {
            background: linear-gradient(to right, #ef7e7e, #f08b8b);
            border: none;
            padding: 15px;
            border-radius: 30px;
            color: #fff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.4s;
            box-shadow: 0 10px 20px rgba(239, 126, 126, 0.3);
        }

        .register-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(239, 126, 126, 0.4);
            filter: brightness(1.1);
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            color: #b2bec3;
            font-size: 14px;
        }

        .login-link a {
            color: #ef7e7e;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .login-link a:hover { text-decoration: underline; }

        .alert-error {
            background: rgba(255, 118, 117, 0.1);
            color: #ff7675;
            padding: 12px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid rgba(255, 118, 117, 0.2);
        }

        /* Định dạng các option của select */
        select option {
            background: #2d3436;
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="main-container">
        <div class="info-side">
            <div class="info-content">
                <h2>Welcome Back!</h2>
                <p>Khám phá lộ trình học tập và nghề nghiệp phù hợp nhất với bản thân bạn ngay hôm nay.</p>
                <a href="index.php?page=login" class="login-btn-outline">ĐĂNG NHẬP</a>
            </div>
        </div>

        <div class="register-side">
            <h2>Create Account</h2>
            <p>Bắt đầu hành trình UniGuide của bạn</p>

            <?php if(isset($error)): ?>
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle me-2"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="index.php?page=register" method="POST">
                <div class="input-group">
                    <i class="fas fa-id-card"></i>
                    <input type="text" name="fullname" placeholder="Họ và tên" required>
                </div>

                <div class="input-group select-wrapper">
                    <i class="fas fa-users"></i>
                    <select name="user_type" required>
                        <option value="" disabled selected>Bạn là...</option>
                        <option value="student">Học sinh / Sinh viên (Cần tư vấn)</option>
                        <option value="alumni">Cựu sinh viên (Đã tốt nghiệp)</option>
                    </select>
                </div>

                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Tên đăng nhập" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Mật khẩu" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-check-circle"></i>
                    <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu" required>
                </div>
                
                <button type="submit" class="register-btn" style="width: 100%;">ĐĂNG KÝ NGAY</button>
            </form>

            <div class="login-link">
                Đã là thành viên? <a href="index.php?page=login">Đăng nhập ngay</a>
            </div>
        </div>
    </div>

</body>
</html>