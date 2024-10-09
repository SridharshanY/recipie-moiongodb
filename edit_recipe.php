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
$client = new Client("mongodb+srv://webdeveloper005ats:webdeveloper005@cluster0.9cx2u.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0");
$db = $client->Recipie; // Your database name
$collection = $db->recipe; // Your recipes collection

// Fetch the meal for editing
$recipe = null;
if (isset($_GET['id'])) {
    $mealID = $_GET['id'];
    
    // Validate the ObjectId
    if (preg_match('/^[a-f0-9]{24}$/', $mealID)) {
        $recipe = $collection->findOne(['_id' => new ObjectId($mealID)]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $recipe) {
    // Update the recipe
    $updatedData = [
        'name' => $_POST['name'],
        'instructions' => $_POST['instructions'],
        'ingredients' => $_POST['ingredients'] // Ingredients as comma-separated values
    ];

    $collection->updateOne(
        ['_id' => new ObjectId($mealID)],
        ['$set' => $updatedData]
    );

    // Redirect back to the view recipe page
    header("Location: view_recipe.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="nav nav-tabs flex-row justify-content-end">
        <a class="nav-link" href="index.php">Home</a>
        <a class="nav-link" href="add_recipe.php">Add recipe</a>
        <a class="nav-link" href="view_recipe.php">View recipe</a>
        <a class="nav-link active" href="edit_recipe.php">Edit recipe</a>
        <a class="nav-link link-danger" href="logout.php">Log Out</a>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit Recipe</h1>

        <?php if ($recipe): ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Recipe Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($recipe['name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="instructions" class="form-label">Instructions</label>
                    <textarea class="form-control" id="instructions" name="instructions" rows="5" required><?php echo htmlspecialchars($recipe['instructions']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="ingredients" class="form-label">Ingredients</label>
                    <?php
                    foreach ($recipe['ingredients'] as  $ingredient) {?>
                        <input type="text" class="form-control mt-2" id="ingredients" name="ingredients[]" value="<?php echo htmlspecialchars($ingredient); ?>" required>
                        <?php
                    }?>
                </div>
                <button type="submit" class="btn btn-primary">Update Recipe</button>
            </form>
        <?php else: ?>
            <div class="alert alert-danger">Recipe not found or invalid ID.</div>
        <?php endif; ?>

        <a href="view_recipe.php" class="btn btn-secondary mt-3">Go Back</a>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
