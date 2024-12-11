<?php   
require 'session_check.php'; // Menyertakan fail untuk memeriksa sesi pengguna yang log masuk  

// Memastikan pengguna telah log masuk  
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {  
    // Jika pengguna tidak log masuk, alihkan ke halaman log masuk  
    header("Location: login.php");  
    exit;  
}  

// Sambungan ke pangkalan data  
$servername = "localhost";  
$username = "root";  
$password = "";  
$dbname = "lab_5b";  

$conn = new mysqli($servername, $username, $password, $dbname);  // Membina sambungan ke pangkalan data  

// Semak jika sambungan ke pangkalan data berjaya  
if ($conn->connect_error) {  
    die("Connection failed: " . $conn->connect_error);  // Papar mesej ralat jika sambungan gagal  
}  

// Ambil data pengguna sedia ada berdasarkan parameter 'matric' dalam URL  
if (isset($_GET['matric'])) {  
    $matric = $_GET['matric'];  // Ambil nombor matrik dari URL  
    $sql = "SELECT matric, name, accesslevel FROM users WHERE matric = ?";  // Soalan SQL untuk mendapatkan data pengguna  
    $stmt = $conn->prepare($sql);  // Sediakan arahan SQL untuk mengelakkan serangan SQL injection  
    $stmt->bind_param("s", $matric);  // Sambung parameter matrik ke dalam soal SQL  
    $stmt->execute();  // Jalankan soal SQL  
    $result = $stmt->get_result();  // Dapatkan hasil soal SQL  

    if ($result->num_rows == 1) {  
        $user = $result->fetch_assoc();  // Jika ada pengguna, simpan data ke dalam pembolehubah `$user`  
    } else {  
        // Jika pengguna tidak wujud  
        echo "User not found.";  
        exit;  
    }  
} else {  
    // Jika parameter 'matric' tiada dalam URL, alihkan ke halaman `display_users.php`  
    header("Location: display_users.php");  
    exit;  
}  

// Memproses kemas kini jika borang dihantar  
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['matric'], $_POST['name'], $_POST['accesslevel'])) {  
    $matric = $_POST['matric'];  // Ambil nombor matrik daripada borang  
    $name = $_POST['name'];  // Ambil nama pengguna daripada borang  
    $accesslevel = $_POST['accesslevel'];  // Ambil tahap akses pengguna daripada borang  

    // Soalan SQL untuk mengemas kini rekod pengguna dalam pangkalan data  
    $sql = "UPDATE users SET name = ?, accesslevel = ? WHERE matric = ?";  
    $stmt = $conn->prepare($sql);  // Sediakan arahan SQL  
    $stmt->bind_param("sss", $name, $accesslevel, $matric);  // Menghubungkan parameter ke soal SQL  

    // Jalankan arahan kemas kini  
    if ($stmt->execute()) {  
        // Jika berjaya, alihkan semula pengguna ke halaman `display_users.php`  
        header("Location: display_users.php");  
        exit;  
    } else {  
        // Paparkan mesej jika berlaku ralat semasa kemas kini  
        echo "An error occurred while updating the user.";  
    }  
}  
?>  

<!DOCTYPE html>  
<html>  
<head>  
    <title>Update User</title>  
</head>  
<body>  
    <h2>Update User</h2>  
    <!-- Borang untuk mengemas kini data pengguna -->  
    <form action="update_user.php?matric=<?php echo htmlspecialchars($user['matric']); ?>" method="POST">  
        <!-- Nombor matrik: Medan ini hanya untuk paparan, pengguna tidak boleh mengubah -->  
        <label for="matric">Matric:</label><br>  
        <input type="text" id="matric" name="matric" value="<?php echo htmlspecialchars($user['matric']); ?>" readonly><br><br>  
        
        <!-- Nama pengguna: Medan ini boleh dikemaskini -->  
        <label for="name">Name:</label><br>  
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br><br>  
        
        <!-- Tahap akses: Medan ini boleh dikemaskini -->  
        <label for="accesslevel">Access Level:</label><br>  
        <input type="text" id="accesslevel" name="accesslevel" value="<?php echo htmlspecialchars($user['accesslevel']); ?>" required><br><br>  
        
        <!-- Butang untuk menghantar perubahan -->  
        <input type="submit" value="Update">  
        <!-- Pautan untuk membatalkan ke halaman `display_users.php` -->  
        <a href="display_users.php">Cancel</a>  
    </form>  
</body>  
</html>  

<?php  
$conn->close();  // Tutup sambungan ke pangkalan data  
?>