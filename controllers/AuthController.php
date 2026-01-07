<?php
// controllers/AuthController.php
require_once 'models/UserModel.php';

// Nạp autoload cho các thư viện (PHPMailer, v.v.)
if (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php'; 
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController {
    private $model;
    private $conn;

    // GitHub App Config
    private $github_client_id = "0v23ctQqZbbxDTpysF2A";
    private $github_client_secret = "MÃ_CLIENT_SECRET_CỦA_BẠN";
    private $github_redirect_uri = "http://localhost:8080/TuVanTuyenSinh/index.php?page=auth&action=callback&provider=github";

    public function __construct($conn) {
        $this->conn = $conn;
        $this->model = new UserModel($conn);
    }

    /**
     * 1. ĐĂNG NHẬP
     */
    public function login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        // 1. Tìm user theo username/email bất kể trạng thái
        $user = $this->model->findUserByUsername($username);
        
        if ($user) {
            // 2. Kiểm tra trạng thái tài khoản trước
            if ($user['status'] !== 'active') {
                $error = "Tài khoản của bạn đã bị khóa vĩnh viễn!";
                require 'views/auth/login.php';
                return;
            }

            // 3. Kiểm tra mật khẩu
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user; 
                $this->redirectByUserRole($user['role']);
            } else {
                $error = "Sai mật khẩu!";
                require 'views/auth/login.php';
            }
        } else {
            $error = "Tài khoản không tồn tại!";
            require 'views/auth/login.php';
        }
    } else {
        require 'views/auth/login.php';
    }
}

    /**
     * 2. ĐĂNG KÝ (Có thêm Email)
     */
    public function register() {
        if (isset($_SESSION['user'])) {
            header("Location: index.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = trim($_POST['fullname']);
            $email = trim($_POST['email']);
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);
            $user_type = $_POST['user_type'] ?? 'student'; 

            if ($password !== $confirm_password) {
                $error = "Mật khẩu xác nhận không khớp!";
                require 'views/auth/register.php';
                return;
            }

            if ($this->model->register($fullname, $email, $username, $password, $user_type)) {
                header("Location: index.php?page=login&message=Đăng ký thành công!"); 
                exit;
            } else {
                $error = "Đăng ký thất bại (Trùng tên đăng nhập hoặc Email)!";
                require 'views/auth/register.php';
            }
        } else {
            require 'views/auth/register.php';
        }
    }

    /**
     * 3. QUÊN MẬT KHẨU (Xác minh thông tin)
     */
    public function forgotPassword() {
        require 'views/auth/forgot_password.php';
    }

    public function handleForgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = isset($_POST['identity']) ? trim($_POST['identity']) : '';
            $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';

            if (empty($email) || empty($fullname)) {
                $error = "Vui lòng nhập đầy đủ thông tin!";
                require 'views/auth/forgot_password.php';
                return;
            }

            // Kiểm tra khớp Email và Họ tên trong DB
            $sql = "SELECT * FROM users WHERE email = ? AND fullname = ? LIMIT 1";
            $stmt = $this->conn->prepare($sql);

            if ($stmt === false) {
                die("Lỗi SQL (Có thể thiếu cột email): " . $this->conn->error);
            }

            $stmt->bind_param("ss", $email, $fullname);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();

            if ($user) {
                $_SESSION['reset_email'] = $email; // Lưu vào session để đổi pass ở bước sau
                require 'views/auth/reset_password_simple.php'; 
            } else {
                $error = "Thông tin không khớp với hệ thống!";
                require 'views/auth/forgot_password.php';
            }
        }
    }

    /**
     * 4. CẬP NHẬT MẬT KHẨU MỚI
     */
    public function updatePasswordSimple() {
        if (isset($_SESSION['reset_email']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_pass = $_POST['new_password'];
            $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);
            $email = $_SESSION['reset_email'];

            $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $hashed_password, $email);
            
            if ($stmt->execute()) {
                unset($_SESSION['reset_email']); // Xóa session tạm
                header("Location: index.php?page=login&message=Đã đổi mật khẩu thành công!");
                exit;
            } else {
                die("Lỗi cập nhật: " . $this->conn->error);
            }
        } else {
            header("Location: index.php?page=login");
            exit;
        }
    }

    /**
     * 5. ĐĂNG XUẤT
     */
    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }

    /**
     * 6. CÁC HÀM XỬ LÝ GITHUB (SOCIAL LOGIN)
     */
    public function socialLogin() {
        $github_client_id = $this->github_client_id;
        $callbackUrl = $this->github_redirect_uri;
        $redirectUri = urlencode($callbackUrl);
        $url = "https://github.com/login/oauth/authorize?client_id={$github_client_id}&redirect_uri={$redirectUri}&scope=user:email";
        header("Location: $url");
        exit;
    }

    public function socialCallback() {
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $post_data = [
                'client_id' => $this->github_client_id,
                'client_secret' => $this->github_client_secret,
                'code' => $code,
                'redirect_uri' => $this->github_redirect_uri
            ];

            $ch = curl_init('https://github.com/login/oauth/access_token');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
            $response = json_decode(curl_exec($ch), true);
            curl_close($ch);

            if (isset($response['access_token'])) {
                $access_token = $response['access_token'];
                $ch = curl_init('https://api.github.com/user');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Authorization: token ' . $access_token,
                    'User-Agent: UniGuide-App'
                ]);
                $github_user = json_decode(curl_exec($ch), true);
                curl_close($ch);

                $username = $github_user['email'] ?? ($github_user['login'] . "@github.com");
                $fullname = $github_user['name'] ?? $github_user['login'];

                $user = $this->model->findUserByUsername($username);
                if (!$user) {
                    // Mật khẩu giả cho login social
                    $this->model->register($fullname, $username . "@github.com", $username, bin2hex(random_bytes(8)), 'student');
                    $user = $this->model->findUserByUsername($username);
                }

                $_SESSION['user'] = $user;
                header("Location: index.php?page=profile&status=success&message=Chào mừng " . $fullname);
                exit;
            }
        }
        header("Location: index.php?page=login&status=error&message=Lỗi kết nối GitHub");
        exit;
    }

    private function redirectByUserRole($role) {
        if ($role === 'admin') {
            header("Location: index.php?page=admin");
        } else {
            header("Location: index.php");
        }
        exit;
    }
}