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
        // Bộ câu hỏi Holland Code ngắn gọn (18 câu - 3 câu mỗi nhóm)
        $questions = [
            ['id' => 1, 'group' => 'R', 'text' => 'Thích làm việc với các công cụ, máy móc, thiết bị kỹ thuật.'],
            ['id' => 2, 'group' => 'R', 'text' => 'Thích sửa chữa đồ đạc, lắp ráp linh kiện.'],
            ['id' => 3, 'group' => 'R', 'text' => 'Thích các hoạt động ngoài trời, vận động chân tay.'],
            
            ['id' => 4, 'group' => 'I', 'text' => 'Thích tìm hiểu nguyên lý hoạt động của mọi vật.'],
            ['id' => 5, 'group' => 'I', 'text' => 'Thích giải các câu đố, bài toán khó, tư duy logic.'],
            ['id' => 6, 'group' => 'I', 'text' => 'Thích nghiên cứu khoa học, đọc sách chuyên sâu.'],

            ['id' => 7, 'group' => 'A', 'text' => 'Thích sáng tạo, vẽ tranh, chơi nhạc cụ hoặc viết lách.'],
            ['id' => 8, 'group' => 'A', 'text' => 'Thích sự tự do, không gò bó theo khuôn mẫu.'],
            ['id' => 9, 'group' => 'A', 'text' => 'Thích cái đẹp, có khả năng thẩm mỹ tốt.'],

            ['id' => 10, 'group' => 'S', 'text' => 'Thích giúp đỡ, chăm sóc, dạy dỗ người khác.'],
            ['id' => 11, 'group' => 'S', 'text' => 'Thích giao tiếp, kết bạn, làm việc nhóm.'],
            ['id' => 12, 'group' => 'S', 'text' => 'Thích tham gia các hoạt động cộng đồng, thiện nguyện.'],

            ['id' => 13, 'group' => 'E', 'text' => 'Thích lãnh đạo, thuyết phục người khác nghe theo mình.'],
            ['id' => 14, 'group' => 'E', 'text' => 'Thích kinh doanh, buôn bán, kiếm tiền.'],
            ['id' => 15, 'group' => 'E', 'text' => 'Thích sự cạnh tranh, dám chấp nhận rủi ro.'],

            ['id' => 16, 'group' => 'C', 'text' => 'Thích sự ngăn nắp, trật tự, quy trình rõ ràng.'],
            ['id' => 17, 'group' => 'C', 'text' => 'Thích làm việc với con số, sổ sách, dữ liệu chi tiết.'],
            ['id' => 18, 'group' => 'C', 'text' => 'Thích sự ổn định, an toàn, tuân thủ quy tắc.']
        ];
        
        require 'views/assessment/test.php';
    }

    // 2. Xử lý kết quả (Chấm điểm)
    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $answers = $_POST['answers'] ?? [];
            
            // Khởi tạo điểm
            $scores = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];

            // Tính điểm (Mỗi câu tick = 1 điểm)
            foreach ($answers as $group) {
                if (isset($scores[$group])) {
                    $scores[$group]++;
                }
            }

            // Tìm nhóm điểm cao nhất
            $max_score = -1;
            $dominant = '';
            foreach ($scores as $key => $val) {
                if ($val > $max_score) {
                    $max_score = $val;
                    $dominant = $key;
                }
            }

            // Lưu vào Database
            $user_id = $_SESSION['user']['id'];
            $sql = "INSERT INTO assessment_results (user_id, r_score, i_score, a_score, s_score, e_score, c_score, dominant_type) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiiiiiis", $user_id, $scores['R'], $scores['I'], $scores['A'], $scores['S'], $scores['E'], $scores['C'], $dominant);
            $stmt->execute();
            $result_id = $stmt->insert_id;

            // Chuyển hướng sang trang kết quả
            header("Location: index.php?page=assessment&action=result&id=$result_id");
            exit;
        }
    }

    // 3. Hiển thị Kết quả & Gợi ý ngành
    public function result() {
        $id = $_GET['id'];
        $user_id = $_SESSION['user']['id'];

        // Lấy kết quả từ DB
        $sql = "SELECT * FROM assessment_results WHERE id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if (!$result) die("Không tìm thấy kết quả!");

        // Logic gợi ý ngành dựa trên nhóm cao nhất
        $dominant = $result['dominant_type'];
        $suggestion_sql = "";
        
        // Mapping nhóm tính cách -> mã nhóm ngành trong bảng majors (DB của bạn)
        // Bạn cần đảm bảo bảng majors có cột 'group_code' khớp hoặc dùng LIKE
        switch ($dominant) {
            case 'R': $group_search = 'CK'; break; // Kỹ thuật - Cơ khí
            case 'I': $group_search = 'IT'; break; // Công nghệ / Nghiên cứu (IT là ví dụ)
            case 'A': $group_search = 'NN'; break; // Nghệ thuật / Ngôn ngữ
            case 'S': $group_search = 'YD'; break; // Xã hội (Y dược, giáo dục...)
            case 'E': $group_search = 'KT'; break; // Kinh tế / Quản lý
            case 'C': $group_search = 'KT'; break; // Nghiệp vụ (Kế toán...)
            default: $group_search = '';
        }

        $suggested_majors = [];
        if ($group_search) {
            // Lấy 5 ngành gợi ý
            $sql_majors = "SELECT * FROM majors WHERE group_code = ? LIMIT 5";
            $stmt_m = $this->conn->prepare($sql_majors);
            $stmt_m->bind_param("s", $group_search);
            $stmt_m->execute();
            $res_m = $stmt_m->get_result();
            while ($row = $res_m->fetch_assoc()) $suggested_majors[] = $row;
        }

        require 'views/assessment/result.php';
    }
}
?>