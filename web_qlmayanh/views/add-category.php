<?php
require_once '../controllers/index.php';
require_once '../controllers/CategoryController.php';

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
    <title>Thêm thể loại</title>

    <!-- Link tới file CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Thêm thể loại mới</h1>
        <div class="error-msg" id="error-message"><?php echo isset($_SESSION['error_msg']) ? $_SESSION['error_msg'] : ''; ?>
        </div>
        <form method="post" action="?action=add_category">
            <div class="form-group">
                <label for="MaTheLoai">Mã thể loại:</label>
                <input type="text" class="form-control" id="MaTheLoai" name="MaTheLoai" required>
            </div>
            <div class="form-group">
                <label for="TenHang">Tên hãng:</label>
                <input type="text" class="form-control" id="TenHang" name="TenHang" required>
            </div>
            <div class="form-group">
                <label for="TrangThai">Trạng thái:</label>
                <select class="form-control" id="TrangThai" name="TrangThai" required>
                    <option value="Không hoạt động">Không hoạt động</option>
                    <option value="Hoạt động">Hoạt động</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Thêm</button>
            <a href="/views/home.php">Chuyển hướng đến trang Home</a>
            <div class="error-message"></div>
        </form>
    </div>

</body>
</html>

