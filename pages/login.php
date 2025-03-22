<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../frontend/styles.css">
    <title>Admin Login</title>
</head>
<body>
    <div class="main-container">
        <div class="placeholder"></div>
        <div class="content main">
            <h2>Admin Login</h2>
            <hr>
            <?php
            session_start();
            if (isset($_SESSION['error'])) {
                echo "<p style='color: var(--accentColor);'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
            }
            ?>
            <form action="../scripts/handle_login.php" method="POST">
                <div style="margin: 20px 0;">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div style="margin: 20px 0;">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" style="width: 100px;">Login</button>
            </form>
        </div>
        <div class="placeholder"></div>
    </div>
</body>
</html> 