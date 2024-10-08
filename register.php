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
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="reg_email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                        </div>
                        <div class="form-group">
                            <label for="reg_password">Password</label>
                            <input type="password" class="form-control" id="reg_password" name="password" placeholder="Create a password" required>
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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $status = 1;

    try {
        // Correct the DSN string format
        $conn = new PDO('mysql:host=localhost;dbname=temp', 'root', '');
    
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // Prepare the SQL statement without single quotes around the placeholders
        $stmt = $conn->prepare("INSERT INTO user (name, email, phone, password, status) 
                                VALUES (:name, :email, :phone, :password, :status)");
    
        // Bind parameters
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
        $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(":status", $status, PDO::PARAM_STR);
    
        // Execute the statement
        $stmt->execute();
        echo"<script>alert('Registered Successfully')</script>";
        
    } catch (PDOException $e) {
        // Print the error message if something goes wrong
        echo "Error: " . $e->getMessage();
    }    
}