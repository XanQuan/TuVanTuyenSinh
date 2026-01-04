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
        // Lấy danh sách câu hỏi ngẫu nhiên
        $sql = "SELECT * FROM questions ORDER BY RAND()"; 
        $result = $this->conn->query($sql);
        
        $questions = [];
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $questions[] = $row;
            }
        }
        
        // Truyền thông báo lỗi (nếu có) sang View
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']); 

        require 'views/assessment/test.php';
    }

    // 2. Xử lý nộp bài (Chấm điểm)
    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $answers = $_POST['answers'] ?? [];
            
            // --- VALIDATION: Bắt buộc phải chọn đáp án mới được nộp ---
            if (empty($answers)) {
                $_SESSION['error'] = "Bạn chưa chọn đáp án nào. Vui lòng hoàn thành bài trắc nghiệm!";
                header("Location: index.php?page=assessment");
                exit;
            }

            // Khởi tạo điểm
            $scores = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];

            // Tính điểm
            foreach ($answers as $group_code) {
                if (isset($scores[$group_code])) {
                    $scores[$group_code]++;
                }
            }

            // Tìm nhóm điểm cao nhất để lưu vào DB (Dùng làm đại diện chính)
            arsort($scores); 
            $dominant = array_key_first($scores);

            // Lưu vào Database
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
            
            // Nếu lỗi
            $_SESSION['error'] = "Có lỗi xảy ra khi lưu kết quả. Thử lại sau.";
            header("Location: index.php?page=assessment");
            exit;
        }
    }

    // 3. Hiển thị Kết quả & Gợi ý ngành
    public function result() {
        $id = $_GET['id'] ?? 0;
        $user_id = $_SESSION['user']['id'];

        // Lấy kết quả từ Database
        $sql = "SELECT * FROM assessment_results WHERE id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        $result_data = $stmt->get_result()->fetch_assoc();

        // Biến $result sẽ được dùng bên View
        $result = $result_data; 
        $suggested_majors = [];

        if ($result) {
            $dominant = $result['dominant_type']; 
            $group_search = '';

            // --- MAPPING HOLLAND -> MÃ NHÓM NGÀNH TRONG DB ---
            // Hãy đảm bảo các mã 'CK', 'IT'... khớp với cột group_code trong bảng majors của bạn
            switch ($dominant) {
                case 'R': $group_search = 'CK'; break; // Realistic -> Cơ khí/Kỹ thuật
                case 'I': $group_search = 'IT'; break; // Investigative -> CNTT/Khoa học
                case 'A': $group_search = 'NN'; break; // Artistic -> Nghệ thuật/Báo chí
                case 'S': $group_search = 'YD'; break; // Social -> Sư phạm/Y dược
                case 'E': $group_search = 'KT'; break; // Enterprising -> Kinh tế/Quản lý
                case 'C': $group_search = 'KT'; break; // Conventional -> Tài chính/Kế toán
                default:  $group_search = 'IT';
            }

            // Lấy danh sách ngành gợi ý (Lấy 6 ngành)
            if ($group_search) {
                $sql_majors = "SELECT * FROM majors WHERE group_code = ? LIMIT 6";
                $stmt_m = $this->conn->prepare($sql_majors);
                $stmt_m->bind_param("s", $group_search);
                $stmt_m->execute();
                $res_m = $stmt_m->get_result();
                while ($row = $res_m->fetch_assoc()) {
                    $suggested_majors[] = $row;
                }
            }
        }

        require 'views/assessment/result.php';
    }
}
?>