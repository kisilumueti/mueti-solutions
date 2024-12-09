<?php
// Include the database connection
include('connect.php');

// Fetch all distinct customers who have messaged
$customers_query = "
    SELECT DISTINCT u.user_id, u.first_name, u.last_name, u.email
    FROM users u
    JOIN support_messages sm ON u.user_id = sm.user_id
    WHERE u.role = 'customer'
";
$customers_result = mysqli_query($conn, $customers_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Support Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Admin Support Panel</h1>
        <h3>Customer Messages</h3>

        <?php if (mysqli_num_rows($customers_result) > 0): ?>
            <ul class="list-group">
                <?php while ($customer = mysqli_fetch_assoc($customers_result)): ?>
                    <li class="list-group-item">
                        <strong><?php echo $customer['first_name'] . " " . $customer['last_name']; ?></strong>
                        (<a href="view_conversation.php?user_id=<?php echo $customer['user_id']; ?>">
                            View Conversation
                        </a>)
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No messages found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
