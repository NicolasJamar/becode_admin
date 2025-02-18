<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Becode Admin</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>

<header>
    <nav>
        <ul>
            <li class="home"><a href="./">Home</a></li>
            <?php if(!isset($_SESSION["user"])): ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="subscription.php">Subscription</a></li>
            <?php else: ?>
                <li><a href="./add-student.php">Add Student</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
