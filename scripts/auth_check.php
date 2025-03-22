<?php
function check_auth() {
    session_start();
    if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
        header('Location: ../pages/login.php');
        exit();
    }
}
?> 