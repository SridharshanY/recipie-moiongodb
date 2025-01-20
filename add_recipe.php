<?php
session_start();
if (isset($_SESSION["active"]) && $_SESSION["active"] == 1) {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MealDB - Add Recipe</title>
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="bg-gray-100 min-h-screen bg-gradient-to-r from-blue-200 via-blue-300 to-blue-400">
    <nav class="bg-indigo-600 text-white p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.php" class="text-xl font-bold">MealDB</a>
            <div class="flex space-x-4">
                <a href="index.php" class="hover:underline">Home</a>
                <a href="add_recipe.php" class="underline font-semibold">Add Recipe</a>
                <a href="view_recipe.php" class="hover:underline">View Recipe</a>
                <a href="logout.php" class="hover:underline text-red-300">Log Out</a>
            </div>
        </div>
    </nav>

        <div class="container mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
            <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Add Your Recipe</h1>
            <form action="submit_recipe.php" method="post" enctype="multipart/form-data" class="space-y-6">
                <!-- Recipe Name and Image -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-gray-700 font-semibold mb-2">Recipe Name</label>
                        <input type="text" id="name" name="name" class="w-full border border-gray-300 rounded-md p-2"
                            placeholder="Enter food name" required>
                    </div>
                    <div>
                        <label for="thumb" class="block text-gray-700 font-semibold mb-2">Upload Picture</label>
                        <input type="file" id="thumb" name="thumb" class="w-full border border-gray-300 rounded-md p-2">
                    </div>
                </div>

                <!-- Instructions -->
                <div>
                    <label for="instructions" class="block text-gray-700 font-semibold mb-2">Instructions</label>
                    <textarea id="instructions" name="instructions" rows="6"
                        class="w-full border border-gray-300 rounded-md p-2" placeholder="Write step-by-step instructions..."
                        required></textarea>
                </div>

                <!-- Ingredients -->
                <div id="inputContainer">
                    <label class="block text-gray-700 font-semibold mb-2">Ingredients</label>
                    <input type="text" name="ingredient[]" class="w-full border border-gray-300 rounded-md p-2 mb-3"
                        placeholder="Add Ingredient" required>
                </div>

                <button id="addInputBtn" type="button"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-md shadow-md hover:bg-indigo-700">
                    Add Another Ingredient
                </button>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-green-700">
                        Submit Recipe
                    </button>
                </div>
            </form>
        </div>

        <script>
            // JavaScript to add new input field
            document.getElementById('addInputBtn').addEventListener('click', function () {
                // Create a new input element
                var input = document.createElement('input');
                input.type = 'text';
                input.name = 'ingredient[]';
                input.className = 'w-full border border-gray-300 rounded-md p-2 mb-3';
                input.placeholder = 'Add Ingredient';
                
                // Add the input to the container
                document.getElementById('inputContainer').appendChild(input);
            });
        </script>
    </body>

    </html>
    <?php
} else {
    header("Location:login.php");
}
