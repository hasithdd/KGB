<?php
include_once './Services/DbService.php';
session_start();
if (!isset($_SESSION['name'])) {
    header('Location: login-page.php');
    exit();
}

$dbService = new Services\DbService();

if (isset($_GET['id'])) {
    $productName = $_GET['id'];
    $deleteQuery = "DELETE FROM `products` WHERE name='$productName'";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['confirm']) && $_POST['confirm'] == 'yes') {
            if ($dbService->query($deleteQuery) === TRUE) {
                header('Location: dashboard.php');
                exit();
            } else {
                echo "Error deleting product: " . $dbService->error;
            }
        } else {
            header('Location: dashboard.php');
            exit();
        }
    }
} else {
    echo "No product ID provided.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        p {
            text-align: center;
            color: #666;
        }
        form {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        input[type="submit"] {
            padding: 10px;
            background: #d9534f;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 10px;
        }
        input[type="submit"]:hover {
            background: #c9302c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Delete Product</h2>
        <p>Are you sure you want to delete the product "<?php echo htmlspecialchars($productName); ?>"?</p>
        <form method="post">
            <input type="hidden" name="confirm" value="yes">
            <input type="submit" value="Yes, delete it">
        </form>
        <form method="post">
            <input type="hidden" name="confirm" value="no">
            <input type="submit" value="No, cancel">
        </form>
    </div>
</body>
</html>