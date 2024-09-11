<?php
include './DbService.php';
use Services\DbService;

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $isSignUp = $_POST['isSignUp'];

  $dbService = new DbService();

  try {
    if ($isSignUp !== "true") {
      $sql = "SELECT * FROM users WHERE username = '$username'";
      $result = $dbService->query($sql);
      echo ($result->num_rows);

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $db_pw = $row['password'];
        if (password_verify($password, $db_pw)) {
          $_SESSION['name'] = $row['name'] ?? $username;
          $_SESSION['username'] = $username;
          header('Location: /kgb/dashboard.php');
          exit();
        } else {
          $_SESSION['error'] = 'Invalid password for user ' . $username;
          header('Location: /kgb/login-page.php');
          exit();
        }
      } else {
        $error = 'Invalid username or password';
        $_SESSION['error'] = $error;
        header('Location: /kgb/login-page.php');
        exit();
      }
    } else {
      $name = $_POST['name'];
      $password = password_hash($password, PASSWORD_DEFAULT);
      $sql = "INSERT INTO users (username, password, name) VALUES ('$username', '$password', '$name')";
      $result = $dbService->execute($sql);

      if ($result === true) {
        $_SESSION['name'] = $name;
        $_SESSION['username'] = $username;
        header('Location: /kgb/dashboard.php');
        exit();
      } else {
        $error = 'Failed to create account:';
        $_SESSION['error'] = $error;
        header('Location: /kgb/login-page.php');
        exit();
      }
    }
  } catch (Exception $e) {
    $error = $e->getMessage();
    $_SESSION['error'] = $error;
    header('Location: /kgb/login-page.php');
    exit();
  }
} else {
  header("Location: /kgb/templates/method-not-allowed.php");
  exit();
}
