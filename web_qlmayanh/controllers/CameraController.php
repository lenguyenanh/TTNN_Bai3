<?php
require_once '../models/CameraModel.php';

class CameraController
{
    private $model;

    public function __construct()
    {
        $this->model = new CameraModel();
    }

    public function getCamerasByCategory($categoryId)
    {
        return $this->model->getCamerasByCategory($categoryId);
    }
    public function getCamerasById($id)
    {
        return $this->model->getCameraById($id);
    }
    public function getCameras()
    {
        return $this->model->getCameras();
    }
    public function searchCamera()
    {
        if (isset($_POST['submit-searchByName'])) {
            $name = isset($_POST['searchByName']) ? $_POST['searchByName'] : '';
            $camera = $this->model->searchByName($name);
        } else if (isset($_POST['submit-searchByPrice'])) {
            $minPrice = isset($_POST['minPrice']) ? $_POST['minPrice'] : '';
            $maxPrice = isset($_POST['maxPrice']) ? $_POST['maxPrice'] : '';
            $camera = $this->model->searchByPrice($minPrice, $maxPrice);
        } else if (isset($_POST['submit-searchByCategory'])) {
            $maTheLoai = isset($_POST['maTheLoai']) ? $_POST['maTheLoai'] : '';
            if ($maTheLoai == 'tat-ca') {
                header("Location: /views/cameras.php");
                $camera = $this->getCameras();
            } else {
                $camera = $this->model->searchByCategory($maTheLoai);
            }
        } else if (isset($_POST['submit-searchByDate'])) {
            $startDate = isset($_POST['startDate']) ? $_POST['startDate'] : '';
            $endDate = isset($_POST['endDate']) ? $_POST['endDate'] : '';
            $camera = $this->model->searchByReleaseDate($startDate, $endDate);
        }
        if (isset($camera)) {
            return $camera;
        }
    }

    public function addCamera()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $target_dir = "images/";
            $target_file = $target_dir . basename($_FILES["HinhAnh"]["name"]);
            move_uploaded_file($_FILES["HinhAnh"]["tmp_name"], $target_file);

            $camera = array(
                'MaTheLoai' => $_POST['MaTheLoai'],
                'TenMayAnh' => $_POST['TenMayAnh'],
                'ThongSoKyThuat' => $_POST['ThongSoKyThuat'],
                'Gia' => $_POST['Gia'],
                'NgayPhatHanh' => $_POST['NgayPhatHanh'],
                'HinhAnh' => $target_file
            );
            try {
                $this->model->addCamera($camera);
                header("Location: /views/cameras.php");
                exit();
            } catch (\Exception $e) {
                echo 'Lỗi: Không thể thêm thể loại có mã trùng';
            }
        }

        require_once '../views/add-camera.php';
    }
    public function deleteCamera()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            try {
                // Xóa máy ảnh và hình ảnh tương ứng
                $camera = $this->model->getCameraById($id);
                $image_path = $_SERVER["DOCUMENT_ROOT"] . "/views/" . $camera['HinhAnh'];
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
                $this->model->deleteCamera($id);
                $_SESSION['success'] = "Xóa máy ảnh thành công";
            } catch (Exception $e) {
                echo $e;
            }

            // Chuyển hướng về trang danh sách danh mục
            header("Location: /views/cameras.php");
            exit;
        }
    }
    public function updateCamera()
    {
        $id = $_POST['id'];
        if (isset($_POST['submit-update-camera'])) {
            $target_dir = "images/";
            $target_file = $target_dir . basename($_FILES["HinhAnh"]["name"]);
            move_uploaded_file($_FILES["HinhAnh"]["tmp_name"], $target_file);
            $camera = array(
                'id' => $_POST['id'],
                'MaTheLoai' => $_POST['MaTheLoai'],
                'TenMayAnh' => $_POST['TenMayAnh'],
                'ThongSoKyThuat' => $_POST['ThongSoKyThuat'],
                'Gia' => $_POST['Gia'],
                'NgayPhatHanh' => $_POST['NgayPhatHanh'],
                'HinhAnh' => $target_file
            );
            try {
                // Lấy thông tin camera trước khi cập nhật
                $old_camera = $this->model->getCameraById($id);

                // Nếu người dùng tải lên một hình ảnh mới thì sẽ xóa hình ảnh cũ
                if ($_FILES["HinhAnh"]["error"] == 0) {
                    $image_path = $_SERVER["DOCUMENT_ROOT"] . "/views/" . $old_camera['HinhAnh'];
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                } else {
                    // Nếu người dùng không tải lên hình ảnh mới thì sẽ giữ lại hình ảnh cũ
                    $camera['HinhAnh'] = $old_camera['HinhAnh'];
                }
                $this->model->updateCamera($camera);
                header("Location: /views/cameras.php?id=" . $_POST['id']);
                exit();
            } catch (\Exception $e) {
                echo 'Lỗi: Không thể cập nhật thông tin máy ảnh';
            }
        }
    }
}
