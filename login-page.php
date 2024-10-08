<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login-page-style.css">
    <title>Login Page</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form method="post" action="./Services/Auth.php">
                <h1>Create Account</h1>
                <span>or use your details for registeration</span>
                <input type="text" placeholder="Name" name="name">
                <input type="text" placeholder="Username" name="username">
                <input type="password" placeholder="Password" name="password">
                <input type="hidden" name="isSignUp" value="true">
                <button>Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form method="post" action="./Services/Auth.php">
                <h1>Sign In</h1>
                <span>or use your Username & Password</span>
                <input type="text" placeholder="Username" name="username">
                <input type="password" placeholder="Password" name="password">
                <input type="hidden" name="isSignUp" value="false">
                <button type="submit">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back Comrade!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Comrade!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/login-page-script.js"></script>

    <?php
    session_start();
    if (isset($_SESSION['error'])) {
        echo "<script>alert('" . $_SESSION['error'] . "')</script>";
        unset($_SESSION['error']);
    }
    ?>
</body>

</html>