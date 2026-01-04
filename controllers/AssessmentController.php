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
        // Lấy danh sách câu hỏi
        $sql = "SELECT * FROM questions ORDER BY RAND()"; 
        $result = $this->conn->query($sql);
        
        $questions = [];
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $questions[] = $row;
            }
        }
        
        // Truyền thông báo lỗi nếu có (từ hàm submit gửi sang)
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']); // Xóa lỗi sau khi đã lấy

        require 'views/assessment/test.php';
    }

    // 2. Xử lý kết quả (Chấm điểm)
    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Nhận mảng answers
            $answers = $_POST['answers'] ?? [];
            
            // --- SỬA LỖI LOGIC TẠI ĐÂY ---
            // Nếu người dùng không chọn đáp án nào -> Không chấm, bắt làm lại
            if (empty($answers)) {
                $_SESSION['error'] = "Bạn chưa chọn đáp án nào. Vui lòng thực hiện bài trắc nghiệm!";
                header("Location: index.php?page=assessment");
                exit;
            }

            $scores = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];

            // Tính điểm
            foreach ($answers as $group_code) {
                if (isset($scores[$group_code])) {
                    $scores[$group_code]++;
                }
            }

            // Tìm nhóm điểm cao nhất
            // Lưu ý: Nếu điểm bằng nhau, arsort giữ thứ tự xuất hiện ban đầu.
            // Bạn có thể thêm logic phụ để ưu tiên nếu muốn.
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
                    // Chuyển hướng sang trang kết quả
                    header("Location: index.php?page=assessment&action=result&id=$result_id");
                    exit;
                } else {
                    $_SESSION['error'] = "Lỗi hệ thống: Không thể lưu kết quả.";
                    header("Location: index.php?page=assessment");
                    exit;
                }
            }
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

        // Nếu không tìm thấy kết quả hoặc ID sai -> View sẽ hiển thị phần "Chưa có kết quả"
        // Nhưng ta vẫn cần khởi tạo biến $suggested_majors rỗng để tránh lỗi View
        $suggested_majors = [];

        if ($result) {
            // Logic Mapping Holland -> Mã nhóm ngành
            // LƯU Ý: Bạn cần kiểm tra lại cột 'group_code' trong bảng 'majors' 
            // xem có đúng là các mã CK, IT, NN... này không nhé.
            $dominant = $result['dominant_type']; 
            $group_search = '';

            switch ($dominant) {
                case 'R': $group_search = 'CK'; break; // Cơ khí - Kỹ thuật
                case 'I': $group_search = 'IT'; break; // Công nghệ thông tin
                case 'A': $group_search = 'NN'; break; // Nghệ thuật - Ngôn ngữ
                case 'S': $group_search = 'YD'; break; // Sư phạm - Y Dược
                case 'E': $group_search = 'KT'; break; // Kinh tế - Quản trị
                case 'C': $group_search = 'KT'; break; // Kế toán (Chung nhóm Kinh tế)
                default:  $group_search = 'IT';
            }

            // Lấy danh sách ngành gợi ý
            if ($group_search) {
                // Lấy tối đa 6 ngành để giao diện đẹp
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

        // Gọi View
        require 'views/assessment/result.php';
    }
}
?>