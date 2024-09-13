<?php
include_once './Services/DbService.php';
session_start();
if (!isset($_SESSION['name'])) {
    header('Location: login-page.php');
    exit();
}

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Select Time Period</title>
    </head>
    <body>
        <h1>Select Time Period for Report</h1>
        <form action="generate_report.php" method="POST">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>
            <br>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>
            <br>
            <input type="submit" value="Generate Report">
        </form>
    </body>
    </html>
?>