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
                $_SESSION['user_email'] = $user['email']; // Store user's email id in session

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
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-200 via-blue-300 to-blue-400">
    <div class="flex justify-center items-center h-screen">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-2xl font-bold text-center text-gray-700 mb-6">Login</h3>
                <form action="login.php" method="POST" class="space-y-4">
                    <!-- Email input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                        <input type="email" id="email" name="email"
                            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Enter your email" required>
                    </div>

                    <!-- Password input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password"
                            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Enter your password" required>
                    </div>

                    <!-- Submit button -->
                    <button type="submit"
                        class="w-full py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition duration-300">
                        Login
                    </button>

                    <!-- Forgot Password and Sign Up links -->
                    <div class="text-center mt-4">
                        <a href="register.php" class="text-indigo-600 hover:underline text-sm">Create an Account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
