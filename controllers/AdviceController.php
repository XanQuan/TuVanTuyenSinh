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
        // Lấy danh sách nhóm ngành để hiển thị vào Select box
        $major_groups = $this->getMajorGroups(); 
        
        // Mặc định kết quả là null
        $results = null;
        $searchGroup = "";
        $searchScore = 0;

        // KIỂM TRA: Nếu có tham số 'group' truyền từ trang chi tiết qua link GET
        if (isset($_GET['group']) && !empty($_GET['group'])) {
            $searchGroup = $_GET['group'];
            // Giả định khi click từ trang chi tiết, ta muốn xem tất cả trường có ngành đó (nên để điểm mặc định cao)
            $searchScore = 30; 
            
            // Lấy ID người dùng nếu có
            $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;

            // Gọi Model để lấy danh sách trường thuộc nhóm ngành này ngay lập tức
            // Lưu ý: Tùy vào Model, bạn có thể truyền điểm 0 hoặc điểm sàn mặc định
            $results = $this->model->getAdvice($searchScore, $searchGroup, $userId);
        }
        
        require 'views/home/index.php';
    }

    // 2. Xử lý tra cứu (Gọi Model tính toán và lưu lịch sử)
    public function result() {
        $results = null;
        $searchScore = "";
        $searchGroup = "";

        // Luôn lấy danh sách nhóm ngành để hiển thị lại Select box (tránh bị mất khi reload)
        $major_groups = $this->getMajorGroups();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $searchScore = isset($_POST['score']) ? floatval($_POST['score']) : 0;
            $searchGroup = isset($_POST['group']) ? $_POST['group'] : "";
            
            // Lấy ID người dùng nếu đã đăng nhập
            $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;

            if ($searchScore > 0 && !empty($searchGroup)) {
                // Gọi Model để lấy kết quả. 
                // Model sẽ tự động lưu lịch sử nhờ vào tham số $userId được truyền vào
                $results = $this->model->getAdvice($searchScore, $searchGroup, $userId);
            }
        }

        // Hiển thị lại trang chủ kèm theo biến $results
        require 'views/home/index.php';
    }

    // --- HÀM PHỤ TRỢ: LẤY DANH SÁCH NHÓM NGÀNH ---
    private function getMajorGroups() {
        // Lấy các nhóm đang hoạt động (status=1)
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

    // 3. Xem lịch sử tra cứu (Có bộ lọc)
    public function history() {
        // Bắt buộc đăng nhập mới xem được lịch sử
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=auth&action=login");
            exit;
        }

        $user_id = $_SESSION['user']['id'];
        
        // Lấy danh sách nhóm ngành cho bộ lọc tìm kiếm bên sidebar (nếu có)
        $major_groups = $this->getMajorGroups();

        // Xây dựng câu SQL có bộ lọc nâng cao
        $sql = "SELECT * FROM search_history WHERE user_id = ?";
        $params = [$user_id];
        $types = "i"; // i = integer

        // A. Lọc theo ngày
        if (!empty($_GET['filter_date'])) {
            $sql .= " AND DATE(created_at) = ?";
            $params[] = $_GET['filter_date'];
            $types .= "s";
        }

        // B. Lọc theo điểm (Lấy các kết quả >= điểm nhập)
        if (!empty($_GET['filter_score'])) {
            $sql .= " AND score >= ?";
            $params[] = $_GET['filter_score'];
            $types .= "d"; // d = double
        }

        // C. Lọc theo nhóm ngành
        if (!empty($_GET['filter_group'])) {
            $sql .= " AND group_code = ?";
            $params[] = $_GET['filter_group'];
            $types .= "s";
        }

        // Sắp xếp mới nhất lên đầu
        $sql .= " ORDER BY created_at DESC";

        // Thực thi Prepare Statement
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