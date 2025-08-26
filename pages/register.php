<?php
include('../config/db_connection.php');
require '../vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

$user_type = 'customer'; 

if (isset($_GET['start-business']) && $_GET['start-business'] == 'true') {
    $user_type = 'service_provider'; 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($password)) {
        $error_message = "All fields are required!";
    } else {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $error_message = "This email is already registered!";
        } else {
            $otp = rand(100000, 999999);

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'jyantithakor941@gmail.com';  
                $mail->Password = 'gqhzroxufgetxqim';    
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('jyantithakor941@gmail.com', 'MeraGhar');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Your OTP for Registration';
                $mail->Body = "
                    <html>
                    <head>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f4f4f4;
                                margin: 0;
                                padding: 0;
                            }
                            .container {
                                background-color: #ffffff;
                                padding: 20px;
                                margin: 40px auto;
                                max-width: 600px;
                                border-radius: 10px;
                                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                            }
                            .container h2 {
                                color: #333;
                            }
                            .container p {
                                font-size: 16px;
                                color: #555;
                            }
                            .otp-code {
                                font-size: 20px;
                                font-weight: bold;
                                color: #4CAF50;
                            }
                            .footer {
                                text-align: center;
                                font-size: 12px;
                                color: #aaa;
                                margin-top: 20px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <h2>Welcome to MeraGhar, $username!</h2>
                            <p>Your OTP for registration is:</p>
                            <p class='otp-code'>$otp</p>
                            <p>Please enter this OTP to verify your account.</p>
                            <div class='footer'>
                                <p>&copy; 2025 MeraGhar, All Rights Reserved.</p>
                            </div>
                        </div>
                    </body>
                    </html>
                ";

                $mail->send();

                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = password_hash($password, PASSWORD_DEFAULT);
                $_SESSION['otp'] = $otp;
                $_SESSION['user_type'] = $user_type;

                header('Location: otp_verification.php');
                exit;
            } catch (Exception $e) {
                $error_message = "Error sending OTP: {$mail->ErrorInfo}";
            }
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
    <title>Register - MeraGhar</title>
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
    <?php include('../includes/header.php'); ?>

    <section class="auth-section">
        <div class="container">
            <div class="row">
                <div class="form-column">
                    <h2>
                        <?php echo ($user_type == 'customer') ? 'Customer Registration' : 'Business Account Registration'; ?>
                    </h2>

                    <?php if (isset($error_message)) : ?>
                        <div class="error-message"><?php echo $error_message; ?></div>
                    <?php endif; ?>

                    <form action="register.php" method="POST">
                        <div class="input-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" required>
                        </div>
                        <div class="input-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="input-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required>
                        </div>

                        <div class="input-group">
                            <button type="submit" class="btn">Register</button>
                        </div>

                        <p>Already have an account? <a href="login.php" class="link">Login Here</a></p>
                        <p><a href="register.php?start-business=<?php echo ($user_type == 'customer') ? 'true' : 'false'; ?>" class="link start-business-link">
    <?php echo ($user_type == 'customer') ? 'Start Business' : 'Create Customer Account'; ?>
</a></p>

                    </form>
                </div>

                <div class="image-column">
                    <img src="https://i.pinimg.com/550x/bd/e5/da/bde5da25aa2c9001c398369a6053ead3.jpg" alt="Registration Image" class="registration-image">
                </div>
            </div>
        </div>
    </section>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
