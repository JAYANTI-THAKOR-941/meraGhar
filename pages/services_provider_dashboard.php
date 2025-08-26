<?php
session_start();
require_once('../config/db_connection.php');

if (!isset($_SESSION['user_id']) ){
    die("Unauthorized Access");
}

$user_id = $_SESSION['user_id'];

$pgQuery = "SELECT * FROM pg_listings WHERE service_provider_id = $user_id";
$pgResult = $conn->query($pgQuery);

$customerQuery = "SELECT * FROM users WHERE user_type = 'customer'";
$customerResult = $conn->query($customerQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Provider Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    
    <style>
        .services-container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background: #ffffff;
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

        .btn {
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            color: #fff;
            display: inline-block;
            margin: 5px;
            transition: 0.3s;
        }

        .btn-add { background: #4CAF50; }
        .btn-update { background: #f0ad4e; }
        .btn-delete { background: #d9534f; }

        .btn:hover { opacity: 0.8; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            border-radius: 5px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #f04e31;
            color: white;
        }
    </style>
</head>
<body>

<?php include('../includes/header.php'); ?>

<div class="services-container">
    <h1 class="heading">Service Provider Dashboard</h1>

    <h2>PG Management</h2>
    <a href="add_pg.php" class="btn btn-add">Add PG</a>

    <?php if ($pgResult->num_rows > 0): ?>
        <table>
            <tr>
                <th>PG Name</th>
                <th>Location</th>
                <th>Rent</th>
                <th>Actions</th>
            </tr>
            <?php while ($pg = $pgResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($pg['pg_name']); ?></td>
                    <td><?php echo htmlspecialchars($pg['location']); ?></td>
                    <td>₹<?php echo htmlspecialchars($pg['rent']); ?></td>
                    <td>
                        <a href="update_pg.php?id=<?php echo $pg['pg_id']; ?>" class="btn btn-update">Update</a>
                        <a href="delete_pg.php?id=<?php echo $pg['pg_id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No PG listings found.</p>
    <?php endif; ?>

    <!-- Customers List -->
    <h2>Customers</h2>
    <?php if ($customerResult->num_rows > 0): ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
            <?php while ($customer = $customerResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($customer['username']); ?></td>
                    <td><?php echo htmlspecialchars($customer['email']); ?></td>
                    <td><?php echo htmlspecialchars($customer['phone'] ?: 'N/A'); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No customers found.</p>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
</body>
</html>
