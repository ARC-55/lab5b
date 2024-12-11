<?php  
// Sambungan daripada SQL Database  
$servername = "localhost";  
$username = "root";  
$password = "";  
$dbname = "lab_5b";  

// Cipta sambungan ke pangkalan data  
$conn = new mysqli($servername, $username, $password, $dbname);  

// Semak sambungan, jika gagal, papar mesej kesalahan  
if ($conn->connect_error) {  
    die("Connection failed: " . $conn->connect_error);  
}  

// Pastikan data dihantar melalui kaedah POST dan semua medan wujud  
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['matric'], $_POST['name'], $_POST['password'], $_POST['role'])) {  
    // Ambil data daripada borang (form)  
    $matric = $_POST['matric'];  
    $name = $_POST['name'];  
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash kata laluan dengan selamat  
    $role = $_POST['role'];  

    // Masukkan data pengguna ke dalam jadual `users`  
    $sql = "INSERT INTO users (matric, name, password, accesslevel) VALUES ('$matric', '$name', '$password', '$role')";  

    // Papar mesej jika data berjaya dimasukkan atau terdapat ralat  
    if ($conn->query($sql) === TRUE) {  
        echo "New record created successfully! <br><br>";  
    } else {  
        echo "Error: " . $sql . "<br>" . $conn->error . "<br><br>";  
    }  
} else {  
    // Papar mesej jika borang tidak diisi dengan betul  
    echo "Invalid form submission.<br><br>";  
}  

// Dapatkan semua pengguna daripada jadual `users` untuk dipaparkan dalam jadual  
$sql = "SELECT matric, name, accesslevel FROM users";  
$result = $conn->query($sql);  
?>  

<!DOCTYPE html>  
<html>  
<head>  
    <title>Inserted Users</title>  
    <style>  
        /* Gaya CSS untuk jadual */  
        table {  
            width: 50%;  
            border-collapse: collapse;  
            margin: 20px 0;  
        }  
        th, td {  
            border: 1px solid black;  
            padding: 8px;  
            text-align: left;  
        }  
        th {  
            background-color: #f2f2f2;  
        }  
    </style>  
</head>  
<body>  
    <h2>Registered Users</h2>  
    <?php if ($result->num_rows > 0): ?>  
        <!-- Jika terdapat rekod pengguna, papar dalam jadual -->  
        <table>  
            <tr>  
                <th>Matric</th>  
                <th>Name</th>  
                <th>Level</th>  
            </tr>  
            <?php while ($row = $result->fetch_assoc()): ?>  
                <tr>  
                    <!-- Paparkan setiap baris data pengguna secara selamat -->  
                    <td><?php echo htmlspecialchars($row['matric']); ?></td>  
                    <td><?php echo htmlspecialchars($row['name']); ?></td>  
                    <td><?php echo htmlspecialchars($row['accesslevel']); ?></td>  
                </tr>  
            <?php endwhile; ?>  
        </table>  
    <?php else: ?>  
        <!-- Jika tiada rekod pengguna, papar mesej -->  
        <p>No users found.</p>  
    <?php endif; ?>  

    <!-- Pautan untuk mendaftar pengguna baharu -->  
    <a href="register.php">Register another user</a>  
</body>  
</html>  

<?php  
// Tutup sambungan ke pangkalan data  
$conn->close();  
?>