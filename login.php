<!DOCTYPE html>  
<html>  
<head>  
    <title>Login Page</title>  
    <link rel="stylesheet" href="styles.css">  
</head>  
<body>  
    <h1>Login</h1>  
    <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>  
        <p style="color: red;">Invalid username or password, try <a href="login.php">login</a> again.</p>  
    <?php endif; ?>  
    
    <form action="authenticate.php" method="POST">  
        <label>Matric:</label>  
        <input type="text" name="matric" required><br><br>  

        <label>Password:</label>  
        <input type="password" name="password" required><br><br>  

        <input type="submit" value="Login">  
    </form><br> 
    <a href="register.php">Register here if you have not.</a>  
</body>  
</html>