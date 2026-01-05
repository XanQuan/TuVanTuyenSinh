<?php
class CourseController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Hiển thị danh sách khóa học
    public function index() {
        $search = isset($_GET['search']) ? $this->conn->real_escape_string($_GET['search']) : '';
        
        // Luôn lấy từ bảng courses
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

    // 2. Chi tiết khóa học & Tự động cập nhật đánh giá
    public function detail() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $course = $stmt->get_result()->fetch_assoc();

        if (!$course) {
            header("Location: index.php?page=courses");
            exit;
        }

        // Lấy đánh giá kèm tên người dùng
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

    // 3. Xử lý gửi đánh giá & CẬP NHẬT SỐ SAO TRUNG BÌNH
   public function rate() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
        $user_id = $_SESSION['user']['id'];
        $course_id = intval($_POST['course_id']);
        $rating = intval($_POST['rating']); // Đây là số sao người dùng vừa chọn
        $comment = $this->conn->real_escape_string($_POST['comment']);

        $sql = "INSERT INTO course_reviews (user_id, course_id, rating, comment) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiis", $user_id, $course_id, $rating, $comment);
        
        if ($stmt->execute()) {
            // 1. Tính toán lại điểm trung bình để cập nhật CSDL
            $avg_sql = "SELECT AVG(rating) as avg_rate FROM course_reviews WHERE course_id = $course_id";
            $avg_res = $this->conn->query($avg_sql);
            $new_avg_total = round($avg_res->fetch_assoc()['avg_rate'], 1);

            // 2. Cập nhật vào bảng courses để hiển thị ngoài danh sách
            $this->conn->query("UPDATE courses SET rating = $new_avg_total WHERE id = $course_id");

            // 3. Hiển thị thông báo SweetAlert2
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Thành công!',
                        // SỬA TẠI ĐÂY: Dùng $rating thay vì $new_avg_total
                        text: 'Cảm ơn bạn đã đánh giá ' + $rating + ' sao cho khóa học.',
                        icon: 'success',
                        confirmButtonColor: '#be1e2d'
                    }).then(() => {
                        window.location.href='index.php?page=courses&action=detail&id=$course_id';
                    });
                });
            </script>";
        } else {
            echo "<script>alert('Lỗi!'); window.history.back();</script>";
        }
        exit;
    }
}
    // 4. Form Đăng ký (SỬA: Lấy từ bảng courses)
    public function register() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $sql = "SELECT id, name FROM courses WHERE id = $id";
        $course = $this->conn->query($sql)->fetch_assoc();
        
        if (!$course) {
            header("Location: index.php?page=courses");
            exit;
        }
        require 'views/courses/register_form.php'; 
    }

    // 5. Xử lý lưu yêu cầu tư vấn
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
                            text: 'Nhân viên tư vấn sẽ liên hệ với bạn qua số $phone.',
                            icon: 'success',
                            confirmButtonColor: '#be1e2d'
                        }).then(() => { window.location.href='index.php?page=courses'; });
                    });
                </script>";
            }
            exit;
        }
    }
}