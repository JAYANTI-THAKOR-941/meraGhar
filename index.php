<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Home - MeraGhar.Com</title>
    <style>
        a{
            text-decoration:none;
        }
        .hero {
            height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to bottom right, rgba(34, 49, 63, 0.8), rgba(44, 62, 80, 0.8)), 
                        url('https://png.pngtree.com/thumb_back/fh260/background/20231001/pngtree-revolutionary-3d-rendered-concept-website-building-and-web-design-enhanced-with-image_13577121.png') no-repeat center center/cover;
            color: #fff;
            text-align: center;
        }
        .hero-container h1 {
            font-size: 50px;
            margin: 0;
        }
        .btn-explore {
            padding: 12px 25px;
            background-color: #e67e22;
            color: #fff;
            border-radius: 5px;
            transition: 0.3s ease;
        }
        .btn-explore:hover {
            background-color: #d35400;
        }

        .about-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 50px;
            background-color: #fff;
        }
        .about-content {
            width: 50%;
        }
        .about-image {
            width: 45%;
        }
        .about-image img {
            width: 100%;
            border-radius: 10px;
        }
        .about-content h2 {
            font-size: 2.5rem;
            color: #333;
        }
        .about-content p {
            font-size: 1.1rem;
            color: #666;
            text-align:justify;
        }
      

        .services-section {
            background-color: #f9f9f9;
            padding: 50px 0;
            text-align: center;
        }
        .services-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .service-card {
            background: #fff;
            padding: 20px;
            width: 300px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        .service-card h3 {
            color: #e67e22;
        }
        .service-card p {
            color: #333;
        }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>

    <main>
        <section class="hero">
            <div class="hero-container">
            <h1>Discover Your Perfect PG with MeraGhar.Com</h1>

                <p>Your trusted partner in PG accommodations.</p>
                <a href="/meraghar/pg-listings.php" class="btn-explore">Explore PGs</a>
            </div>
        </section>

        <section class="about-section">
            <div class="about-content">
                <h2>About MeraGhar.Com</h2>
                <p>
    MeraGhar.Com specializes in providing premium PG accommodations tailored to your needs. We understand that finding a comfortable and affordable place to stay can be a challenge, especially in bustling cities. That's why we focus on offering well-maintained PGs that meet high standards of comfort, security, and convenience. 
</p>
<p>Our mission is to ensure that every individual has access to a homely and safe environment, whether you're a student, working professional, or someone in need of short-term accommodation. 
With MeraGhar.Com, you get peace of mind knowing that our listings offer only verified, reliable properties, complete with all the necessary amenities for a hassle-free living experience.</p>

            </div>
            <div class="about-image">
                <img src="https://5.imimg.com/data5/SELLER/Default/2020/12/UA/CU/BD/33987214/premium-bungalows-design-service.PNG" alt="About MeraGhar.Com">
            </div>
        </section>

        <section class="services-section">
            <h2>Our Services</h2>
            <div class="services-container">
                <div class="service-card">
                    <h3>PG Rentals</h3>
                    <p>Find well-maintained PGs with flexible lease terms.</p>
                </div>
                <div class="service-card">
                    <h3>Furnished Rooms</h3>
                    <p>Fully furnished rooms with beds, WiFi, AC, and other essentials.</p>
                </div>
                <div class="service-card">
                    <h3>Food & Dining</h3>
                    <p>Enjoy healthy home-cooked meals as part of our service.</p>
                </div>
                <div class="service-card">
                    <h3>24/7 Security</h3>
                    <p>CCTV, biometric access, and round-the-clock security for your safety.</p>
                </div>
                <div class="service-card">
                    <h3>Housekeeping</h3>
                    <p>Regular cleaning and maintenance to ensure a comfortable stay.</p>
                </div>
            </div>
        </section>
    </main>

    <?php include('includes/footer.php'); ?>
</body>
</html>
