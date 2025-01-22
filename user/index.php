<?php
// filepath: /c:/xampp/htdocs/Virtual-Try-On/user/index.php

// Start the session
session_start();

$isLoggedIn = isset($_SESSION['custID']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Try On</title>
    <link rel="stylesheet" href="index-style.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/logo.png" alt="Virtual Try On Logo">
        </div>
        <div class="search-bar">
            <form action="search.php" method="GET">
                <input type="text" name="query" placeholder="Search By Typing Keywords...">
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="account">
            <img src="images/account-logo.png" alt="Account Icon">
            <a href="userprofile.php"><span>Account</span> </a>
            <?php if ($isLoggedIn): ?>
                <a href="login/logoutprocess.php" class="btn">Logout</a>
            <?php else: ?>
                <a href="login/login.php" class="btn">Login</a>
            <?php endif; ?>
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="category.php">Category</a></li>
            <li><a href="tryon.php">Virtual Try On</a></li>
            <li><a href="review.php">Review</a></li>
        </ul>
    </nav>
    <main>
        <div class="model-display">
            <div class="model-display">
                <img src="images/model.png" alt="Models" class="models-image">
            </div>
        </div>
    </main>
</body>
</html>
