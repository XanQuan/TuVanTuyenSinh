<?php
// controllers/AuthController.php
require_once 'models/UserModel.php';

class AuthController {
    private $model;

    public function __construct($conn) {
        $this->model = new UserModel($conn);
    }

    /**
     * 1. Xử lý Đăng nhập
     */
    public function login() {
        if (isset($_SESSION['user'])) {
            $this->redirectByUserRole($_SESSION['user']['role']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $user = $this->model->login($username, $password);
        
        if ($user) {
            // Lưu toàn bộ mảng user bao gồm cả user_type vào Session
            $_SESSION['user'] = $user; 
            $this->redirectByUserRole($user['role']);
        } else {
            $error = "Sai tên đăng nhập hoặc mật khẩu!";
            require 'views/auth/login.php';
        }
    } else {
        require 'views/auth/login.php';
    }
    }

    /**
     * 2. Xử lý Đăng ký
     */
    public function register() {
        if (isset($_SESSION['user'])) {
            header("Location: index.php");
            exit;
        }

       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fullname = trim($_POST['fullname']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        // Lấy user_type (student/alumni) từ form
        $user_type = $_POST['user_type'] ?? 'student'; 

        // Truyền thêm biến $user_type vào Model
        if ($this->model->register($fullname, $username, $password, $user_type)) {
            header("Location: index.php?page=login"); 
            exit;
        } else {
            $error = "Đăng ký thất bại (Tên đăng nhập đã tồn tại)!";
            require 'views/auth/register.php';
        }
    } else {
        require 'views/auth/register.php';
    }
    }

    /**
     * 3. Xử lý Đăng xuất
     */
    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }

    /**
     * 4. Hiển thị form Quên mật khẩu
     */
    public function forgotPassword() {
        require 'views/auth/forgot_password.php';
    }

    /**
     * 5. Xử lý gửi yêu cầu Quên mật khẩu
     */
    public function handleForgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['identity']);
            $message = "Yêu cầu đã được gửi tới: " . $email;
            require 'views/auth/forgot_password.php';
        }
    }

    /**
     * Hàm phụ trợ: Điều hướng
     */
    private function redirectByUserRole($role) {
        if ($role === 'admin') {
            header("Location: index.php?page=admin");
        } else {
            header("Location: index.php");
        }
        exit;
    }
} // Kết thúc class - Chỉ có duy nhất 1 dấu đóng ngoặc ở đây