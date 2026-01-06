<?php
class AssessmentController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        // Kiểm tra đăng nhập ngay khi khởi tạo để bảo mật các hành động bên dưới
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=auth&action=login");
            exit;
        }
    }

    /**
     * 1. Hiển thị bài trắc nghiệm Holland
     */
    public function index() {
        // Lấy danh sách câu hỏi ngẫu nhiên từ database
        $sql = "SELECT * FROM questions ORDER BY RAND()"; 
        $result = $this->conn->query($sql);
        
        $questions = [];
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $questions[] = $row;
            }
        }
        
        // Lấy thông báo lỗi từ Session (nếu có) để hiển thị trên giao diện
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']); 

        require 'views/assessment/test.php';
    }

    /**
     * 2. Xử lý lưu kết quả sau khi nộp bài
     */
    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $answers = $_POST['answers'] ?? [];
            
            // Chặn trường hợp người dùng không chọn câu nào mà đã bấm nộp
            if (empty($answers)) {
                $_SESSION['error'] = "Bạn chưa chọn đáp án nào. Vui lòng thực hiện bài trắc nghiệm!";
                header("Location: index.php?page=assessment");
                exit;
            }

            // Khởi tạo mảng điểm cho 6 nhóm Holland
            $scores = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];

            foreach ($answers as $group_code) {
                if (isset($scores[$group_code])) {
                    $scores[$group_code]++;
                }
            }

            // Tìm nhóm có điểm cao nhất để xác định dominant_type
            $temp_scores = $scores;
            arsort($temp_scores); 
            $dominant = array_key_first($temp_scores);

            $user_id = $_SESSION['user']['id'];
            
            // Lưu kết quả vào bảng assessment_results
            $sql = "INSERT INTO assessment_results (user_id, r_score, i_score, a_score, s_score, e_score, c_score, dominant_type) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("iiiiiiis", 
                    $user_id, 
                    $scores['R'], $scores['I'], $scores['A'], 
                    $scores['S'], $scores['E'], $scores['C'], 
                    $dominant
                );
                
                if ($stmt->execute()) {
                    $result_id = $stmt->insert_id;
                    // Sau khi lưu thành công, chuyển hướng đến trang xem kết quả chi tiết
                    header("Location: index.php?page=assessment&action=result&id=$result_id");
                    exit;
                }
            }
            
            $_SESSION['error'] = "Lỗi hệ thống: Không thể lưu kết quả. Vui lòng thử lại.";
            header("Location: index.php?page=assessment");
            exit;
        }
    }

    /**
     * 3. Hiển thị trang Kết quả & Gợi ý ngành học
     */
    public function result() {
        $id = $_GET['id'] ?? 0;
        $user_id = $_SESSION['user']['id'];

        // Lấy thông tin kết quả test vừa thực hiện
        $sql = "SELECT * FROM assessment_results WHERE id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        // Lấy thêm thông tin User để View biết là 'student' hay 'alumni' (dùng cho tính năng xác minh)
        $stmt_u = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt_u->bind_param("i", $user_id);
        $stmt_u->execute();
        $user = $stmt_u->get_result()->fetch_assoc();

        $suggested_majors_grouped = [];

        if ($result) {
            $scores = [
                'R' => $result['r_score'], 'I' => $result['i_score'], 'A' => $result['a_score'],
                'S' => $result['s_score'], 'E' => $result['e_score'], 'C' => $result['c_score']
            ];

            $max_score = max($scores);

            // Tìm tất cả các nhóm có điểm cao nhất (xử lý trường hợp đa tiềm năng)
            $top_types = [];
            if ($max_score > 0) {
                foreach ($scores as $type => $score) {
                    if ($score == $max_score) {
                        $top_types[] = $type;
                    }
                }
            }

            // Cấu hình bản đồ ánh xạ từ Mã Holland sang Mã nhóm ngành trong DB
            $mapping = [
                'R' => ['code' => 'CK', 'name' => 'Thực tế (Realistic)'],
                'I' => ['code' => 'IT', 'name' => 'Nghiên cứu (Investigative)'],
                'A' => ['code' => 'NN', 'name' => 'Nghệ thuật (Artistic)'],
                'S' => ['code' => 'YD', 'name' => 'Xã hội (Social)'],
                'E' => ['code' => 'KT', 'name' => 'Quản lý (Enterprising)'],
                'C' => ['code' => 'KT', 'name' => 'Nghiệp vụ (Conventional)']
            ];

            // Truy vấn lấy danh sách ngành học gợi ý cho từng nhóm dẫn đầu
            foreach ($top_types as $type) {
                if (isset($mapping[$type])) {
                    $group_code = $mapping[$type]['code'];
                    $type_name = $mapping[$type]['name'];

                    $majors = [];
                    $sql_m = "SELECT * FROM majors WHERE group_code = ? LIMIT 4";
                    $stmt_m = $this->conn->prepare($sql_m);
                    $stmt_m->bind_param("s", $group_code);
                    $stmt_m->execute();
                    $res_m = $stmt_m->get_result();
                    while ($row = $res_m->fetch_assoc()) {
                        $majors[] = $row;
                    }

                    if (!empty($majors)) {
                        $suggested_majors_grouped[$type] = [
                            'name' => $type_name,
                            'majors' => $majors
                        ];
                    }
                }
            }
        }

        require 'views/assessment/result.php';
    }

    /**
     * 4. Tính năng xác minh dữ liệu AI (Dành riêng cho Cựu sinh viên - Alumni)
     */
    public function verify_data() {
        // Chỉ cho phép xử lý nếu là Alumni nộp form xác nhận
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['user']['user_type'] == 'alumni') {
            $result_id = $_POST['result_id'];
            $is_accurate = $_POST['confirm']; // 1: Chính xác, 0: Không khớp
            $user_id = $_SESSION['user']['id'];

            // Lấy ngành học thực tế mà cựu sinh viên đã cập nhật trong Hồ sơ
            $stmt_user = $this->conn->prepare("SELECT aspiration FROM users WHERE id = ?");
            $stmt_user->bind_param("i", $user_id);
            $stmt_user->execute();
            $user_data = $stmt_user->get_result()->fetch_assoc();
            $actual_major = $user_data['aspiration'] ?? '';

            // Chặn nếu cựu sinh viên chưa khai báo ngành học thật
            if (empty($actual_major) || $actual_major == '123') {
                $_SESSION['error'] = "Tiền bối vui lòng cập nhật ngành học chính xác trong Hồ sơ trước khi xác minh dữ liệu AI!";
                header("Location: index.php?page=profile");
                exit;
            }

            // Cập nhật trạng thái xác minh và lưu ngành học "nhãn" vào kết quả trắc nghiệm
            $sql = "UPDATE assessment_results SET is_verified = ?, feedback_major = ? WHERE id = ? AND user_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("isii", $is_accurate, $actual_major, $result_id, $user_id);
            
            if ($stmt->execute()) {
                $_SESSION['message'] = "Xác minh thành công! Dữ liệu của bạn đã trở thành tập mẫu quý giá cho hệ thống định hướng.";
            }
            
            header("Location: index.php?page=assessment&action=result&id=$result_id");
            exit;
        }
    }
}