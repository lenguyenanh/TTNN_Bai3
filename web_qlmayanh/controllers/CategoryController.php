<?php
//CategoryController.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/CategoryModel.php';

class CategoryController
{
    private $model;

    public function __construct()
    {
        $model = new CategoryModel();
        $this->model = $model;
    }
    public function getCategories()
    {
        $categories = $this->model->getAllCategories();
        return $categories;
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/home.php';
    }
    public function searchCategories()
    {
        if (isset($_POST['submit-search'])) {
            if(isset($_POST['keyword-category'])){
                $_POST['keyword-category'] = htmlspecialchars($_POST['keyword-category'], ENT_QUOTES);
            }
            $keyword = $_POST['keyword-category'];
            $keyword = strip_tags($keyword);
            //$keyword = "<script>alert('Bạn đã bị tấn công!');</script><br><br><br><br><br><br><br><br>";
            $categories = $this->model->searchCategories($keyword);
            require_once $_SERVER['DOCUMENT_ROOT'] . '/views/home.php';
            if (empty($categories)) {
                $_SESSION['error-search-category'] = 'Không tìm thấy thể loại nào.';
            } else if (empty($_POST['keyword-category'])) {
                $_SESSION['error-search-category'] = 'Vui lòng nhập từ khóa vào ô tìm kiếm';
            }
            return $categories;
        }
    } 
    public function addCategory()
    {
        if (isset($_POST['submit'])) {
            $category = array(
                'MaTheLoai' => $_POST['MaTheLoai'],
                'TenHang' => $_POST['TenHang'],
                'TrangThai' => $_POST['TrangThai']
            );
            try {
                $this->model->addCategory($category);
                header("Location: /views/home.php");
                exit();
            } catch (\Exception $e) {
                $_SESSION['error_msg'] = 'Lỗi: Không thể thêm thể loại có mã trùng';
            }
        }
    }
    public function updateCategory()
    {
        $id = $_POST['id'];
        if (isset($_POST['update-category'])) {
            $updatedCategory = array(
                'id' => $id,
                'MaTheLoai' => $_POST['MaTheLoai'],
                'TenHang' => $_POST['TenHang'],
                'TrangThai' => $_POST['TrangThai']
            );
            $this->model->updateCategory($updatedCategory);
            header("Location: /views/home.php");
            exit();
        }
    }
    public function deleteCategory()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            try {
                // Xóa danh mục
                $this->model->deleteCategory($id);
                $_SESSION['success'] = "Xóa thể loại thành công";
            } catch (Exception $e) {
                $_SESSION['error'] = "Không thể xóa thể loại này vì có máy ảnh thuộc thể loại này";
            }

            // Chuyển hướng về trang danh sách danh mục
            header("Location: /views/home.php");
            exit;
        }
    }
}
