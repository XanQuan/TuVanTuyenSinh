<?php
class MajorController {
    private $conn;
    public function __construct($db) { $this->conn = $db; }
    
    public function index() {
        $sql = "SELECT * FROM majors";
        $result = $this->conn->query($sql);
        $majors = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) $majors[] = $row;
        }
        require 'views/majors/index.php';
    }
    public function store() {
    $title = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['tuition'];
    
    // Xử lý Upload ảnh
    $image = "course-01.jpg"; // Mặc định
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "public/assets/images/" . $image);
    }

    $sql = "INSERT INTO majors (name, description, tuition, image) VALUES (?, ?, ?, ?)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ssss", $title, $description, $price, $image);
    $stmt->execute();
    header("Location: index.php?page=admin&action=majors");
}
}
?>