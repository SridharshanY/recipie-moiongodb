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
$client = new Client("mongodb+srv://webdeveloper005ats:webdeveloper005@cluster0.9cx2u.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0");
$db = $client->Recipie; // Your database name
$collection = $db->recipe; // Your recipes collection

// Delete the recipe
if (isset($_GET['id'])) {
    $mealID = $_GET['id'];

    // Validate the ObjectId
    if (preg_match('/^[a-f0-9]{24}$/', $mealID)) {
        $result = $collection->deleteOne(['_id' => new ObjectId($mealID)]);
        
        if ($result->getDeletedCount() === 1) {
            // Redirect to the view recipe page with a success message
            $_SESSION['message'] = 'Recipe deleted successfully.';
            header("Location: view_recipe.php");
            exit();
        } else {
            $_SESSION['message'] = 'Recipe not found or could not be deleted.';
        }
    } else {
        $_SESSION['message'] = 'Invalid meal ID.';
    }
} else {
    $_SESSION['message'] = 'No meal ID provided.';
}

// Redirect back to the view recipe page in case of an error
header("Location: view_recipe.php");
exit();
?>
