<?php  
require 'session_check.php'; // Melakukan semakan sama ada pengguna telah log masuk atau tidak  

// Sambungan pangkalan data  
$servername = "localhost";  
$username = "root";  
$password = "";  
$dbname = "lab_5b";  

// Membina sambungan ke pangkalan data  
$conn = new mysqli($servername, $username, $password, $dbname);  

// Semak sama ada sambungan berjaya, jika gagal, papar mesej ralat  
if ($conn->connect_error) {  
    die("Connection failed: " . $conn->connect_error);  
}  

// Ambil rekod pengguna daripada pangkalan data  
$sql = "SELECT matric, name, accesslevel FROM users";  
$result = $conn->query($sql);  
?>  

<!DOCTYPE html>  
<html>  
<head>  
    <title>Users List with Actions</title>  
    <!-- Memaut fail CSS untuk gaya -->  
    <link rel="stylesheet" href="styles.css">  
</head>  
<body>  
    <!-- Papar ucapan selamat datang dengan nama pengguna yang sedang log masuk -->  
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>  
    <table>  
        <!-- Tajuk lajur jadual -->  
        <tr>  
            <th>Matric</th>  
            <th>Name</th>  
            <th>Level</th>  
            <th>Action</th>  
        </tr>  
        <?php  
        // Semak jika terdapat rekod pengguna dalam pangkalan data  
        if ($result->num_rows > 0) {  
            // Ulang setiap rekod pengguna yang diambil daripada pangkalan data  
            while ($row = $result->fetch_assoc()) {  
                echo "<tr>";  
                // Paparkan data pengguna secara selamat menggunakan `htmlspecialchars`  
                echo "<td>" . htmlspecialchars($row['matric']) . "</td>";  
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";  
                echo "<td>" . htmlspecialchars($row['accesslevel']) . "</td>";  
                echo "<td>  
                        <!-- Pautan untuk mengemaskini rekod -->  
                        <a href='update_user.php?matric=" . htmlspecialchars($row['matric']) . "'>Update</a> |   
                        <!-- Pautan untuk memadam rekod dengan pengesahan -->  
                        <a href='delete_user.php?matric=" . htmlspecialchars($row['matric']) . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>  
                      </td>";  
                echo "</tr>";  
            }  
        } else {  
            // Jika tiada rekod ditemui, papar mesej "No records found"  
            echo "<tr><td colspan='4'>No records found.</td></tr>";  
        }  
        ?>  
    </table>  
    <!-- Pautan untuk log keluar -->  
    <a href="logout.php">Logout</a>  
</body>  
</html>  

<?php  
// Tutup sambungan pangkalan data  
$conn->close();  
?>