<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * 1. Xử lý Đăng ký thành viên (Đã thêm Email)
     */
    public function register($fullname, $email, $username, $password, $user_type = 'student') {
        // Kiểm tra xem Username HOẶC Email đã tồn tại chưa
        $checkSql = "SELECT id FROM users WHERE username = ? OR email = ?";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bind_param("ss", $username, $email);
        $checkStmt->execute();
        
        if ($checkStmt->get_result()->num_rows > 0) {
            return false; // Trả về false nếu bị trùng tên hoặc email
        }

        // Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = 'student';

        // Cập nhật câu lệnh SQL: thêm cột 'email'
        $sql = "INSERT INTO users (fullname, email, username, password, user_type, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        
        // ssssss = 6 chuỗi (string) tương ứng với các dấu ?
        $stmt->bind_param("ssssss", $fullname, $email, $username, $hashed_password, $user_type, $role);
        
        return $stmt->execute();
    }

    /**
     * 2. Xử lý Đăng nhập
     */
    public function login($username, $password) {
    // Chỉ lấy user nếu trạng thái là 'active'
    $sql = "SELECT * FROM users WHERE (username = ? OR email = ?) AND status = 'active'";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Kiểm tra mật khẩu đã băm (password_verify)
        if (password_verify($password, $user['password'])) {
            return $user; 
        }
    }
    return false; 
}

    /**
     * 3. Tìm user theo Username (Dùng cho GitHub/Auth)
     */
    public function findUserByUsername($username) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>