<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration Page</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="flex justify-center items-center min-h-screen">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
            <!-- Registration Form -->
            <h3 class="text-center text-2xl font-semibold mb-6">Register</h3>
            <form action="register.php" method="POST">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium">Full Name</label>
                    <input type="text" class="w-full p-3 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" id="name" name="name" placeholder="Enter your full name" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium">Email address</label>
                    <input type="email" class="w-full p-3 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" id="reg_email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-medium">Phone Number</label>
                    <input type="tel" class="w-full p-3 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" id="phone" name="phone" placeholder="Enter your phone number" required>
                </div>
                <div class="mb-6">
                    <label for="reg_password" class="block text-gray-700 font-medium">Password</label>
                    <input type="password" class="w-full p-3 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" id="reg_password" name="password" placeholder="Create a password" required>
                </div>
                <button type="submit" name="submit" class="w-full bg-green-500 text-white p-3 rounded-md hover:bg-green-600 transition duration-200">Register</button>
                <p class="text-center text-gray-500 mt-4">Already have an account? <a href="login.php" class="text-blue-500 hover:underline">Login Here!</a></p>
            </form>
        </div>
    </div>

    <!-- Tailwind JS (Optional for interactivity) -->
    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>

<?php
require 'vendor/autoload.php'; // Include Composer's autoloader for MongoDB

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Connecting to MongoDB
        $client = new MongoDB\Client("mongodb+srv://webdeveloper005ats:webdeveloper005@cluster0.9cx2u.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0");

        // Select the database and collection
        $db = $client->Recipie;  // Replace 'mydatabase' with your database name
        $collection = $db->users;   // Replace 'users' with your collection name

        // Prepare the data to insert
        $userData = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $hashedPassword,
            'status' => 1, // Active user
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Insert the data into MongoDB
        $result = $collection->insertOne($userData);

        // Check if the data was inserted
        if ($result->getInsertedCount() == 1) {
            echo "<script>
                    alert('Registration successful! Please log in.');
                    window.location.href = 'login.php'; // Redirect to login page
                  </script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.');</script>";
        }

    } catch (Exception $e) {
        echo "<script>alert('Error connecting to MongoDB: " . $e->getMessage() . "');</script>";
    }
}
?>
