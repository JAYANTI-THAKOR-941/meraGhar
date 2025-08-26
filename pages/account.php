<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die("User ID not found in session.");
}

require_once('../config/db_connection.php');

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("User not found.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - MeraGhar</title>
    <link rel="stylesheet" href="../assets/css/styles.css">

    <style>
        /* General Layout */
        .account-container {
            max-width: 400px;
            margin: 30px auto;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;

        }

        .heading {
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        /* Profile Section */
        .profile-section {
            display: flex;
            align-items: center;
            flex-direction: column;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 3px solid #f04e31;
        }

        .username-circle {
            width: 120px;
            height: 120px;
            background-color: #f04e31;
            color: #fff;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 40px;
            margin-bottom: 15px;
        }

        .profile-info {
            font-size: 18px;
            color: #333;
        }

        .profile-info p {
            margin: 5px 0;
            font-size: 16px;
            color: #666;
        }

        /* Hide empty fields */
        .profile-info p.hidden {
            display: none;
        }

        /* Buttons */
        .button, .dashboard-button {
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            text-align: center;
            transition: background 0.3s ease;
            margin-top: 15px;
        }

        .button {
            background: #f04e31;
            color: #fff;
        }

        .button:hover {
            background: #d43f29;
        }

        .dashboard-button {
            background: #4CAF50;
            color: white;
        }

        .dashboard-button:hover {
            background: #45a049;
        }

    </style>
</head>
<body>
<?php include('../includes/header.php'); ?>

<div class="account-container">
    <h1 class="heading">My Account</h1>

    <!-- Profile Section -->
    <div class="profile-section">
        <?php if ($user['profile_image']): ?>
            <img src="/meraghar/uploads/<?php echo basename($user['profile_image']); ?>" alt="Profile Image" class="profile-image">
        <?php else: ?>
            <div class="username-circle"><?php echo strtoupper($user['username'][0]); ?></div>
        <?php endif; ?>

        <div class="profile-info">
            <h2><?php echo htmlspecialchars($user['username']); ?></h2>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

            <?php if (!empty($user['phone'])): ?>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            <?php endif; ?>

            <?php if (!empty($user['address'])): ?>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
            <?php endif; ?>

            <?php if (!empty($user['date_of_birth'])): ?>
                <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['date_of_birth']); ?></p>
            <?php endif; ?>

            <!-- Profile Update or Complete Profile -->
            <?php if ($user['phone'] && $user['address'] && $user['profile_image']): ?>
                <a href="/meraghar/pages/update-profile.php" class="button">Update Profile</a>
            <?php else: ?>
                <a href="/meraghar/pages/complete-profile.php" class="button">Complete Your Profile</a>
            <?php endif; ?>

            <?php if ($user['user_type'] === 'service_provider'): ?>
                <a href="/meraghar/pages/services_provider_dashboard.php" class="dashboard-button">Go to Dashboard</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
</body>
</html>
