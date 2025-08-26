<?php
include('../config/db_connection.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_GET['pg_id'])) { 
    echo "Invalid PG ID";
    exit;
}

$pg_id = intval($_GET['pg_id']);

$query = "SELECT * FROM pg_listings WHERE pg_id = $pg_id";
$result = mysqli_query($conn, $query);
$pg = mysqli_fetch_assoc($result);

if (!$pg) {
    echo "PG not found.";
    exit;
}

// Fetch images
$imageQuery = "SELECT image_url FROM pg_images WHERE pg_id = $pg_id";
$imageResult = mysqli_query($conn, $imageQuery);
$images = mysqli_fetch_all($imageResult, MYSQLI_ASSOC);

// Split amenities into an array
$amenities = explode(',', $pg['amenities']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pg['pg_name']); ?></title>
    <link rel="stylesheet" href="../assets/css/styles.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            text-align: center;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .pg-container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            /* box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); */
        }

        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            padding: 20px 0;
        }

        .image-gallery img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }

        .image-gallery img:hover {
            transform: scale(1.05);
        }

        .pg-info {
            text-align: left;
            padding: 15px;
        }

        .pg-info p {
            color: #555;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .amenities-list {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .amenities-list li {
            background: #ff416c;
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 14px;
        }

        .map-link {
            display: block;
            margin: 15px 0;
            font-size: 16px;
            color: #007BFF;
            text-decoration: none;
        }

        .map-link:hover {
            text-decoration: underline;
        }

        .book-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 50px;
            background: linear-gradient(to right, #ff416c, #ff4b2b);
            color: white;
            font-weight: bold;
            text-decoration: none;
            border-radius: 25px;
            transition: transform 0.3s ease-in-out;
        }

        .book-button:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<?php include('../includes/header.php'); ?>

    <div class="pg-container">
        <h1><?php echo htmlspecialchars($pg['pg_name']); ?></h1>
        
        <div class="image-gallery">
            <?php foreach ($images as $image) { ?>
                <img src="<?php echo htmlspecialchars($image['image_url']); ?>" alt="PG Image">
            <?php } ?>
        </div>
        
        <div class="pg-info">
            <p><strong>Description:</strong> <?php echo htmlspecialchars($pg['description']); ?></p>
            <p><strong>Rent:</strong> ₹<?php echo number_format($pg['rent']); ?> Per Month</p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($pg['location']); ?></p>
            <a class="map-link" href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($pg['location']); ?>" target="_blank">View on Google Maps</a>
            <p><strong>Available Rooms:</strong> <?php echo $pg['available_rooms']; ?></p>
            <h3>Amenities</h3>
            <ul class="amenities-list">
                <?php foreach ($amenities as $amenity) { ?>
                    <li><?php echo trim(htmlspecialchars($amenity)); ?></li>
                <?php } ?>
            </ul>
        </div>

        <a href="booking_process.php?pg_id=<?php echo $pg_id; ?>" class="book-button">Book PG</a>

    </div>
<?php include('../includes/footer.php'); ?>

</body>
</html>
