<?php
class MentorController {
    private $conn;
    public function __construct($db) { $this->conn = $db; }
    
    public function index() {
        $sql = "SELECT * FROM mentors";
        $result = $this->conn->query($sql);
        $mentors = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) $mentors[] = $row;
        }
        require 'views/mentors/index.php';
    }
}
?>