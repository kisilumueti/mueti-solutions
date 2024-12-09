<?php
// Include the database connection
include('connect.php');

// Get the customer user_id from the URL
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

// Fetch the customer details
$customer_query = "SELECT first_name, last_name FROM users WHERE user_id = '$user_id'";
$customer_result = mysqli_query($conn, $customer_query);
$customer = mysqli_fetch_assoc($customer_result);

// Fetch messages for this customer
$messages_query = "
    SELECT sender_role, message, created_at
    FROM support_messages
    WHERE user_id = '$user_id'
    ORDER BY created_at ASC
";
$messages_result = mysqli_query($conn, $messages_query);

// Handle reply submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['reply'])) {
    $reply = mysqli_real_escape_string($conn, $_POST['reply']);

    $insert_query = "
        INSERT INTO support_messages (user_id, sender_role, message)
        VALUES ('$user_id', 'admin', '$reply')
    ";

    if (mysqli_query($conn, $insert_query)) {
        header("Location: view_conversation.php?user_id=$user_id");
        exit;
    } else {
        $error_message = "Error sending reply: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversation with <?php echo $customer['first_name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Conversation with <?php echo $customer['first_name'] . " " . $customer['last_name']; ?></h1>

        <!-- Display Messages -->
        <div class="mb-3">
            <?php while ($row = mysqli_fetch_assoc($messages_result)): ?>
                <div class="<?php echo $row['sender_role'] === 'admin' ? 'text-end' : 'text-start'; ?>">
                    <p><strong><?php echo ucfirst($row['sender_role']); ?>:</strong></p>
                    <p><?php echo htmlspecialchars($row['message']); ?></p>
                    <small><em><?php echo $row['created_at']; ?></em></small>
                </div>
                <hr>
            <?php endwhile; ?>
        </div>

        <!-- Reply Form -->
        <form method="POST" action="view_conversation.php?user_id=<?php echo $user_id; ?>">
            <div class="mb-3">
                <label for="reply" class="form-label">Reply</label>
                <textarea name="reply" id="reply" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Reply</button>
        </form>
    </div>
</body>
</html>
