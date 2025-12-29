<?php
class CompareController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Hiển thị trang chọn 2 trường để so sánh
    public function index() {
        // Lấy danh sách Trường ĐH
        $universities = [];
        $res = $this->conn->query("SELECT * FROM universities ORDER BY name ASC");
        while($row = $res->fetch_assoc()) $universities[] = $row;

        // Lấy danh sách Ngành
        $majors = [];
        $res = $this->conn->query("SELECT * FROM majors ORDER BY name ASC");
        while($row = $res->fetch_assoc()) $majors[] = $row;

        require 'views/compare/index.php';
    }

    // 2. Xử lý kết quả so sánh
    public function result() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uni1_id = $_POST['uni1'];
            $major1_id = $_POST['major1'];
            
            $uni2_id = $_POST['uni2'];
            $major2_id = $_POST['major2'];

            // Lấy thông tin Đối tượng 1
            $info1 = $this->getInfo($uni1_id, $major1_id);
            $scores1 = $this->getScoreHistory($uni1_id, $major1_id);

            // Lấy thông tin Đối tượng 2
            $info2 = $this->getInfo($uni2_id, $major2_id);
            $scores2 = $this->getScoreHistory($uni2_id, $major2_id);

            require 'views/compare/result.php';
        } else {
            header("Location: index.php?page=compare");
        }
    }

    // Hàm phụ: Lấy thông tin chi tiết (Tên, Học phí, Rating...)
    private function getInfo($uni_id, $major_id) {
        $sql = "SELECT u.name as uni_name, u.code as uni_code, 
                       m.name as major_name, m.tuition, m.job_rating, m.description
                FROM universities u, majors m
                WHERE u.id = ? AND m.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $uni_id, $major_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Hàm phụ: Lấy lịch sử điểm chuẩn
    private function getScoreHistory($uni_id, $major_id) {
        $sql = "SELECT year, score FROM entry_scores 
                WHERE uni_id = ? AND major_id = ? 
                ORDER BY year ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $uni_id, $major_id);
        $stmt->execute();
        $res = $stmt->get_result();
        
        $data = [];
        while($row = $res->fetch_assoc()) $data[] = $row;
        return $data;
    }
}
?>