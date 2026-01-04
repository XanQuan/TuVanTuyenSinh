<?php
class AssessmentController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=auth&action=login");
            exit;
        }
    }

    // 1. Hiển thị bài test
    public function index() {
        // Lấy câu hỏi ngẫu nhiên
        $sql = "SELECT * FROM questions ORDER BY RAND()"; 
        $result = $this->conn->query($sql);
        
        $questions = [];
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $questions[] = $row;
            }
        }
        
        // Lấy thông báo lỗi từ Session (nếu có) để truyền sang View
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']); // Xóa lỗi sau khi đã lấy để không hiện lại lần sau

        require 'views/assessment/test.php';
    }

    // 2. Xử lý nộp bài
    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $answers = $_POST['answers'] ?? [];
            
            // --- VALIDATION: Chặn nộp bài trống ---
            if (empty($answers)) {
                $_SESSION['error'] = "Bạn chưa chọn đáp án nào. Vui lòng thực hiện bài trắc nghiệm!";
                header("Location: index.php?page=assessment");
                exit;
            }

            $scores = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];

            foreach ($answers as $group_code) {
                if (isset($scores[$group_code])) {
                    $scores[$group_code]++;
                }
            }

            // Tìm nhóm điểm cao nhất để lưu "dominant_type" (lấy đại diện 1 cái đầu tiên)
            arsort($scores); 
            $dominant = array_key_first($scores);

            $user_id = $_SESSION['user']['id'];
            $sql = "INSERT INTO assessment_results (user_id, r_score, i_score, a_score, s_score, e_score, c_score, dominant_type) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("iiiiiiis", $user_id, $scores['R'], $scores['I'], $scores['A'], $scores['S'], $scores['E'], $scores['C'], $dominant);
                
                if ($stmt->execute()) {
                    $result_id = $stmt->insert_id;
                    header("Location: index.php?page=assessment&action=result&id=$result_id");
                    exit;
                }
            }
            
            $_SESSION['error'] = "Lỗi hệ thống: Không thể lưu kết quả. Vui lòng thử lại.";
            header("Location: index.php?page=assessment");
            exit;
        }
    }

    // 3. Hiển thị Kết quả & Gợi ý ngành (LOGIC ĐA TIỀM NĂNG)
    public function result() {
        $id = $_GET['id'] ?? 0;
        $user_id = $_SESSION['user']['id'];

        $sql = "SELECT * FROM assessment_results WHERE id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        $result_data = $stmt->get_result()->fetch_assoc();

        $result = $result_data; 
        $suggested_majors_grouped = []; // Mảng chứa ngành đã phân nhóm

        if ($result) {
            $scores = [
                'R' => $result['r_score'],
                'I' => $result['i_score'],
                'A' => $result['a_score'],
                'S' => $result['s_score'],
                'E' => $result['e_score'],
                'C' => $result['c_score']
            ];

            $max_score = max($scores);

            // Tìm TẤT CẢ các nhóm có điểm bằng điểm cao nhất
            $top_types = [];
            if ($max_score > 0) {
                foreach ($scores as $type => $score) {
                    if ($score == $max_score) {
                        $top_types[] = $type;
                    }
                }
            }

            // --- CẤU HÌNH MAPPING: MÃ HOLLAND -> MÃ NHÓM NGÀNH (DATABASE) ---
            // Bạn cần kiểm tra cột 'group_code' trong bảng 'majors' để điền cho đúng
            $mapping = [
                'R' => ['code' => 'CK', 'name' => 'Thực tế (Realistic)'],       // Ví dụ: CK = Cơ khí/Kỹ thuật
                'I' => ['code' => 'IT', 'name' => 'Nghiên cứu (Investigative)'], // Ví dụ: IT = CNTT
                'A' => ['code' => 'NN', 'name' => 'Nghệ thuật (Artistic)'],      // Ví dụ: NN = Năng khiếu/Nghệ thuật
                'S' => ['code' => 'YD', 'name' => 'Xã hội (Social)'],            // Ví dụ: YD = Y Dược/Sư phạm
                'E' => ['code' => 'KT', 'name' => 'Quản lý (Enterprising)'],     // Ví dụ: KT = Kinh tế
                'C' => ['code' => 'KT', 'name' => 'Nghiệp vụ (Conventional)']    // Ví dụ: KT = Kế toán (Chung nhóm Kinh tế)
            ];

            // Vòng lặp lấy ngành cho TỪNG nhóm trong Top
            foreach ($top_types as $type) {
                if (isset($mapping[$type])) {
                    $group_code = $mapping[$type]['code'];
                    $type_name = $mapping[$type]['name'];

                    // Lấy 4 ngành tiêu biểu
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
}
?>