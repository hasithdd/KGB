<?php
include_once './Services/DbService.php';
session_start();
if (!isset($_SESSION['name'])) {
    header('Location: login-page.php');
    exit();
}

// Initialize the database service
$dbService = new Services\DbService();

// Get user ID from query parameter
$user_id = $_GET['id'];

// Fetch user data
$sql = "SELECT id, username, user_level FROM users WHERE id = ?";
$stmt = $dbService->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update user data
    $username = $_POST['username'];
    $user_level = $_POST['user_level'];

    $update_sql = "UPDATE users SET username = ?, user_level = ? WHERE id = ?";
    $update_stmt = $dbService->prepare($update_sql);
    $update_stmt->bind_param("sii", $username, $user_level, $user_id);
    $update_stmt->execute();

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" type="text/css" href="css/user-style.css">
</head>
<body>
    <h2>Edit User</h2>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        <br>
        <label for="user_level">User Level:</label>
        <select id="user_level" name="user_level" required>
            <option value="1" <?php if ($user['user_level'] == 1) echo 'selected'; ?>>Admin</option>
            <option value="3" <?php if ($user['user_level'] == 3) echo 'selected'; ?>>User</option>
        </select>
        <br>
        <button type="submit">Update</button>
    </form>
</body>
</html>