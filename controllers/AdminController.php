<?php
class AdminController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        
        // 1. KIỂM TRA QUYỀN (QUAN TRỌNG NHẤT)
        // Nếu chưa đăng nhập HOẶC role không phải 'admin' -> Chặn ngay
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            die('<div style="color:red; text-align:center; margin-top:50px;">
                    <h1>⛔ TRUY CẬP BỊ TỪ CHỐI</h1>
                    <p>Bạn không có quyền truy cập trang quản trị.</p>
                    <a href="index.php">Quay về trang chủ</a>
                 </div>');
        }
    }

    // Trang chính của Admin (Dashboard)
    public function index() {
    $count_users = 0;
    $count_visits = 0;
    $count_unis = 0;
    $count_questions = 0;

    // 1. Đếm User
    $sql_users = "SELECT COUNT(*) as total FROM users WHERE role != 'admin'";
    $stmt = $this->conn->prepare($sql_users);
    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) $count_users = $row['total'];
        $stmt->close();
    }

    // 2. Đếm Lịch sử tra cứu (Sửa tên bảng thành search_history)
    $sql_history = "SELECT COUNT(*) as total FROM search_history"; 
    $stmt = $this->conn->prepare($sql_history);
    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) $count_visits = $row['total'];
        $stmt->close();
    }

    // 3. Đếm Trường ĐH
    $sql_unis = "SELECT COUNT(*) as total FROM universities";
    $stmt = $this->conn->prepare($sql_unis);
    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) $count_unis = $row['total'];
        $stmt->close();
    }

    // Gửi ra View
    $data = [
        'count_users'  => $count_users,
        'count_visits' => $count_visits,
        'count_unis'   => $count_unis,
        'count_questions' => $count_questions
    ];
    extract($data);

    require_once 'views/admin/dashboard.php';
}
    
    // 1. Xem danh sách trường Đại học
    public function universities() {
        $sql = "SELECT * FROM universities ORDER BY id DESC";
        $result = $this->conn->query($sql);
        
        $universities = [];
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $universities[] = $row;
            }
        }
        require 'views/admin/universities/index.php';
    }

    // 2. Thêm trường Đại học mới
    public function add_university() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $code = $_POST['code'];
            $name = $_POST['name'];
            
            if (empty($code) || empty($name)) {
                $error = "Vui lòng nhập đầy đủ thông tin!";
            } else {
                // Kiểm tra mã trường tồn tại
                $check = $this->conn->query("SELECT id FROM universities WHERE code = '$code'");
                if ($check->num_rows > 0) {
                    $error = "Mã trường '$code' đã tồn tại!";
                } else {
                    $sql = "INSERT INTO universities (code, name) VALUES (?, ?)";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("ss", $code, $name);
                    
                    if ($stmt->execute()) {
                        $stmt->close(); // Đóng kết nối
                        header("Location: index.php?page=admin&action=universities");
                        exit;
                    } else {
                        $error = "Lỗi hệ thống: " . $this->conn->error;
                    }
                }
            }
        }
        require 'views/admin/universities/add.php';
    }

    // 3. Sửa trường Đại học
    public function edit_university() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?page=admin&action=universities");
            exit;
        }
        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $code = $_POST['code'];
            $name = $_POST['name'];

            $sql = "UPDATE universities SET code = ?, name = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssi", $code, $name, $id);

            if ($stmt->execute()) {
                $stmt->close();
                header("Location: index.php?page=admin&action=universities");
                exit;
            } else {
                $error = "Lỗi cập nhật: " . $this->conn->error;
            }
        }

        // Lấy thông tin cũ
        $sql = "SELECT * FROM universities WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $university = $stmt->get_result()->fetch_assoc();
        $stmt->close(); // <--- QUAN TRỌNG: Phải đóng ở đây

        require 'views/admin/universities/edit.php';
    }

    // 4. Xóa trường Đại học
    public function delete_university() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "DELETE FROM universities WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }
        header("Location: index.php?page=admin&action=universities");
        exit;
    }

    // 5. Quản lý Điểm Chuẩn (Danh sách)
    public function scores() {
        $sql = "SELECT entry_scores.*, 
                       universities.name AS uni_name, 
                       universities.code AS uni_code,
                       majors.name AS major_name 
                FROM entry_scores 
                JOIN universities ON entry_scores.uni_id = universities.id 
                JOIN majors ON entry_scores.major_id = majors.id 
                ORDER BY entry_scores.year DESC, universities.code ASC";
        
        $result = $this->conn->query($sql);
        
        $scores = [];
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $scores[] = $row;
            }
        }
        require 'views/admin/scores/index.php';
    }

    // 6. Thêm Điểm Chuẩn Mới
    public function add_score() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uni_id = $_POST['uni_id'];
            $major_id = $_POST['major_id'];
            $year = $_POST['year'];
            $score = $_POST['score'];

            if (empty($year) || empty($score)) {
                $error = "Vui lòng nhập đầy đủ năm và điểm!";
            } else {
                $sql = "INSERT INTO entry_scores (uni_id, major_id, year, score) VALUES (?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("iiid", $uni_id, $major_id, $year, $score);
                
                if ($stmt->execute()) {
                    $stmt->close();
                    header("Location: index.php?page=admin&action=scores");
                    exit;
                } else {
                    $error = "Lỗi: " . $this->conn->error;
                }
            }
        }

        // --- CHUẨN BỊ DỮ LIỆU CHO FORM ---
        $universities = [];
        $res = $this->conn->query("SELECT * FROM universities ORDER BY name ASC");
        if($res) while($row = $res->fetch_assoc()) $universities[] = $row;

        $majors = [];
        $res = $this->conn->query("SELECT * FROM majors ORDER BY name ASC");
        if($res) while($row = $res->fetch_assoc()) $majors[] = $row;

        require 'views/admin/scores/add.php';
    }

    // 7. Sửa Điểm Chuẩn
    public function edit_score() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?page=admin&action=scores");
            exit;
        }
        $id = $_GET['id'];

        // Xử lý POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uni_id = $_POST['uni_id'];
            $major_id = $_POST['major_id'];
            $year = $_POST['year'];
            $score = $_POST['score'];

            $sql = "UPDATE entry_scores SET uni_id=?, major_id=?, year=?, score=? WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiidi", $uni_id, $major_id, $year, $score, $id);

            if ($stmt->execute()) {
                $stmt->close();
                header("Location: index.php?page=admin&action=scores");
                exit;
            } else {
                $error = "Lỗi: " . $this->conn->error;
            }
        }

        // Lấy thông tin điểm chuẩn hiện tại
        // SỬA LỖI SYNC: Phải đóng stmt trước khi query danh sách bên dưới
        $stmt = $this->conn->prepare("SELECT * FROM entry_scores WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $current_score = $result->fetch_assoc();
        $stmt->close(); // <--- BẮT BUỘC PHẢI CÓ DÒNG NÀY

        // Lấy danh sách trường và ngành
        $universities = [];
        $res = $this->conn->query("SELECT * FROM universities ORDER BY name ASC");
        if($res) while($row = $res->fetch_assoc()) $universities[] = $row;

        $majors = [];
        $res = $this->conn->query("SELECT * FROM majors ORDER BY name ASC");
        if($res) while($row = $res->fetch_assoc()) $majors[] = $row;

        require 'views/admin/scores/edit.php';
    }

    // 8. Xóa Điểm Chuẩn
    public function delete_score() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $this->conn->prepare("DELETE FROM entry_scores WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }
        header("Location: index.php?page=admin&action=scores");
        exit;
    }

    // 9. Danh sách Ngành Học
    public function majors() {
        $majors = [];
        $result = $this->conn->query("SELECT * FROM majors ORDER BY group_code ASC, name ASC");
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $majors[] = $row;
            }
        }
        require 'views/admin/majors/index.php';
    }

    // 10. Thêm Ngành Học Mới
    public function add_major() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $group_code = $_POST['group_code']; 

            if (!empty($name) && !empty($group_code)) {
                $sql = "INSERT INTO majors (name, group_code) VALUES (?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ss", $name, $group_code);
                
                if ($stmt->execute()) {
                    $stmt->close();
                    header("Location: index.php?page=admin&action=majors");
                    exit;
                }
            }
        }
        require 'views/admin/majors/add.php';
    }

    // 11. Xóa Ngành Học
    public function delete_major() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            // Dùng query thường cũng được, nhưng prepare an toàn hơn
            $stmt = $this->conn->prepare("DELETE FROM majors WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }
        header("Location: index.php?page=admin&action=majors");
        exit;
    }
    // xử Lý thêm câu hỏi holland code
 public function save_question() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $text = $_POST['question_text'] ?? '';
        $group = $_POST['holland_group'] ?? '';
        $image_name = null;

        // Xử lý upload ảnh
        if (!empty($_FILES['question_image']['name'])) {
            $target_dir = "uploads/questions/";
            if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
            $image_name = time() . '_' . basename($_FILES['question_image']['name']);
            move_uploaded_file($_FILES['question_image']['tmp_name'], $target_dir . $image_name);
        }

        if (!empty($text) && !empty($group)) {
            // Đảm bảo tên cột khớp 100% với DB sau khi chạy lệnh ALTER ở Bước 1
            $sql = "INSERT INTO questions (content, group_code, image_url) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            
            if ($stmt) { // Kiểm tra prepare thành công mới bind_param
                $stmt->bind_param("sss", $text, $group, $image_name);
                if ($stmt->execute()) {
                    $stmt->close();
                    header("Location: index.php?page=admin&action=questions&status=success");
                    exit;
                } else {
                    die("Lỗi thực thi: " . $stmt->error);
                }
            } else {
                die("Lỗi Prepare SQL: " . $this->conn->error . ". Hãy kiểm tra xem bạn đã thêm cột 'image_url' vào bảng 'questions' chưa?");
            }
        }
    }
}
// 12. Danh sách câu hỏi trắc nghiệm
public function questions() {
        $questions = [];
        // SỬA: Lấy dữ liệu theo tên cột thực tế trong DB: content, group_code
        $result = $this->conn->query("SELECT * FROM questions ORDER BY group_code ASC, id ASC");
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $questions[] = $row;
            }
        }
        // Gọi đến file giao diện đồng bộ
        require 'views/admin/questions/index.php';
    }

// 13. Xóa câu hỏi
public function delete_question() {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $stmt = $this->conn->prepare("DELETE FROM questions WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }
        header("Location: index.php?page=admin&action=questions");
        exit;
    }
// 13.1 lưu câu hỏi 
// Hàm xử lý lưu câu hỏi mới

// 14. Xem lịch sử chat của tất cả người dùng với AI
public function chat_logs() {
    $logs = [];
    $sql = "SELECT ai_chats.*, users.full_name 
            FROM ai_chats 
            JOIN users ON ai_chats.user_id = users.id 
            ORDER BY ai_chats.created_at DESC LIMIT 100";
    $result = $this->conn->query($sql);
    if ($result) {
        while($row = $result->fetch_assoc()) { $logs[] = $row; }
    }
    require 'views/admin/chat_logs/index.php';
}
// 15. Thống kê kết quả trắc nghiệm
public function assessment_stats() {
    $stats = [];
    $sql = "SELECT dominant_type, COUNT(*) as count 
            FROM assessment_results 
            GROUP BY dominant_type";
    $result = $this->conn->query($sql);
    if ($result) {
        while($row = $result->fetch_assoc()) { $stats[] = $row; }
    }
    // Gửi dữ liệu này qua View để vẽ biểu đồ tròn bằng Chart.js
    require 'views/admin/stats/assessment.php';
}
}
?>