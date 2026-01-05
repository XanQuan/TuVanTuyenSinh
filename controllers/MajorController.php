<?php
class MajorController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function index() {
        // Lấy toàn bộ danh sách ngành học từ bảng majors
        $sql = "SELECT * FROM majors ORDER BY id ASC";
        $result = $this->conn->query($sql);
        
        $majors = [];
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $majors[] = $row;
            }
        }
        
        // Truyền biến $majors sang View
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
}