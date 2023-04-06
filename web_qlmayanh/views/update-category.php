<?php
require_once '../models/CategoryModel.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/index.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/CategoryController.php';

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];
    $category_model = new CategoryModel();
    $category = $category_model->getCategoryById($category_id);

    if (!$category) {
        die("Thể loại không tồn tại");
    }
} else {
    die("Không có thể loại được chọn");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật thể loại</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Cập nhật thể loại</h1>
        <form method="post" action="?action=update_category">
            <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
            <div class="form-group">
                <label>Mã thể loại:</label>
                <input type="text" class="form-control" name="MaTheLoai" value="<?php echo $category['MaTheLoai']; ?>" readonly="true" required>
            </div>
            <div class="form-group">
                <label>Tên hãng:</label>
                <input type="text" class="form-control" name="TenHang" value="<?php echo $category['TenHang']; ?>" required>
            </div>
            <div class="form-group">
                <label>Trạng thái:</label>
                <select name="TrangThai" class="form-control">
                    <option value="Hoạt động" <?php if ($category['TrangThai'] == 'Hoạt động') echo 'selected'; ?>>Hoạt động</option>
                    <option value="Không hoạt động" <?php if ($category['TrangThai'] == 'Không hoạt động') echo 'selected'; ?>>Không hoạt động</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="update-category">Cập nhật</button>
        </form>
        <?php if (isset($message)) : ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
