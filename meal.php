<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Details</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-200 via-blue-300 to-blue-400 min-h-screen">
    <div class="container mx-auto p-6">
        <?php
        if (isset($_GET['id'])) {
            $mealID = $_GET['id'];
            $url = "https://www.themealdb.com/api/json/v1/1/lookup.php?i=" . urlencode($mealID);

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            if (!$response = curl_exec($curl)) {
                echo "<div class='bg-red-100 text-red-700 p-4 rounded-lg'>cURL Error: " . curl_error($curl) . "</div>";
            } else {
                $data = json_decode($response, true);
                if (!empty($data['meals'])) {
                    $meal = $data['meals'][0];
                    echo "<div class='grid grid-cols-1 md:grid-cols-2 gap-8 bg-white shadow-lg rounded-lg p-6'>";
                    
                    // Meal Image and Title
                    echo "<div>";
                    echo "<h1 class='text-3xl font-bold mb-4'>" . $meal['strMeal'] . "</h1>";
                    echo "<img src='" . $meal['strMealThumb'] . "' class='rounded-lg w-full object-cover mb-4' alt='" . $meal['strMeal'] . "'>";
                    echo "</div>";

                    // Instructions and Ingredients
                    echo "<div>";
                    echo "<h2 class='text-2xl font-semibold mb-3'>Instructions</h2>";
                    echo "<p class='text-gray-700 leading-relaxed mb-6'>" . nl2br($meal['strInstructions']) . "</p>";
                    
                    echo "<h2 class='text-2xl font-semibold mb-3'>Ingredients</h2>";
                    echo "<ul class='list-disc pl-6'>";
                    for ($i = 1; $i <= 20; $i++) {
                        if (!empty($meal["strIngredient$i"])) {
                            echo "<li class='text-gray-800'>" . $meal["strIngredient$i"] . " - " . $meal["strMeasure$i"] . "</li>";
                        }
                    }
                    echo "</ul>";
                    echo "</div>";

                    echo "</div>";
                } else {
                    echo "<div class='bg-yellow-100 text-yellow-800 p-4 rounded-lg'>No meal found.</div>";
                }
            }
            curl_close($curl);
        }
        ?>
        <!-- Back Button -->
        <div class="text-center mt-6">
            <a href="index.php" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                Go Back
            </a>
        </div>
    </div>
</body>

</html>
