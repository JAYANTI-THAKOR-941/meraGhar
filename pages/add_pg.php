<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">

    <title>Add PG Listing</title>
    <style>
        .add-pg-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 750px;
            margin: 5% auto;
        }

        .add-pg-title {
            text-align: center;
            color: #333;
        }

        .add-pg-form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        .add-pg-form input, .add-pg-form textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .add-pg-button {
            width: 100%;
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            margin-top: 15px;
            cursor: pointer;
            border-radius: 5px;
        }

        .add-pg-button:hover {
            background: #0056b3;
        }

        .success-message {
            color: green;
            text-align: center;
        }

        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<?php 
session_start();
require_once('../config/db_connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT user_type FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user['user_type'] !== 'service_provider') {
    echo "<p class='error-message'>Access Denied! Only service providers can add PG listings.</p>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pg_name = $_POST['pg_name'];
    $location = $_POST['location'];
    $rent = $_POST['rent'];
    $description = $_POST['description'];
    $available_rooms = $_POST['available_rooms'];
    $amenities = $_POST['amenities'];

    $query = "INSERT INTO pg_listings (service_provider_id, pg_name, location, rent, description, available_rooms, amenities) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issdsiss", $user_id, $pg_name, $location, $rent, $description, $available_rooms, $amenities );

    if ($stmt->execute()) {
        $pg_id = $stmt->insert_id;

        if (!empty($_FILES['pg_images']['name'][0])) {
            $upload_dir = "../uploads/pg_images/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            foreach ($_FILES['pg_images']['tmp_name'] as $key => $tmp_name) {
                $image_name = basename($_FILES['pg_images']['name'][$key]);
                $image_path = $upload_dir . time() . "_" . $image_name;

                if (move_uploaded_file($tmp_name, $image_path)) {
                    $insert_image_query = "INSERT INTO pg_images (pg_id, image_url) VALUES (?, ?)";
                    $stmt_image = $conn->prepare($insert_image_query);
                    $stmt_image->bind_param("is", $pg_id, $image_path);
                    $stmt_image->execute();
                }
            }
        }

        echo "<p class='success-message'>PG Listing added successfully!</p>";
    } else {
        echo "<p class='error-message'>Error: " . $stmt->error . "</p>";
    }
}

?>

<?php include('../includes/header.php'); ?>

<div class="add-pg-container">
    <h2 class="add-pg-title">Add PG Listing</h2>
    <form method="POST" enctype="multipart/form-data" class="add-pg-form">
        <label for="pg_name">PG Name:</label>
        <input type="text" name="pg_name" required>

        <label for="location">Location:</label>
        <input type="text" name="location" required>

        <label for="rent">Rent (INR):</label>
        <input type="number" step="0.01" name="rent" required>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea>

        <label for="available_rooms">Available Rooms:</label>
        <input type="number" name="available_rooms" required>

        <label for="amenities">Amenities :</label>
        <input type="text" name="amenities">

        <label for="pg_images">Upload PG Images:</label>
        <input type="file" name="pg_images[]" multiple accept="image/*">

        <button type="submit" class="add-pg-button">Add Listing</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>

</body>
</html>
