<?php  
session_start(); // Mula sesi untuk mengurus keadaan log masuk  

// Menyambung ke pangkalan data  
$servername = "localhost";  
$username = "root";  
$password = "";  
$dbname = "lab_5b";  

// Membina sambungan ke pangkalan data  
$conn = new mysqli($servername, $username, $password, $dbname);  

// Semak sama ada sambungan berjaya, jika tidak, papar mesej ralat  
if ($conn->connect_error) {  
    die("Connection failed: " . $conn->connect_error);  
}  

// Semak jika maklumat log masuk dihantar melalui borang POST  
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['matric'], $_POST['password'])) {  
    $matric = $_POST['matric'];  // Ambil nombor matrik dari borang  
    $password = $_POST['password'];  // Ambil kata laluan dari borang  

    // Semak jika matrik wujud dalam pangkalan data  
    $sql = "SELECT password, accesslevel, name FROM users WHERE matric = ?";  
    $stmt = $conn->prepare($sql);  // Sediakan penyataan SQL untuk dilaksanakan  
    $stmt->bind_param("s", $matric);  // Tetapkan parameter (nombor matrik) untuk soalan SQL  
    $stmt->execute();  // Laksanakan soalan SQL  
    $stmt->store_result();  // Simpan hasil daripada soalan SQL  

    // Jika rekod dengan matrik tersebut dijumpai  
    if ($stmt->num_rows === 1) {  
        $stmt->bind_result($hashedPassword, $accesslevel, $name);  // Ambil data dari pangkalan  
        $stmt->fetch();  // Dapatkan nilai daripada hasil soalan  

        // Semak jika kata laluan yang dimasukkan adalah betul  
        if (password_verify($password, $hashedPassword)) {  
            // Jika betul, simpan data pengguna dalam sesi  
            $_SESSION['logged_in'] = true;  // Tetapkan pengguna sebagai log masuk  
            $_SESSION['matric'] = $matric;  // Simpan nombor matrik dalam sesi  
            $_SESSION['accesslevel'] = $accesslevel;  // Simpan tahap akses pengguna dalam sesi  
            $_SESSION['name'] = $name;  // Simpan nama pengguna dalam sesi  

            // Alihkan pengguna ke halaman `display_users.php`  
            header("Location: display_users.php");  
            exit;  
        } else {  
            // Jika kata laluan salah, alihkan kembali ke halaman log masuk dengan mesej ralat  
            header("Location: login.php?error=invalid");  
            exit;  
        }  
    } else {  
        // Jika matrik tidak wujud dalam pangkalan data, alihkan kembali ke halaman log masuk dengan mesej ralat  
        header("Location: login.php?error=invalid");  
        exit;  
    }  
} else {  
    // Jika borang tidak dihantar dengan betul, alihkan kembali ke halaman log masuk  
    header("Location: login.php");  
    exit;  
}  

// Tutup sambungan ke pangkalan data  
$conn->close();  
?>