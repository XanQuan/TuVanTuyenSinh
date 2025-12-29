<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Login - UniGuide</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/TuVanTuyenSinh/public/assets/css/fontawesome.css">
    
    <style>
        * { margin: 0; padding: 0; box-box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
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
            height: 500px;
            background: #2d3436;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }

        /* Nửa bên trái - Form */
        .login-side {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-side h2 {
            color: #ef7e7e;
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .login-side p {
            color: #b2bec3;
            font-size: 13px;
            margin-bottom: 30px;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
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
            padding: 12px 12px 12px 45px;
            background: transparent;
            border: 1px solid #636e72;
            border-radius: 25px;
            color: #fff;
            outline: none;
            transition: 0.3s;
        }

        .input-group input:focus {
            border-color: #ef7e7e;
        }

        .login-btn {
            background: linear-gradient(to right, #ef7e7e, #81ecec);
            border: none;
            padding: 12px;
            border-radius: 25px;
            color: #2d3436;
            font-weight: 800;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }

        .login-btn:hover {
            transform: scale(1.02);
            opacity: 0.9;
        }

        .forgot-pass {
            text-align: right;
            margin-top: 15px;
            color: #b2bec3;
            font-size: 12px;
            text-decoration: none;
            font-style: italic;
        }

        /* Nửa bên phải - Hình ảnh & Social */
        .social-side {
            flex: 1;
            background: url('https://images.unsplash.com/photo-1519681393784-d120267933ba?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
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
            background: rgba(0, 0, 0, 0.4);
        }

        .social-content {
            position: relative;
            z-index: 1;
        }

        .social-content h2 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .social-icons {
            display: flex;
            gap: 20px;
            margin: 30px 0;
        }

        .icon-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: 0.3s;
            cursor: pointer;
        }

        .icon-circle:hover {
            background: #ef7e7e;
            border-color: #ef7e7e;
        }

        .terms {
            font-size: 11px;
            margin-top: 40px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .create-account {
            margin-top: 20px;
            font-size: 12px;
            color: #fff;
            text-decoration: none;
            display: block;
        }

        .alert-error {
            color: #ff7675;
            font-size: 12px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="main-container">
        <div class="login-side">
            <h2>Member Login</h2>
            <p>Please fill in your basic info</p>

            <?php if(isset($error)): ?>
                <div class="alert-error"><?= $error ?></div>
            <?php endif; ?>

            <form action="index.php?page=login" method="POST" style="display: flex; flex-direction: column;">
                <div class="input-group">
                    <i class="fa fa-user"></i>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                
                <button type="submit" class="login-btn">LOGIN</button>
                <a href="#" class="forgot-pass">Forgot Password?</a>
            </form>
        </div>

        <div class="social-side">
            <div class="social-content">
                <h2>Sign Up</h2>
                <p>Using your social media account</p>

                <div class="social-icons">
                    <div class="icon-circle"><i class="fa fa-envelope"></i></div>
                    <div class="icon-circle"><i class="fa fa-facebook"></i></div>
                    <div class="icon-circle"><i class="fa fa-twitter"></i></div>
                </div>

                <div class="terms">
                    <input type="checkbox" required>
                    <span>By signing up I agree with <a href="#" style="color: #ef7e7e;">terms and conditions</a></span>
                </div>

                <a href="index.php?page=register" class="create-account">Create account</a>
            </div>
        </div>
    </div>

</body>
</html>