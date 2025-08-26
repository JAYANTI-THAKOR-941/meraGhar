<?php
include('../config/db_connection.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$query = "SELECT pl.pg_id, pl.pg_name, pl.location, pl.rent, pi.image_url  
          FROM pg_listings pl 
          LEFT JOIN pg_images pi ON pl.pg_id = pi.pg_id 
          GROUP BY pl.pg_id"; // Get one image per PG

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>PG Listings</title>
    <style>
       *{
            margin: 0;
            padding: 0;
            text-align:center;
       }

       .pg-header {
            position: relative;
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.7)), 
                        url('https://www.shutterstock.com/image-illustration/key-house-banner-new-home-260nw-700088764.jpg') center/cover no-repeat;
            color: white;
            padding: 120px 20px;
            text-align: center;
        }

        .pg-header h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .pg-header p {
            font-size: 18px;
            opacity: 0.8;
        }

        .pg-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }

        .pg-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            animation: fadeInUp 0.8s ease-in-out;
            width: 300px;
        }

        .pg-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
        }

        .pg-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
        }

        .pg-card h3 {
            color: #2c3e50;
            font-size: 20px;
            margin: 12px 0 8px;
        }

        .pg-card p {
            color: #555;
            font-size: 14px;
            margin: 5px 0;
        }

        .pg-card a {
            display: inline-block;
            background: linear-gradient(to right, #ff416c, #ff4b2b);
            color: white;
            padding: 10px 15px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s ease-in-out;
            margin-top: 10px;
        }

        .pg-card a:hover {
            background: linear-gradient(to right, #ff4b2b, #ff416c);
            transform: scale(1.05);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<?php include('../includes/header.php'); ?>

    <div class="pg-header">
        <h1>Find Your Perfect PG</h1>
        <p>Explore the best PG accommodations at affordable rates</p>
    </div>

    <div class="pg-container">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="pg-card">
                <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="PG Image">
                <h3><?php echo htmlspecialchars($row['pg_name']); ?></h3>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                <p><strong>Rent:</strong> ₹<?php echo number_format($row['rent'], 2); ?> Month</p>
                <a href="pg_details.php?pg_id=<?php echo $row['pg_id']; ?>">View Details</a>
            </div>
        <?php } ?>
    </div>
    
    <?php include('../includes/footer.php'); ?>
</body>
</html>
