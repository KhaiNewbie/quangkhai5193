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

    $sql = "UPDATE NHANVIEN SET Ten_NV='$tenNV', Phai='$phai', Noi_Sinh='$noiSinh', Ma_Phong='$maPhong', Luong='$luong' WHERE Ma_NV='$maNV'";

    if ($conn->query($sql) === TRUE) {
        echo "Sửa nhân viên thành công!";
    } else {
        echo "Lỗi khi sửa nhân viên: " . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM nhanvien WHERE Ma_NV='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $maNV = $row['Ma_NV'];
        $tenNV = $row['Ten_NV'];
        $phai = $row['Phai'];
        $noiSinh = $row['Noi_Sinh'];
        $maPhong = $row['Ma_Phong'];
        $luong = $row['Luong'];
    } else {
        echo "Không tìm thấy nhân viên!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Nhân Viên</title>
</head>

<body>
    <h2>Sửa Thông Tin Nhân Viên</h2>
    <form method="POST">
        <input type="text" name="Ma_NV" placeholder="Mã nhân viên" value="<?php echo $maNV; ?>" required readonly><br>
        <input type="text" name="Ten_NV" placeholder="Tên nhân viên" value="<?php echo $tenNV; ?>" required><br>
        <input type="text" name="Phai" placeholder="Phái" value="<?php echo $phai; ?>" required><br>
        <input type="text" name="Noi_Sinh" placeholder="Nơi sinh" value="<?php echo $noiSinh; ?>" required><br>
        <input type="text" name="Ma_Phong" placeholder="Mã phòng" value="<?php echo $maPhong; ?>" required><br>
        <input type="text" name="Luong" placeholder="Lương" value="<?php echo $luong; ?>" required><br>
        <input type="submit" value="Lưu">
    </form>
</body>

</html>
