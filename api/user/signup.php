<?php
session_start();
include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$user->username = isset($_POST['username']) ? $_POST['username'] : null;
$user->password = isset($_POST['password']) ? $_POST['password'] : null;
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : null;

$errors = array();

if (!$user->username) {
    $errors[] = 'Login jest wymagany';
}

if (!$user->password) {
    $errors[] = 'Haslo jest wymagane';
}

if (!$confirm_password) {
    $errors[] = 'Musisz powtórzyć hasło';
}

if ($user->password && $confirm_password && $user->password !== $confirm_password) {
    $errors[] = 'Rejestracja nieudana: Hasła nie są takie same.';
}

if (empty($errors) && $user->signup()) {
    $query = "SELECT id FROM users WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $user->username);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $_SESSION['username'] = $user->username;
        $_SESSION['id'] = $row['id'];
        $_SESSION['session_id'] = session_id();
        header("Location: ../../index.php");
        exit();
    } else {
        $errors[] = 'Rejestracja nieudana: Nie można pobrać ID użytkownika.';
    }
} else if (empty($errors)) {
    $errors[] = 'Rejestracja nieudana.';
}

$_SESSION['signup_errors'] = $errors;
header("Location: ../../index.php");
exit();
?>
