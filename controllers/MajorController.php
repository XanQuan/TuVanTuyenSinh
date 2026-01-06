<?php
class MajorController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function index() {
        // 1. Lấy mã nhóm ưu tiên từ URL (ví dụ: index.php?page=majors&highlight=R)
        $highlight = isset($_GET['highlight']) ? $_GET['highlight'] : null;

        // 2. Lấy toàn bộ danh sách ngành học từ bảng majors
        $sql = "SELECT * FROM majors ORDER BY id ASC";
        $result = $this->conn->query($sql);
        
        $majors = [];
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $majors[] = $row;
            }
        }
        
        // 3. LOGIC SẮP XẾP: Đưa các ngành thuộc nhóm $highlight lên đầu danh sách
        if ($highlight) {
            usort($majors, function($a, $b) use ($highlight) {
                // Nếu ngành a thuộc nhóm highlight và b thì không -> đẩy a lên trước
                if ($a['group_code'] == $highlight && $b['group_code'] != $highlight) {
                    return -1;
                }
                // Ngược lại -> đẩy b lên trước
                if ($a['group_code'] != $highlight && $b['group_code'] == $highlight) {
                    return 1;
                }
                return 0; // Giữ nguyên vị trí nếu cùng nhóm hoặc cùng không thuộc nhóm highlight
            });
        }
        
        // Truyền biến $majors và $highlight sang View
        require 'views/majors/index.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $tuition = $_POST['tuition'];
            $group_code = $_POST['group_code'];

            // Xử lý Upload ảnh
            $image = "default.jpg"; 
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = time() . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], "public/assets/images/" . $image);
            }

            $sql = "INSERT INTO majors (name, description, tuition, image, group_code) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssss", $name, $description, $tuition, $image, $group_code);
            $stmt->execute();
            header("Location: index.php?page=admin&action=majors");
            exit;
        }
    }

    public function detail() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        // Truy vấn lấy thông tin chi tiết ngành
        $stmt = $this->conn->prepare("SELECT * FROM majors WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $major = $stmt->get_result()->fetch_assoc();

        if (!$major) {
            header("Location: index.php?page=majors");
            exit;
        }

        // Gọi view chi tiết
        require 'views/majors/detail.php';
    }
}