<?php
session_start();
require_once '../controllers/CameraController.php';
require_once '../controllers/CategoryController.php';
require_once '../controllers/index.php';

$controllerCamera = new CameraController();
$controllerCategory = new CategoryController();

$categories = $controllerCategory->getCategories();
$resultSearch = $controllerCamera->searchCamera();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$showCode = false;
if (isset($_POST['show-code'])){
    $showCode = !$showCode;
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $cameras = $controllerCamera->getCamerasById($id);
}
if (isset($_GET['MaTheLoai'])) {
    $categoryId = $_GET['MaTheLoai'];
    $cameras = $controllerCamera->getCamerasByCategory($categoryId);
} else {
    $cameras = $controllerCamera->getCameras();
}
if (isset($_POST['submit-searchByName']) || isset($_POST['submit-searchByPrice']) || isset($_POST['submit-searchByCategory']) || isset($_POST['submit-searchByDate'])) {
    if (isset($resultSearch)) {
        $cameras = $resultSearch;
    } else if (!isset($resultSearch) && isset($_GET['MaTheLoai'])) {
        $categoryId = $_GET['MaTheLoai'];
        $cameras = $controllerCamera->getCamerasByCategory($categoryId);
    } else if (!isset($resultSearch) && !isset($_GET['MaTheLoai'])) {
        $cameras = $controllerCamera->getCameras();
    }
}

// Lấy thông tin người dùng từ session
$user = $_SESSION['user'];

// Phân quyền
$is_admin = $user['role'] == 'administrator';

// Nếu có yêu cầu logout
if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    header("location: login.php");
    exit;
}

?>
<html>

<head>
    <title>Danh sách máy ảnh</title>
    <link rel="stylesheet" href="css/camera.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
</head>

<body>
    <div class="container">
        <div class="page-header">
            <?php if (isset($_GET['MaTheLoai'])) : ?>
                <h1>Máy ảnh thuộc mã thể loại <?= $categoryId; ?></h1>
            <?php else : ?>
                <h1>Danh sách máy ảnh</h1>
            <?php endif; ?>
        </div>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert-success"><?php echo $_SESSION['success']; ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php } ?>
        <form method="post">
            <input class="btn btn-default" type="submit" name="reload" value="Làm mới">
            <?php if ($is_admin) : ?>
                <a href="add-camera.php" class="btn btn-success" id="add-camera">Thêm sản phẩm</a>
            <?php endif; ?>
            <input class="btn btn-default" type="submit" name="show-code" value="Tìm kiếm">
        </form>

        <?php if ($showCode) : ?>
            <div class="well well-sm">
                <p>Tìm kiếm theo tên máy ảnh</p>
                <form method="post" class="form-inline">
                    <input class="form-control" type="text" name="searchByName" placeholder="Nhập tên máy ảnh cần tìm" required>
                    <button type="submit" name="submit-searchByName" class="btn btn-default">Tìm kiếm</button>
                </form>
            </div>
            <div class="well well-sm">
                <p>Tìm kiếm theo khoảng giá</p>
                <form method="post" class="form-inline">
                    <input class="form-control" type="number" min="1" name="minPrice" placeholder="Giá thấp nhất" required>
                    <input class="form-control" type="number" min="1" name="maxPrice" placeholder="Giá cao nhất" required>
                    <button type="submit" name="submit-searchByPrice" class="btn btn-default">Tìm kiếm</button>
                </form>
            </div>
            <div class="well well-sm">
                <p>Tìm kiếm theo thể loại máy ảnh</p>
                <form method="post" class="form-inline">
                    <select name="maTheLoai">
                        <option value="tat-ca">Tất cả</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?= $category['MaTheLoai']; ?>"><?= $category['TenHang']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="submit-searchByCategory" class="btn btn-default">Tìm kiếm</button>
                </form>
            </div>
            <div class="well well-sm">
                <p>Tìm kiếm theo ngày phát hành</p>
                <form method="post" class="form-inline">
                    <input class="form-control" type="date" name="startDate" placeholder="Ngày bắt đầu" required>
                    <input class="form-control" type="date" name="endDate" placeholder="Ngày kết thúc" required>
                    <button type="submit" name="submit-searchByDate" class="btn btn-default">Tìm kiếm</button>
                </form>
            </div>
        <?php endif; ?>
        <div class="products-list">
            <?php foreach ($cameras as $camera) : ?>
                <div class="product">
                    <img src="<?= $camera['HinhAnh']; ?>" alt="<?= $camera['TenMayAnh']; ?>">
                    <h2><?= $camera['TenMayAnh']; ?></h2>
                    <p>Mã thể loại: <?= $camera['MaTheLoai']; ?></p>
                    <p>Thông số kỹ thuật: <?= $camera['ThongSoKyThuat']; ?></p>
                    <p>Ngày phát hành: <?= $camera['NgayPhatHanh']; ?></p>
                    <p class="price"><?= number_format($camera['Gia'], 0, '', '.'); ?>$</p>
                    <?php if ($is_admin) : ?>
                        <a href="?action=delete_camera&id=<?php echo $camera['id']; ?>" class="btn btn-danger">Xóa sản phẩm</a>
                        <a href="update-camera.php?id=<?php echo $camera['id']; ?>" class="btn btn-success">Sửa sản phẩm</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (isset($_POST['submit-searchByName']) || isset($_POST['submit-searchByPrice']) || isset($_POST['submit-searchByCategory']) || isset($_POST['submit-searchByDate'])) : ?>
            <?php if (empty($resultSearch)) : ?>
                <p> Không tìm thấy sản phẩm nào</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>

</html>