<?php
session_start(); 
include 'koneksi.php'; 
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit; 

if (isset($_GET['nama']) && $_GET['nama'] != '') {
    $nama = mysqli_real_escape_string($koneksi, $_GET['nama']); 
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$nama'");
    $user  = mysqli_fetch_assoc($query);

    if (!$user) {
        echo "<script>alert('User tidak ditemukan dalam sistem!'); window.location='dashboard_admin.php';</script>";
        exit;
    }
} else {
    header("Location: dashboard_admin.php");
    exit;
}

if (isset($_POST['update_pass'])) {
    $pass_baru = $_POST['new_password'];
    $hashed_baru = password_hash($pass_baru, PASSWORD_DEFAULT);
    $update = mysqli_query($koneksi, "UPDATE users SET password = '$hashed_baru' WHERE username = '$nama'");
    
    if ($update) {
        echo "<script>alert('Password untuk user $nama Berhasil Diperbarui!'); window.location='dashboard_admin.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal memperbarui password! Silakan coba lagi.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password User - Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./style/ganti_password.css">
</head>
<body>

    <div class="box">
        <h2>Ganti Password</h2>
        
        <p class="user-info">User: <strong><?= htmlspecialchars($nama) ?></strong></p>

        <form method="POST">
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="new_password" placeholder="Masukkan Password Baru" required>
            </div>

            <button type="submit" name="update_pass" class="btn-update">SIMPAN PASSWORD BARU</button>
            
            <div class="footer-text">
                <a href="dashboard_admin.php">Kembali ke Dashboard</a>
            </div>
        </form>
    </div>

</body>
</html>