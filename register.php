<!-- registration.php -->  
<!DOCTYPE html>  
<html>  
<head>  
    <title>Registration Page</title>  
</head>  
<body>  
    <h2>Register User</h2>  
    <form action="insert.php" method="POST">  
        <label for="matric">Matric:</label><br>  
        <input type="text" id="matric" name="matric" required><br><br>  
        
        <label for="name">Name:</label><br>  
        <input type="text" id="name" name="name" required><br><br>  
        
        <label for="password">Password:</label><br>  
        <input type="password" id="password" name="password" required><br><br>  
        
        <label for="role">Role:</label><br>  
        <select id="role" name="role" required>  
            <option value="">Please select</option>  
            <option value="lecturer">Lecturer</option>  
            <option value="student">Student</option>  
        </select><br><br>  

        <input type="submit" value="Submit">  
    </form><br>
    <a href="login.php">Log in if you have.</a> 
</body>  
</html>