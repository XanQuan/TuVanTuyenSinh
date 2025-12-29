<?php
class CourseController {
    private $conn;
    public function __construct($db) { $this->conn = $db; }
    
    public function index() {
        // Lấy danh sách khóa học
        $sql = "SELECT * FROM courses ORDER BY id DESC";
        $result = $this->conn->query($sql);
        $courses = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) $courses[] = $row;
        }
        require 'views/courses/index.php';
    }
}
?>