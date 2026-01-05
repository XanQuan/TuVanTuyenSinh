<?php
// controllers/ProfileController.php

class ProfileController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        // Kiểm tra đăng nhập ngay khi khởi tạo
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit;
        }
    }

    /**
     * Hiển thị trang hồ sơ cá nhân với dữ liệu thật
     */
    public function index() {
        $user_id = $_SESSION['user']['id'];
        
        // 1. Lấy thông tin người dùng mới nhất từ bảng users
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        // 2. Đếm số bài trắc nghiệm Holland thực tế (bảng assessment_results)
        $quiz_count = 0;
        $stmt_quiz = $this->conn->prepare("SELECT COUNT(*) as total FROM assessment_results WHERE user_id = ?");
        if ($stmt_quiz) {
            $stmt_quiz->bind_param("i", $user_id);
            $stmt_quiz->execute();
            $quiz_count = $stmt_quiz->get_result()->fetch_assoc()['total'];
        }

        // 3. Đếm số cuộc hội thoại AI (số phiên chat trong bảng chat_sessions)
        $chat_count = 0;
        $stmt_chat = $this->conn->prepare("SELECT COUNT(*) as total FROM chat_sessions WHERE user_id = ?");
        if ($stmt_chat) {
            $stmt_chat->bind_param("i", $user_id);
            $stmt_chat->execute();
            $chat_count = $stmt_chat->get_result()->fetch_assoc()['total'];
        }

        // 4. Tính % hoàn thiện hồ sơ tự động dựa trên các trường bắt buộc
        $fields = ['fullname', 'birthday', 'gender', 'phone', 'academic_performance', 'address', 'aspiration', 'avatar'];
        $filled = 0;
        foreach ($fields as $field) {
            if (!empty($user[$field])) $filled++;
        }
        $completion_percent = round(($filled / count($fields)) * 100);

        // Truyền dữ liệu sang view
        require 'views/profile/index.php';
    }

    /**
     * Xử lý cập nhật thông tin và đồng bộ Session
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user']['id'];
            
            // Nhận dữ liệu khối thi (tận dụng trường region)
            $region = $_POST['region'] ?? ''; 
            
            // 1. Xử lý Upload Ảnh đại diện
            $avatar = $_POST['current_avatar']; 
            if (!empty($_FILES['avatar']['name'])) {
                $target_dir = "public/uploads/avatars/";
                if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
                
                $file_name = time() . "_" . basename($_FILES["avatar"]["name"]);
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_dir . $file_name)) {
                    $avatar = $file_name; 
                }
            }

            // 2. Cập nhật Database
            $sql = "UPDATE users SET 
                    fullname = ?, gender = ?, birthday = ?, academic_performance = ?, 
                    region = ?, aspiration = ?, address = ?, phone = ?, 
                    personality = ? , avatar = ? 
                    WHERE id = ?";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssssssssi", 
                $_POST['fullname'], $_POST['gender'], $_POST['birthday'], 
                $_POST['academic_performance'], $region, $_POST['aspiration'], 
                $_POST['address'], $_POST['phone'], $_POST['personality'], $avatar, $user_id
            );

            if ($stmt->execute()) {
                // ĐỒNG BỘ SESSION: Để Header/Avatar thay đổi ngay lập tức
                $_SESSION['user']['fullname'] = $_POST['fullname'];
                $_SESSION['user']['avatar'] = $avatar; 
                
                header("Location: index.php?page=profile&status=success&message=Cập nhật hồ sơ thành công!");
            } else {
                header("Location: index.php?page=profile&status=error&message=Có lỗi xảy ra trong quá trình lưu.");
            }
            exit;
        }
    }
}