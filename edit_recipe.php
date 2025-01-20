<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-cover bg-center bg-gradient-to-r from-blue-200 via-blue-300 to-blue-400" style="background-image: url('https://source.unsplash.com/1600x900/?cooking,kitchen');">
    <nav class="flex justify-end space-x-4 bg-black bg-opacity-60 p-4">
        <a href="index.php" class="text-white hover:text-yellow-400">Home</a>
        <a href="add_recipe.php" class="text-white hover:text-yellow-400">Add recipe</a>
        <a href="view_recipe.php" class="text-white hover:text-yellow-400">View recipe</a>
        <a href="edit_recipe.php" class="text-white hover:text-yellow-400 border-b-2 border-yellow-400">Edit recipe</a>
        <a href="logout.php" class="text-red-500 hover:text-white">Log Out</a>
    </nav>

    <div class="container mx-auto mt-10 p-8 bg-white bg-opacity-90 rounded-lg shadow-lg max-w-3xl">
        <h1 class="text-center text-3xl font-semibold text-blue-600 mb-6">Edit Recipe</h1>

        <?php if ($recipe): ?>
            <form method="POST">
                <div class="mb-6">
                    <label for="name" class="block text-lg font-medium text-gray-700">Recipe Name</label>
                    <input type="text" class="w-full p-3 mt-2 border border-gray-300 rounded-lg" id="name" name="name" value="<?php echo htmlspecialchars($recipe['name']); ?>" required>
                </div>

                <div class="mb-6">
                    <label for="instructions" class="block text-lg font-medium text-gray-700">Instructions</label>
                    <textarea class="w-full p-3 mt-2 border border-gray-300 rounded-lg" id="instructions" name="instructions" rows="5" required><?php echo htmlspecialchars($recipe['instructions']); ?></textarea>
                </div>

                <div class="mb-6">
                    <label for="ingredients" class="block text-lg font-medium text-gray-700">Ingredients</label>
                    <?php foreach ($recipe['ingredients'] as $ingredient): ?>
                        <input type="text" class="w-full p-3 mt-2 border border-gray-300 rounded-lg" name="ingredients[]" value="<?php echo htmlspecialchars($ingredient); ?>" required>
                    <?php endforeach; ?>
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update Recipe</button>
                </div>
            </form>
        <?php else: ?>
            <div class="text-center text-red-600 font-semibold">Recipe not found or invalid ID.</div>
        <?php endif; ?>

        <div class="mt-6 text-center">
            <a href="view_recipe.php" class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Go Back</a>
        </div>
    </div>
</body>

</html>
