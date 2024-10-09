<?php
session_start();

require 'vendor/autoload.php'; // Include Composer's autoloader for MongoDB

// Check if the form was submitted and user is logged in
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['active']) && $_SESSION['active'] == 1) {

    // Connection to MongoDB
    try {
        $client = new MongoDB\Client("mongodb+srv://webdeveloper005ats:webdeveloper005@cluster0.9cx2u.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0"); // Replace with your MongoDB server URI if needed
        $db = $client->Recipie; // Replace with your database name
        $collection = $db->recipe; // Replace with your collection name
    } catch (Exception $e) {
        die("Error connecting to MongoDB: " . $e->getMessage());
    }

    // Retrieve form data
    $name = $_POST['name'];
    $instructions = $_POST['instructions'];
    $ingredients = $_POST['ingredient'];

    // Handle file upload (if provided)
    $file_path = '';
    if (isset($_FILES['thumb']) && $_FILES['thumb']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['thumb']['tmp_name'];
        $file_name = $_FILES['thumb']['name'];
        $file_destination = 'uploads/' . $file_name;

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($file_tmp, $file_destination)) {
            $file_path = $file_destination; // Store file path in the database
        } else {
            echo "File upload failed.<br>";
        }
    }

    // Prepare recipe data for insertion into MongoDB
    $recipeData = [
        'name' => $name,
        'instructions' => $instructions,
        'ingredients' => $ingredients,
        'user_email' => $_SESSION['user_email'],
        'image' => $file_path, // Store image path if uploaded
        'created_at' => date('Y-m-d H:i:s') // Current timestamp
    ];

    // Insert the recipe data into MongoDB
    try {
        $insertResult = $collection->insertOne($recipeData);
        if ($insertResult->getInsertedCount() === 1) {
            echo "<script>alert('Recipe successfully added!'); window.location.href = 'view_recipe.php';</script>";
        } else {
            echo "Failed to add recipe.<br>";
        }
    } catch (Exception $e) {
        echo "Error inserting recipe into MongoDB: " . $e->getMessage();
    }
} else {
    header("Location: login.php");
}
