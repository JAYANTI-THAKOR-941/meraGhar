<?php
require '../vendor/autoload.php';
use Razorpay\Api\Api;

include('../config/db_connection.php');

$api = new Api('rzp_test_MCCHlSWeh3mRj4', 'hTSHYNC8Cm084lPqg9AdejH7');

$data = json_decode(file_get_contents('php://input'), true);

$pg_id = intval($data['pg_id']);
$duration = intval($data['duration']);

if (!$pg_id || !$duration) {
    echo json_encode(['error' => 'Invalid PG ID or duration']);
    exit;
}

// Fetch PG rent from the database
$query = "SELECT rent FROM pg_listings WHERE pg_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $pg_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pg_data = mysqli_fetch_assoc($result);

if (!$pg_data) {
    echo json_encode(['error' => 'PG not found']);
    exit;
}

$pg_rent = intval($pg_data['rent']); // Monthly rent

// Convert rent to per-day basis
$daily_rent = $pg_rent / 30;

// Calculate total amount based on selected duration
$total_amount = round($daily_rent * $duration * 100); // Convert to paise (Razorpay requires amount in paise)

// Create order in Razorpay
try {
    $order = $api->order->create([
        'receipt' => 'pg_' . $pg_id,
        'amount' => $total_amount, 
        'currency' => 'INR',
        'payment_capture' => 1
    ]);

    echo json_encode([
        'order_id' => $order->id,
        'amount' => $total_amount
    ]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Payment gateway error: ' . $e->getMessage()]);
}

// Close connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
