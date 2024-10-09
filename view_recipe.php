<?php
session_start();
require 'vendor/autoload.php'; // Ensure you're using Composer's autoloader

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

// Check if user is logged in
if (!isset($_SESSION["active"]) || $_SESSION["active"] != 1) {
    header("Location: login.php");
    exit();
}

// Connect to MongoDB
$client = new Client("mongodb+srv://webdeveloper005ats:webdeveloper005@cluster0.9cx2u.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0"); // Adjust the URI if needed
$db = $client->Recipie; // Your database name
$collection = $db->recipe; // Your recipes collection

// Fetch recipes for the logged-in user
$userId = $_SESSION["user_email"]; // Assuming you store user email in the session
$recipes = $collection->find(['user_email' => $userId]); // Adjust the filter as per your schema

// Convert the cursor to an array to check if it's empty
$recipesArray = iterator_to_array($recipes);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Recipes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="nav nav-tabs flex-row justify-content-end">
        <a class="nav-link" href="index.php">Home</a>
        <a class="nav-link" href="add_recipe.php">Add recipe</a>
        <a class="nav-link active" href="view_recipe.php">View recipe</a>
        <a class="nav-link link-danger" href="logout.php">Log Out</a>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Your Recipes</h1>

        <?php if (empty($recipesArray)): ?>
            <div class="alert alert-warning">No recipes found.</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($recipesArray as $recipe): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php if (!empty($recipe['image'])): ?>
                                <img src="<?php echo htmlspecialchars($recipe['image']); ?>" class="card-img-top"
                                    alt="<?php echo htmlspecialchars($recipe['name']); ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($recipe['name']); ?></h5>
                                <a href="mongo_meal.php?id=<?php echo (string) $recipe['_id']; ?>" class="btn btn-primary">View
                                    Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <a href="index.php" class="btn btn-secondary mt-3">Go Back</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>