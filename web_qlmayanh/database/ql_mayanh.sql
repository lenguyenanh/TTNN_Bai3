CREATE DATABASE IF NOT EXISTS ql_mayanh;

USE ql_mayanh;

CREATE TABLE IF NOT EXISTS users (
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('user', 'administrator') NOT NULL DEFAULT 'user',
  PRIMARY KEY (username)
);
/*------------------- Thêm dữ liệu cho bảng USERS--------------------------*/
INSERT INTO Users (username, password, role) VALUES 
('user', '1', 'user'),
('admin', '1', 'administrator');
/*--------------------------------------------------------------------------*/

CREATE TABLE IF NOT EXISTS categories (
  id INT NOT NULL AUTO_INCREMENT,
  MaTheLoai VARCHAR(50) CHARACTER SET utf8 COLLATE UTF8_UNICODE_CI NOT NULL ,
  TenHang VARCHAR(255) CHARACTER SET utf8 COLLATE UTF8_UNICODE_CI NOT NULL ,
  TrangThai ENUM('Hoạt động', 'Không hoạt động') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Hoạt động',
  PRIMARY KEY (MaTheLoai),
  UNIQUE (id),
  UNIQUE (MaTheLoai)
);

/*------------------------Thêm dữ liệu cho bảng categories--------------------*/
INSERT INTO Categories (id, MaTheLoai, TenHang, TrangThai) VALUES 
(1, 'CAN', 'Canon', 'Hoạt động'),
(2, 'NIK', 'Nikon', 'Không hoạt động'),
(3, 'SON', 'Sony', 'Hoạt động');
/*----------------------------------------------------------------------------*/


CREATE TABLE IF NOT EXISTS cameras (
  id INT NOT NULL AUTO_INCREMENT,
  MaTheLoai VARCHAR(50) CHARACTER SET utf8 COLLATE UTF8_UNICODE_CI NOT NULL,
  TenMayAnh VARCHAR(255) CHARACTER SET utf8 COLLATE UTF8_UNICODE_CI NOT NULL,
  ThongSoKyThuat TEXT,
  Gia FLOAT NOT NULL,
  NgayPhatHanh DATE,
  HinhAnh VARCHAR(255) CHARACTER SET utf8 COLLATE UTF8_UNICODE_CI,
  PRIMARY KEY (id),
  UNIQUE (id),
  FOREIGN KEY (MaTheLoai) REFERENCES categories(MaTheLoai)
);

/*------------------- Thêm dữ liệu cho bảng cameras----------------------------*/
INSERT INTO Cameras (id, MaTheLoai, TenMayAnh, ThongSoKyThuat, Gia, NgayPhatHanh, HinhAnh) VALUES 
(1, 'CAN', 'Canon EOS R5', '45MP, 8K Video', 3799.00, '2020-07-09', 'images/Canon-EOS-R5.jpg'),
(2, 'NIK', 'Nikon Z7 II', '45.7MP, 4K Video', 2999.00, '2020-11-05', 'images/Nikon-Z7-II.jpg'),
(3, 'SON', 'Sony Alpha a7R IV', '61MP, ISO 100-32000, 10fps, 4K 30fps', 3499.00,'2019-07-16','images/sony-alpha-a7r-mark-4.jpg'),
(4, 'CAN', 'Canon EOS R6', '20.1MP, 4K 60fps', 2499.00, '2020-07-09', 'images/Canon-EOS-R6.jpg'),
(5, 'NIK', 'Nikon D850', '45.7MP, 4K Video', 2796.95, '2017-08-24', 'images/Nikon-D850.jpg'),
(6, 'SON', 'Sony Alpha a7S III', '12.1MP, 4K 120fps', 3498.00,'2020-07-28','images/sony-alpha-a7s-mark-3.jpg'),
(7, 'CAN', 'Canon EOS RP', '26.2MP, 4K Video', 1299.00, '2019-02-14', 'images/Canon-EOS-RP.jpg'),
(8, 'NIK', 'Nikon Z6 II', '24.5MP, 4K Video', 1999.00, '2020-10-14', 'images/Nikon-Z6-II.jpg'),
(9, 'SON', 'Sony Alpha a7 III', '24.2MP, 4K Video', 1998.00, '2018-02-27', 'images/sony-alpha-a7-mark-3.jpg');
/*----------------------------------------------------------------------------*/