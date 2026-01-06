<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * 1. Xử lý Đăng ký thành viên
     * Tự động băm mật khẩu và gán vai trò mặc định là 'student'
     */
    public function register($fullname, $username, $password, $user_type = 'student') {
        // Kiểm tra tên đăng nhập tồn tại
        $checkSql = "SELECT id FROM users WHERE username = ?";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bind_param("s", $username);
        $checkStmt->execute();
        
        if ($checkStmt->get_result()->num_rows > 0) {
            return false; 
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = 'student';

        // Cập nhật câu lệnh SQL để lưu trường user_type
        $sql = "INSERT INTO users (fullname, username, password, user_type, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $fullname, $username, $hashed_password, $user_type, $role);
        
        return $stmt->execute();
    }

    /**
     * 2. Xử lý Đăng nhập
     * Sử dụng Prepared Statement và kiểm tra mật khẩu đã mã hóa 
     */
   public function login($username, $password) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                // Trả về toàn bộ thông tin bao gồm user_type
                return $user; 
            }
        }
        
        return false; 
    }
}

?>