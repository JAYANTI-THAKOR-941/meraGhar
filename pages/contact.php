<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$errorMessage = '';
$successMessage = '';
$name = '';
$email = '';
$message = '';
if (empty($errors)) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'jyantithakor941@gmail.com'; 
        $mail->Password = 'gqhzroxufgetxqim'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom($email, $name);
        $mail->addAddress('jyantithakor941@gmail.com'); 
        $mail->isHTML(true);  
        $mail->Subject = 'MeraGhar Contact Form Submission';

        $mail->Body = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; background: #f8f8f8; padding: 20px; }
                .container { max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
                h2 { color: #e63946; text-align: center; }
                .info { font-size: 16px; color: #333; }
                .info p { margin: 10px 0; }
                .message-box { padding: 15px; background: #f1f1f1; border-left: 5px solid #e63946; }
                .footer { margin-top: 20px; text-align: center; font-size: 14px; color: #666; }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>MeraGhar Contact Form Submission</h2>
                <div class='info'>
                    <p><strong>Name:</strong> {$name}</p>
                    <p><strong>Email:</strong> {$email}</p>
                    <p><strong>Message:</strong></p>
                    <div class='message-box'>{$message}</div>
                </div>
                <div class='footer'>This email was sent from the MeraGhar Contact Form.</div>
            </div>
        </body>
        </html>";

        $mail->send();
        $successMessage = "Thank you! We will get back to you soon.";
        $name = $email = $message = '';
    } catch (Exception $e) {
        $errorMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Contact Us - MeraGhar</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f9f9f9; }
        .contact-header {
            background: url('https://static.vecteezy.com/system/resources/thumbnails/025/133/377/small_2x/happy-asian-couple-client-tenant-buy-home-realtor-hand-holding-model-home-giving-new-landlord-after-sign-signature-contract-rental-purchase-bank-approve-mortgage-loan-property-of-financial-free-photo.jpg') center/cover no-repeat;
            height: 300px; display: flex; align-items: center; justify-content: center;
            color: white; text-align: center; position: relative;
        }
        .contact-header-content {
            background: rgba(0, 0, 0, 0.6); padding: 20px; border-radius: 10px;
            animation: fadeInDown 1.5s ease-in-out;
        }
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
        .contact-container { display: flex; justify-content: center; padding: 50px 20px; gap: 40px; }
        .contact-info, .contact-form {
            background: white; padding: 30px; border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); animation: fadeIn 2s ease-in-out;
        }
        .contact-info { flex: 1; max-width: 400px; }
        .contact-form { flex: 1; }
        .contact-item { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
        .contact-item img { width: 24px; height: 24px; }
        .input-group { margin-bottom: 15px; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #e63946; color: white; padding: 10px 15px; border: none; cursor: pointer; border-radius: 5px; transition: background 0.3s ease-in-out; }
        button:hover { background: #c5303b; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>
    <?php include('../includes/header.php'); ?>
    
    <section class="contact-header">
        <div class="contact-header-content">
            <h1>Contact MeraGhar</h1>
            <p>Your dream home is just a message away!</p>
        </div>
    </section>

    <section class="contact-container">
        <div class="contact-info">
            <h2>Get in Touch</h2>
            <p>We'd love to hear from you! Reach out to us through any of the following means:</p>
            <div class="contact-item">
                <img src="https://i.pinimg.com/736x/cb/dc/54/cbdc54feb9a9d3b062b99fd0b400ba5b.jpg" alt="Location" />
                <p>123 MeraGhar Street, New Delhi, India</p>
            </div>
            <div class="contact-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSXwuNxN0yCS3oLHr27AouQM2vddf6BtXy8Tg&s" alt="Phone" />
                <p>+91 9876543210</p>
            </div>
            <div class="contact-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRnb0gybrvVahOcY-DB3crbY-7YyYZJLrudCg&s" alt="Email" />
                <p>support@meraghar.com</p>
            </div>
        </div>

        <div class="contact-form">
            <h2>Send Us a Message</h2>
            <form action="contact.php" method="POST">
                <div class="input-group">
                    <input type="text" name="name" placeholder="Your Name" value="<?php echo $name; ?>" required />
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Your Email" value="<?php echo $email; ?>" required />
                </div>
                <div class="input-group">
                    <textarea name="message" placeholder="Your Message" rows="6" required><?php echo $message; ?></textarea>
                </div>
                <button type="submit">Send Message</button>
            </form>
        </div>
    </section>
    
    <?php include('../includes/footer.php'); ?>
</body>
</html>
