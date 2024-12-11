<?php  
require 'session_check.php'; // Membolehkan fail session_check.php untuk memeriksa status log masuk pengguna  

// Semak jika pengguna sudah log masuk  
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {  
    // Jika tidak log masuk, alihkan pengguna ke halaman login.php  
    header("Location: login.php");  
    exit;  
}  

// Sambungan pangkalan data  
$servername = "localhost";  
$username = "root";  
$password = "";  
$dbname = "lab_5b";  

// Membina sambungan ke pangkalan data  
$conn = new mysqli($servername, $username, $password, $dbname);  

// Semak sama ada sambungan berjaya atau gagal  
if ($conn->connect_error) {  
    die("Connection failed: " . $conn->connect_error); // Paparkan mesej ralat sambungan  
}  

// Semak jika parameter 'matric' dihantar melalui kaedah GET (contohnya dari URL)  
if (isset($_GET['matric'])) {  
    $matric = $_GET['matric']; // Ambil nilai parameter 'matric' dari URL  
    
    // Sediakan arahan SQL untuk memadamkan pengguna berdasarkan matrik  
    $sql = "DELETE FROM users WHERE matric = ?";  
    $stmt = $conn->prepare($sql); // Sediakan arahan SQL untuk mengelakkan serangan SQL injection  
    $stmt->bind_param("s", $matric); // Sambungkan parameter matrik ke dalam arahan SQL  

    // Laksanakan arahan SQL  
    if ($stmt->execute()) {  
        // Jika berjaya, alihkan semula pengguna ke halaman display_users.php  
        header("Location: display_users.php");  
        exit;  
    } else {  
        // Paparkan mesej jika berlaku ralat semasa memadam rekod pengguna  
        echo "An error occurred while deleting the user.";  
    }  
} else {  
    // Jika parameter 'matric' tidak tersedia, alihkan kembali ke halaman display_users.php  
    header("Location: display_users.php");  
    exit;  
}  

// Tutup sambungan ke pangkalan data  
$conn->close();  
?>