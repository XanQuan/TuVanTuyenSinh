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
    public function register($fullname, $username, $password) {
        // Kiểm tra xem tên đăng nhập đã tồn tại trong hệ thống chưa
        $checkSql = "SELECT id FROM users WHERE username = ?";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bind_param("s", $username);
        $checkStmt->execute();
        
        if ($checkStmt->get_result()->num_rows > 0) {
            return false; // Tên đăng nhập đã bị trùng
        }

        // Thực hiện băm mật khẩu bảo mật trước khi lưu vào Database 
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = 'student';

        // Sử dụng Prepared Statement để thêm người dùng mới chống SQL Injection 
        $sql = "INSERT INTO users (fullname, username, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $fullname, $username, $hashed_password, $role);
        
        return $stmt->execute();
    }

    /**
     * 2. Xử lý Đăng nhập
     * Sử dụng Prepared Statement và kiểm tra mật khẩu đã mã hóa 
     */
    public function login($username, $password) {
        // Sử dụng Prepared Statement để tìm người dùng dựa trên username 
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Kiểm tra mật khẩu người dùng nhập so với chuỗi băm trong DB 
            if (password_verify($password, $user['password'])) {
                return $user; // Đăng nhập thành công, trả về thông tin user
            }
        }
        
        return false; // Đăng nhập thất bại
    }
}
?>