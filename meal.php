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
    <div class="container mt-5">
        <?php
        if (isset($_GET['id'])) {
            $mealID = $_GET['id'];
            $url = "https://www.themealdb.com/api/json/v1/1/lookup.php?i=" . urlencode($mealID);

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            if (!$response = curl_exec($curl)) {
                echo "<div class='alert alert-danger'>cURL Error: " . curl_error($curl) . "</div>";
            } else {
                $data = json_decode($response, true);
                if (!empty($data['meals'])) {
                    $meal = $data['meals'][0];
                    echo "<div class='row'>";
                    echo "<div class='col-md-6'>";
                    echo "<h1>" . $meal['strMeal'] . "</h1>";
                    echo "<img src='" . $meal['strMealThumb'] . "' class='img-fluid mb-4' alt='" . $meal['strMeal'] . "'>";
                    echo "</div>";

                    echo "<div class='col-md-6'>";
                    echo "<h2>Instructions</h2>";
                    echo "<p>" . nl2br($meal['strInstructions']) . "</p>";
                    echo "<h2>Ingredients</h2>";
                    echo "<ul class='list-group'>";
                    for ($i = 1; $i <= 20; $i++) {
                        if (!empty($meal["strIngredient$i"])) {
                            echo "<li class='list-group-item'>" . $meal["strIngredient$i"] . " - " . $meal["strMeasure$i"] . "</li>";
                        }
                    }
                    echo "</ul>";
                    echo "</div></div>";
                } else {
                    echo "<div class='alert alert-warning'>No meal found.</div>";
                }
            }
            curl_close($curl);
        }
        ?>
        <a href="index.php" class="btn btn-secondary mt-3">Go Back</a>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
