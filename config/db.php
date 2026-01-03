<?php
// config/db.php

$servername = "localhost"; 
$username = "root";        
$password = "123456";            // Nếu máy bạn đặt mật khẩu MySQL thì điền vào đây
$dbname = "tuvan_db";     
$port = 3306; 

/* Mẹo đồng bộ: Kiểm tra xem đang chạy ở máy nào để tự đổi PORT
  Giả sử máy bạn dùng port 3306 (mặc định MySQL), máy bạn kia dùng 2511 (XAMPP)
// */
// $port = ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_ADDR'] == '127.0.0.1') ? 3306 : 2511;

// Hoặc đơn giản nhất là thống nhất để một số port cố định nếu cả hai cùng sửa được
// $port = 3306; 

try {
    // Kết nối
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        throw new Exception($conn->connect_error);
    }

    mysqli_set_charset($conn, 'UTF8');

} catch (Exception $e) {
    die("❌ Lỗi kết nối: " . $e->getMessage() . " (Đang thử Port: $port)");
}
?>