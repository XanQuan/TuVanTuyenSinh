<?php
// controllers/AdviceController.php
require_once 'models/AdviceModel.php';

class AdviceController {
    private $model;
    private $conn; 

    public function __construct($conn) {
        $this->conn = $conn; 
        $this->model = new AdviceModel($conn);
    }

    // 1. Trang chủ mặc định
    public function index() {
        // --- THÊM ĐOẠN NÀY ĐỂ LẤY NGÀNH ---
        $major_groups = $this->getMajorGroups(); 
        
        // Mặc định vào trang chủ chưa có kết quả
        require 'views/home/index.php';
    }

    // 2. Xử lý tra cứu (Và lưu lịch sử)
    // controllers/AdviceController.php

public function result() {
    $results = null;
    $searchScore = "";
    $searchGroup = "";

    // Luôn lấy danh sách nhóm ngành để hiển thị lại Select box
    $major_groups = $this->getMajorGroups();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lấy dữ liệu từ form (cả form trang chủ và form "Tra lại" ở lịch sử)
        $searchScore = isset($_POST['score']) ? floatval($_POST['score']) : 0;
        $searchGroup = isset($_POST['group']) ? $_POST['group'] : "";
        
        if ($searchScore > 0 && !empty($searchGroup)) {
            // A. Gọi Model để lấy kết quả tư vấn
            $results = $this->model->getAdvice($searchScore, $searchGroup);

            // B. LƯU LỊCH SỬ (Chỉ lưu nếu đây là lượt tra cứu mới, 
            // tránh trùng lặp khi bấm "Tra lại" từ trang lịch sử nếu muốn)
            // Nếu bạn vẫn muốn lưu mỗi khi bấm "Tra lại", giữ nguyên đoạn code dưới:
            if (isset($_SESSION['user'])) {
                $user_id = $_SESSION['user']['id'];
                $sql = "INSERT INTO search_history (user_id, score, group_code) VALUES (?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ids", $user_id, $searchScore, $searchGroup);
                $stmt->execute();
            }
        }
    }

    // Quan trọng: Phải truyền các biến này ra View
    require 'views/home/index.php';
}

    // --- HÀM PHỤ TRỢ ĐỂ LẤY DỮ LIỆU TỪ DATABASE ---
    private function getMajorGroups() {
        $sql = "SELECT * FROM major_groups WHERE status = 1 ORDER BY group_name ASC";
        $res = $this->conn->query($sql);
        $groups = [];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $groups[] = $row;
            }
        }
        return $groups;
    }

    // 3. Xem lịch sử tra cứu
   public function history() {
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?page=login");
        exit;
    }

    $user_id = $_SESSION['user']['id'];
    
    // Lấy danh sách nhóm ngành cho bộ lọc
    $major_groups = $this->getMajorGroups();

    // Xây dựng câu SQL có bộ lọc
    $sql = "SELECT * FROM search_history WHERE user_id = ?";
    $params = [$user_id];
    $types = "i";

    // 1. Lọc theo ngày
    if (!empty($_GET['filter_date'])) {
        $sql .= " AND DATE(created_at) = ?";
        $params[] = $_GET['filter_date'];
        $types .= "s";
    }

    // 2. Lọc theo điểm (Lấy các kết quả >= điểm nhập)
    if (!empty($_GET['filter_score'])) {
        $sql .= " AND score >= ?";
        $params[] = $_GET['filter_score'];
        $types .= "d";
    }

    // 3. Lọc theo ngành
    if (!empty($_GET['filter_group'])) {
        $sql .= " AND group_code = ?";
        $params[] = $_GET['filter_group'];
        $types .= "s";
    }

    $sql .= " ORDER BY created_at DESC";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $history_list = [];
    while($row = $result->fetch_assoc()) {
        $history_list[] = $row;
    }

    require 'views/home/history.php';
}
}
?>