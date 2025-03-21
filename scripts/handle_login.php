<?php
session_start();
include("db_functions.php");

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    $_SESSION['error'] = 'Please provide both username and password';
    header('Location: ../pages/login.php');
    exit();
}

$username = $_POST['username'];
$password = $_POST['password'];

try {
    $conn = new mysqli($_ENV["SERVER"], $_ENV["USERNAME"], $_ENV["PASSWORD"], $_ENV["DB_NAME"]);
} catch (Exception $e) {
    $_SESSION['error'] = 'Database connection error';
    header('Location: ../pages/login.php');
    exit();
}

$stmt = $conn->prepare("SELECT id, password FROM Users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = 'Invalid credentials';
    header('Location: ../pages/login.php');
    exit();
}

$user = $result->fetch_assoc();
if (!password_verify($password, $user['password'])) {
    $_SESSION['error'] = 'Invalid credentials';
    header('Location: ../pages/login.php');
    exit();
}

// Create session token
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $username;
$_SESSION['authenticated'] = true;

header('Location: ../index.php');
exit();
?> 