<?php
// controllers/AdviceController.php
require_once 'models/AdviceModel.php';

class AdviceController {
    private $model;
    private $conn; // Thêm biến kết nối để dùng cho việc lưu lịch sử

    public function __construct($conn) {
        $this->conn = $conn; // Lưu kết nối vào biến class
        $this->model = new AdviceModel($conn);
    }

    // 1. Trang chủ mặc định
    public function index() {
        // Mặc định vào trang chủ chưa có kết quả
        require 'views/home/index.php';
    }

    // 2. Xử lý tra cứu (Và lưu lịch sử)
    public function result() {
        $results = null;
        $searchScore = "";
        $searchGroup = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $searchScore = floatval($_POST['score']);
            $searchGroup = $_POST['group'];
            
            // A. Gọi Model để lấy kết quả tư vấn
            $results = $this->model->getAdvice($searchScore, $searchGroup);

            // B. 🔥 LƯU LỊCH SỬ (Nếu đã đăng nhập)
            if (isset($_SESSION['user'])) {
                $user_id = $_SESSION['user']['id'];
                
                // Câu lệnh INSERT vào bảng search_history
                $sql = "INSERT INTO search_history (user_id, score, group_code) VALUES (?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                // i: integer, d: double(float), s: string
                $stmt->bind_param("ids", $user_id, $searchScore, $searchGroup);
                $stmt->execute();
            }
        }

        // Hiển thị lại trang chủ kèm kết quả
        require 'views/home/index.php';
    }

    // 3. Xem lịch sử tra cứu
    public function history() {
        // Bắt buộc đăng nhập mới xem được
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $user_id = $_SESSION['user']['id'];

        // Lấy danh sách lịch sử (Mới nhất lên đầu)
        $sql = "SELECT * FROM search_history WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $history_list = [];
        while($row = $result->fetch_assoc()) {
            $history_list[] = $row;
        }

        // Gọi View hiển thị lịch sử
        require 'views/home/history.php';
    }
}
?>