<?php
// controllers/AuthController.php

// Nhúng model để tương tác với CSDL
require_once 'models/UserModel.php';

class AuthController {
    private $model;

    public function __construct($conn) {
        // Khởi tạo model với kết nối CSDL được truyền từ index.php
        $this->model = new UserModel($conn);
    }

    /**
     * 1. Xử lý Đăng nhập
     */
    public function login() {
        // Nếu đã đăng nhập rồi thì tự động điều hướng theo quyền hạn, không hiện form login
        if (isset($_SESSION['user'])) {
            $this->redirectByUserRole($_SESSION['user']['role']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            // Gọi hàm login từ UserModel đã được cập nhật Prepared Statement
            $user = $this->model->login($username, $password);
            
            if ($user) {
                // Đăng nhập thành công -> Lưu thông tin vào session
                $_SESSION['user'] = $user;
                
                // Phân quyền chuyển hướng dựa trên vai trò (admin hoặc student)
                $this->redirectByUserRole($user['role']);
            } else {
                // Đăng nhập thất bại -> Gửi thông báo lỗi ra View
                $error = "Sai tên đăng nhập hoặc mật khẩu!";
                require 'views/auth/login.php';
            }
        } else {
            // Truy cập lần đầu qua phương thức GET -> Hiển thị form đăng nhập
            require 'views/auth/login.php';
        }
    }

    /**
     * 2. Xử lý Đăng ký
     */
    public function register() {
        // Nếu đã đăng nhập rồi thì không cho phép truy cập trang đăng ký
        if (isset($_SESSION['user'])) {
            header("Location: index.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = trim($_POST['fullname']);
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            // Gọi hàm đăng ký trong Model để băm mật khẩu và lưu vào DB
            if ($this->model->register($fullname, $username, $password)) {
                // Đăng ký thành công -> Chuyển hướng sang trang đăng nhập
                header("Location: index.php?page=login"); 
                exit;
            } else {
                // Đăng ký thất bại (ví dụ: trùng tên đăng nhập)
                $error = "Đăng ký thất bại (Tên đăng nhập đã tồn tại)!";
                require 'views/auth/register.php';
            }
        } else {
            // Hiển thị form đăng ký
            require 'views/auth/register.php';
        }
    }

    /**
     * 3. Xử lý Đăng xuất
     */
    public function logout() {
        // Xóa toàn bộ dữ liệu session
        session_unset();
        session_destroy();
        
        // Quay về trang Đăng nhập
        header("Location: index.php?page=login");
        exit;
    }

    /**
     * Hàm phụ trợ: Điều hướng người dùng dựa trên vai trò
     */
    private function redirectByUserRole($role) {
        if ($role === 'admin') {
            header("Location: index.php?page=admin");
        } else {
            header("Location: index.php");
        }
        exit;
    }
}
?>