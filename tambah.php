<?php
session_start(); 
include 'koneksi.php';
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit; 
}

if (isset($_POST['submit'])) {
    $nama         = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $password_in  = $_POST['password']; // Password murni tidak di-escape karena akan di-hash
    $angkatan     = mysqli_real_escape_string($koneksi, $_POST['angkatan']);
    $jurusan      = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    $telepon      = mysqli_real_escape_string($koneksi, $_POST['telepon']);
    $email        = mysqli_real_escape_string($koneksi, $_POST['email']);
    $instagram    = mysqli_real_escape_string($koneksi, $_POST['instagram']);
    $status       = mysqli_real_escape_string($koneksi, $_POST['status_alumni']);
    $tempat_kerja = mysqli_real_escape_string($koneksi, $_POST['tempat_kerja']);
    $alamat       = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $cek_duplikasi = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$nama'");
    if (mysqli_num_rows($cek_duplikasi) > 0) {
        echo "<script>
                alert('Gagal Menambahkan! Nama/Username tersebut sudah terdaftar di dalam sistem.');
                window.history.back();
              </script>";
        exit;
    }
    $pass_hashed = password_hash($password_in, PASSWORD_DEFAULT);
    $query_alumni = "INSERT INTO alumni (nama, angkatan, jurusan, telepon, email, instagram, status_alumni, tempat_kerja, alamat, password) 
                     VALUES ('$nama', '$angkatan', '$jurusan', '$telepon', '$email', '$instagram', '$status', '$tempat_kerja', '$alamat', '$pass_hashed')";

    if (mysqli_query($koneksi, $query_alumni)) {
        $query_user = "INSERT INTO users (username, password, role) 
                       VALUES ('$nama', '$pass_hashed', 'alumni')";

        mysqli_query($koneksi, $query_user);
        echo "<script>
                alert('Data Alumni & Akun Login Berhasil Ditambahkan!'); 
                window.location='dashboard_admin.php';
              </script>";
        exit;
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Alumni - Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./style/tambah.css">
</head>
<body class="body-tambah">

    <div class="form-glass">
        <h3><i class="fas fa-user-plus"></i> Tambah Data Alumni</h3>

        <form action="" method="POST" autocomplete="off">
            <div class="form-scroll">

                <div class="input-group-custom">
                    <i class="fas fa-user"></i>
                    <input type="text" name="nama" placeholder="Nama Lengkap" required>
                </div>

                <div class="input-group-custom">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Buat Password Login" required autocomplete="off">
                </div>

                <div class="input-group-custom">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="number" name="angkatan" placeholder="Tahun Angkatan" min="2000" max="2100" required>
                </div>

                <div class="input-group-custom">
                    <i class="fas fa-graduation-cap"></i>
                    <select name="jurusan" required>
                        <option value="" disabled selected>Pilih Jurusan</option>
                        <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                        <option value="Teknik Komputer Jaringan">Teknik Komputer Jaringan</option>
                        <option value="Teknik Jaringan Akses Telekomunikasi">Teknik Jaringan Akses Telekomunikasi</option>
                        <option value="Animasi">Animasi</option>
                    </select>
                </div>

                <div class="input-group-custom">
                    <i class="fab fa-whatsapp"></i>
                    <input type="text" name="telepon" placeholder="Nomor WhatsApp">
                </div>

                <div class="input-group-custom">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email">
                </div>

                <div class="input-group-custom">
                    <i class="fab fa-instagram"></i>
                    <input type="text" name="instagram" placeholder="Instagram (@username)" autocomplete="off">
                </div>

                <div class="input-group-custom">
                    <i class="fas fa-briefcase"></i>
                    <select name="status_alumni">
                        <option value="" disabled selected>Status Alumni</option>
                        <option value="Kuliah">Kuliah</option>
                        <option value="Kerja">Kerja</option>
                        <option value="Wirausaha">Wirausaha</option>
                        <option value="Mencari Kerja">Mencari Kerja</option>
                    </select>
                </div>

                <div class="input-group-custom">
                    <i class="fas fa-university"></i>
                    <input type="text" name="tempat_kerja" placeholder="Nama Kampus / Tempat Kerja">
                </div>

                <div class="input-group-custom">
                    <i class="fas fa-map-marker-alt"></i>
                    <textarea name="alamat" rows="2" placeholder="Alamat Domisili"></textarea>
                </div>

            </div>

            <button type="submit" name="submit" class="btn-blue-light">Simpan Data</button>
            <a href="dashboard_admin.php" class="btn-outline-white">Batal</a>
        </form>
    </div>

</body>
</html>