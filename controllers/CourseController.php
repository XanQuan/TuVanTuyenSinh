<?php
class CourseController {
    private $conn;
    public function __construct($db) { $this->conn = $db; }

    public function index() {
        // 1. Lấy dữ liệu từ bảng majors (vì hình MySQL của bạn dùng bảng này)
        $sql = "SELECT * FROM majors ORDER BY id DESC"; 
        $result = $this->conn->query($sql);

        $courses = []; 
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Map dữ liệu từ DB sang mảng $courses để file View người dùng hiểu được
                $courses[] = [
                    'title'       => $row['name'],         // Cột 'name' trong DB
                    'description' => $row['description'],  // Cột 'description' trong DB
                    'price'       => $row['tuition'],      // Cột 'tuition' trong DB
                    'image'       => 'course-01.jpg',      // Ảnh mặc định
                    'teacher'     => 'UniGuide',
                    'rating'      => $row['job_rating']    // Cột 'job_rating' trong DB
                ];
            }
        }
        
        // 2. PHẢI gọi file View của người dùng (không phải file admin)
        require 'views/courses/index.php'; 
    }
}
?>