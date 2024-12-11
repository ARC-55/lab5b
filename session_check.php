<?php  
session_start();  // Memulakan sesi PHP untuk mengakses data sesi yang disimpan  

// Semak jika pengguna sudah log masuk  
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {  
    // Sekiranya sesi `logged_in` tidak wujud atau nilainya bukan `true`,  
    // pengguna akan dialihkan ke halaman log masuk (login.php).  
    header("Location: login.php");  
    exit;  // Hentikan skrip selepas pengalihan  
}  
?>