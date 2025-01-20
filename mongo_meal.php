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
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-200 via-blue-300 to-blue-400">

    <nav class="bg-blue-600 p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div>
                <a href="index.php" class="text-white text-lg font-semibold">Home</a>
            </div>
            <div class="space-x-4">
                <a href="add_recipe.php" class="text-white">Add Recipe</a>
                <a href="view_recipe.php" class="text-white">View Recipe</a>
                <a href="logout.php" class="text-red-500">Log Out</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto my-10 p-5 bg-white rounded-lg shadow-lg">
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
                    echo "<div class='grid grid-cols-1 md:grid-cols-2 gap-8'>";
                    echo "<div>";
                    echo "<h1 class='text-3xl font-bold text-gray-800'>" . htmlspecialchars($recipe['name']) . "</h1>";
                    if (!empty($recipe['image'])) {
                        echo "<img src='" . htmlspecialchars($recipe['image']) . "' class='mt-4 max-w-full rounded-lg shadow-md' alt='" . htmlspecialchars($recipe['name']) . "'>";
                    }
                    echo "</div>";

                    echo "<div>";
                    echo "<h2 class='text-2xl font-semibold text-gray-700 mt-4'>Instructions</h2>";
                    echo "<p class='mt-2 text-gray-600'>" . nl2br(htmlspecialchars($recipe['instructions'])) . "</p>";
                    echo "<h2 class='text-2xl font-semibold text-gray-700 mt-6'>Ingredients</h2>";
                    echo "<ul class='mt-2 list-disc list-inside space-y-2'>";
                    foreach ($recipe['ingredients'] as $ingredient) {
                        echo "<li class='text-gray-600'>" . htmlspecialchars($ingredient) . "</li>";
                    }
                    echo "</ul>";
                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "<div class='text-center text-red-500'>No meal found.</div>";
                }
            }
        }
        ?>
        <div class="flex justify-between mt-6">
            <a href="view_recipe.php" class="text-blue-500 hover:underline">Go Back</a>
            <a href="edit_recipe.php?id=<?php echo (string) $recipe['_id']; ?>" class="text-blue-500 hover:underline">Edit</a>
        </div>
    </div>

</body>

</html>
