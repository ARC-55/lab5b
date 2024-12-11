<?php  
session_start();  
session_destroy(); // Musnahkan semua sesi
header("Location: login.php");  
exit;  
?>