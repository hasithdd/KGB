<?php
include_once './Services/DbService.php';
session_start();
if (!isset($_SESSION['name'])) {
    header('Location: login-page.php');
    exit();
}
$dbService = new Services\DbService();
$group_level = 0;  // Default group level

if (isset($_SESSION['username'])) {
    $result1 = $dbService->query("SELECT `user_level` FROM `users` WHERE `username` = '" . $_SESSION['username'] . "'");
    if ($result1->num_rows > 0) {
        $group_level = $result1->fetch_assoc()['user_level'];
    }
}
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="css/admin-style.css">
    <title>Management System</title>
</head>
<body>
    <div class="container">
        <aside>
            <div class="toggle">
                <div class="logo">
                    <a href="index.php">
                        <img src="res/img/admin-images/logo.png">
                        <h2><span class="danger">KGB</span></h2>
                    </a>
                </div>
            </div>
            <div class="sidebar">
                <a href="#dashboard" data-target="dashboard" class="active">
                    <span class="material-icons-sharp">
                        dashboard
                    </span>
                    <h3>Dashboard</h3>
                </a>
                <?php if ($group_level==1):?> 
                    <a href="#user_management" data-target="user_management">
                        <span class="material-icons-sharp">
                            person_outline
                        </span>
                        <h3>User Management</h3>
                    </a>
                    <a href="#product_management" data-target="product_management">
                        <span class="material-icons-sharp">
                            insights
                        </span>
                        <h3>Product</h3>
                    </a>
                    <a href="#sales_management" data-target="sales_management">
                        <span class="material-icons-sharp">
                            inventory
                        </span>
                        <h3>Sales</h3>
                    </a>
                <?php endif; ?>
                <a href="report_form.php" data-target="reports_management">
                    <span class="material-icons-sharp">
                        report_gmailerrorred
                    </span>
                    <h3>Reports</h3>
                </a>
            </div>
        </aside>
        <main>
            <h1>Admin Panel</h1>
            <section id="dashboard" class="dashboard_content">
                <div class="content-section analyse">
                    <div class="sales">
                        <div class="status">
                            <div class="info">
                                <h3>Total Sales</h3>
                                <h1>
                                    <?php
                                        $dbService = new Services\DbService();
                                        $result12 = $dbService->query("SELECT SUM(quantity*sale_price) as total FROM `products`");
                                        echo $result12->fetch_assoc()['total']." M RUB";
                                    ?>
                                </h1>
                            </div>
                            <div class="progresss">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="visits">
                        <div class="status">
                            <div class="info">
                                <h3>Products</h3>
                                <h1>
                                    <?php
                                        $dbService = new Services\DbService();
                                        $result9 = $dbService->query("SELECT COUNT(*) as count FROM `products`");
                                        echo $result9->fetch_assoc()['count']." Products";
                                    ?>
                                </h1>
                            </div>
                            <div class="progresss">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="searches">
                        <div class="status">
                            <div class="info">
                                <h3>Categories</h3>
                                <h1>
                                    <?php
                                    $dbService = new Services\DbService();
                                    $result8 = $dbService->query("SELECT COUNT(*) as count FROM `categories`");
                                    echo $result8->fetch_assoc()['count']." Categories";
                                    ?>
                                </h1>
                            </div>
                            <div class="progresss">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($group_level==1):?>
                    <div class="new-users">
                        <h2>Administrators</h2>
                        <div class="user-list">
                        <?php
                        $dbService = new Services\DbService();
                        $result3 = $dbService->query("SELECT `username` FROM `users` WHERE `user_level` = 1");

                        if ($result3->num_rows > 0) {
                            while ($row = $result3->fetch_assoc()) {
                                ?>
                                <div class="user">
                                    <img src="res/img/admin-images/profile.png">
                                    <h2><?php echo htmlspecialchars($row['username']); ?></h2>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="user">
                                <h2>No admins found.</h2>
                            </div>
                            <?php
                        }
                        ?>
                        </div>
                    </div>
                    <div class="recent-orders">
                        <h2>Recent Orders</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Course Number</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>
            <section id="user_management" class="dashboard_content">
                <?php if ($group_level==3):?> 
                    <div class="new-users">
                        <?php
                            $dbService = new Services\DbService();
                            $result4 = $dbService->query("SELECT `user_level` FROM `users` WHERE `username` = '" . $_SESSION['username'] . "'");
                            if ($result4 && $row4 = $result4->fetch_assoc()) {
                                $group_level = $row4['user_level'];
                                $result5 = $dbService->query("SELECT `group_name` FROM `user_groups` WHERE `group_level` = " . $group_level);
                                if ($result5 && $row5 = $result5->fetch_assoc()) {
                                    $group_name = $row5['group_name'];
                                } else {
                                    $group_name = "Unknown Group";
                                }
                            } else {
                                $group_level = "Unknown Level";
                                $group_name = "Unknown Group";
                            }
                        ?>
                        <div class="user-list">
                            <img src="res/img/admin-images/profile.png" alt="Profile Picture" style="width: 5rem;height: 5rem;margin-bottom: 0.4rem;border-radius: 50%;">
                            <div class="user-info">
                                <h2><?php echo htmlspecialchars($_SESSION['username']); ?></h2>
                                <p>Name: <?php echo htmlspecialchars($_SESSION['name']); ?></p>
                                <p>User Group: <?php echo htmlspecialchars($group_name); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($group_level==1):?>
                    <div class="user-table">
                        <h2>User Management</h2>
                        <table>
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Group Level</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $dbService = new Services\DbService();
                                    $result6 = $dbService->query("SELECT id,username,user_level FROM `users`");
                                    if ($result6->num_rows > 0) {
                                        // Output data of each row
                                        while($row = $result6->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row["id"] . "</td>";
                                            echo "<td>" . $row["username"] . "</td>";
                                            echo "<td>";
                                            if ($row["user_level"] == 1) {
                                                echo "admin";
                                            } elseif ($row["user_level"] == 3) {
                                                echo "user";
                                            }
                                            echo '<td><a href="user-edit.php?id=' . $row["id"] . '">Edit</a></td>';
                                            echo '<td><a href="user-delete.php?id=' . $row["id"] . '">Delete</a></td>';
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>No users found</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>
            <section id="product_management" class="dashboard_content">
                <?php if ($group_level==1):?>
                    <div class="product-table">
                        <h2>Product Management</h2>
                        <table>
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Production Cost(M RUB)</th>
                                <th>Sale Price(M RUB)</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $dbService = new Services\DbService();
                                    $result7 = $dbService->query("SELECT name,category_id,buy_price,sale_price FROM `products`");
                                    if ($result7->num_rows > 0) {
                                        // Output data of each row
                                        while($row = $result7->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row["name"] . "</td>";
                                            echo "<td>";
                                            if ($row["category_id"] == 1) {
                                                echo "Fighter Jets";
                                            } elseif ($row["category_id"] == 2) {
                                                echo "Nuclear Bombs";
                                            }
                                            elseif ($row["category_id"] == 3) {
                                                echo "Balastic Missiles";
                                            }
                                            elseif ($row["category_id"] == 4) {
                                                echo "Battle Tanks";
                                            }
                                            elseif ($row["category_id"] == 5) {
                                                echo "Submarines";
                                            }
                                            elseif ($row["category_id"] == 6) {
                                                echo "Aircraft Carriers";
                                            }
                                            elseif ($row["category_id"] == 7) {
                                                echo "Helicopters";
                                            }
                                            elseif ($row["category_id"] == 8) {
                                                echo "Air Defense System";
                                            }
                                            echo "<td>" . $row["buy_price"] . "</td>";
                                            echo "<td>" . $row["sale_price"] . "</td>";
                                            echo '<td><a href="product-edit.php?id=' . $row["name"] . '">Edit</a></td>';
                                            echo '<td><a href="product-delete.php?id=' . $row["name"] . '">Delete</a></td>';
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>No products found</td></tr>";
                                    }
                                ?>
                                <tr>
                                    <td colspan="6" style="text-align: center;">
                                        <a href="product-add.php" class="add-product-button" style="font-size: 15px; padding: 10px 20px; background-color: #4CAF50; color: white; border-radius: 5px; text-decoration: none;">Add Products</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>
            <section id="sales_management" class="dashboard_content">
                <?php if ($group_level==1):?>
                    <div class="sales-table">
                        <h2>Sales Management</h2>
                        <table>
                            <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Sale Price</th>
                                <th>Total Price</th>
                                <th>Date & Time</th>
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $dbService = new Services\DbService();
                                    $result10 = $dbService->query("SELECT name,quantity,sale_price,date FROM `products`");
                                    if ($result10->num_rows > 0) {
                                        // Output data of each row
                                        while($row = $result10->fetch_assoc()) {
                                            $totalPrice = $row["quantity"] * $row["sale_price"];
                                            echo "<tr>";
                                            echo "<td>" . $row["name"] . "</td>";
                                            echo "<td>" . $row["quantity"] . "</td>";
                                            echo "<td>" . $row["sale_price"] . "</td>";
                                            echo "<td>" . $totalPrice . "</td>";
                                            echo "<td>" . $row["date"] . "</td>";
                                            echo '<td><a href="sale-edit.php?id=' . $row["name"] . '">Edit</a></td>';
                                            echo "</tr>";
                                        }
                                    }else {
                                        echo "<tr><td colspan='6'>No products found</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>
        </main>

        <div class="right-section">
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">
                        menu
                    </span>
                </button>
                <div class="dark-mode">
                    <span class="material-icons-sharp active">
                        light_mode
                    </span>
                    <span class="material-icons-sharp">
                        dark_mode
                    </span>
                </div>

                <div class="profile">
                    <div class="info">
                        <p>Hey,
                            <b><?php
                            if (isset($_SESSION['name'])) {
                                echo $_SESSION['name'];
                            } else {
                                echo 'user';
                            }
                            ?>
                            </b>
                        </p>
                        <small class="text-muted">
                            <?php
                            $dbService = new Services\DbService();
                            $result1 = $dbService->query("SELECT `user_level` FROM `users` WHERE `username` = '" . $_SESSION['username'] . "'");
                            $group_level = $result1->fetch_assoc()['user_level'];
                            $result2 = $dbService->query("SELECT `group_name` FROM `user_groups` WHERE `group_level` = " . $group_level);
                            echo $result2->fetch_assoc()['group_name'];
                            ?>
                        </small>
                    </div>
                    <div class="profile-photo">
                        <img src="res/img/admin-images/profile.png">
                    </div>
                </div>
            </div>
            <button id="logout-btn" class="logout-btn" onclick="logout()">
                Logout
            </button>
            <div class="user-profile">
                <div class="logo">
                    <img src="res/img/admin-images/logo2.png">
                    <h2>KGB</h2>
                    <p>Committee for State Security</p>
                </div>
            </div>

            <div class="user-profile">
                <div class="logo">
                    <img src="res/img/admin-images/logo1.svg">
                    <h2>Soviet Union</h2>
                    <p>Union of Soviet Socialist Republics</p>
                </div>
            </div>
        </div>
    </div>
    <script src="js/admin-orders.js"></script>
    <script src="js/admin-index.js"></script>
    <script>
        function logout() {
            window.location.href = 'logout.php';
        }
    </script>
</body>

</html>