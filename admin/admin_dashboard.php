<?php
session_start();
include('../config/db_connection.php'); // Include database connection

// // Ensure the user is logged in as an admin
// if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
//     header("Location: ../login.php");
//     exit();
// }

// Fetch total service providers
$query_providers = "SELECT COUNT(*) AS total_providers FROM users WHERE user_type = 'service_provider'";
$result_providers = mysqli_query($conn, $query_providers);
$row_providers = mysqli_fetch_assoc($result_providers);
$total_providers = $row_providers['total_providers'];

// Fetch total customers
$query_customers = "SELECT COUNT(*) AS total_customers FROM users WHERE user_type = 'customer'";
$result_customers = mysqli_query($conn, $query_customers);
$row_customers = mysqli_fetch_assoc($result_customers);
$total_customers = $row_customers['total_customers'];

// Fetch total PG listings
$query_pg = "SELECT COUNT(*) AS total_pg FROM pg_listings";
$result_pg = mysqli_query($conn, $query_pg);
$row_pg = mysqli_fetch_assoc($result_pg);
$total_pg = $row_pg['total_pg'];

// Fetch total billing amount from bookings
$query_billing = "SELECT SUM(rent) AS total_billing FROM bookings b
                  JOIN pg_listings p ON b.pg_id = p.pg_id";
$result_billing = mysqli_query($conn, $query_billing);
$row_billing = mysqli_fetch_assoc($result_billing);
$total_billing = $row_billing['total_billing'] ? $row_billing['total_billing'] : 0; // Handle NULL case

// Calculate admin and service provider shares
$admin_share = $total_billing * 0.30;
$provider_share = $total_billing * 0.70;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="styles.css"> 
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .header {
            background:rgb(75, 75, 77);
            color: white;
            padding: 49px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }
        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        .dashboard {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .card {
            background:rgb(118, 120, 122);
            color: white;
            padding: 20px;
            border-radius: 5px;
            margin: 10px;
            width: 40%;
            text-align: center;
        }
        .card h3 {
            margin: 0;
        }
        .chart-container {
            margin-top: 20px;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
        }
        .logout {
            display: block;
            margin-top: 20px;
            padding: 10px 20px;
            background: red;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">Admin Dashboard</div>
    <div class="container">
        <div class="dashboard">
            <div class="card">
                <h3>Total Service Providers</h3>
                <p><?php echo $total_providers; ?></p>
            </div>
            <div class="card">
                <h3>Total Customers</h3>
                <p><?php echo $total_customers; ?></p>
            </div>
            <div class="card">
                <h3>Total PG Listings</h3>
                <p><?php echo $total_pg; ?></p>
            </div>
            <div class="card">
                <h3>Total Billing Amount</h3>
                <p>₹<?php echo number_format($total_billing, 2); ?></p>
            </div>
        </div>
        <div class="chart-container">
            <h3>Billing Report</h3>
            <canvas id="billingChart"></canvas>
        </div>
    </div>
    <script>
        var ctx = document.getElementById('billingChart').getContext('2d');
        var billingChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Admin (30%)', 'Service Providers (70%)'],
                datasets: [{
                    data: [<?php echo $admin_share; ?>, <?php echo $provider_share; ?>],
                    backgroundColor: ['#ff5733', '#33ff57']
                }]
            }
        });
    </script>
</body>
</html>
