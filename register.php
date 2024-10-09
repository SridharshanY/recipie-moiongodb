<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Registration Form -->
                        <h3 class="card-title text-center mb-4 mt-3">Register</h3>
                        <form action="register.php" method="POST">
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter your full name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="reg_email" name="email"
                                    placeholder="Enter your email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                    placeholder="Enter your phone number" required>
                            </div>
                            <div class="form-group">
                                <label for="reg_password">Password</label>
                                <input type="password" class="form-control" id="reg_password" name="password"
                                    placeholder="Create a password" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-success btn-block">Register</button>
                            <p class="text-center">Already have an account? <a href="login.php">Login Here!</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
        $client = new MongoDB\Client("mongodb+srv://webdeveloper005ats:webdeveloper005@cluster0.9cx2u.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0"); // Change the URL if your MongoDB is hosted elsewhere

        // Select the database and collection
        $db = $client->Recipie;  // Replace 'mydatabase' with your database name
        $collection = $db->users;   // Replace 'users' with your collection name

        // Prepare the data to insert
        $userData = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $hashedPassword,
            'status' => 1, // For example, 1 for active users
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Insert the data into MongoDB
        $result = $collection->insertOne($userData);

        // Check if the data was inserted
        if ($result->getInsertedCount() == 1) {
            // Echo the JavaScript alert and redirect to login page
            echo "<script>
                    alert('Registration successful! Please log in.');
                    window.location.href = 'login.php'; // Redirect to the login page
                  </script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.');</script>";
        }

    } catch (Exception $e) {
        echo "<script>alert('Error connecting to MongoDB: " . $e->getMessage() . "');</script>";
    }}