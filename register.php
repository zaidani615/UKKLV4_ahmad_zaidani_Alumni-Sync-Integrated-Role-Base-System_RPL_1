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

if (isset($_POST['register'])) {
    $username  = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password  = $_POST['password']; 
    $angkatan  = mysqli_real_escape_string($koneksi, $_POST['angkatan']);
    $jurusan   = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    $telepon   = mysqli_real_escape_string($koneksi, $_POST['telepon']);
    $status    = mysqli_real_escape_string($koneksi, $_POST['status_alumni']);
    $alamat    = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $email     = mysqli_real_escape_string($koneksi, $_POST['email']);
    $instagram = mysqli_real_escape_string($koneksi, $_POST['instagram']);
    $cek_username = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($cek_username) > 0) {
        echo "<script>
                alert('Gagal Daftar! Username atau Nama Lengkap tersebut sudah terdaftar di sistem.');
                window.history.back();
              </script>";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $query_user  = "INSERT INTO users (username, password, role) 
                    VALUES ('$username', '$hashed_password', 'alumni')";
    $result_user = mysqli_query($koneksi, $query_user);

    if ($result_user) {
        $query_alumni = "INSERT INTO alumni (nama, angkatan, jurusan, telepon, email, instagram, alamat, status_alumni, tempat_kerja, password) 
                         VALUES ('$username', '$angkatan', '$jurusan', '$telepon', '$email', '$instagram', '$alamat', '$status', '', '$hashed_password')";
        
        if (mysqli_query($koneksi, $query_alumni)) {
            echo "<script>
                    alert('Pendaftaran Berhasil! Akun anda telah aktif. Silakan Login.');
                    window.location='login.php';
                  </script>";
            exit;
        } else {
            echo "<script>alert('Gagal menyimpan profil alumni: " . mysqli_error($koneksi) . "');</script>";
        }
    } else {
        echo "<script>alert('Gagal membuat akun users: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Alumni Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./style/register.css">
</head>
<body>

    <div class="box">
        <img src="img/logo2.png" alt="Logo Sekolah" class="logo-login">
        <h2>DAFTAR AKUN</h2>
        
        <form method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username / Nama Lengkap" required>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Buat Password" required>
            </div>

            <div class="input-group">
                <i class="fas fa-calendar-alt"></i>
                <input type="number" name="angkatan" placeholder="Tahun Angkatan" min="2000" max="2100" required>
            </div>

            <div class="input-group">
                <i class="fas fa-graduation-cap"></i>
                <select name="jurusan" required>
                    <option value="" disabled selected>Pilih Jurusan</option>
                    <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                    <option value="Teknik Komputer Jaringan">Teknik Komputer Jaringan</option>
                    <option value="Teknik Jaringan Akses Telekomunikasi">Teknik Jaringan Akses Telekomunikasi</option>
                    <option value="Animasi">Animasi</option>
                </select>
            </div>

            <div class="input-group">
                <i class="fab fa-whatsapp"></i>
                <input type="text" name="telepon" placeholder="No. WhatsApp (08...)" required>
            </div>

            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email Aktif" required>
            </div>

            <div class="input-group">
                <i class="fab fa-instagram"></i>
                <input type="text" name="instagram" placeholder="Instagram (@...)" autocomplete="off">
            </div>

            <div class="input-group">
                <i class="fas fa-briefcase"></i>
                <select name="status_alumni" required>
                    <option value="" disabled selected>Status Saat Ini</option>
                    <option value="Bekerja">Bekerja</option>
                    <option value="Kuliah">Kuliah</option>
                    <option value="Mencari Kerja">Mencari Kerja</option>
                    <option value="Wirausaha">Wirausaha</option>
                </select>
            </div>

            <div class="input-group" style="position: relative;">
                <i class="fas fa-map-marker-alt"></i>
                <textarea name="alamat" placeholder="Alamat Domisili Sekarang" required></textarea>
            </div>

            <button type="submit" name="register" class="btn-register">DAFTAR SEKARANG</button>
            
            <p class="footer-text">
                Sudah punya akun? <a href="login.php">Masuk ke sini</a>
            </p>
        </form>
    </div>

</body>
</html>