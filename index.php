<?php
session_start();
include 'db_connect.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Danh sách nhân viên</title>
    <style>
        .add-button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .add-button i {
            margin-right: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }

        .avatar {
            width: 100px;
            height: 100px;
        }

        .edit-link, .delete-link {
            margin-left: 10px;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination a {
            padding: 8px 12px;
            border: 1px solid #ddd;
            background-color: #f2f2f2;
            text-decoration: none;
            color: #333;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <?php
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
    }

    // Xử lý phân trang
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 5;
    $start = ($page - 1) * $limit;

    $sql = "SELECT n.*, p.Ten_Phong, n.Luong FROM nhanvien n JOIN phongban p ON n.Ma_Phong = p.Ma_Phong LIMIT $start, $limit";
    $result = $conn->query($sql);
    ?>

    <h1>Danh sách nhân viên</h1>
    <!-- Nút Thêm -->
    <?php if ($_SESSION['role'] == 'admin') { ?>
        <a href="add.php" class="add-button"><i class="fas fa-plus"></i>Thêm</a>
    <?php } ?>
    <table>
        <tr>
            <th>Mã NV</th>
            <th>Tên NV</th>
            <th>Nơi sinh</th>
            <th>Giới tính</th>
            <th>Tên phòng</th>
            <th>Lương</th>
            <?php if ($_SESSION['role'] == 'admin') { ?>
                <th>Chức năng</th>
            <?php } ?>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Ma_NV'] . "</td>";
                echo "<td>" . $row['Ten_NV'] . "</td>";
                echo "<td>" . $row['Noi_Sinh'] . "</td>";
                echo "<td>";
                if ($row['Phai'] == 'NAM') {
                    echo '<img src="man.jpg" alt="Man" class="avatar">';
                } else {
                    echo '<img src="woman.jpg" alt="Woman" class="avatar">';
                }
                echo "</td>";
                echo "<td>" . $row['Ma_Phong'] . "</td>";
                echo "<td>" . $row['Luong'] . "</td>";
                if ($_SESSION['role'] == 'admin') {
                    echo '<td>';
                    echo "<a class='edit-link' href='edit.php?id=" . $row['Ma_NV'] . "'>Sửa</a>";
                    echo "<a class='delete-link' href='delete.php?id=" . $row['Ma_NV'] . "'>Xóa</a>";
                    echo '</td>';
                }
                echo "</tr>";
            }
        }
        ?>
    </table>
    <?php
// Tính số trang
$sql_count = "SELECT COUNT(*) AS total FROM NHANVIEN";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_pages = ceil($row_count['total'] / $limit);
?>

<div class="pagination">
    <?php if ($page > 1) { ?>
        <a href="?page=<?php echo ($page - 1); ?>">Trang trước</a>
    <?php } ?>

    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
        <a href="?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
    <?php } ?>

    <?php if ($page < $total_pages) { ?>
        <a href="?page=<?php echo ($page + 1); ?>">Trang sau</a>
    <?php } ?>
</div>