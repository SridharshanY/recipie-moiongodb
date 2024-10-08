<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Correct the DSN string format
        $conn = new PDO('mysql:host=localhost;dbname=temp', 'root', '');

        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the statement to fetch user by email
        $stmt = $conn->prepare('SELECT * FROM user WHERE email=:email');

        // Bind the email parameter
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        // Execute the statement
        $stmt->execute();

        // Set fetch mode to associative array
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // Fetch the user details
        $results = $stmt->fetch();

        // Check if user exists and verify the password
        if ($results && password_verify($password, $results['password'])) {
            ?>
            <script>
                alert('Login Successful')
            </script>
            <?php
            $_SESSION['active']=1;
            header('Location:index.php');
        } else {
            ?>
            <script>
                alert('Login Failed')
            </script>
            <?php
            header('Location:login.php');
        }

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
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