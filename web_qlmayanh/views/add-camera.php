<?php
require_once '../controllers/CategoryController.php';
require_once '../controllers/index.php';

$controller = new CategoryController();
$categories = $controller->getCategories();

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <!-- CSS của Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="page-header">
            <h1>Thêm máy ảnh</h1>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form action="?action=add_camera" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="category">Thể loại:</label>
                        <select id="category" name="MaTheLoai" class="form-control">
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo $category['MaTheLoai']; ?>"><?php echo $category['TenHang']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tenmayanh">Tên máy ảnh:</label>
                        <input type="text" id="tenmayanh" name="TenMayAnh" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="thongsokythuat">Thông số kỹ thuật:</label>
                        <textarea id="thongsokythuat" name="ThongSoKyThuat" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="gia">Giá:</label>
                        <input type="number" id="gia" name="Gia" min="0" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="ngayphathanh">Ngày phát hành:</label>
                        <input type="date" id="ngayphathanh" name="NgayPhatHanh" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="hinhanh" class="form-label">Hình ảnh:</label>
                        <input type="file" id="hinhanh" name="HinhAnh" class="form-control" accept="images/*" required>
                    </div>
                    <button type="submit" name="submit-add-camera" class="btn btn-primary">Thêm máy ảnh</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript của Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>