<?php
// reply_message.php

include 'connect.php';

if (isset($_POST['message_id']) && isset($_POST['reply'])) {
    $message_id = (int)$_POST['message_id'];
    $reply = mysqli_real_escape_string($conn, $_POST['reply']);

    $query = "UPDATE support_messages SET reply = '$reply', status = 'read', reply_created_at = NOW() WHERE message_id = $message_id";
    if (mysqli_query($conn, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>

