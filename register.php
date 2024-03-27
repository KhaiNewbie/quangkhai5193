<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký</title>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        .register-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="submit"] {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .login-link {
            text-align: center;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Đăng ký</h2>
        <?php
        session_start();
        include 'db_connect.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];

            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu

            $sql = "INSERT INTO users (username, password, fullname, email) 
                    VALUES ('$username', '$hashed_password', '$fullname', '$email')";

            if ($conn->query($sql) === TRUE) {
                echo '<p style="color: #4CAF50;">Đăng ký thành công!</p>';
                // Redirect đến trang đăng nhập sau khi đăng ký thành công
                header("refresh:2;url=login.php");
                exit();
            } else {
                echo '<p style="color: red;">Lỗi khi đăng ký: ' . $conn->error . '</p>';
            }
        }
        ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Tên đăng nhập" required><br>
            <input type="password" name="password" placeholder="Mật khẩu" required><br>
            <input type="text" name="fullname" placeholder="Họ và tên" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="submit" value="Đăng ký">
        </form>

        <div class="login-link">
            <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
        </div>
    </div>
</body>
</html>
