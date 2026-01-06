    <?php
    class CompareController {
        private $conn;

        public function __construct($db) {
            $this->conn = $db;
        }

        // 1. Hiển thị trang chọn trường
        public function index() {
            $universities = [];
            // Lấy danh sách trường (Chỉ lấy ID và Name để tránh lỗi)
            $res = $this->conn->query("SELECT id, name FROM universities ORDER BY name ASC");
            if ($res && $res->num_rows > 0) {
                while($row = $res->fetch_assoc()) $universities[] = $row;
            }
            
            require 'views/compare/index.php';
        }

        // 2. API AJAX: Lấy danh sách ngành theo ID trường
        public function getMajorsByUni() {
            header('Content-Type: application/json');
            
            $uni_id = isset($_GET['uni_id']) ? (int)$_GET['uni_id'] : 0;
            $data = [];

            if ($uni_id > 0) {
                // SỬA LỖI: Chỉ lấy m.id và m.name (Tuyệt đối không lấy cột lạ)
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

        // --- HÀM ĐÃ SỬA LỖI: CHỈ LẤY CỘT CƠ BẢN ---
        private function getInfo($uni_id, $major_id) {
            // Tôi đã xóa hết các cột: code, description, career_prospects, tuition...
            // Chỉ giữ lại name để đảm bảo 100% không lỗi dù DB sơ sài cỡ nào.
            
            $sql = "SELECT u.name as uni_name, 
                        m.name as major_name
                    FROM universities u, majors m
                    WHERE u.id = ? AND m.id = ?";
            
            $stmt = $this->conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ii", $uni_id, $major_id);
                $stmt->execute();
                $data = $stmt->get_result()->fetch_assoc();
                
                // Tự tạo dữ liệu giả để giao diện không bị trống (Vì DB bạn không có)
                if ($data) {
                    $data['description'] = "Đang cập nhật mô tả cho ngành " . $data['major_name'];
                    $data['career_prospects'] = "Cơ hội việc làm rộng mở.";
                    $data['tuition'] = "Liên hệ trường";
                    $data['job_rating'] = 5;
                    $data['uni_code'] = "U" . $uni_id; // Mã giả
                }
                return $data;
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