<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maNV = $_POST['Ma_NV'];
    $tenNV = $_POST['Ten_NV'];
    $phai = $_POST['Phai'];
    $noiSinh = $_POST['Noi_Sinh'];
    $maPhong = $_POST['Ma_Phong'];
    $luong = $_POST['Luong'];

    $sql = "INSERT INTO NHANVIEN (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) 
            VALUES ('$maNV', '$tenNV', '$phai', '$noiSinh', '$maPhong', '$luong')";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm nhân viên thành công!";
    } else {
        echo "Lỗi khi thêm nhân viên: " . $conn->error;
    }
}
?>

<form method="POST">
    <input type="text" name="Ma_NV" placeholder="Mã nhân viên" required><br>
    <input type="text" name="Ten_NV" placeholder="Tên nhân viên" required><br>
    <input type="text" name="Phai" placeholder="Phái" required><br>
    <input type="text" name="Noi_Sinh" placeholder="Nơi sinh" required><br>
    <input type="text" name="Ma_Phong" placeholder="Mã phòng" required><br>
    <input type="text" name="Luong" placeholder="Lương" required><br>
    <input type="submit" value="Thêm">
</form>
