<?php
require_once 'config.php';

class CameraModel
{
    private $db;

    public function __construct()
    {
        require_once 'config.php';
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }
    public function getCamerasByCategory($categoryId)
    {
        $sql = "SELECT * FROM cameras WHERE MaTheLoai = '$categoryId'";
        $result = mysqli_query($this->db, $sql);
        $cameras = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $cameras[] = $row;
        }
        return $cameras;
    }
    public function getCameras()
    {
        $sql = "SELECT * FROM cameras";
        $result = mysqli_query($this->db, $sql);
        $cameras = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $cameras[] = $row;
        }
        return $cameras;
    }
    public function getCameraById($id) {
        $stmt = $this->db->prepare("SELECT * FROM cameras WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $camera = $result->fetch_assoc();
        $stmt->close();
        return $camera;
    }
    public function searchByName($name)
    {
        $query = "SELECT * FROM cameras WHERE TenMayAnh LIKE '%$name%'";
        $result = $this->db->query($query);
        $cameras = [];
        while ($row = $result->fetch_assoc()) {
            $cameras[] = $row;
        }
        return $cameras;
    }
    public function searchByPrice($minPrice, $maxPrice)
    {
        $query = "SELECT * FROM cameras WHERE Gia >= $minPrice AND Gia <= $maxPrice";
        $result = $this->db->query($query);
        $cameras = [];
        while ($row = $result->fetch_assoc()) {
            $cameras[] = $row;
        }
        return $cameras;
    }
    public function searchByCategory($maTheLoai)
    {
        $sql = "SELECT * FROM cameras WHERE MaTheLoai = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $maTheLoai);
        $stmt->execute();
        $result = $stmt->get_result();
        $camera = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $camera;
    }
    public function searchByReleaseDate($startDate, $endDate)
    {
        $sql = "SELECT * FROM cameras WHERE NgayPhatHanh >= ? AND NgayPhatHanh <= ?";
        $stmt = $this->db->prepare($sql);
        $startDate = new DateTime($_POST['startDate']);
        $endDate = new DateTime($_POST['endDate']);
        $startDateFormatted = $startDate->format('Y-m-d');
        $endDateFormatted = $endDate->format('Y-m-d');
        $stmt->bind_param('ss', $startDateFormatted, $endDateFormatted);

        $stmt->execute();
        $result = $stmt->get_result();
        $camera = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $camera;
    }
    public function addCamera($camera) {
        $stmt = $this->db->prepare("INSERT INTO cameras (MaTheLoai, TenMayAnh, ThongSoKyThuat, Gia, NgayPhatHanh, HinhAnh) 
            VALUES (?, ?, ?, ?, ?, ?)");
        $NgayPhatHanh = new DateTime($camera['NgayPhatHanh']);
        $formatDate = $NgayPhatHanh->format('Y-m-d');
        $camera['NgayPhatHanh']= $formatDate;
        $stmt->bind_param("ssssss", $camera['MaTheLoai'], $camera['TenMayAnh'], $camera['ThongSoKyThuat'], $camera['Gia'], $camera['NgayPhatHanh'], $camera['HinhAnh']);
        $stmt->execute();
        $stmt->close();
    }
    public function deleteCamera($id)
    {
        $stmt = $this->db->prepare("DELETE FROM cameras WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    public function updateCamera($camera) {
        $stmt = $this->db->prepare("UPDATE cameras SET MaTheLoai=?, TenMayAnh=?, ThongSoKyThuat=?, Gia=?, NgayPhatHanh=?, HinhAnh=? WHERE id=?");
        $NgayPhatHanh = new DateTime($camera['NgayPhatHanh']);
        $formatDate = $NgayPhatHanh->format('Y-m-d');
        $camera['NgayPhatHanh']= $formatDate;
        $stmt->bind_param("ssssssi", $camera['MaTheLoai'], $camera['TenMayAnh'], $camera['ThongSoKyThuat'], $camera['Gia'], $camera['NgayPhatHanh'],$camera['HinhAnh'],$camera['id']);
        $stmt->execute();
    }
    
}
