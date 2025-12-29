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
}
?>