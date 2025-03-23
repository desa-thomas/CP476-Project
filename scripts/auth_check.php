<?php
function check_auth($root=false) {
    session_start();
    if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
        if (!$root) header('Location: ./login.php');
        else header('Location: ./pages/login.php');
        exit();
    }
}
?> 