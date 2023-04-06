<?php
    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/config.php';

    if(isset($_SESSION['user'])) {
        header("location: home.php");
        exit;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once '../controllers/UserController.php';
        $userController = new UserController($conn);
        $userController->login();
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Đăng nhập</title>
	<!-- Tải các file CSS của Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<!-- Tải các file JS của Bootstrap -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container mt-5">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<h2 class="text-center">Đăng nhập</h2>
					</div>
					<div class="card-body">
						<?php
							if(isset($_SESSION['error'])) {
								echo '<div class="alert alert-danger">'.$_SESSION['error'].'</div>';
							}
						?>
						<form method="post">
							<div class="form-group">
								<label for="username">Tên đăng nhập:</label>
								<input type="text" class="form-control" name="username" value="admin" required>
							</div>
							<div class="form-group">
								<label for="password">Mật khẩu:</label>
								<input type="password" class="form-control" name="password" value="1" required>
							</div>
							<div class="form-group text-center">
								<input type="submit" class="btn btn-primary" value="Đăng nhập">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

