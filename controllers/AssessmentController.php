<?php
class AssessmentController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=auth&action=login");
            exit;
        }
    }

    // 1. Hiển thị bài test
    public function index() {
        $sql = "SELECT * FROM questions ORDER BY RAND()"; // Lấy ngẫu nhiên cho khách quan
        $result = $this->conn->query($sql);
        
        $questions = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $questions[] = $row;
            }
        }
        
        require 'views/assessment/test.php';
    }
    

    // 2. Xử lý kết quả (Chấm điểm)
    public function submit() {if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Nhận mảng answers dạng [question_id => group_code]
            $answers = $_POST['answers'] ?? [];
            
            $scores = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];

            // Tính điểm dựa trên group của câu hỏi được chọn
            foreach ($answers as $group_code) {
                if (isset($scores[$group_code])) {
                    $scores[$group_code]++;
                }
            }

            // Tìm nhóm điểm cao nhất (Logic giữ nguyên)
            arsort($scores); // Sắp xếp giảm dần theo điểm số
            $dominant = array_key_first($scores);

            // Lưu vào Database (Giữ nguyên logic của bạn)
            $user_id = $_SESSION['user']['id'];
            $sql = "INSERT INTO assessment_results (user_id, r_score, i_score, a_score, s_score, e_score, c_score, dominant_type) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiiiiiis", $user_id, $scores['R'], $scores['I'], $scores['A'], $scores['S'], $scores['E'], $scores['C'], $dominant);
            $stmt->execute();
            
            $result_id = $stmt->insert_id;
            header("Location: index.php?page=assessment&action=result&id=$result_id");
            exit;
        }
    }

    // 3. Hiển thị Kết quả & Gợi ý ngành
   public function result() {
    // 1. Kiểm tra đăng nhập
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?page=auth&action=login");
        exit;
    }

    $id = $_GET['id'] ?? 0;
    $user_id = $_SESSION['user']['id'];

    // 2. Lấy kết quả từ Database
    $sql = "SELECT * FROM assessment_results WHERE id = ? AND user_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if (!$result) {
        die("Không tìm thấy kết quả hoặc bạn không có quyền xem.");
    }

    // 3. Logic gợi ý ngành (Mapping Holland -> Mã nhóm ngành)
    $dominant = $result['dominant_type']; // Ví dụ: 'R', 'I', 'A'...
    $group_search = '';

    // LƯU Ý: Mã nhóm ngành bên dưới (CK, IT, NN...) phải khớp với cột 'group_code' trong bảng 'majors' của bạn
    switch ($dominant) {
        case 'R': $group_search = 'CK'; break; // Thực tế -> Cơ khí/Kỹ thuật
        case 'I': $group_search = 'IT'; break; // Nghiên cứu -> CNTT
        case 'A': $group_search = 'NN'; break; // Nghệ thuật -> Ngôn ngữ/Báo chí
        case 'S': $group_search = 'YD'; break; // Xã hội -> Y Dược/Sư phạm
        case 'E': $group_search = 'KT'; break; // Quản lý -> Kinh tế
        case 'C': $group_search = 'KT'; break; // Nghiệp vụ -> Kế toán (Chung nhóm Kinh tế)
        default: $group_search = 'IT';
    }

    // 4. Lấy danh sách ngành gợi ý
    $suggested_majors = [];
    if ($group_search) {
        // Lấy 5 ngành thuộc nhóm đó, hoặc lấy ngẫu nhiên nếu muốn
        $sql_majors = "SELECT * FROM majors WHERE group_code = ? LIMIT 6";
        $stmt_m = $this->conn->prepare($sql_majors);
        $stmt_m->bind_param("s", $group_search);
        $stmt_m->execute();
        $res_m = $stmt_m->get_result();
        while ($row = $res_m->fetch_assoc()) {
            $suggested_majors[] = $row;
        }
    }

    // 5. Gọi View hiển thị
    require 'views/assessment/result.php';
}
}
?>