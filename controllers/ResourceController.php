<?php
class ResourceController {
    private $conn;
    public function __construct($db) { $this->conn = $db; }
    
    public function index() {
        $sql = "SELECT * FROM resources";
        $result = $this->conn->query($sql);
        $resources = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) $resources[] = $row;
        }
        require 'views/resources/index.php';
    }
}
?>