<?php require_once('config.php');

$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;

    die(mysqli_connect_error());
}

$user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
$first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
$last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
$user_email = mysqli_real_escape_string($connection, $_POST['user_email']);
$user_country = mysqli_real_escape_string($connection, $_POST['user_country']);
$user_doseNum = mysqli_real_escape_string($connection, $_POST['user_doseNum']);
$user_password = mysqli_real_escape_string($connection, $_POST['user_password']);

$sql = "UPDATE user SET first_name='$first_name', last_name='$last_name', user_email='$user_email', user_country='$user_country', user_doseNum='$user_doseNum', user_password='$user_password' WHERE user_id=$user_id";
echo $sql;

//(SELECT country_id FROM country WHERE country_name='$user_country' limit 1)
if (mysqli_query($connection, $sql)) {
    echo "Record updated successfully";
    header("Location: user_profile.php?userp=$user_id");
} else {
    echo "Error updating record: " . mysqli_error($connection);
}

mysqli_close($connection);
?>