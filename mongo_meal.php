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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Details</title>
    <!-- Bootstrap CSS -->
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
        <?php
        if (isset($_GET['id'])) {
            $mealID = $_GET['id'];

            // Validate the ObjectId
            if (!preg_match('/^[a-f0-9]{24}$/', $mealID)) {
                echo "<div class='alert alert-danger'>Invalid meal ID.</div>";
            } else {
                // Fetch the meal from MongoDB
                $recipe = $collection->findOne(['_id' => new ObjectId($mealID)]);

                if ($recipe) {
                    echo "<div class='row'>";
                    echo "<div class='col-md-6'>";
                    echo "<h1>" . htmlspecialchars($recipe['name']) . "</h1>";
                    if (!empty($recipe['image'])) {
                        echo "<img src='" . htmlspecialchars($recipe['image']) . "' class='img-fluid mb-4' alt='" . htmlspecialchars($recipe['name']) . "'>";
                    }
                    echo "</div>";

                    echo "<div class='col-md-6'>";
                    echo "<h2>Instructions</h2>";
                    echo "<p>" . nl2br(htmlspecialchars($recipe['instructions'])) . "</p>";
                    echo "<h2>Ingredients</h2>";
                    echo "<ul class='list-group'>";
                    foreach ($recipe['ingredients'] as $ingredient) {
                        echo "<li class='list-group-item'>" . htmlspecialchars($ingredient) . "</li>";
                    }
                    echo "</ul>";
                    echo "</div></div>";
                } else {
                    echo "<div class='alert alert-warning'>No meal found.</div>";
                }
            }
        }
        ?>
        <a href="view_recipe.php" class="btn btn-secondary mt-3">Go Back</a>
        <a href="edit_recipe.php?id=<?php echo (string) $recipe['_id']; ?>" class="btn btn-primary mt-3">Edit</a>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>