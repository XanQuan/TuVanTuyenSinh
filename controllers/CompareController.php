<?php
class CompareController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Trang chọn trường
    public function index() {
        $universities = [];
        $res = $this->conn->query("SELECT id, name FROM universities ORDER BY name ASC");
        while($row = $res->fetch_assoc()) $universities[] = $row;
        
        // Mặc định load tất cả ngành cho lần đầu tiên
        $majors = [];
        $res = $this->conn->query("SELECT id, name FROM majors ORDER BY name ASC");
        while($row = $res->fetch_assoc()) $majors[] = $row;

        require 'views/compare/index.php';
    }

    // 2. API TRẢ VỀ NGÀNH CỦA TRƯỜNG (Cực kỳ quan trọng để sửa lỗi "Lỗi tải dữ liệu")
   public function getMajorsByUni() {
    header('Content-Type: application/json');
    
    // Vì Database của bạn không có bảng university_majors, 
    // chúng ta sẽ lấy toàn bộ ngành từ bảng majors để người dùng chọn.
    $sql = "SELECT id, name FROM majors ORDER BY name ASC";
    $res = $this->conn->query($sql);
    
    $data = [];
    while($row = $res->fetch_assoc()) {
        $data[] = $row;
    }
    
    echo json_encode($data);
    exit;
}
    // 3. Hiển thị kết quả so sánh
    public function result() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uni1_id = (int)$_POST['uni1'];
            $major1_id = (int)$_POST['major1'];
            $uni2_id = (int)$_POST['uni2'];
            $major2_id = (int)$_POST['major2'];

            $info1 = $this->getInfo($uni1_id, $major1_id);
            $scores1 = $this->getScoreHistory($uni1_id, $major1_id);
            $info2 = $this->getInfo($uni2_id, $major2_id);
            $scores2 = $this->getScoreHistory($uni2_id, $major2_id);

            require 'views/compare/result.php';
        } else {
            header("Location: index.php?page=compare");
        }
    }

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
 

// Kiểm tra những trường nào có ngành này
public function checkMajorAjax() {
    header('Content-Type: application/json');
    $major_id = (int)($_GET['major_id'] ?? 0);
    $sql = "SELECT university_id FROM university_majors WHERE major_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $major_id);
    $stmt->execute();
    $ids = [];
    $res = $stmt->get_result();
    while($row = $res->fetch_assoc()) $ids[] = (int)$row['university_id'];
    echo json_encode($ids);
    exit;
}
}