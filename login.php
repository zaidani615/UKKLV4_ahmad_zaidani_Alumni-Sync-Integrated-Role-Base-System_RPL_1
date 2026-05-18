<?php
session_start();
include 'koneksi.php';
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: dashboard_admin.php");
    } else {
        header("Location: dashboard_users.php");
    }
    exit; 
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    $user  = mysqli_fetch_assoc($query);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['login']    = true;
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];
        if ($user['role'] == 'admin') {
            header("Location: dashboard_admin.php");
        } else {
            header("Location: dashboard_users.php");
        }
        exit; 
        
    } else {
        echo "<script>
                alert('Username atau password salah!'); 
                window.location='login.php';
              </script>";
        exit; 
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Alumni Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./style/index.css">
</head>
<body>

    <div class="box">
        <img src="img/logo2.png" alt="Logo" class="logo-login">
        <h2>LOGIN</h2>
        
        <form method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            
            <button type="submit" name="login" class="btn-login">MASUK</button>
            
            <p class="footer-text">
                Belum Punya akun? <a href="register.php">Buat Di Sini</a>
            </p>
        </form>
    </div>

</body>
</html>