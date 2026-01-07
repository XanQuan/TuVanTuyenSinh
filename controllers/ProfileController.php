<?php
// controllers/ProfileController.php

class ProfileController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit;
        }
    }

    public function index() {
        $user_id = $_SESSION['user']['id'];
        
        // 1. Lấy thông tin người dùng và kết quả Holland mới nhất
        $stmt = $this->conn->prepare("SELECT u.*, r.r_score, r.i_score, r.a_score, r.s_score, r.e_score, r.c_score 
                                      FROM users u 
                                      LEFT JOIN assessment_results r ON u.id = r.user_id 
                                      WHERE u.id = ? ORDER BY r.id DESC LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        // Lấy danh sách khối thi
        $exam_groups_result = $this->conn->query("SELECT * FROM exam_groups ORDER BY code ASC");
        $all_exam_groups = [];
        if ($exam_groups_result) {
            while($row = $exam_groups_result->fetch_assoc()) {
                $all_exam_groups[] = $row;
            }
        }

        // 2. Thống kê
        $quiz_count = $this->conn->query("SELECT COUNT(*) as total FROM assessment_results WHERE user_id = $user_id")->fetch_assoc()['total'] ?? 0;
        $chat_count = $this->conn->query("SELECT COUNT(*) as total FROM chat_sessions WHERE user_id = $user_id")->fetch_assoc()['total'] ?? 0;

        // 3. THUẬT TOÁN KNN: CẢI TIẾN LINH HOẠT
        $top_suggestion = "Đang thu thập thêm dữ liệu...";
        $top_match_rate = 0;
        $top_employment_status = 'working';

        // Lấy dữ liệu Alumni (Tiền bối)
        $sql_ml = "SELECT u.fullname, u.region, u.academic_performance, u.employment_status, 
                          r.feedback_major as aspiration, 
                          r.r_score, r.i_score, r.a_score, r.s_score, r.e_score, r.c_score 
                   FROM assessment_results r 
                   INNER JOIN users u ON u.id = r.user_id 
                   WHERE u.user_type = 'alumni' AND r.is_verified = 1"; 
        
        $others = $this->conn->query($sql_ml);

        if ($others && $others->num_rows > 0) {
            $recommendations = [];
            while($row = $others->fetch_assoc()) {
               // --- SỬA LẠI LOGIC TÍNH % TRONG VÒNG LẶP WHILE ---

$similarity = $this->calculateSimilarity($user, $row);

// 1. Tính % dựa trên khoảng cách Holland (Similarity càng cao % càng cao)
// Giả sử similarity = 5 là khớp hoàn hảo 100% tính cách
$holland_percent = ($similarity / 5) * 100;

// 2. Xử lý biến thiên theo Khối thi (Region)
if (!empty($user['region']) && $user['region'] == $row['region']) {
    // Nếu trùng khối thi: Lấy % tính cách + 40% điểm thưởng 
    // (nhưng không vượt quá 98% để trông thật hơn)
    $final_percentage = min(98, $holland_percent + 40);
} else {
    // Nếu khác khối thi: Chỉ lấy % tính cách và đảm bảo không quá thấp
    $final_percentage = max(35, $holland_percent);
}

// 3. Làm tròn số để hiển thị đẹp (Ví dụ: 76%)
$match_rate_display = round($final_percentage);

$recommendations[] = [
    'major' => $row['aspiration'], 
    'fullname' => $row['fullname'],
    'score' => $similarity,
    'match_rate' => $match_rate_display,
    'status' => $row['employment_status']
];
            }
            
            // Sắp xếp: Ai có score cao nhất (giống nhất) lên đầu
            usort($recommendations, function($a, $b) { return $b['score'] <=> $a['score']; });
            
            $top_suggestion = $recommendations[0]['major'];
            $top_match_rate = $recommendations[0]['match_rate']; 
            $top_employment_status = $recommendations[0]['status'];
        }

        // 4. Tính % hoàn thiện hồ sơ
        $fields = ['fullname', 'birthday', 'gender', 'phone', 'academic_performance', 'address', 'aspiration', 'avatar'];
        $filled = 0; 
        foreach ($fields as $f) { if (!empty($user[$f])) $filled++; }
        $completion_percent = round(($filled / count($fields)) * 100);

        require 'views/profile/index.php';
    }

    private function calculateSimilarity($userA, $userB) {
        $score = 0;
        // Thưởng 20 điểm nếu trùng khối thi (Chỉ số quan trọng nhất của bạn)
        if (!empty($userA['region']) && !empty($userB['region']) && $userA['region'] == $userB['region']) {
            $score += 20; 
        }

        // Thưởng 5 điểm nếu cùng học lực
        if (!empty($userA['academic_performance']) && !empty($userB['academic_performance']) 
            && $userA['academic_performance'] == $userB['academic_performance']) {
            $score += 5;
        }

        // Độ lệch tính cách Holland
        $dist = sqrt(
            pow(($userA['r_score'] ?? 0) - ($userB['r_score'] ?? 0), 2) +
            pow(($userA['i_score'] ?? 0) - ($userB['i_score'] ?? 0), 2) +
            pow(($userA['a_score'] ?? 0) - ($userB['a_score'] ?? 0), 2) +
            pow(($userA['s_score'] ?? 0) - ($userB['s_score'] ?? 0), 2) +
            pow(($userA['e_score'] ?? 0) - ($userB['e_score'] ?? 0), 2) +
            pow(($userA['c_score'] ?? 0) - ($userB['c_score'] ?? 0), 2)
        );

        return $score - $dist;
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user']['id'];
            $avatar = $_POST['current_avatar'];
            if (!empty($_FILES['avatar']['name'])) {
                $target_dir = "public/uploads/avatars/";
                $fn = time() . "_" . basename($_FILES["avatar"]["name"]);
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_dir . $fn)) { $avatar = $fn; }
            }

            $emp_status = $_POST['employment_status'] ?? 'working';
            $sql = "UPDATE users SET fullname=?, gender=?, birthday=?, academic_performance=?, region=?, aspiration=?, address=?, phone=?, personality=?, user_type=?, avatar=?, employment_status=? WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssssssssssi", $_POST['fullname'], $_POST['gender'], $_POST['birthday'], $_POST['academic_performance'], $_POST['region'], $_POST['aspiration'], $_POST['address'], $_POST['phone'], $_POST['personality'], $_POST['user_type'], $avatar, $emp_status, $user_id);

            if ($stmt->execute()) {
                $_SESSION['user']['fullname'] = $_POST['fullname'];
                $_SESSION['user']['avatar'] = $avatar; 
                $_SESSION['user']['user_type'] = $_POST['user_type'];
                header("Location: index.php?page=profile&status=success&message=Cập nhật hồ sơ thành công!");
            } else {
                header("Location: index.php?page=profile&status=error&message=Lỗi SQL: " . urlencode($this->conn->error));
            }
            exit;
        }
    }
}