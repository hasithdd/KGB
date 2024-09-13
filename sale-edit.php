<?php
include_once './Services/DbService.php';
session_start();
if (!isset($_SESSION['name'])) {
    header('Location: login-page.php');
    exit();
}

// Initialize the database service
$dbService = new Services\DbService();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];

    // Update the product details
    $updateQuery = "UPDATE products SET quantity=?, date=? WHERE name=?";
    $stmt = $dbService->prepare($updateQuery);
    $stmt->bind_param("iss", $quantity, $date, $name);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
    exit;

}

// Fetch product details
if (isset($_GET['id'])) {
    $name = $_GET['id'];
    $query = "SELECT name, quantity, date FROM products WHERE name=?";
    $stmt = $dbService->prepare($query);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "No product specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        p {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"],
        input[type="number"],
        input[type="datetime-local"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color:#900d0d;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4f0707;
        }
    </style>
</head>
<body>
    <h1>Edit Product</h1>
    <form method="post" action="sale-edit.php">
        <input type="hidden" name="name" value="<?php echo htmlspecialchars($product['name']); ?>">
        <p>
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" disabled>
        </p>
        <p>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required>
        </p>
        <p>
            <label for="date">Date:</label>
            <input type="datetime-local" id="date" name="date" value="<?php echo htmlspecialchars($product['date']); ?>" required>
        </p>
        <p>
            <input type="submit" value="Update">
        </p>
    </form>
</body>
</html>