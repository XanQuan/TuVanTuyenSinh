<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Mật khẩu mới - UniGuide</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #ef7e7e; --secondary: #81ecec; --bg-dark: #2d3436; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { 
            background: radial-gradient(circle at top left, #f08b8b, #7e98d5); 
            height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;
            perspective: 1000px;
        }
        .main-container { 
            width: 100%; max-width: 450px; background: var(--bg-dark); padding: 50px 40px; 
            border-radius: 30px; text-align: center; color: white;
            box-shadow: 20px 20px 60px rgba(0,0,0,0.5);
            animation: slideIn 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        }
        h2 { color: var(--primary); margin-bottom: 15px; font-weight: 800; font-size: 30px; }
        p { color: #b2bec3; font-size: 14px; margin-bottom: 30px; }
        
        .reset-email-info {
            background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px);
            padding: 15px; border-radius: 15px; margin-bottom: 30px;
            font-size: 14px; color: var(--secondary); border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        }
        
        .input-group { position: relative; margin-bottom: 25px; }
        .input-group i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: var(--primary); }
        .input-group input { 
            width: 100%; padding: 16px 16px 16px 55px; background: #1e2223; 
            border: 2px solid transparent; border-radius: 15px; color: white; outline: none; 
            transition: 0.3s; box-shadow: inset 4px 4px 8px rgba(0,0,0,0.4);
        }
        .input-group input:focus { border-color: var(--primary); transform: scale(1.02); }
        
        .login-btn { 
            width: 100%; background: linear-gradient(135deg, var(--primary), #d63031); 
            border: none; padding: 18px; border-radius: 15px; color: white; 
            font-weight: 800; cursor: pointer; transition: 0.4s; text-transform: uppercase; letter-spacing: 2px;
            box-shadow: 0 10px 25px rgba(239, 126, 126, 0.4);
        }
        .login-btn:hover { transform: translateY(-5px); box-shadow: 0 20px 35px rgba(239, 126, 126, 0.6); }

        @keyframes slideIn { from { opacity: 0; transform: scale(0.9) rotateX(-10deg); } to { opacity: 1; transform: scale(1) rotateX(0); } }
    </style>
</head>
<body>
    <div class="main-container">
        <h2>Mật khẩu mới</h2>
        <p>Hệ thống đã xác thực thành công. Vui lòng thiết lập mật khẩu mới bên dưới.</p>

        <?php if(isset($_SESSION['reset_email'])): ?>
            <div class="reset-email-info">
                <i class="fa fa-shield-alt"></i> Đang bảo mật cho: <br>
                <strong style="font-size: 16px;"><?= htmlspecialchars($_SESSION['reset_email']) ?></strong>
            </div>
        <?php endif; ?>
        
        <form action="index.php?page=auth&action=updatePasswordSimple" method="POST">
            <div class="input-group">
                <i class="fa fa-lock"></i>
                <input type="password" name="new_password" placeholder="Nhập mật khẩu mới" required minlength="6">
            </div>
            <button type="submit" class="login-btn">CẬP NHẬT MẬT KHẨU</button>
        </form>
    </div>
</body>
</html>