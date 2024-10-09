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
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <nav class="nav nav-tabs flex-row justify-content-end">
            <a class="nav-link" href="index.php">Home</a>
            <a class="nav-link active" href="add_recipe.php">Add recipe</a>
            <a class="nav-link" href="view_recipe.php">View recipe</a>
            <a class="nav-link link-danger" href="logout.php">Log Out</a>
        </nav>

        <div class="container mt-5">
            <h1 class="text-center mb-4">Add Your Recipe</h1>
            <form action="submit_recipe.php" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col input-group">
                        <span class="input-group-text">Name</span>
                        <input type="text" name="name" class="form-control" placeholder="Enter food name">
                    </div>
                    <div class="col">
                        <span>Upload picture</span>
                        <input type="file" name="thumb">
                    </div>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Instructions</span>
                    <textarea name="instructions" id="" class="form-control"></textarea>
                </div>
                <div id="inputContainer">

                </div>
                <button id="addInputBtn" type="button" class="btn btn-primary mt-3">Ingredient+</button>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Submit Recipe</button>
                </div>
            </form>
        </div>

        <!-- Bootstrap JS and Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
        <script>
            // JavaScript to add new input field
            document.getElementById('addInputBtn').addEventListener('click', function () {
                // Create a new input element
                var input = document.createElement('input');
                input.type = 'text';
                input.name = 'ingredient[]';
                input.className = 'form-control mt-2';
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