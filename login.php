<?php
session_start();
require 'vendor/autoload.php'; // Include Composer's autoloader for MongoDB

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    try {
        // Connect to MongoDB
        $client = new MongoDB\Client("mongodb+srv://webdeveloper005ats:webdeveloper005@cluster0.9cx2u.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0"); // Adjust the connection string as needed
        $db = $client->Recipie;  // Replace 'mydatabase' with your actual database name
        $collection = $db->users;   // Replace 'users' with your actual collection name

        // Find the user with the matching email
        $user = $collection->findOne(['email' => $email]);
        if ($user) {
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Successful login: Set session variables
                $_SESSION['active'] = 1; // Store user ID in session
                $_SESSION['user_name'] = $user['name']; // Store user's name in session

                // Redirect to the dashboard or homepage
                header('Location: index.php');
                exit();
            } else {
                // Incorrect password
                echo "<script>alert('Incorrect password. Please try again.');</script>";
            }
        } else {
            // User not found
            echo "<script>alert('No user found with this email. Please register first.');</script>";
        }

    } catch (Exception $e) {
        // Handle connection or query errors
        echo "<script>alert('Error connecting to MongoDB: " . $e->getMessage() . "');</script>";
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Login</h3>
                        <form action="login.php" method="POST">
                            <!-- Email input -->
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" required>
                            </div>

                            <!-- Password input -->
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Enter your password" required>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block">Login</button>

                            <!-- Forgot Password and Sign Up links -->
                            <div class="text-center mt-3">
                                <a href="register.php" class="small">Create an Account</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>









    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>