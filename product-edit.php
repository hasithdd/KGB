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
    $result = $dbService->query("SELECT * FROM `products` WHERE name='$productName'");

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found.";
        exit;
    }
}

$categories = $dbService->query("SELECT * FROM `categories`");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $buy_price = $_POST['buy_price'];
    $sale_price = $_POST['sale_price'];

    $updateQuery = "UPDATE `products` SET name='$name', category_id='$category_id', buy_price='$buy_price', sale_price='$sale_price' WHERE name='$productName'";
    if ($dbService->query($updateQuery) === TRUE) {
        echo "Product updated successfully.";
    } else {
        echo "Error updating product: " . $dbService->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 100px;
            padding: 20px;
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
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="text"], select {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px;
            background: #900d0d;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #4f0707;
        }
    </style>
</head>
<body>
    <h2>Edit Product</h2>
    <form method="post">
        Name: <input type="text" name="name" value="<?php echo $product['name']; ?>"><br>
        Category: 
        <select name="category_id">
            <?php while ($category = $categories->fetch_assoc()) { ?>
                <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $product['category_id']) echo 'selected'; ?>>
                    <?php echo $category['name']; ?>
                </option>
            <?php } ?>
        </select><br>
        Production Cost: <input type="text" name="buy_price" value="<?php echo $product['buy_price']; ?>"><br>
        Sale Price: <input type="text" name="sale_price" value="<?php echo $product['sale_price']; ?>"><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>