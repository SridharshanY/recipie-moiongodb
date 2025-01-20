<?php
session_start();
if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-info'>" . $_SESSION['message'] . "</div>";
    unset($_SESSION['message']); // Clear the message after displaying
}
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
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-200 via-blue-300 to-blue-400 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-indigo-600 text-white p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.php" class="text-xl font-bold">MealDB</a>
            <div class="flex space-x-4">
                <a href="index.php" class="hover:underline">Home</a>
                <a href="add_recipe.php" class="hover:underline">Add Recipe</a>
                <a href="view_recipe.php" class="underline font-semibold">View Recipe</a>
                <a href="logout.php" class="hover:underline text-red-300">Log Out</a>
            </div>
        </div>
    </nav>

    <!-- Recipes Section -->
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Your Recipes</h1>

        <?php if (empty($recipesArray)): ?>
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg text-center">
                No recipes found.
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <?php foreach ($recipesArray as $recipe): ?>
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                        <?php if (!empty($recipe['image'])): ?>
                            <img src="<?php echo htmlspecialchars($recipe['image']); ?>" 
                                class="w-full h-48 object-cover"
                                alt="<?php echo htmlspecialchars($recipe['name']); ?>">
                        <?php endif; ?>
                        <div class="p-4">
                            <h5 class="text-lg font-bold mb-2"><?php echo htmlspecialchars($recipe['name']); ?></h5>
                            <div class="flex space-x-2">
                                <a href="mongo_meal.php?id=<?php echo (string) $recipe['_id']; ?>" 
                                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                                    View Details
                                </a>
                                <a href="delete_recipe.php?id=<?php echo (string) $recipe['_id']; ?>" 
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                                    Delete
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="text-center mt-6">
            <a href="index.php" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">
                Go Back
            </a>
        </div>
    </div>
</body>

</html>
