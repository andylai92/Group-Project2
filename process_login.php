<?php
require_once('config.php');
session_start();

$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $sql = "SELECT * FROM user WHERE user_email = '$email' AND user_password = '$password'";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['user_id'];
        header('Location: user_profile.php?userp=' . $user['user_id']);
        exit;
    } else {
        echo "Invalid email or password";
    }
}
mysqli_close($connection);
?>