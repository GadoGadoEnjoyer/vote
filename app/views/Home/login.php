<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="<?php echo BASEURL ?>/public/css/style.css">
</head>
<body>
    <h2>Login</h2>
    <form action="" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
    <p>No account?<a href="<?php echo BASEURL ?>/Home/register"> Register!</a></p>    
</body>
</html>
