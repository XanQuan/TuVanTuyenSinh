<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu - UniGuide</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/TuVanTuyenSinh/public/assets/css/fontawesome.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: linear-gradient(135deg, #f08b8b 0%, #7e98d5 100%); height: 100vh; display: flex; align-items: center; justify-content: center; }
        .main-container { width: 100%; max-width: 450px; background: #2d3436; padding: 40px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.4); text-align: center; color: white; }
        h2 { color: #ef7e7e; margin-bottom: 15px; font-weight: 800; }
        p { color: #b2bec3; font-size: 14px; margin-bottom: 30px; }
        .input-group { position: relative; margin-bottom: 20px; }
        .input-group i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #b2bec3; }
        .input-group input { width: 100%; padding: 15px 15px 15px 55px; background: transparent; border: 1px solid #636e72; border-radius: 30px; color: white; outline: none; }
        .btn-reset { width: 100%; background: linear-gradient(to right, #ef7e7e, #81ecec); border: none; padding: 15px; border-radius: 30px; color: #2d3436; font-weight: 800; cursor: pointer; transition: 0.3s; }
        .btn-reset:hover { transform: scale(1.02); opacity: 0.9; }
        .back-link { display: block; margin-top: 25px; color: #81ecec; text-decoration: none; font-size: 14px; }
        .message { color: #55efc4; margin-bottom: 20px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="main-container">
        <h2>Quên mật khẩu?</h2>
        <p>Nhập email của bạn, chúng tôi sẽ gửi hướng dẫn khôi phục mật khẩu.</p>

        <?php if(isset($message)): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <form action="index.php?page=auth&action=handleForgotPassword" method="POST">
            <div class="input-group">
                <i class="fa fa-envelope"></i>
                <input type="email" name="identity" placeholder="Địa chỉ Email" required>
            </div>
            <button type="submit" class="btn-reset">GỬI YÊU CẦU</button>
        </form>
        
        <a href="index.php?page=login" class="back-link"> quay lại Đăng nhập</a>
    </div>
</body>
</html>