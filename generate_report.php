<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        // Validate dates
        if (strtotime($start_date) > strtotime($end_date)) {
            echo "Start date cannot be later than end date.";
            exit;
        }

        // Assuming you have a DbService class for database operations
        $dbService = new Services\DbService();

        // Use prepared statements to prevent SQL injection
        $stmt = $dbService->prepare("SELECT sales, product_name, date_column FROM products WHERE date_column BETWEEN ? AND ?");
        $stmt->bind_param("ss", $start_date, $end_date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<h1>Report from $start_date to $end_date</h1>";
            echo "<table border='1'>
                    <tr>
                        <th>Product Name</th>
                        <th>Sales</th>
                        <th>Date</th>
                    </tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['product_name']}</td>
                        <td>{$row['sales']}</td>
                        <td>{$row['date_column']}</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "No data found for the selected time period.";
        }

        $stmt->close();
        $dbService->close();
    }
?>