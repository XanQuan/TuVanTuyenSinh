<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập thành viên - UniGuide</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #ef7e7e;
            --secondary: #81ecec;
            --bg-dark: #2d3436;
            --glass: rgba(255, 255, 255, 0.1);
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

        /* Container 3D */
        .main-container { 
            display: flex; 
            width: 100%; 
            max-width: 1000px; 
            height: 85vh; 
            min-height: 600px; 
            background: var(--bg-dark); 
            border-radius: 30px; 
            overflow: hidden; 
            box-shadow: 20px 20px 60px rgba(0,0,0,0.5), 
                        -5px -5px 20px rgba(255,255,255,0.05);
            transform-style: preserve-3d;
            animation: fadeIn 1s ease-out;
        }

        /* FORM BÊN TRÁI */
        .login-side { 
            flex: 1; 
            padding: 60px; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            background: #252a2b; /* Đậm hơn một chút để tạo khối */
            position: relative;
        }

        .login-side h2 { 
            color: var(--primary); 
            font-size: 38px; 
            font-weight: 800; 
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .login-side p { color: #b2bec3; font-size: 15px; margin-bottom: 40px; }

        /* Input Group 3D */
        .input-group { position: relative; margin-bottom: 25px; }
        .input-group i { 
            position: absolute; 
            left: 20px; 
            top: 50%; 
            transform: translateY(-50%); 
            color: var(--primary); 
            transition: 0.3s;
        }

        .input-group input { 
            width: 100%; 
            padding: 16px 16px 16px 55px; 
            background: #1e2223; 
            border: 2px solid transparent; 
            border-radius: 15px; 
            color: #fff; 
            outline: none; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: inset 4px 4px 8px rgba(0,0,0,0.5), 
                        inset -2px -2px 5px rgba(255,255,255,0.05);
        }

        .input-group input:focus { 
            border-color: var(--primary);
            box-shadow: 0 0 15px rgba(239, 126, 126, 0.2),
                        inset 2px 2px 5px rgba(0,0,0,0.5);
            transform: scale(1.02);
        }

        .login-terms {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
            color: #dfe6e9;
            font-size: 13px;
        }

        .login-terms input {
            accent-color: var(--primary);
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        /* Button 3D */
        .login-btn { 
            background: linear-gradient(135deg, var(--primary), #d63031); 
            border: none; 
            padding: 18px; 
            border-radius: 15px; 
            color: #fff; 
            font-weight: 800; 
            text-transform: uppercase; 
            letter-spacing: 2px; 
            cursor: pointer; 
            transition: 0.4s;
            box-shadow: 0 10px 20px rgba(239, 126, 126, 0.3);
            position: relative;
            overflow: hidden;
        }

        .login-btn:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 15px 30px rgba(239, 126, 126, 0.5);
            filter: brightness(1.1);
        }

        .login-btn:active { transform: translateY(-2px); }

        .forgot-pass { 
            text-align: center; 
            margin-top: 25px; 
            color: #b2bec3; 
            font-size: 14px; 
            text-decoration: none; 
            font-style: italic;
            transition: 0.3s;
        }
        .forgot-pass:hover { color: var(--primary); }

        /* BÊN PHẢI GLASSMORPHISM */
        .social-side { 
            flex: 1; 
            background: url('https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1350&q=80'); 
            background-size: cover; 
            background-position: center; 
            position: relative; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }

        .social-side::before { 
            content: ""; 
            position: absolute; 
            top: 0; left: 0; width: 100%; height: 100%; 
            background: rgba(0, 0, 0, 0.4); 
            backdrop-filter: blur(3px);
        }

        .social-content { 
            position: relative; 
            z-index: 1; 
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 50px 40px;
            border-radius: 25px;
            text-align: center;
            max-width: 380px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            transform: translateZ(50px); /* Đẩy khối về phía người dùng */
        }

        .social-content h2 { 
            font-size: 42px; 
            font-weight: 800; 
            color: #fff;
            margin-bottom: 20px;
            text-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .create-account { 
            display: block;
            margin-top: 30px;
            font-size: 15px; 
            color: #fff; 
            text-decoration: none; 
            font-weight: 600; 
            padding: 15px 30px; 
            border: 2px solid #fff; 
            border-radius: 50px; 
            transition: 0.4s;
            background: rgba(255,255,255,0.05);
        }

        .create-account:hover { 
            background: #fff; 
            color: var(--bg-dark); 
            box-shadow: 0 10px 25px rgba(255,255,255,0.3);
            transform: scale(1.05);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px) rotateX(-10deg); }
            to { opacity: 1; transform: translateY(0) rotateX(0); }
        }

        .alert-error { 
            background: rgba(255, 118, 117, 0.2); 
            color: #ff7675; 
            padding: 15px; 
            border-radius: 12px; 
            font-size: 14px; 
            margin-bottom: 25px; 
            border-left: 5px solid #ff7675;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

    </style>
</head>
<body>

    <div class="main-container">
        <div class="login-side">
            <h2>Đăng nhập</h2>
            <p>Chào mừng bạn trở lại với UniGuide</p>

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
                
                <div class="login-terms">
                    <input type="checkbox" name="accept_terms" id="check_terms" required>
                    <label for="check_terms">Tôi đồng ý với các <a href="#" style="color:var(--primary); text-decoration:none;">điều khoản</a></label>
                </div>
                
                <button type="submit" class="login-btn">Đăng nhập ngay</button>
                <a href="index.php?page=forgot_password" class="forgot-pass">Quên mật khẩu?</a>
            </form>
        </div>

        <div class="social-side">
            <div class="social-content">
                <h2>New Here?</h2>
                <p style="color: #dfe6e9; font-size: 15px;">Tham gia UniGuide để nhận tư vấn tuyển sinh cá nhân hóa và lộ trình nghề nghiệp tối ưu.</p>
                <a href="index.php?page=register" class="create-account">Tạo tài khoản mới</a>
            </div>
        </div>
    </div>

</body>
</html>