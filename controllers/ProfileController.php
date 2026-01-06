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
        
        // 1. Lấy thông tin người dùng hiện tại và điểm Holland mới nhất
        $stmt = $this->conn->prepare("SELECT u.*, r.r_score, r.i_score, r.a_score, r.s_score, r.e_score, r.c_score 
                                      FROM users u 
                                      LEFT JOIN assessment_results r ON u.id = r.user_id 
                                      WHERE u.id = ? ORDER BY r.id DESC LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        // --- BỔ SUNG: Lấy danh sách khối thi từ database để đổ ra View ---
        $exam_groups_result = $this->conn->query("SELECT * FROM exam_groups ORDER BY code ASC");
        $all_exam_groups = [];
        if ($exam_groups_result) {
            while($row = $exam_groups_result->fetch_assoc()) {
                $all_exam_groups[] = $row;
            }
        }

        // 2. Lấy dữ liệu thống kê hoạt động
        $quiz_count = $this->conn->query("SELECT COUNT(*) as total FROM assessment_results WHERE user_id = $user_id")->fetch_assoc()['total'] ?? 0;
        $chat_count = $this->conn->query("SELECT COUNT(*) as total FROM chat_sessions WHERE user_id = $user_id")->fetch_assoc()['total'] ?? 0;

        // --- KHỞI TẠO DỮ LIỆU MACHINE LEARNING THẬT ---
        $top_suggestion = "Đang thu thập thêm dữ liệu...";
        $top_match_rate = 0;
        $top_employment_status = 'working';
        $best_mentor_name = "Tiền bối ẩn danh";

        // 3. THUẬT TOÁN KNN: Truy vấn tập mẫu từ Alumni đã xác minh
        $sql_ml = "SELECT u.fullname, r.feedback_major as aspiration, u.employment_status, 
                          r.r_score, r.i_score, r.a_score, r.s_score, r.e_score, r.c_score 
                   FROM assessment_results r 
                   INNER JOIN users u ON u.id = r.user_id 
                   WHERE u.user_type = 'alumni' AND r.is_verified = 1"; 
        
        $others = $this->conn->query($sql_ml);

        if ($others && $others->num_rows > 0) {
            $recommendations = [];
            while($row = $others->fetch_assoc()) {
                $similarity = $this->calculateSimilarity($user, $row);
                $percentage = (($similarity + 25) / (25 + 15)) * 100; 
                $percentage = max(30, min(99, $percentage)); 

                $recommendations[] = [
                    'major' => $row['aspiration'], 
                    'fullname' => $row['fullname'],
                    'score' => $similarity,
                    'match_rate' => round($percentage),
                    'status' => $row['employment_status']
                ];
            }
            usort($recommendations, function($a, $b) { return $b['score'] <=> $a['score']; });
            
            $top_suggestion = $recommendations[0]['major'];
            $top_match_rate = $recommendations[0]['match_rate']; 
            $top_employment_status = $recommendations[0]['status'];
            $best_mentor_name = $recommendations[0]['fullname'];
        }

        // 4. Tính % hoàn thiện hồ sơ tự động
        $fields = ['fullname', 'birthday', 'gender', 'phone', 'academic_performance', 'address', 'aspiration', 'avatar'];
        $filled = 0; 
        foreach ($fields as $f) { if (!empty($user[$f])) $filled++; }
        $completion_percent = round(($filled / count($fields)) * 100);

        require 'views/profile/index.php';
    }

    private function calculateSimilarity($userA, $userB) {
        $score = 0;
        if (($userA['region'] ?? '') == ($userB['region'] ?? '')) $score += 3;
        if (($userA['academic_performance'] ?? '') == ($userB['academic_performance'] ?? '')) $score += 2;
        
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