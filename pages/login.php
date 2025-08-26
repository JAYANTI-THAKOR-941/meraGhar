<?php
include('../config/db_connection.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error_message = "Both fields are required!";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];

                header('Location: ../index.php');
                exit;
            } else {
                $error_message = "Invalid password!";
            }
        } else {
            $error_message = "No user found with this email address!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Login - MeraGhar</title>
    <style>
.auth-section .container {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
    animation: fadeIn 1s ease-in-out;
}

.row {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    width: 100%;
}

/* Left Column (Form) */
.form-column {
    flex: 1;
    max-width: 500px;
    padding: 20px;
    box-sizing: border-box;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    animation: slideInLeft 1s ease-out;
}

.form-column h2 {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
    color: #333;
}

.input-group {
    margin-bottom: 15px;
}

.input-group label {
    display: block;
    font-size: 14px;
    color: #333;
}

.input-group input {
    width: 96%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-top: 5px;
    font-size: 14px;
    transition: all 0.3s ease;
    background-color: #f9f9f9;
}

.input-group input:focus {
    border-color:rgb(243, 138, 52);
    outline: none;
    background-color: #fff;
}

.input-group button {
    width: 100%;
    padding: 14px;
    border: none;
    background-color: rgb(243, 138, 52);
    color: white;
    font-size: 16px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.input-group button:hover {
    background-color: rgb(243, 138, 52);
}

.error-message {
    color: #FF4D4D;
    font-size: 14px;
    margin-bottom: 15px;
    text-align: center;
}

/* Right Column (Image) */
.image-column {
    flex: 1;
    max-width: 500px;
    padding: 20px;
}

.registration-image {
    width: 100%;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    animation: zoomIn 1.5s ease-in-out;
}

/* Links */
a.link {
    color: #4CAF50;
    text-decoration: none;
}

a.link:hover {
    text-decoration: underline;
}

.start-business-link {
    color: #FF9800;
}

.start-business-link:hover {
    text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 768px) {
    .row {
        flex-direction: column;
        align-items: center;
    }

    .form-column {
        max-width: 100%;
        margin-bottom: 20px;
    }

    .image-column {
        max-width: 100%;
    }
}

@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}

@keyframes slideInLeft {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(0); }
}

@keyframes zoomIn {
    0% { transform: scale(0.9); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}


    </style>
</head>
<body>
    <!-- Include Header -->
    <?php include('../includes/header.php'); ?>

    <!-- Login Form Section -->
    <section class="auth-section">
        <div class="container">
            <div class="row">
                <!-- Left Column for Login Form -->
                <div class="form-column">
                    <h2>Login</h2>

                    <!-- Display error message if any -->
                    <?php if (isset($error_message)) : ?>
                        <div class="error-message"><?php echo $error_message; ?></div>
                    <?php endif; ?>

                    <form action="login.php" method="POST">
                        <div class="input-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="input-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required>
                        </div>

                        <div class="input-group">
                            <button type="submit" class="btn">Login</button>
                        </div>

                        <p>Don't have an account? <a href="register.php" class="link">Register Here</a></p>
                    </form>
                </div>

                <!-- Right Column for Image -->
                <div class="image-column">
                    <img src="https://i.pinimg.com/550x/bd/e5/da/bde5da25aa2c9001c398369a6053ead3.jpg" alt="Login Image" class="registration-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Include Footer -->
    <?php include('../includes/footer.php'); ?>
</body>
</html>
