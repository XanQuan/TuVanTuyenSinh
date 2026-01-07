<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Sign Up - UniGuide</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        :root {
            --primary: #ef7e7e;
            --secondary: #81ecec;
            --bg-dark: #2d3436;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        body {
            background: radial-gradient(circle at top left, #f08b8b, #7e98d5);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            perspective: 1000px;
        }

        /* Container 3D Depth */
        .main-container {
            display: flex;
            width: 1000px;
            min-height: 700px; 
            background: var(--bg-dark);
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 25px 25px 50px rgba(0,0,0,0.4), 
                        -5px -5px 15px rgba(255,255,255,0.02);
            animation: slideUp 0.8s ease-out;
        }

        /* Nửa bên trái - Glassmorphism style */
        .info-side {
            flex: 1;
            background: url('https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1350&q=80');
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
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(2px);
        }

        .info-content {
            position: relative;
            z-index: 1;
            width: 100%;
            padding: 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        .info-content h2 { font-size: 38px; margin-bottom: 20px; font-weight: 800; color: #fff; text-shadow: 0 4px 10px rgba(0,0,0,0.3); }
        .info-content p { font-size: 15px; line-height: 1.8; color: #dfe6e9; margin-bottom: 40px; }

        .login-btn-outline {
            text-decoration: none;
            display: inline-block;
            padding: 12px 45px;
            background: transparent;
            border: 2px solid #fff;
            color: #fff;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.4s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-btn-outline:hover { 
            background: #fff; 
            color: var(--bg-dark); 
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(255,255,255,0.2);
        }

        /* Nửa bên phải - Neumorphism Input */
        .register-side {
            flex: 1.2;
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #252a2b;
        }

        .register-side h2 { color: var(--primary); font-size: 34px; font-weight: 800; margin-bottom: 8px; text-shadow: 2px 2px 4px rgba(0,0,0,0.2); }
        .register-side p { color: #b2bec3; font-size: 14px; margin-bottom: 25px; }

        .input-group {
            position: relative;
            margin-bottom: 18px;
            width: 100%;
        }

        .input-group i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            z-index: 2;
            transition: 0.3s;
        }

        .input-group input, 
        .input-group select {
            width: 100%;
            height: 52px;
            padding: 0 20px 0 55px;
            background: #1e2223;
            border: 2px solid transparent;
            border-radius: 15px;
            color: #fff;
            outline: none;
            transition: all 0.3s;
            font-size: 14px;
            box-shadow: inset 4px 4px 8px rgba(0,0,0,0.4), 
                        inset -2px -2px 5px rgba(255,255,255,0.05);
        }

        .input-group input:focus, 
        .input-group select:focus {
            border-color: var(--primary);
            background: #252a2b;
            box-shadow: 0 0 15px rgba(239, 126, 126, 0.15),
                        inset 2px 2px 5px rgba(0,0,0,0.5);
            transform: translateY(-2px);
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

        /* 3D Button */
        .register-btn {
            background: linear-gradient(135deg, var(--primary), #d63031);
            border: none;
            height: 58px;
            border-radius: 15px;
            color: #fff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            margin-top: 15px;
            transition: 0.4s;
            box-shadow: 0 10px 25px rgba(239, 126, 126, 0.3);
            width: 100%;
        }

        .register-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px rgba(239, 126, 126, 0.4);
            filter: brightness(1.1);
        }

        .register-btn:active { transform: translateY(-1px); }

        .login-link { text-align: center; margin-top: 25px; color: #b2bec3; font-size: 14px; }
        .login-link a { color: var(--primary); text-decoration: none; font-weight: 600; transition: 0.3s; }
        .login-link a:hover { text-decoration: underline; color: #ff9f9f; }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        select option { background: #2d3436; color: #fff; }
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
                <div class="alert-error" style="background: rgba(255, 118, 117, 0.2); color: #ff7675; padding: 12px; border-radius: 10px; margin-bottom: 20px; border-left: 5px solid #ff7675;">
                    <i class="fas fa-exclamation-circle"></i> <?= $error ?>
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
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Địa chỉ Email" required>
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
                
                <button type="submit" class="register-btn">ĐĂNG KÝ NGAY</button>
            </form>

            <div class="login-link">
                Đã là thành viên? <a href="index.php?page=login">Đăng nhập ngay</a>
            </div>
        </div>
    </div>

</body>
</html>