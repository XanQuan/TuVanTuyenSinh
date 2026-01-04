<?php
class CompareController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Hiển thị trang so sánh
    public function index() {
        $universities = [];
        // Lấy danh sách trường
        $res = $this->conn->query("SELECT id, name FROM universities ORDER BY name ASC");
        if ($res && $res->num_rows > 0) {
            while($row = $res->fetch_assoc()) $universities[] = $row;
        }
        
        // TUYỆT ĐỐI KHÔNG LẤY BIẾN $majors Ở ĐÂY NỮA
        // Để ô chọn ngành trống trơn, bắt buộc chọn trường trước
        
        require 'views/compare/index.php';
    }

    // 2. API AJAX: Lấy danh sách ngành theo ID trường
    public function getMajorsByUni() {
        header('Content-Type: application/json');
        
        $uni_id = isset($_GET['uni_id']) ? (int)$_GET['uni_id'] : 0;
        $data = [];

        if ($uni_id > 0) {
            // LOGIC CHUẨN: Chỉ lấy những ngành có liên kết với trường này trong bảng điểm chuẩn
            $sql = "SELECT DISTINCT m.id, m.name 
                    FROM majors m 
                    JOIN entry_scores s ON m.id = s.major_id 
                    WHERE s.uni_id = ? 
                    ORDER BY m.name ASC";
            
            $stmt = $this->conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("i", $uni_id);
                $stmt->execute();
                $res = $stmt->get_result();
                while($row = $res->fetch_assoc()) {
                    $data[] = $row;
                }
            }
        }
        
        echo json_encode($data);
        exit;
    }

    // 3. Xử lý kết quả so sánh
    public function result() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uni1_id = isset($_POST['uni_a']) ? (int)$_POST['uni_a'] : 0;
            $major1_id = isset($_POST['major_a']) ? (int)$_POST['major_a'] : 0;
            
            $uni2_id = isset($_POST['uni_b']) ? (int)$_POST['uni_b'] : 0;
            $major2_id = isset($_POST['major_b']) ? (int)$_POST['major_b'] : 0;

            if ($uni1_id && $major1_id && $uni2_id && $major2_id) {
                // Lấy thông tin
                $info1 = $this->getInfo($uni1_id, $major1_id);
                $scores1 = $this->getScoreHistory($uni1_id, $major1_id);
                
                $info2 = $this->getInfo($uni2_id, $major2_id);
                $scores2 = $this->getScoreHistory($uni2_id, $major2_id);

                require 'views/compare/result.php';
            } else {
                echo "<script>alert('Vui lòng chọn đầy đủ thông tin để so sánh!'); window.history.back();</script>";
            }
        } else {
            header("Location: index.php?page=compare");
        }
    }

    // --- SỬA LỖI TẠI ĐÂY: Đã xóa u.logo khỏi câu lệnh SQL ---
    private function getInfo($uni_id, $major_id) {
        // Chỉ lấy những cột chắc chắn có
        $sql = "SELECT u.name as uni_name, u.code as uni_code,
                       m.name as major_name, m.code as major_code, 
                       m.description, m.career_prospects,
                       m.tuition, m.job_rating
                FROM universities u, majors m
                WHERE u.id = ? AND m.id = ?";
        
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ii", $uni_id, $major_id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }
        return null;
    }

    private function getScoreHistory($uni_id, $major_id) {
        $sql = "SELECT year, score FROM entry_scores 
                WHERE uni_id = ? AND major_id = ? 
                ORDER BY year ASC";
        
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ii", $uni_id, $major_id);
            $stmt->execute();
            $res = $stmt->get_result();
            $data = [];
            while($row = $res->fetch_assoc()) $data[] = $row;
            return $data;
        }
        return [];
    }
}
?>