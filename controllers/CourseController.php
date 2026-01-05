<?php
class CourseController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Hiển thị danh sách khóa học kèm điểm đánh giá trung bình
   public function index() {
        $search = isset($_GET['search']) ? $this->conn->real_escape_string($_GET['search']) : '';

        // SỬA: Query trực tiếp từ bảng courses
        $sql = "SELECT * FROM courses";

        if (!empty($search)) {
            $sql .= " WHERE name LIKE '%$search%' OR description LIKE '%$search%' ";
        }
        $sql .= " ORDER BY id DESC";

        $result = $this->conn->query($sql);
        $courses = []; 
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $courses[] = $row;
            }
        }
        require 'views/courses/index.php'; 
    }
    // 2. Chi tiết khóa học & 5 đánh giá mới nhất
 public function detail() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        // SỬA: Lấy từ bảng courses
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $course = $stmt->get_result()->fetch_assoc();

        if (!$course) {
            header("Location: index.php?page=courses");
            exit;
        }

        // Lấy đánh giá liên quan
        $review_sql = "SELECT r.*, u.fullname as user_name FROM course_reviews r 
                       JOIN users u ON r.user_id = u.id 
                       WHERE r.course_id = ? 
                       ORDER BY r.created_at DESC LIMIT 5";
        $stmt_rev = $this->conn->prepare($review_sql);
        $stmt_rev->bind_param("i", $id);
        $stmt_rev->execute();
        $reviews = $stmt_rev->get_result();

        require 'views/courses/detail.php';
    }

    // 3. Xử lý gửi đánh giá kèm thông báo SweetAlert2
    public function rate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
            $user_id = $_SESSION['user']['id'];
            $course_id = intval($_POST['course_id']);
            $rating = intval($_POST['rating']);
            $comment = $this->conn->real_escape_string($_POST['comment']);

            $sql = "INSERT INTO course_reviews (user_id, course_id, rating, comment) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiis", $user_id, $course_id, $rating, $comment);
            
            if ($stmt->execute()) {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Thành công!',
                            text: 'Cảm ơn bạn đã đánh giá khóa học.',
                            icon: 'success',
                            confirmButtonColor: '#be1e2d',
                            confirmButtonText: 'Đóng'
                        }).then(() => {
                            window.location.href='index.php?page=courses&action=detail&id=$course_id';
                        });
                    });
                </script>";
            } else {
                echo "<script>alert('Lỗi hệ thống!'); window.history.back();</script>";
            }
            exit;
        }
    }

    // 4. Chuyển hướng đến trang Form Đăng ký Tư vấn (Action 'register')
    public function register() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $sql = "SELECT id, name FROM majors WHERE id = $id";
        $course = $this->conn->query($sql)->fetch_assoc();
        
        if (!$course) {
            header("Location: index.php?page=courses");
            exit;
        }
        require 'views/courses/register_form.php'; 
    }

    // 5. Xử lý lưu yêu cầu tư vấn vào Database (Action 'submit_consultation')
    public function submit_consultation() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname    = $this->conn->real_escape_string($_POST['fullname']);
            $phone       = $this->conn->real_escape_string($_POST['phone']);
            $email       = $this->conn->real_escape_string($_POST['email']);
            $address     = $this->conn->real_escape_string($_POST['address']);
            $requirement = $this->conn->real_escape_string($_POST['requirement']);
            $course_id   = intval($_POST['course_id']);

            $sql = "INSERT INTO consultation_requests (fullname, phone, email, address, requirement, course_id) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssssi", $fullname, $phone, $email, $address, $requirement, $course_id);

            if ($stmt->execute()) {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Gửi thành công!',
                            text: 'Nhân viên tư vấn sẽ liên hệ với bạn sớm nhất.',
                            icon: 'success',
                            confirmButtonColor: '#be1e2d'
                        }).then(() => { window.location.href='index.php?page=courses'; });
                    });
                </script>";
            } else {
                echo "<script>alert('Gửi yêu cầu thất bại!'); window.history.back();</script>";
            }
            exit;
        }
    }
}