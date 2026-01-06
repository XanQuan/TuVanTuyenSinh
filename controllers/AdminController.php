<?php
class AdminController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        
        // 1. KIỂM TRA QUYỀN (BẮT BUỘC)
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            die('<div style="color:red; text-align:center; margin-top:50px;">
                    <h1>⛔ TRUY CẬP BỊ TỪ CHỐI</h1>
                    <p>Bạn không có quyền truy cập trang quản trị.</p>
                    <a href="index.php">Quay về trang chủ</a>
                 </div>');
        }
    }

    // ======================================================
    // 1. TRANG CHỦ DASHBOARD
    // ======================================================
    public function index() {
        // Thống kê cơ bản
        $count_users = $this->conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'student'")->fetch_assoc()['total'] ?? 0;
        $count_visits = $this->conn->query("SELECT COUNT(*) as total FROM search_history")->fetch_assoc()['total'] ?? 0;
        $count_unis = $this->conn->query("SELECT COUNT(*) as total FROM universities")->fetch_assoc()['total'] ?? 0;

        // Thống kê Holland
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
        
        $holland_stats = [];
        foreach(['R','I','A','S','E','C'] as $key) {
            $holland_stats[$key] = (int)($res_holland[$key] ?? 0);
        }

        // Thống kê Ngành học
        $major_labels = []; $major_counts = [];
        $major_res = $this->conn->query("SELECT aspiration, COUNT(*) as count FROM users WHERE aspiration IS NOT NULL AND aspiration != '' GROUP BY aspiration ORDER BY count DESC LIMIT 5");
        if($major_res) {
            while($row = $major_res->fetch_assoc()){
                $major_labels[] = $row['aspiration'];
                $major_counts[] = $row['count'];
            }
        }

        // Tỷ lệ chính xác AI
        $ai_feedback = $this->conn->query("SELECT SUM(CASE WHEN is_verified = 1 THEN 1 ELSE 0 END) as v, COUNT(*) as t FROM assessment_results WHERE user_id IN (SELECT id FROM users WHERE user_type = 'alumni')")->fetch_assoc();
        $accuracy_rate = ($ai_feedback['t'] > 0) ? round(($ai_feedback['v'] / $ai_feedback['t']) * 100, 1) : 0;

        // Nhật ký hoạt động gần đây
        $recent_activities = [];
        $res_act = $this->conn->query("SELECT ai_chats.*, users.fullname FROM ai_chats LEFT JOIN users ON ai_chats.user_id = users.id ORDER BY ai_chats.created_at DESC LIMIT 5");
        if ($res_act) while($row = $res_act->fetch_assoc()) { $recent_activities[] = $row; }

        require_once 'views/admin/dashboard.php';
    }

    // ======================================================
    // 2. QUẢN LÝ TRƯỜNG ĐẠI HỌC
    // ======================================================
    public function universities() {
        $universities = [];
        $result = $this->conn->query("SELECT * FROM universities ORDER BY code ASC");
        if ($result) {
            while($row = $result->fetch_assoc()) { $universities[] = $row; }
        }
        
        $content_view = 'views/admin/universities/index.php';
        require_once 'views/admin/dashboard.php';
    }

    public function add_university() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $code = $_POST['code'];
            $name = $_POST['name'];
            $region = $_POST['region'] ?? 'ToanQuoc'; // Thêm khu vực nếu có
            
            $check = $this->conn->query("SELECT id FROM universities WHERE code = '$code'");
            if ($check->num_rows > 0) {
                echo "<script>alert('Mã trường đã tồn tại!');</script>";
            } else {
                $stmt = $this->conn->prepare("INSERT INTO universities (code, name, region) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $code, $name, $region);
                if ($stmt->execute()) {
                    header("Location: index.php?page=admin&action=universities");
                    exit;
                }
            }
        }
        $content_view = 'views/admin/universities/add.php';
        require_once 'views/admin/dashboard.php';
    }

    public function edit_university() {
        $id = $_GET['id'] ?? 0;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $code = $_POST['code'];
            $name = $_POST['name'];
            $stmt = $this->conn->prepare("UPDATE universities SET code = ?, name = ? WHERE id = ?");
            $stmt->bind_param("ssi", $code, $name, $id);
            $stmt->execute();
            header("Location: index.php?page=admin&action=universities");
            exit;
        }
        
        $stmt = $this->conn->prepare("SELECT * FROM universities WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $university = $stmt->get_result()->fetch_assoc();
        
        $content_view = 'views/admin/universities/edit.php';
        require_once 'views/admin/dashboard.php';
    }

    public function delete_university() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->conn->query("DELETE FROM universities WHERE id = $id");
        }
        header("Location: index.php?page=admin&action=universities");
        exit;
    }

    // ======================================================
    // 3. QUẢN LÝ ĐIỂM CHUẨN
    // ======================================================
    public function scores() {
        $sql = "SELECT entry_scores.*, universities.name AS uni_name, universities.code AS uni_code, majors.name AS major_name 
                FROM entry_scores 
                JOIN universities ON entry_scores.uni_id = universities.id 
                JOIN majors ON entry_scores.major_id = majors.id 
                ORDER BY entry_scores.year DESC, universities.code ASC";
        
        $result = $this->conn->query($sql);
        $scores = [];
        if ($result) while($row = $result->fetch_assoc()) { $scores[] = $row; }
        
        $content_view = 'views/admin/scores/index.php';
        require_once 'views/admin/dashboard.php';
    }

    public function add_score() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uni_id = $_POST['uni_id'];
            $major_id = $_POST['major_id'];
            $year = $_POST['year'];
            $score = $_POST['score'];

            // Kiểm tra trùng lặp
            $check = $this->conn->query("SELECT id FROM entry_scores WHERE uni_id=$uni_id AND major_id=$major_id AND year=$year");
            if ($check->num_rows == 0) {
                $stmt = $this->conn->prepare("INSERT INTO entry_scores (uni_id, major_id, year, score) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiid", $uni_id, $major_id, $year, $score);
                $stmt->execute();
                header("Location: index.php?page=admin&action=scores");
                exit;
            } else {
                echo "<script>alert('Dữ liệu điểm này đã tồn tại!');</script>";
            }
        }
        
        // Load data cho dropdown
        $universities = [];
        $res = $this->conn->query("SELECT * FROM universities ORDER BY name ASC");
        while($row = $res->fetch_assoc()) $universities[] = $row;

        $majors = [];
        $res = $this->conn->query("SELECT * FROM majors ORDER BY name ASC");
        while($row = $res->fetch_assoc()) $majors[] = $row;

        $content_view = 'views/admin/scores/add.php';
        require_once 'views/admin/dashboard.php';
    }

    public function edit_score() {
        $id = $_GET['id'] ?? 0;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uni_id = $_POST['uni_id'];
            $major_id = $_POST['major_id'];
            $year = $_POST['year'];
            $score = $_POST['score'];

            $stmt = $this->conn->prepare("UPDATE entry_scores SET uni_id=?, major_id=?, year=?, score=? WHERE id=?");
            $stmt->bind_param("iiidi", $uni_id, $major_id, $year, $score, $id);
            $stmt->execute();
            header("Location: index.php?page=admin&action=scores");
            exit;
        }

        $current_score = $this->conn->query("SELECT * FROM entry_scores WHERE id=$id")->fetch_assoc();
        
        // Load lại data cho dropdown edit
        $universities = [];
        $res = $this->conn->query("SELECT * FROM universities ORDER BY name ASC");
        while($row = $res->fetch_assoc()) $universities[] = $row;

        $majors = [];
        $res = $this->conn->query("SELECT * FROM majors ORDER BY name ASC");
        while($row = $res->fetch_assoc()) $majors[] = $row;

        $content_view = 'views/admin/scores/edit.php';
        require_once 'views/admin/dashboard.php';
    }

    public function delete_score() {
        if (isset($_GET['id'])) {
            $this->conn->query("DELETE FROM entry_scores WHERE id=" . $_GET['id']);
        }
        header("Location: index.php?page=admin&action=scores");
        exit;
    }

    // ======================================================
    // 4. QUẢN LÝ NGÀNH HỌC
    // ======================================================
    public function majors() {
        $majors = [];
        $result = $this->conn->query("SELECT * FROM majors ORDER BY group_code ASC, name ASC");
        if ($result) while($row = $result->fetch_assoc()) { $majors[] = $row; }
        
        $content_view = 'views/admin/majors/index.php';
        require_once 'views/admin/dashboard.php';
    }

    public function add_major() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $group_code = $_POST['group_code']; 
            
            $stmt = $this->conn->prepare("INSERT INTO majors (name, group_code) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $group_code);
            $stmt->execute();
            header("Location: index.php?page=admin&action=majors");
            exit;
        }
        $content_view = 'views/admin/majors/add.php';
        require_once 'views/admin/dashboard.php';
    }

    public function delete_major() {
        if (isset($_GET['id'])) {
            $this->conn->query("DELETE FROM majors WHERE id=" . $_GET['id']);
        }
        header("Location: index.php?page=admin&action=majors");
        exit;
    }

    // ======================================================
    // 5. QUẢN LÝ CÂU HỎI & TEST HOLLAND
    // ======================================================
    public function questions() {
        $questions = [];
        $result = $this->conn->query("SELECT * FROM questions ORDER BY group_code ASC, id ASC");
        if ($result) while($row = $result->fetch_assoc()) { $questions[] = $row; }
        
        $content_view = 'views/admin/questions/index.php';
        require_once 'views/admin/dashboard.php';
    }

    public function save_question() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $text = $_POST['question_text'] ?? '';
            $group = $_POST['holland_group'] ?? '';
            $image_name = null;
    
            if (!empty($_FILES['question_image']['name'])) {
                if (!file_exists("uploads/questions/")) mkdir("uploads/questions/", 0777, true);
                $image_name = time() . '_' . basename($_FILES['question_image']['name']);
                move_uploaded_file($_FILES['question_image']['tmp_name'], "uploads/questions/" . $image_name);
            }
    
            if (!empty($text) && !empty($group)) {
                $stmt = $this->conn->prepare("INSERT INTO questions (content, group_code, image_url) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $text, $group, $image_name);
                $stmt->execute();
            }
        }
        header("Location: index.php?page=admin&action=questions");
        exit;
    }

    public function delete_question() {
        if (isset($_GET['id'])) {
            $this->conn->query("DELETE FROM questions WHERE id=" . $_GET['id']);
        }
        header("Location: index.php?page=admin&action=questions");
        exit;
    }

    // ======================================================
    // 6. NHẬT KÝ CHAT AI
    // ======================================================
    public function chat_logs() {
        $users_chatted = [];
        $sql = "SELECT ai_chats.user_id, users.fullname, MAX(ai_chats.created_at) as last_chat, COUNT(*) as total_messages
                FROM ai_chats 
                LEFT JOIN users ON ai_chats.user_id = users.id 
                GROUP BY ai_chats.user_id 
                ORDER BY last_chat DESC";
        $result = $this->conn->query($sql);
        if ($result) while($row = $result->fetch_assoc()) { $users_chatted[] = $row; }
        
        $content_view = 'views/admin/chat_logs/index.php';
        require_once 'views/admin/dashboard.php';
    }

    public function chat_detail() {
        $user_id = $_GET['user_id'] ?? 0;
        $details = [];
        $stmt = $this->conn->prepare("SELECT * FROM ai_chats WHERE user_id = ? ORDER BY created_at ASC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) { $details[] = $row; }
        
        $content_view = 'views/admin/chat_logs/detail.php';
        require_once 'views/admin/dashboard.php';
    }

    // ======================================================
    // 7. QUẢN LÝ NGƯỜI DÙNG
    // ======================================================
    public function users() {
        $users = [];
        $sql = "SELECT id, fullname, username, role, status, created_at FROM users WHERE role != 'admin' ORDER BY created_at DESC";
        $result = $this->conn->query($sql);
        if ($result) while($row = $result->fetch_assoc()) { $users[] = $row; }
        
        $content_view = 'views/admin/users/index.php';
        require_once 'views/admin/dashboard.php';
    }

    public function toggle_user_status() {
        $id = $_GET['id'] ?? 0;
        $status = $_GET['status'] ?? 'active';
        $this->conn->query("UPDATE users SET status = '$status' WHERE id = $id");
        header("Location: index.php?page=admin&action=users");
        exit;
    }

    public function edit_user() {
        $id = $_GET['id'] ?? 0;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fullname = $_POST['fullname'];
            $role = $_POST['role'];
            $stmt = $this->conn->prepare("UPDATE users SET fullname = ?, role = ? WHERE id = ?");
            $stmt->bind_param("ssi", $fullname, $role, $id);
            $stmt->execute();
            header("Location: index.php?page=admin&action=users");
            exit;
        }
        
        $user = $this->conn->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();
        $content_view = 'views/admin/users/edit.php';
        require_once 'views/admin/dashboard.php';
    }

    // ======================================================
    // 8. QUẢN LÝ KHÓA HỌC
    // ======================================================
    public function courses() {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $courses = [];
        
        if (!empty($search)) {
            $stmt = $this->conn->prepare("SELECT * FROM courses WHERE name LIKE ? OR teacher LIKE ? ORDER BY id DESC");
            $term = "%$search%";
            $stmt->bind_param("ss", $term, $term);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $this->conn->query("SELECT * FROM courses ORDER BY id DESC");
        }

        if ($result) while($row = $result->fetch_assoc()) { $courses[] = $row; }
        
        $content_view = 'views/admin/courses/index.php';
        require_once 'views/admin/dashboard.php';
    }

    public function add_course() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $teacher = $_POST['teacher'];
            $tuition = $_POST['tuition']; 
            $rating = min(5.0, (float)$_POST['rating']);
            $description = $_POST['description'];
            
            $image = 'default.jpg';
            if (!empty($_FILES['image']['name'])) {
                if (!file_exists("uploads/courses/")) mkdir("uploads/courses/", 0777, true);
                $image = time() . '_' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], "uploads/courses/" . $image);
            }

            $stmt = $this->conn->prepare("INSERT INTO courses (name, teacher, tuition, rating, description, image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssdss", $name, $teacher, $tuition, $rating, $description, $image);
            $stmt->execute();
            header("Location: index.php?page=admin&action=courses");
            exit;
        }
        $content_view = 'views/admin/courses/add.php';
        require_once 'views/admin/dashboard.php';
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
                if (!file_exists("uploads/courses/")) mkdir("uploads/courses/", 0777, true);
                $image = time() . '_' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], "uploads/courses/" . $image);
                $stmt = $this->conn->prepare("UPDATE courses SET name=?, description=?, tuition=?, image=?, teacher=?, rating=? WHERE id=?");
                $stmt->bind_param("sssssdi", $name, $desc, $tuition, $image, $teacher, $rating, $id);
            } else {
                $stmt = $this->conn->prepare("UPDATE courses SET name=?, description=?, tuition=?, teacher=?, rating=? WHERE id=?");
                $stmt->bind_param("ssssdi", $name, $desc, $tuition, $teacher, $rating, $id);
            }
            $stmt->execute();
            header("Location: index.php?page=admin&action=courses");
            exit;
        }
        $course = $this->conn->query("SELECT * FROM courses WHERE id = $id")->fetch_assoc();
        $content_view = 'views/admin/courses/edit.php';
        require_once 'views/admin/dashboard.php';
    }

    public function delete_course() {
        if (isset($_GET['id'])) {
            $this->conn->query("DELETE FROM courses WHERE id=" . $_GET['id']);
        }
        header("Location: index.php?page=admin&action=courses");
        exit;
    }

    // ======================================================
    // 9. QUẢN LÝ SỰ KIỆN (EVENTS)
    // ======================================================
    public function events() {
        $events = [];
        $result = $this->conn->query("SELECT * FROM events ORDER BY event_date DESC");
        if ($result) while($row = $result->fetch_assoc()) { $events[] = $row; }
        
        $content_view = 'views/admin/events/index.php';
        require_once 'views/admin/dashboard.php';
    }

    public function add_event() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $event_date = $_POST['event_date'];
            $location = $_POST['location'];
            
            $image_url = NULL;
            if (!empty($_FILES['image']['name'])) {
                if (!file_exists("public/assets/images/")) mkdir("public/assets/images/", 0777, true);
                $image_url = time() . '_evt_' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], "public/assets/images/" . $image_url);
            }

            $stmt = $this->conn->prepare("INSERT INTO events (title, description, event_date, location, image_url) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $title, $description, $event_date, $location, $image_url);
            $stmt->execute();
            header("Location: index.php?page=admin&action=events");
            exit;
        }
        $content_view = 'views/admin/events/add.php';
        require_once 'views/admin/dashboard.php';
    }

    public function edit_event() {
        $id = $_GET['id'] ?? 0;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $event_date = $_POST['event_date'];
            $location = $_POST['location'];
            $image_url = $_POST['current_image'];

            if (!empty($_FILES['image']['name'])) {
                if (!file_exists("public/assets/images/")) mkdir("public/assets/images/", 0777, true);
                $image_url = time() . '_evt_' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], "public/assets/images/" . $image_url);
            }

            $stmt = $this->conn->prepare("UPDATE events SET title=?, description=?, event_date=?, location=?, image_url=? WHERE id=?");
            $stmt->bind_param("sssssi", $title, $description, $event_date, $location, $image_url, $id);
            $stmt->execute();
            header("Location: index.php?page=admin&action=events");
            exit;
        }
        $event = $this->conn->query("SELECT * FROM events WHERE id = $id")->fetch_assoc();
        $content_view = 'views/admin/events/edit.php';
        require_once 'views/admin/dashboard.php';
    }

    public function delete_event() {
        if (isset($_GET['id'])) {
            $this->conn->query("DELETE FROM events WHERE id=" . $_GET['id']);
        }
        header("Location: index.php?page=admin&action=events");
        exit;
    }

    // ======================================================
    // 10. QUẢN LÝ CHUYÊN GIA (MENTORS)
    // ======================================================
    public function mentors() {
        $mentors = [];
        // Lấy thông tin mentor kèm username nếu email không có
        $sql = "SELECT mentors.*, users.fullname, users.username 
                FROM mentors 
                JOIN users ON mentors.user_id = users.id";
        $result = $this->conn->query($sql);
        if ($result) while($row = $result->fetch_assoc()) { $mentors[] = $row; }
        
        $content_view = 'views/admin/mentors/index.php';
        require_once 'views/admin/dashboard.php';
    }

    public function add_mentor() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_POST['user_id'];
            $full_name = $_POST['full_name'];
            $job_title = $_POST['job_title'];
            $expertise = $_POST['expertise'];
            $bio = $_POST['bio'];
            $linkedin_url = $_POST['linkedin_url'];
            
            $avatar = 'default_mentor.jpg';
            if (!empty($_FILES['avatar']['name'])) {
                if (!file_exists("public/assets/images/")) mkdir("public/assets/images/", 0777, true);
                $avatar = time() . '_avt_' . basename($_FILES['avatar']['name']);
                move_uploaded_file($_FILES['avatar']['tmp_name'], "public/assets/images/" . $avatar);
            }

            $stmt = $this->conn->prepare("INSERT INTO mentors (user_id, full_name, job_title, expertise, bio, avatar, linkedin_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssss", $user_id, $full_name, $job_title, $expertise, $bio, $avatar, $linkedin_url);
            $stmt->execute();
            header("Location: index.php?page=admin&action=mentors");
            exit;
        }
        
        // Lấy danh sách user để chọn
        $users = [];
        $res = $this->conn->query("SELECT id, fullname, username FROM users ORDER BY fullname ASC");
        while($row = $res->fetch_assoc()) $users[] = $row;

        $content_view = 'views/admin/mentors/add.php';
        require_once 'views/admin/dashboard.php';
    }

    public function delete_mentor() {
        if (isset($_GET['id'])) {
            $this->conn->query("DELETE FROM mentors WHERE id=" . $_GET['id']);
        }
        header("Location: index.php?page=admin&action=mentors");
        exit;
    }

    // ======================================================
    // 11. QUẢN LÝ TÀI LIỆU (RESOURCES)
    // ======================================================
    public function resources() {
        $resources = [];
        $result = $this->conn->query("SELECT * FROM resources ORDER BY created_at DESC");
        if ($result) while($row = $result->fetch_assoc()) { $resources[] = $row; }
        
        $content_view = 'views/admin/resources/index.php';
        require_once 'views/admin/dashboard.php';
    }

    public function add_resource() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $category = $_POST['category'];
            $content = $_POST['content']; // Lưu vào cột content thay vì description
            
            $thumbnail = NULL;
            if (!empty($_FILES['thumbnail']['name'])) {
                if (!file_exists("public/assets/images/")) mkdir("public/assets/images/", 0777, true);
                $thumbnail = time() . '_thumb_' . basename($_FILES['thumbnail']['name']);
                move_uploaded_file($_FILES['thumbnail']['tmp_name'], "public/assets/images/" . $thumbnail);
            }

            $file_link = NULL;
            if (!empty($_FILES['file_upload']['name'])) {
                if (!file_exists("public/assets/documents/")) mkdir("public/assets/documents/", 0777, true);
                $file_link = time() . '_' . basename($_FILES['file_upload']['name']);
                move_uploaded_file($_FILES['file_upload']['tmp_name'], "public/assets/documents/" . $file_link);
            } elseif (!empty($_POST['file_link_url'])) {
                $file_link = $_POST['file_link_url'];
            }

            $stmt = $this->conn->prepare("INSERT INTO resources (title, category, content, thumbnail, file_link) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $title, $category, $content, $thumbnail, $file_link);
            $stmt->execute();
            header("Location: index.php?page=admin&action=resources");
            exit;
        }
        $content_view = 'views/admin/resources/add.php';
        require_once 'views/admin/dashboard.php';
    }

    public function edit_resource() {
        $id = $_GET['id'] ?? 0;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $category = $_POST['category'];
            $content = $_POST['content'];
            $file_link = $_POST['current_file_link'];
            $thumbnail = $_POST['current_thumbnail'];

            if (!empty($_FILES['thumbnail']['name'])) {
                if (!file_exists("public/assets/images/")) mkdir("public/assets/images/", 0777, true);
                $thumbnail = time() . '_thumb_' . basename($_FILES['thumbnail']['name']);
                move_uploaded_file($_FILES['thumbnail']['tmp_name'], "public/assets/images/" . $thumbnail);
            }

            if (!empty($_FILES['file_upload']['name'])) {
                if (!file_exists("public/assets/documents/")) mkdir("public/assets/documents/", 0777, true);
                $file_link = time() . '_' . basename($_FILES['file_upload']['name']);
                move_uploaded_file($_FILES['file_upload']['tmp_name'], "public/assets/documents/" . $file_link);
            } elseif (!empty($_POST['file_link_url'])) {
                $file_link = $_POST['file_link_url'];
            }

            $stmt = $this->conn->prepare("UPDATE resources SET title=?, category=?, content=?, thumbnail=?, file_link=? WHERE id=?");
            $stmt->bind_param("sssssi", $title, $category, $content, $thumbnail, $file_link, $id);
            $stmt->execute();
            header("Location: index.php?page=admin&action=resources");
            exit;
        }
        
        $resource = $this->conn->query("SELECT * FROM resources WHERE id = $id")->fetch_assoc();
        $content_view = 'views/admin/resources/edit.php';
        require_once 'views/admin/dashboard.php';
    }

    public function delete_resource() {
        if (isset($_GET['id'])) {
            $this->conn->query("DELETE FROM resources WHERE id=" . $_GET['id']);
        }
        header("Location: index.php?page=admin&action=resources");
        exit;
    }
}
?>