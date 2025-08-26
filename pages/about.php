<?php
// Start the session only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>About Us - MeraGhar</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .about-header { 
            background: url('https://static.vecteezy.com/system/resources/previews/010/195/978/non_2x/real-estate-agent-holding-house-key-to-his-client-after-signing-contract-concept-for-business-loan-investment-mortgage-real-estate-moving-home-or-renting-property-banner-with-copy-space-photo.jpg') center/cover no-repeat; 
            height: 350px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            color: white; 
            text-align: center; 
            position: relative;
        }
        .about-header-content {
            background:lightgray;
            color:white;
            padding: 20px;
            border-radius: 10px;
            animation: fadeInDown 1.5s ease-in-out;
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .about-us {
            padding: 50px 20px;
            max-width: 1000px;
            margin: auto;
            background: white;
            border-radius: 10px;
            animation: fadeIn 2s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        h2 { color: #333; position: relative; }
        h2::after {
            content: ''; 
            display: block; 
            width: 50px; 
            height: 3px; 
            background: #e63946;
            margin-top: 5px;
        }
        p, ul { color: #555; line-height: 1.6; }
        ul { padding-left: 20px; }
        .highlight { color: #e63946; font-weight: bold; }
        .image-gallery {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
            overflow: hidden;
        }
        .image-gallery img {
            width: 30%;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }
        .image-gallery img:hover {
            transform: scale(1.1);
        }
        .btn {
            display: inline-block;
            background: #e63946;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .btn:hover { background: #c5283d; }
    </style>
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <!-- About Us Header Image Section -->
    <section class="about-header">
        <div class="about-header-content">
            <h1>Welcome to MeraGhar</h1>
            <p>Find your perfect home with trust, ease, and affordability.</p>
        </div>
    </section>

    <!-- About Us Main Content -->
    <section class="about-us">
        <h2>Our Story</h2>
        <p>MeraGhar was founded with a vision to revolutionize the rental market by making it easier, safer, and more accessible for everyone. Whether you are a student, a working professional, or a family, we provide housing solutions tailored to your needs.</p>

        <div class="image-gallery">
            <img src="https://st2.depositphotos.com/3092723/5368/i/450/depositphotos_53689175-stock-photo-home-for-rent.jpg" alt="House 1">
            <img src="https://smartcity.eletsonline.com/wp-content/uploads/2016/06/house-to-rent.jpg" alt="House 2">
            <img src="https://thumbs.dreamstime.com/b/house-rent-model-banner-48989831.jpg" alt="House 3">
        </div>

        <h2>Our Mission</h2>
        <p>We aim to simplify the home rental process by offering verified listings, transparent pricing, and seamless online bookings. Our goal is to ensure that finding your next home is a hassle-free and enjoyable experience.</p>

        <h2>Why Choose MeraGhar?</h2>
        <ul>
            <li><span class="highlight">Verified Properties:</span> All listings are verified to ensure authenticity and quality.</li>
            <li><span class="highlight">Seamless Booking:</span> Easily book your dream home online with a few clicks.</li>
            <li><span class="highlight">Affordable Pricing:</span> We offer competitive rates with no hidden charges.</li>
            <li><span class="highlight">Customer Support:</span> Our dedicated team is available to assist you 24/7.</li>
            <li><span class="highlight">Secure Payments:</span> Enjoy safe and reliable payment options with trusted gateways.</li>
        </ul>

        <h2>Our Values</h2>
        <p>At MeraGhar, we believe in <span class="highlight">trust, transparency, and convenience</span>. Every step of your journey with us is designed to provide a seamless and satisfying experience.</p>

        <h2>Join Us Today!</h2>
        <p>Looking for your next home? MeraGhar is here to make your search easy and stress-free. Explore our listings, book online, and step into your new home with confidence.</p>
        <a href="pg_listings.php" class="btn">Explore Listings</a>
    </section>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
