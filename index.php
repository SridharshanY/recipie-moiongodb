<?php
session_start();
if (isset($_SESSION["active"]) && $_SESSION["active"] == 1) {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MealDB - Search Recipe</title>
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="bg-gray-100 min-h-screen flex flex-col bg-gradient-to-r from-blue-200 via-blue-300 to-blue-400">
        <!-- Navigation -->
        <nav class="bg-indigo-600 text-white p-4 shadow-lg">
            <div class="container mx-auto flex justify-between items-center">
                <a href="index.php" class="text-xl font-bold">MealDB</a>
                <div class="flex space-x-4">
                    <a href="index.php" class="hover:underline">Home</a>
                    <a href="add_recipe.php" class="hover:underline">Add Recipe</a>
                    <a href="view_recipe.php" class="hover:underline">View Recipe</a>
                    <a href="logout.php" class="hover:underline text-red-300">Log Out</a>
                </div>
            </div>
        </nav>

        <!-- Search Form -->
        <div class="container mx-auto mt-10 flex flex-col items-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Search for a Recipe</h1>
            <form action="index.php" method="GET" class="flex space-x-4 w-full max-w-lg">
                <input type="text" name="search" 
                    class="flex-grow p-3 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200"
                    placeholder="Enter ingredients (e.g., chicken,tomato)" required>
                <button type="submit" 
                    class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    Search
                </button>
            </form>
        </div>

        <!-- Results Section -->
        <div class="container mx-auto mt-10">
            <?php
            if (isset($_GET['search'])) {
                $ingredients = $_GET['search'];
                $ingredientArray = array_map('trim', explode(',', $ingredients));
                $allRecipes = [];
                $commonRecipes = null;

                foreach ($ingredientArray as $ingredient) {
                    $url = "https://www.themealdb.com/api/json/v1/1/filter.php?i=" . urlencode($ingredient);

                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                    $response = curl_exec($curl);

                    if (!$response) {
                        echo "<div class='bg-red-100 text-red-700 p-4 rounded-lg mb-4'>cURL Error for ingredient '$ingredient': " . curl_error($curl) . "</div>";
                        curl_close($curl);
                        continue;
                    }

                    $data = json_decode($response, true);

                    if (!empty($data['meals'])) {
                        $recipes = array_column($data['meals'], null, 'idMeal'); // Index by meal ID
                        if ($commonRecipes === null) {
                            $commonRecipes = $recipes; // First ingredient
                        } else {
                            $commonRecipes = array_intersect_key($commonRecipes, $recipes); // Find common recipes
                        }
                    } else {
                        echo "<div class='bg-yellow-100 text-yellow-700 p-4 rounded-lg mb-4'>No recipes found for ingredient '$ingredient'.</div>";
                    }

                    curl_close($curl);
                }

                if (!empty($commonRecipes)) {
                    echo "<h2 class='text-center text-2xl font-bold mb-6'>Results for ingredients: '" . htmlspecialchars($ingredients) . "'</h2>";
                    echo "<div class='grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6'>";

                    foreach ($commonRecipes as $meal) {
                        echo "<div class='bg-white shadow-lg rounded-lg overflow-hidden'>";
                        echo "<img src='" . $meal['strMealThumb'] . "' alt='Meal Image' class='w-full h-48 object-cover'>";
                        echo "<div class='p-4'>";
                        echo "<h5 class='text-lg font-bold mb-2'>" . $meal['strMeal'] . "</h5>";
                        echo "<a href='meal.php?id=" . $meal['idMeal'] . "' class='inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition'>View Details</a>";
                        echo "</div></div>";
                    }

                    echo "</div>";
                } else {
                    echo "<div class='bg-yellow-100 text-yellow-700 p-4 rounded-lg text-center'>No recipes found matching all the given ingredients.</div>";
                }
            }
            ?>
        </div>
    </body>

    </html>
    <?php
} else {
    header("Location:login.php");
}
?>
