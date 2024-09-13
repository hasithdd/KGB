<?php
include_once './Services/DbService.php';
session_start();
if (!isset($_SESSION['name'])) {
    header('Location: login-page.php');
    exit();
}

// Initialize the database service
$dbService = new Services\DbService();

// Initialize variables
$name = $category_id = $buy_price = $sale_price = "";
$name_err = $category_id_err = $buy_price_err = $sale_price_err = "";

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a product name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate category
    if (empty(trim($_POST["category_id"]))) {
        $category_id_err = "Please select a category.";
    } else {
        $category_id = trim($_POST["category_id"]);
    }

    // Validate buy price
    if (empty(trim($_POST["buy_price"]))) {
        $buy_price_err = "Please enter the production cost.";
    } elseif (!is_numeric(trim($_POST["buy_price"]))) {
        $buy_price_err = "Please enter a valid number.";
    } else {
        $buy_price = trim($_POST["buy_price"]);
    }

    // Validate sale price
    if (empty(trim($_POST["sale_price"]))) {
        $sale_price_err = "Please enter the sale price.";
    } elseif (!is_numeric(trim($_POST["sale_price"]))) {
        $sale_price_err = "Please enter a valid number.";
    } else {
        $sale_price = trim($_POST["sale_price"]);
    }

    // Check input errors before inserting in database
    if (empty($name_err) && empty($category_id_err) && empty($buy_price_err) && empty($sale_price_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO products (name, category_id, buy_price, sale_price) VALUES (?, ?, ?, ?)";

        if ($stmt = $dbService->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sidd", $param_name, $param_category_id, $param_buy_price, $param_sale_price);

            // Set parameters
            $param_name = $name;
            $param_category_id = $category_id;
            $param_buy_price = $buy_price;
            $param_sale_price = $sale_price;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to dashboard
                header("location: dashboard.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            }

            .wrapper {
                width: 500px;
                margin: 50px auto;
                padding: 20px;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
            }

            h2 {
                text-align: center;
                color: #333;
            }

            p {
                text-align: center;
                color: #666;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .form-group label {
                display: block;
                color: #333;
                margin-bottom: 5px;
            }

            .form-group input,
            .form-group select {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            .form-group .help-block {
                color: red;
                font-size: 12px;
            }

            .btn {
                display: inline-block;
                padding: 10px 20px;
                color: #fff;
                background-color: #007bff;
                border: none;
                border-radius: 4px;
                text-decoration: none;
                text-align: center;
                cursor: pointer;
            }

            .btn-primary {
                background-color: #900d0d;
            }

            .btn-default {
                background-color: #4f0707;
                margin:auto;
            }

            .btn:hover {
                opacity: 0.9;
            }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Add Product</h2>
        <p>Please fill this form to add a new product.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err;?></span>
            </div>
            <div class="form-group <?php echo (!empty($category_id_err)) ? 'has-error' : ''; ?>">
                <label>Category</label>
                <select name="category_id" class="form-control">
                    <option value="">Select a category</option>
                    <option value="1">Fighter Jets</option>
                    <option value="2">Nuclear Bombs</option>
                    <option value="3">Balastic Missiles</option>
                    <option value="4">Battle Tanks</option>
                    <option value="5">Submarines</option>
                    <option value="6">Aircraft Carriers</option>
                    <option value="7">Helicopters</option>
                    <option value="8">Air Defense System</option>
                </select>
                <span class="help-block"><?php echo $category_id_err;?></span>
            </div>
            <div class="form-group <?php echo (!empty($buy_price_err)) ? 'has-error' : ''; ?>">
                <label>Production Cost (M RUB)</label>
                <input type="text" name="buy_price" class="form-control" value="<?php echo $buy_price; ?>">
                <span class="help-block"><?php echo $buy_price_err;?></span>
            </div>
            <div class="form-group <?php echo (!empty($sale_price_err)) ? 'has-error' : ''; ?>">
                <label>Sale Price (M RUB)</label>
                <input type="text" name="sale_price" class="form-control" value="<?php echo $sale_price; ?>">
                <span class="help-block"><?php echo $sale_price_err;?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="dashboard.php" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>