<?php
session_start();
require_once '../models/CameraModel.php';
require_once '../controllers/CategoryController.php';
require_once '../controllers/index.php';

$controllerCategory = new CategoryController();
$categories = $controllerCategory->getCategories();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $camera_id = $_GET['id'];
    $camera_model = new CameraModel();
    $camera = $camera_model->getCameraById($camera_id);

    if (!$camera) {
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cập nhật máy ảnh</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="page-header">
            <h1>Cập nhật máy ảnh</h1>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form action="?action=update_camera&id=<?php echo $camera['id']; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $camera['id']; ?>">
                    <div class="form-group">
                        <label for="category">Thể loại:</label>
                        <select id="category" name="MaTheLoai" class="form-control">
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo $category['MaTheLoai']; ?>" <?php if ($category['MaTheLoai'] == $camera['MaTheLoai']) {
                                                                                            echo 'selected';
                                                                                        } ?>>
                                    <?php echo $category['TenHang']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tenmayanh">Tên máy ảnh:</label>
                        <input type="text" id="tenmayanh" name="TenMayAnh" class="form-control" value="<?php echo $camera['TenMayAnh']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="thongsokythuat">Thông số kỹ thuật:</label>
                        <textarea id="thongsokythuat" name="ThongSoKyThuat" class="form-control" required><?php echo $camera['ThongSoKyThuat']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="gia">Giá:</label>
                        <input type="number" id="gia" name="Gia" class="form-control" value="<?php echo $camera['Gia']; ?>" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="ngayphathanh">Ngày phát hành:</label>
                        <input type="date" id="ngayphathanh" name="NgayPhatHanh" class="form-control" value="<?php echo $camera['NgayPhatHanh']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="hinhanh">Hình ảnh:</label>
                        <input type="file" id="hinhanh" name="HinhAnh" class="form-control" accept="images/*">
                    </div>
                    <br><br>
                    <div class="form-group">
                        <img src="<?php echo $camera['HinhAnh']; ?>" alt="Hình ảnh" width="200">
                    </div>
                    <br><br>
                    <button type="submit" name="submit-update-camera" class="btn btn-primary">Cập nhật máy ảnh</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>