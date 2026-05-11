<?php
include 'koneksi.php';
session_start();

$login_message = "";
if (isset($_POST['login'])) {
    $user_input = $_POST['username'];
    $pass_input = $_POST['password'];

    if (strlen($user_input) > 50 || strlen($pass_input) > 50) {
        $login_message = "<b style='color:red;'>Akses Ditolak! Input terlalu panjang.</b>";
    } else {
        $stmt = $koneksi->prepare("SELECT salt, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $user_input);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hash_verifikasi = hash('sha256', $row['salt'] . $pass_input);
            if ($hash_verifikasi === $row['password']) {
                $_SESSION['user'] = $user_input;
                $login_message = "<b style='color:green;'>Login Berhasil! Selamat datang, " . $user_input . "</b>";
            } else {
                $login_message = "<b style='color:red;'>Password Salah!</b>";
            }
        } else {
            $login_message = "<b style='color:red;'>Username tidak ditemukan!</b>";
        }
        $stmt->close();
    }
}

if (isset($_POST['kirim_komentar'])) {
    $nama_komentar = $_POST['nama'];
    $isi_komentar = $_POST['isi'];

    if (strlen($nama_komentar) <= 50 && strlen($isi_komentar) <= 500) {
        $stmt_kom = $koneksi->prepare("INSERT INTO komentar (nama, isi_komentar) VALUES (?, ?)");
        $stmt_kom->bind_param("ss", $nama_komentar, $isi_komentar);
        $stmt_kom->execute();
        $stmt_kom->close();

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Project CLO 2 - Keamanan Sistem</title>
</head>
<body>
    <h1>Project CLO 2</h1>
    <p>Status Koneksi: 🔒 <b>HTTPS Aktif (SSL/TLS RSA-2048)</b></p>
    <hr>

    <div style="background: #f4f4f4; padding: 15px; border: 1px solid #ccc;">
        <h3>Menu Login</h3>
        <form method="POST" action="">
            Username: <input type="text" name="username" maxlength="50" required><br><br>
            Password: <input type="password" name="password" maxlength="50" required><br><br>
            <button type="submit" name="login">Login</button>
        </form>
        <p><?php echo $login_message; ?></p>
    </div>

    <br>

    <div style="background: #e8f4fd; padding: 15px; border: 1px solid #ccc;">
        <h3>Halaman Komentar</h3>
        <form method="POST" action="">
            Nama: <br><input type="text" name="nama" maxlength="50" required><br><br>
            Komentar: <br><textarea name="isi" rows="3" cols="40" maxlength="500" required></textarea><br><br>
            <button type="submit" name="kirim_komentar">Kirim Komentar</button>
        </form>
        <hr>
        <h4>Daftar Komentar Terbaru:</h4>
        <ul>
        <?php
        $res = $koneksi->query("SELECT * FROM komentar ORDER BY id DESC LIMIT 5");
        while ($k = $res->fetch_assoc()) {
            echo "<li><b>" . $k['nama'] . "</b>: " . $k['isi_komentar'] . "</li>";
        }
        ?>
        </ul>
    </div>
</body>
</html>