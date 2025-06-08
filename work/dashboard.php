<?php
require 'auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Welcome, <?= $_SESSION['user'] ?>!</h2>
<p><a href="book.php">Manage Books</a></p>
<p><a href="logout.php">Logout</a></p>

</body>
</html>
