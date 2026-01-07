<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác minh tài khoản - UniGuide</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #ef7e7e; --bg-dark: #2d3436; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { 
            background: radial-gradient(circle at top left, #f08b8b, #7e98d5); 
            height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;
            perspective: 1000px;
        }
        .main-container { 
            width: 100%; max-width: 450px; background: var(--bg-dark); padding: 50px 40px; 
            border-radius: 30px; text-align: center; color: white;
            box-shadow: 20px 20px 60px rgba(0,0,0,0.5), -5px -5px 20px rgba(255,255,255,0.05);
            animation: fadeIn 0.8s ease-out;
        }
        h2 { color: var(--primary); margin-bottom: 15px; font-weight: 800; font-size: 28px; text-shadow: 0 4px 10px rgba(0,0,0,0.3); }
        p { color: #b2bec3; font-size: 14px; margin-bottom: 35px; line-height: 1.6; }
        
        .input-group { position: relative; margin-bottom: 20px; }
        .input-group i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: var(--primary); }
        .input-group input { 
            width: 100%; padding: 15px 15px 15px 55px; background: #1e2223; 
            border: 2px solid transparent; border-radius: 15px; color: white; outline: none; 
            transition: 0.3s;
            box-shadow: inset 4px 4px 8px rgba(0,0,0,0.4);
        }
        .input-group input:focus { border-color: var(--primary); transform: translateY(-2px); box-shadow: 0 0 15px rgba(239, 126, 126, 0.2); }
        
        .btn-reset { 
            width: 100%; background: linear-gradient(135deg, var(--primary), #d63031); 
            border: none; padding: 16px; border-radius: 15px; color: white; 
            font-weight: 800; cursor: pointer; transition: 0.4s; text-transform: uppercase; letter-spacing: 1px;
            box-shadow: 0 10px 20px rgba(239, 126, 126, 0.3);
        }
        .btn-reset:hover { transform: translateY(-3px); box-shadow: 0 15px 25px rgba(239, 126, 126, 0.5); }
        
        .back-link { display: inline-block; margin-top: 25px; color: #81ecec; text-decoration: none; font-size: 14px; transition: 0.3s; }
        .back-link:hover { color: white; text-shadow: 0 0 8px #81ecec; }
        
        .error { background: rgba(255, 118, 117, 0.2); color: #ff7675; padding: 12px; border-radius: 12px; margin-bottom: 25px; font-size: 13px; border-left: 5px solid #ff7675; text-align: left; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>
    <div class="main-container">
        <h2>Xác minh danh tính</h2>
        <p>Vui lòng nhập Email và Họ tên chính xác để mở khóa tính năng đặt lại mật khẩu.</p>

        <?php if(isset($error)): ?>
            <div class="error"><i class="fa fa-exclamation-circle"></i> <?= $error ?></div>
        <?php endif; ?>

        <form action="index.php?page=forgot_password" method="POST">
            <div class="input-group">
                <i class="fa fa-envelope"></i>
                <input type="email" name="identity" placeholder="Email đăng ký" required>
            </div>
            <div class="input-group">
                <i class="fa fa-user"></i>
                <input type="text" name="fullname" placeholder="Họ và tên của bạn" required>
            </div>
            <button type="submit" class="btn-reset">XÁC MINH NGAY</button>
        </form>
        <a href="index.php?page=login" class="back-link"><i class="fa fa-arrow-left"></i> Quay lại Đăng nhập</a>
    </div>
</body>
</html>