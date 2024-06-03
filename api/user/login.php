<?php
session_start();
include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$user->username = isset($_GET['username']) ? $_GET['username'] : null;
$user->password = isset($_GET['password']) ? md5($_GET['password']) : null;

$errors = array();

if (!$user->username) {
    $errors[] = 'Login jest wymagany';
}

if (!$user->password) {
    $errors[] = 'Hasło jest wymagane';
}

if (empty($errors)) {
    $stmt = $user->login();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['username'] = $row['username'];
        $_SESSION['id'] = $row['id'];
        header("Location: ../../index.php");
        exit();
    } else {
        $errors[] = 'Nieprawidłowe dane logowania.';
    }
}

$_SESSION['login_errors'] = $errors;
header("Location: ../../index.php");
exit();
?>
