<?php
session_start(); 
include 'koneksi.php'; 
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'alumni') {
    header("Location: login.php");
    exit; 
}

$username_sekarang = $_SESSION['username'];
$query = mysqli_query($koneksi, "SELECT * FROM alumni WHERE nama = '$username_sekarang'");
$d = mysqli_fetch_array($query);
$email_val      = $d['email'] ?? '';
$telp_val       = $d['telepon'] ?? '';
$ig_val         = $d['instagram'] ?? '';
$status_val     = $d['status_alumni'] ?? '';
$kerja_val      = $d['tempat_kerja'] ?? '';
$alamat_val     = $d['alamat'] ?? '';

if (isset($_POST['update'])) {
    $email_post     = mysqli_real_escape_string($koneksi, $_POST['email']);
    $telepon_post   = mysqli_real_escape_string($koneksi, $_POST['telepon']);
    $instagram_post = mysqli_real_escape_string($koneksi, $_POST['instagram']);
    $status_post    = mysqli_real_escape_string($koneksi, $_POST['status_alumni']);
    $kerja_post     = mysqli_real_escape_string($koneksi, $_POST['tempat_kerja']);
    $alamat_post    = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $update = mysqli_query($koneksi, "UPDATE alumni SET 
                email = '$email_post',
                telepon = '$telepon_post',
                instagram = '$instagram_post',
                status_alumni = '$status_post',
                tempat_kerja = '$kerja_post',
                alamat = '$alamat_post'
                WHERE nama = '$username_sekarang'");
            
    if ($update) {
        echo "<script>
                alert('Data profil berhasil diperbarui!'); 
                window.location.href='dashboard_users.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui data! Periksa kembali struktur tabel database anda.');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil Saya</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./style/register.css"> 
    <style>
        .readonly-input { background-color: rgba(255, 255, 255, 0.1); cursor: not-allowed; color: #aaa !important; }
        textarea { width: 100%; padding: 10px 10px 10px 40px; border-radius: 5px; background: transparent; border: none; color: #fff; font-size: 16px; outline: none; border-bottom: 1.5px solid rgba(255,255,255,0.5); }
    </style>
</head>
<body>
    <div class="box">
        <h2>EDIT PROFIL</h2>
        <form method="POST">
            
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" value="<?= htmlspecialchars($d['nama'] ?? '') ?>" class="readonly-input" readonly>
            </div>

            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" value="<?= htmlspecialchars($email_val) ?>" placeholder="Alamat Email" required>
            </div>

            <div class="input-group">
                <i class="fab fa-whatsapp"></i>
                <input type="text" name="telepon" value="<?= htmlspecialchars($telp_val) ?>" placeholder="No. WhatsApp">
            </div>

            <div class="input-group">
                <i class="fab fa-instagram"></i>
                <input type="text" name="instagram" value="<?= htmlspecialchars($ig_val) ?>" placeholder="Username Instagram">
            </div>

            <div class="input-group">
                <i class="fas fa-briefcase"></i>
                <select name="status_alumni">
                    <option value="Bekerja" <?= ($status_val == 'Bekerja') ? 'selected' : '' ?>>Bekerja</option>
                    <option value="Kuliah" <?= ($status_val == 'Kuliah') ? 'selected' : '' ?>>Kuliah</option>
                    <option value="Mencari Kerja" <?= ($status_val == 'Mencari Kerja') ? 'selected' : '' ?>>Mencari Kerja</option>
                    <option value="Wirausaha" <?= ($status_val == 'Wirausaha') ? 'selected' : '' ?>>Wirausaha</option>
                </select>
            </div>

            <div class="input-group">
                <i class="fas fa-building"></i>
                <input type="text" name="tempat_kerja" value="<?= htmlspecialchars($kerja_val) ?>" placeholder="Nama Kantor / Kampus">
            </div>

            <div class="input-group">
                <i class="fas fa-map-marker-alt" style="position: absolute; top: 13px;"></i>
                <textarea name="alamat" rows="2" placeholder="Alamat Domisili"><?= htmlspecialchars($alamat_val) ?></textarea>
            </div>

            <button type="submit" name="update" class="btn-register">SIMPAN PERUBAHAN</button>
            <a href="dashboard_users.php" style="display:block; text-align:center; margin-top:15px; color:#ddd; text-decoration:none;">Batal & Kembali</a>
        </form>
    </div>
</body>
</html>