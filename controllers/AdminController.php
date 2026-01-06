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
    // Trang chính của Admin (Dashboard)
public function index() {
    $count_users = $this->conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'student'")->fetch_assoc()['total'] ?? 0;
    $count_visits = $this->conn->query("SELECT COUNT(*) as total FROM search_history")->fetch_assoc()['total'] ?? 0;
    $count_unis = $this->conn->query("SELECT COUNT(*) as total FROM universities")->fetch_assoc()['total'] ?? 0;

    // 2. Lấy dữ liệu cho biểu đồ Holland - Đảm bảo ép kiểu INT để JS không bị lỗi
    $res_holland = $this->conn->query("
        SELECT 
            SUM(CASE WHEN dominant_type LIKE '%R%' THEN 1 ELSE 0 END) as R,
            SUM(CASE WHEN dominant_type LIKE '%I%' THEN 1 ELSE 0 END) as I,
            SUM(CASE WHEN dominant_type LIKE '%A%' THEN 1 ELSE 0 END) as A,
            SUM(CASE WHEN dominant_type LIKE '%S%' THEN 1 ELSE 0 END) as S,
            SUM(CASE WHEN dominant_type LIKE '%E%' THEN 1 ELSE 0 END) as E,
            SUM(CASE WHEN dominant_type LIKE '%C%' THEN 1 ELSE 0 END) as C
        FROM assessment_results
    ")->fetch_assoc();
    
    // Gán giá trị mặc định là 0 nếu NULL
    $holland_stats = [];
    foreach(['R','I','A','S','E','C'] as $key) {
        $holland_stats[$key] = (int)($res_holland[$key] ?? 0);
    }

    // 3. Lấy dữ liệu cho biểu đồ Ngành học (Bar Chart)
    $major_labels = []; $major_counts = [];
    $major_res = $this->conn->query("SELECT aspiration, COUNT(*) as count FROM users WHERE aspiration IS NOT NULL AND aspiration != '' GROUP BY aspiration ORDER BY count DESC LIMIT 5");
    while($row = $major_res->fetch_assoc()){
        $major_labels[] = $row['aspiration'];
        $major_counts[] = $row['count'];
    }

    // 4. Tính tỷ lệ chính xác AI (KNN)
    $ai_feedback = $this->conn->query("SELECT SUM(CASE WHEN is_verified = 1 THEN 1 ELSE 0 END) as v, COUNT(*) as t FROM assessment_results WHERE user_id IN (SELECT id FROM users WHERE user_type = 'alumni')")->fetch_assoc();
    $accuracy_rate = ($ai_feedback['t'] > 0) ? round(($ai_feedback['v'] / $ai_feedback['t']) * 100, 1) : 0;

    // 5. Nhật ký hoạt động
    $recent_activities = [];
    $res_act = $this->conn->query("SELECT ai_chats.*, users.fullname FROM ai_chats LEFT JOIN users ON ai_chats.user_id = users.id ORDER BY ai_chats.created_at DESC LIMIT 5");
    if ($res_act) while($row = $res_act->fetch_assoc()) { $recent_activities[] = $row; }

    require_once 'views/admin/dashboard.php';
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
    $users_chatted = [];
    // Nhóm theo user_id để lấy danh sách những người đã từng hỏi AI
    $sql = "SELECT ai_chats.user_id, users.fullname, MAX(ai_chats.created_at) as last_chat, COUNT(*) as total_messages
            FROM ai_chats 
            LEFT JOIN users ON ai_chats.user_id = users.id 
            GROUP BY ai_chats.user_id 
            ORDER BY last_chat DESC";
            
    $result = $this->conn->query($sql);
    if ($result) {
        while($row = $result->fetch_assoc()) { $users_chatted[] = $row; }
    }
    require 'views/admin/chat_logs/index.php';
}

// 2. Hàm hiển thị chi tiết hội thoại của 1 người (gọi qua AJAX hoặc trang mới)
public function chat_detail() {
    $user_id = $_GET['user_id'] ?? 0;
    $details = [];
    $stmt = $this->conn->prepare("SELECT * FROM ai_chats WHERE user_id = ? ORDER BY created_at ASC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) { $details[] = $row; }
    
    require 'views/admin/chat_logs/detail.php'; // Bạn sẽ tạo file này sau
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
// 16. Danh sách người dùng
public function users() {
    $users = [];
    // QUAN TRỌNG: Phải có 'status' trong câu lệnh SELECT
    $sql = "SELECT id, fullname, username, role, status, created_at FROM users WHERE role != 'admin' ORDER BY created_at DESC";
    $result = $this->conn->query($sql);
    
    if ($result) {
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    require 'views/admin/users/index.php';
}
// 17. Xử lý khóa/mở khóa người dùng
public function toggle_user_status() {
    $id = $_GET['id'] ?? 0;
    $status = $_GET['status'] ?? 'active';
    
    $stmt = $this->conn->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    
    header("Location: index.php?page=admin&action=users&status=updated");
    exit;
}

// 18. Chỉnh sửa thông tin người dùng
public function edit_user() {
    $id = $_GET['id'] ?? 0;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fullname = $_POST['fullname'];
        $role = $_POST['role'];
        
        $stmt = $this->conn->prepare("UPDATE users SET fullname = ?, role = ? WHERE id = ?");
        $stmt->bind_param("ssi", $fullname, $role, $id);
        $stmt->execute();
        header("Location: index.php?page=admin&action=users&status=success");
        exit;
    }
    
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    require 'views/admin/users/edit.php';
}
// --- QUẢN LÝ KHÓA HỌC TOÀN DIỆN ---

public function courses() {
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $courses = [];
    
    if (!empty($search)) {
        // Chức năng TÌM KIẾM theo tên khóa học hoặc giảng viên
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE name LIKE ? OR teacher LIKE ? ORDER BY id DESC");
        $term = "%$search%";
        $stmt->bind_param("ss", $term, $term);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $this->conn->query("SELECT * FROM courses ORDER BY id DESC");
    }

    if ($result) {
        while($row = $result->fetch_assoc()) { $courses[] = $row; }
    }
    require 'views/admin/courses/index.php';
}

public function add_course() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $teacher = $_POST['teacher'];
        $tuition = $_POST['tuition']; // Giữ nguyên chuỗi "2.500.000đ" để đồng bộ DB
        $rating = min(5.0, (float)$_POST['rating']); // Ép tối đa 5.0
        $description = $_POST['description'];
        
        $image = 'default.jpg';
        if (!empty($_FILES['image']['name'])) {
            $image = time() . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], "uploads/courses/" . $image);
        }

        $stmt = $this->conn->prepare("INSERT INTO courses (name, teacher, tuition, rating, description, image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdss", $name, $teacher, $tuition, $rating, $description, $image);
        $stmt->execute();
        header("Location: index.php?page=admin&action=courses");
        exit;
    }
    require 'views/admin/courses/add.php';
}
public function edit_course() {
    $id = (int)$_GET['id'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $tuition = $_POST['tuition'];
        $teacher = $_POST['teacher'];
        $rating = $_POST['rating'];

        if (!empty($_FILES['image']['name'])) {
            $image = time() . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], "uploads/courses/" . $image);
            $sql = "UPDATE courses SET name=?, description=?, tuition=?, image=?, teacher=?, rating=? WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssssdi", $name, $desc, $tuition, $image, $teacher, $rating, $id);
        } else {
            $sql = "UPDATE courses SET name=?, description=?, tuition=?, teacher=?, rating=? WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssdi", $name, $desc, $tuition, $teacher, $rating, $id);
        }
        $stmt->execute();
        header("Location: index.php?page=admin&action=courses");
        exit;
    }
    $course = $this->conn->query("SELECT * FROM courses WHERE id = $id")->fetch_assoc();
    require 'views/admin/courses/edit.php';
}

public function delete_course() {
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $this->conn->query("DELETE FROM courses WHERE id = $id");
    }
    header("Location: index.php?page=admin&action=courses");
    exit;
}
}
?>