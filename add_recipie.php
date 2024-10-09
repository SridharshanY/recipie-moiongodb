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
            <a class="nav-link active" href="add_recipie.php">Add Recipie</a>
            <a class="nav-link" href="view_recipie.php">View Recipie</a>
            <a class="nav-link" href="edit_recipie.php">Edit Recipie</a>
            <a class="nav-link link-danger" href="logout.php">Log Out</a>
        </nav>

        <div class="container mt-5">

            <h1 class="text-center mb-4">Search for a Recipe</h1>

            <form action="index.php" method="GET" class="d-flex justify-content-center mb-4">
                <input type="text" name="search" class="form-control me-2" style="width: 300px;"
                    placeholder="Enter meal name" required>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <?php
            if (isset($_GET['search'])) {
                $mealName = $_GET['search'];
                $url = "https://www.themealdb.com/api/json/v1/1/search.php?s=" . urlencode($mealName);

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                if (!$response = curl_exec($curl)) {
                    echo "<div class='alert alert-danger'>cURL Error: " . curl_error($curl) . "</div>";
                } else {
                    $data = json_decode($response, true);

                    if (!empty($data['meals'])) {
                        echo "<h2 class='text-center'>Results for '" . htmlspecialchars($mealName) . "'</h2>";
                        echo "<div class='row'>";

                        foreach ($data['meals'] as $meal) {
                            echo "<div class='col-md-4 mb-4'>";
                            echo "<div class='card'>";
                            echo "<img src='" . $meal['strMealThumb'] . "' class='card-img-top' alt='Meal Image'>";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title'>" . $meal['strMeal'] . "</h5>";
                            echo "<a href='meal.php?id=" . $meal['idMeal'] . "' class='btn btn-primary'>View Details</a>";
                            echo "</div></div></div>";
                        }

                        echo "</div>";
                    } else {
                        echo "<div class='alert alert-warning'>No meals found. Try another search.</div>";
                    }
                }
                curl_close($curl);
            }
            ?>
        </div>

        <!-- Bootstrap JS and Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    </body>

    </html>
    <?php
} else {
    header("Location:login.php");
}