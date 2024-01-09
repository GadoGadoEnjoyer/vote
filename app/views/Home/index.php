<!DOCTYPE html>
<html>
<head>
  <title>Welcome to our website</title>
  <link rel="stylesheet" href="<?php echo BASEURL ?>/public/css/style.css">
</head>
<body>
  <h1>Welcome!</h1>
  <a href="<?php echo BASEURL ?>/Home/login">Login</a>
  <a href="<?php echo BASEURL ?>/Home/logout">Logout</a>
  <a href="<?php echo BASEURL ?>/Home/register">Register</a>
  <a href="<?php echo BASEURL ?>/Post/create">Create Post</a>
  <p>Put some Vote ID here to find the vote page!</p>
  <form action="" method="POST">
    <input type="text" id="search" name="search" placeholder="Search">
    <input type="submit" value="Search">
  </form>

</body>
</html>