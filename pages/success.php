<?php
include('../config/db_connection.php');

$pg_id = isset($_GET['pg_id']) ? intval($_GET['pg_id']) : 0;
$payment_id = isset($_GET['payment_id']) ? htmlspecialchars($_GET['payment_id']) : '';

if (!$pg_id || !$payment_id) {
    echo "<h2 style='color: red; text-align: center;'>Invalid payment details!</h2>";
    exit;
}

// Insert booking record
$query = "INSERT INTO bookings (pg_id, user_id, payment_id, status) VALUES (?, 1, ?, 'Paid')";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "is", $pg_id, $payment_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background-color: #f0f8ff; text-align: center; padding: 50px; }
        .success-container { background: white; padding: 30px; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); }
        h2 { color: #28a745; margin-bottom: 10px; }
        p { font-size: 18px; margin-bottom: 20px; }
        .details { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; font-weight: bold; }
        .home-button { display: inline-block; padding: 10px 20px; margin-top: 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; transition: 0.3s; }
        .home-button:hover { background: #218838; }
    </style>
</head>
<body>
    <div class="success-container">
        <h2>🎉 Payment Successful! 🎉</h2>
        <p>Your PG booking has been confirmed.</p>
        <div class="details">Transaction ID: <strong><?php echo $payment_id; ?></strong></div>
        <a href="../index.php" class="home-button">Go to Home</a>
    </div>
</body>
</html>
