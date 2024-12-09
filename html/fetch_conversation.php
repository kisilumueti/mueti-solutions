<?php
include 'connect.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Fetch all messages from a specific user, ordered by the latest message
    $query = "SELECT * FROM support_messages WHERE user_id = $user_id ORDER BY created_at DESC";
    $result = mysqli_query($conn, $query);

    $messages = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }

    // Return messages as JSON
    echo json_encode([
        'messages' => $messages,
        'latest_message_id' => end($messages)['message_id'] ?? null
    ]);
}
?>
