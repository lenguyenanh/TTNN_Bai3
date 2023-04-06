<?php
//home.php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
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

// Kết nối đến cơ sở dữ liệu
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/config.php';
require_once '../controllers/CategoryController.php';
require_once '../controllers/index.php';

$controller = new CategoryController();
$categories = $controller->getCategories();
$categories_search = $controller->searchCategories();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quản lý thể loại máy ảnh</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
</head>

<body>
    <div class="container">
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php } ?>
        <?php if ($is_admin) : ?>
            <div class="page-header">
                <h1>Quản lý thể loại máy ảnh</h1>
            </div>
        <?php else : ?>
            <div class="page-header">
                <h1>Danh sách thể loại máy ảnh</h1>
            </div>
        <?php endif ?>
        <?php if ($is_admin) : ?>
            <p class="lead">Chào mừng <span style="color:red;"><?php echo $user['username']; ?></span></p>
        <?php else : ?>
            <p class="lead">Chào mừng <span style="color:blue;"><?php echo $user['username']; ?></span></p>
        <?php endif ?>

        <form method="post" action="/controllers/logout.php">
            <button type="submit" name="logout" class="btn btn-default">Đăng xuất</button>
        </form>
        <form method="post">
            <button type="submit" name="reload" class="btn btn-default">Làm mới</button>
        </form>

        <div class="well well-sm">
            <form method="post" action="home.php" class="form-inline">
                <div class="form-group">
                    <label for="keyword-category">Tìm kiếm theo tên:</label>
                    <input type="text" class="form-control" id="keyword-category" name="keyword-category" placeholder="Nhập từ khóa">
                </div>
                <button type="submit" name="submit-search" class="btn btn-default">Tìm kiếm</button>
            </form>
        </div>
        <?php if (isset($_POST['submit-search'])) : ?>
            <?php if (!empty($_POST['keyword-category'])) : ?>
                <div class="categories-search">
                    <p>Kết quả tìm kiếm theo từ khóa "<?= $_POST['keyword-category'] ?>"</p>
                    <?php foreach ($categories_search as $category) : ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">ID: <?= $category['id'] ?></h3>
                            </div>
                            <div class="panel-body">
                                <p>Mã thể loại: <?= $category['MaTheLoai'] ?></p>
                                <p>Tên hãng: <?= $category['TenHang'] ?></p>
                                <p>Trạng thái: <?= $category['TrangThai'] ?></p>
                                <a href="cameras.php?MaTheLoai=<?= $category['MaTheLoai'] ?>" class="btn btn-primary">Xem danh sách</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (isset($_SESSION['error-search-category'])) { ?>
                        <div class="alert alert-danger"><?php echo $_SESSION['error-search-category']; ?></div>
                        <?php unset($_SESSION['error-search-category']); ?>
                    <?php } ?>
                </div>
            <?php else : ?>
                <?php if (isset($_SESSION['error-search-category'])) { ?>
                    <div class="alert alert-danger"><?php echo $_SESSION['error-search-category']; ?></div>
                    <?php unset($_SESSION['error-search-category']); ?>
                <?php } ?>
            <?php endif; ?>
        <?php endif; ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mã thể loại</th>
                    <th>Tên hãng</th>
                    <th>Trạng thái</th>
                    <?php if ($is_admin) : ?>
                        <th>Xóa</th>
                        <th>Sửa</th>
                    <?php endif; ?>
                    <th>Xem danh sách</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category) { ?>
                    <tr>
                        <td><?php echo $category['id']; ?></td>
                        <td><?php echo $category['MaTheLoai']; ?></td>
                        <td><?php echo $category['TenHang']; ?></td>
                        <td><?php echo $category['TrangThai']; ?></td>
                        <?php if ($is_admin) : ?>
                            <td><a href="?action=delete_category&id=<?php echo $category['id']; ?>">Xóa</a></td>
                            <td><a href="update-category.php?id=<?php echo $category['id']; ?>">Sửa</a></td>
                        <?php endif; ?>
                        <td><a href="cameras.php?MaTheLoai=<?php echo $category['MaTheLoai']; ?>">Xem danh sách</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php if ($is_admin) : ?>
            <a href="add-category.php" class="btn btn-success">Thêm thể loại</a>
        <?php endif; ?>

</body>

</html>