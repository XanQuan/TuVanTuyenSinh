<?php
class CourseController {
    private $conn;
    public function __construct($db) { $this->conn = $db; }
public function index() {
    // 1. Sửa 'courses' thành 'majors'
    $sql = "SELECT * FROM majors ORDER BY id DESC"; 
    $result = $this->conn->query($sql);

    $courses = []; // Khởi tạo mảng khớp với biến ở View
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Chuyển đổi tên cột từ DB sang tên cột View đang dùng
            $courses[] = [
                'title'       => $row['name'],         // DB dùng 'name'
                'description' => $row['description'],  // DB dùng 'description'
                'price'       => $row['tuition'],      // DB dùng 'tuition'
                'image'       => 'course-01.jpg',      // Ảnh mặc định
                'teacher'     => 'UniGuide',
                'rating'      => $row['job_rating']    // DB dùng 'job_rating'
            ];
        }
    }
    require 'views/courses/index.php';
}
}
?>