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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] == 'yes') {
        // Delete user
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $dbService->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // Redirect to dashboard if user cancels
        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirm Delete</title>
    <link rel="stylesheet" type="text/css" href="css/user-style.css">
</head>
<body>
    <h2>Confirm Delete</h2>
    <p>Are you sure you want to delete this user?</p>
    <form method="POST">
        <button type="submit" name="confirm" value="yes">Yes</button>
        <button type="submit" name="confirm" value="no">No</button>
    </form>
</body>
</html>