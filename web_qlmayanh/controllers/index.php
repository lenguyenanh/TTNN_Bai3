<?php
// index.php
require_once '../models/CategoryModel.php';
require_once 'CategoryController.php';
require_once 'CameraController.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

$categoryController = new CategoryController();
$cameraController = new CameraController();

switch ($action) {
    case 'add_category':
        $categoryController->addCategory();
        break;
    case 'update_category':
        $categoryController->updateCategory();
        break;
    case 'delete_category':
        $categoryController->deleteCategory();
        break;
    case 'add_camera':
        $cameraController->addCamera();
        break;
    case 'delete_camera':
        $cameraController->deleteCamera();
        break;
    case 'update_camera':
        $cameraController->updateCamera();
        break;
    default:
        $categoryController->getCategories();
        break;
}
