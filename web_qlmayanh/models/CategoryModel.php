<?php
//CategoryModel.php

class CategoryModel
{
    private $db;

    public function __construct()
    {
        require_once 'config.php';
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    //Lấy danh sách thể loại máy ảnh
    public function getAllCategories()
    {
        $result = $this->db->query("SELECT * FROM categories");
        $categories = $result->fetch_all(MYSQLI_ASSOC);
        return $categories;
    }

    //Tìm kiếm theo tên thể loại máy ảnh
    public function searchCategories($keyword)
    {
        $keyword = '%' . $this->db->real_escape_string($keyword) . '%';
        $result = $this->db->query("SELECT * FROM categories WHERE TenHang LIKE '$keyword'");
        $categories = $result->fetch_all(MYSQLI_ASSOC);
        $this->db->close();
        return $categories;
    }
    public function getCategoryById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $category = $result->fetch_assoc();
        $stmt->close();
        return $category;
    }

    public function addCategory($category)
    {
        $stmt = $this->db->prepare("INSERT INTO categories (MaTheLoai, TenHang, TrangThai) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $category['MaTheLoai'], $category['TenHang'], $category['TrangThai']);
        $stmt->execute();
        $stmt->close();
    }

    public function updateCategory($category)
    {
        $stmt = $this->db->prepare("UPDATE categories SET MaTheLoai=?, TenHang=?, TrangThai=? WHERE id=?");
        $stmt->bind_param("sssi", $category['MaTheLoai'], $category['TenHang'], $category['TrangThai'], $category['id']);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteCategory($id)
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
