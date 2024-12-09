<?php
// send_message.php

include 'connect.php';

if (isset($_POST['message']) && isset($_POST['user_id'])) {
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $user_id = (int)$_POST['user_id'];

    $query = "INSERT INTO support_messages (user_id, message) VALUES ($user_id, '$message')";
    if (mysqli_query($conn, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
