<?php
// Decoy login handler for ATO detection lab — NOT a real auth system.
session_start();

$valid_users = [
    "jsmith" => "Winter2026!",
    "mchen" => "Toronto123",
];

$user = $_POST['username'] ?? '';
$pass = $_POST['password'] ?? '';

if (isset($valid_users[$user]) && $valid_users[$user] === $pass) {
    session_regenerate_id(true);
    $_SESSION['user'] = $user;
    $_SESSION['login_time'] = time();
    error_log("ATO_LAB SESSION_CREATED session_id=" . session_id() . " user=$user ip=" . $_SERVER['REMOTE_ADDR'] . "\n", 3, "/var/log/securebank/session.log");
    http_response_code(200);
    echo "Login successful. Welcome, $user.";
    error_log("ATO_LAB LOGIN_SUCCESS user=$user ip=" . $_SERVER['REMOTE_ADDR']);
} else {
    http_response_code(401);
    echo "Invalid username or password.";
    error_log("ATO_LAB LOGIN_FAILURE user=$user ip=" . $_SERVER['REMOTE_ADDR']);
}
?>
