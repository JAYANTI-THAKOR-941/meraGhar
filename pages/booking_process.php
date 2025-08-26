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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book PG - <?php echo htmlspecialchars($pg['pg_name']); ?></title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <link rel="stylesheet" href="../assets/css/styles.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background-color: #f9f9f9;  text-align: center; }
        .booking-form { background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: 5% auto; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); }
        input, select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }
        .book-button { background: linear-gradient(to right, #ff416c, #ff4b2b); color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; transition: 0.3s; }
        .book-button:hover { background: linear-gradient(to right, #ff4b2b, #ff416c); }
    </style>
</head>
<body>
<?php include('../includes/header.php'); ?>

    <div class="booking-form">
        <h2>Book <?php echo htmlspecialchars($pg['pg_name']); ?></h2>
        <form id="booking-form" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="phone" placeholder="Phone Number" required>
            <input type="file" name="id_proof" accept="image/*,application/pdf" required>
            <select name="duration" id="duration" required>
                <option value="">Select Duration</option>
                <option value="7">7 Days</option>
                <option value="15">15 Days</option>
                <option value="30">1 Month</option>
                <option value="60">2 Months</option>
            </select>
            <input type="hidden" id="pg_id" value="<?php echo $pg_id; ?>">
            <button type="button" class="book-button" onclick="payNow()">Proceed to Pay</button>
        </form>
    </div>

    <script>
        function payNow() {
            let name = document.querySelector('input[name="name"]').value;
            let email = document.querySelector('input[name="email"]').value;
            let phone = document.querySelector('input[name="phone"]').value;
            let duration = document.getElementById("duration").value;
            let pgId = document.getElementById("pg_id").value;

            if (!name || !email || !phone || !duration) {
                alert("Please fill all details!");
                return;
            }

            fetch("create_order.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ pg_id: pgId, duration: duration })
            })
            .then(response => response.json())
            .then(data => {
                var options = {
                    "key": "rzp_test_MCCHlSWeh3mRj4",
                    "amount": data.amount,
                    "currency": "INR",
                    "name": "PG Booking",
                    "description": "Booking Payment",
                    "image": "logo.png",
                    "order_id": data.order_id,
                    "handler": function (response) {
                        alert('Payment Successful! Transaction ID: ' + response.razorpay_payment_id);
                        window.location.href = "success.php?pg_id=" + pgId + "&payment_id=" + response.razorpay_payment_id;
                    },
                    "prefill": { "name": name, "email": email, "contact": phone },
                    "theme": { "color": "#ff4b2b" }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
            })
            .catch(error => console.error("Error:", error));
        }
    </script>
    <?php include('../includes/footer.php'); ?>

</body>
</html>
