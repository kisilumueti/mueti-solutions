<?php
// delete_message.php

include 'connect.php';

if (isset($_POST['message_id'])) {
    $message_id = (int)$_POST['message_id'];

    $query = "DELETE FROM support_messages WHERE message_id = $message_id";
    if (mysqli_query($conn, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
