<?php
class CourseController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Hiển thị danh sách khóa học kèm điểm đánh giá trung bình
   public function index() {
    $search = isset($_GET['search']) ? $this->conn->real_escape_string($_GET['search']) : '';

    $sql = "SELECT m.*, 
            IFNULL(AVG(r.rating), 5.0) as average_rating";

    // Thêm logic tính điểm ưu tiên (Priority) dựa trên từ khóa tìm kiếm
    if (!empty($search)) {
        $sql .= ", (CASE 
                    WHEN m.name LIKE '$search' THEN 1           -- Khớp chính xác tên ngành
                    WHEN m.name LIKE '$search%' THEN 2          -- Tên ngành bắt đầu bằng từ khóa
                    WHEN m.name LIKE '%$search%' THEN 3         -- Tên ngành chứa từ khóa
                    WHEN m.description LIKE '%$search%' THEN 4  -- Mô tả chứa từ khóa
                    ELSE 5 END) as priority";
    }

    $sql .= " FROM majors m 
              LEFT JOIN course_reviews r ON m.id = r.course_id ";

    if (!empty($search)) {
        $sql .= " WHERE m.name LIKE '%$search%' OR m.description LIKE '%$search%' ";
    }

    $sql .= " GROUP BY m.id ";

    // Sắp xếp theo độ ưu tiên (priority tăng dần: 1 là cao nhất)
    if (!empty($search)) {
        $sql .= " ORDER BY priority ASC, m.id DESC";
    } else {
        $sql .= " ORDER BY m.id DESC";
    }

    $result = $this->conn->query($sql);

    $courses = []; 
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $courses[] = [
                'id'          => $row['id'],
                'name'        => $row['name'],
                'description' => $row['description'],
                'tuition'     => $row['tuition'],
                'image'       => $row['image'],
                'teacher'     => 'UniGuide', // Bạn có thể thay bằng $row['teacher_name'] nếu bảng có cột này
                'rating'      => number_format((float)$row['average_rating'], 1, '.', '')
            ];
        }
    }
    require 'views/courses/index.php'; 
}
    // 2. Chi tiết khóa học & 5 đánh giá mới nhất
    public function detail() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        // Sử dụng Prepared Statement để lấy thông tin khóa học
        $stmt = $this->conn->prepare("SELECT * FROM majors WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $course = $stmt->get_result()->fetch_assoc();

        if (!$course) {
            header("Location: index.php?page=courses");
            exit;
        }

        // Lấy 5 đánh giá gần nhất (Sử dụng u.fullname theo cấu trúc bảng users của bạn)
        $review_sql = "SELECT r.*, u.fullname as user_name FROM course_reviews r 
                       JOIN users u ON r.user_id = u.id 
                       WHERE r.course_id = ? 
                       ORDER BY r.created_at DESC 
                       LIMIT 5";

        $stmt_rev = $this->conn->prepare($review_sql);

        if ($stmt_rev === false) {
            die("Lỗi SQL: " . $this->conn->error); 
        }

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