<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập thành viên - UniGuide</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/TuVanTuyenSinh/public/assets/css/fontawesome.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        body {
            background: linear-gradient(135deg, #f08b8b 0%, #7e98d5 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .main-container {
            display: flex;
            width: 100%; 
            max-width: 1000px;
            height: 85vh; 
            min-height: 550px;
            background: #2d3436;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        }

        /* Nửa bên trái - Form Đăng nhập */
        .login-side {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #2d3436;
        }

        .login-side h2 {
            color: #ef7e7e;
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .login-side p {
            color: #b2bec3;
            font-size: 14px;
            margin-bottom: 35px;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #b2bec3;
        }

        .input-group input {
            width: 100%;
            padding: 15px 15px 15px 55px;
            background: transparent;
            border: 1px solid #636e72;
            border-radius: 30px;
            color: #fff;
            outline: none;
            transition: 0.3s;
            font-size: 15px;
        }

        .input-group input:focus {
            border-color: #ef7e7e;
            box-shadow: 0 0 10px rgba(239, 126, 126, 0.2);
        }

        .login-btn {
            background: linear-gradient(to right, #ef7e7e, #81ecec);
            border: none;
            padding: 15px;
            border-radius: 30px;
            color: #2d3436;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            margin-top: 15px;
            transition: 0.3s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(129, 236, 236, 0.3);
            opacity: 0.9;
        }

        .forgot-pass {
            text-align: right;
            margin-top: 20px;
            color: #b2bec3;
            font-size: 13px;
            text-decoration: none;
            font-style: italic;
        }
        
        .forgot-pass:hover { color: #ef7e7e; }

        /* Nửa bên phải - Hình ảnh & Đăng ký */
        .social-side {
            flex: 1;
            background: url('https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1350&q=80');
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

        .social-side::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Làm tối nền để chữ rõ hơn */
        }

        .social-content {
            position: relative;
            z-index: 1;
        }

        .social-content h2 {
            font-size: 36px;
            margin-bottom: 15px;
            font-weight: 800;
        }

        .social-icons {
            display: flex;
            gap: 20px;
            margin: 35px 0;
            justify-content: center;
        }

        .icon-circle {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: 0.4s;
            cursor: pointer;
            color: #fff;
            text-decoration: none;
        }

        .icon-circle:hover {
            background: #ef7e7e;
            border-color: #ef7e7e;
            transform: rotate(360deg);
        }

        .terms {
            font-size: 12px;
            margin-top: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #dfe6e9;
        }

        .create-account {
            margin-top: 25px;
            font-size: 14px;
            color: #fff;
            text-decoration: none;
            display: block;
            font-weight: 600;
            border-bottom: 1px solid transparent;
            transition: 0.3s;
        }

        .create-account:hover {
            color: #81ecec;
            border-bottom: 1px solid #81ecec;
        }

        .alert-error {
            background: rgba(255, 118, 117, 0.1);
            color: #ff7675;
            padding: 12px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            border-left: 4px solid #ff7675;
            text-align: left;
        }

        /* Responsive cho điện thoại */
        @media (max-width: 768px) {
            .main-container { flex-direction: column; height: auto; }
            .social-side { display: none; } /* Ẩn bớt phần ảnh trên mobile cho gọn */
        }
    </style>
</head>
<body>

    <div class="main-container">
        <div class="login-side">
            <h2>Đăng nhập</h2>
            <p>Vui lòng điền thông tin tài khoản của bạn</p>

            <?php if(isset($error)): ?>
                <div class="alert-error">
                    <i class="fa fa-exclamation-circle"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="index.php?page=login" method="POST" style="display: flex; flex-direction: column;">
                <div class="input-group">
                    <i class="fa fa-user"></i>
                    <input type="text" name="username" placeholder="Tên đăng nhập" required>
                </div>
                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" placeholder="Mật khẩu" required>
                </div>
                
                <button type="submit" class="login-btn">Đăng nhập</button>
                <a href="index.php?page=forgot_password" class="forgot-pass">Quên mật khẩu?</a>
            </form>
        </div>

        <div class="social-side">
            <div class="social-content">
                <h2>Đăng ký</h2>
                <p>Sử dụng tài khoản mạng xã hội của bạn</p>

                <div class="social-icons">
    <a href="https://github.com/cuontelebara/TuVanTuyenSinh" target="_blank" class="icon-circle">
        <i class="fa fa-github"></i>
    </a>
    <a href="https://www.facebook.com/DangThanhNhan.0" target="_blank" class="icon-circle">
        <i class="fa fa-facebook-f"></i>
    </a>
    <a href="https://www.instagram.com/dangthangnhan/" target="_blank" class="icon-circle">
        <i class="fa fa-instagram"></i>
    </a>
</div>

                <div class="terms">
                    <input type="checkbox" id="check_terms" required>
                    <label for="check_terms">Tôi đồng ý với các <a href="#" style="color: #ef7e7e; text-decoration: none;">điều khoản & điều kiện</a></label>
                </div>

                <a href="index.php?page=register" class="create-account">Chưa có tài khoản? Tạo tài khoản mới</a>
            </div>
        </div>
    </div>

</body>
</html>