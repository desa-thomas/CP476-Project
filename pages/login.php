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
        <div class="content main login">
            <h2>Admin Login</h2>
            <form action="../scripts/handle_login.php" method="POST" class="">

                <div class="login-inputs">
                    <label for="username">Username</label>
                    <input type="text" name="username" required> 
                    <label for="password">Password</label>                   
                    <input type="password" name="password" required>
                    <button type="submit" id="login">Login</button>
                </div>
                <?php
                session_start();
                if (isset($_SESSION['error'])) {
                    echo "<p style='color: var(--accentColor);'>" . $_SESSION['error'] . "</p>";
                    unset($_SESSION['error']);
                }
                ?>
                
            </form>
        </div>
        <div class="placeholder"></div>
    </div>
</body>

</html>