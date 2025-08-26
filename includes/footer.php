<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-left">
                <p>&copy; 2025 MeraGhar.Com. All rights reserved.</p>
                <ul class="social-links">
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">LinkedIn</a></li>
                </ul>
            </div>
            <div class="footer-right">
                <ul class="footer-links">
                    <li><a href="/about-us.php">About Us</a></li>
                    <li><a href="/contact-us.php">Contact Us</a></li>
                    <li><a href="/privacy-policy.php">Privacy Policy</a></li>
                    <li><a href="/terms-of-service.php">Terms of Service</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<style>
    /* Footer Section */
.footer {
    background-color: #333;
    color: #fff;
    padding: 40px 0;
    text-align: center;
    font-size: 1rem;
}

.footer .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.footer-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.footer-left, .footer-right {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.footer-left p {
    margin: 0;
    font-size: 1.2rem;
}

.social-links {
    list-style: none;
    padding: 0;
    margin-top: 10px;
    display: flex;
    gap: 15px;
}

.social-links li {
    display: inline-block;
}

.social-links a {
    color: #fff;
    text-decoration: none;
    font-size: 1.2rem;
    transition: color 0.3s;
}

.social-links a:hover {
    color: #e67e22; /* Hover effect */
}

.footer-right .footer-links {
    list-style: none;
    padding: 0;
}

.footer-right .footer-links li {
    margin-bottom: 10px;
}

.footer-right .footer-links a {
    color: #fff;
    text-decoration: none;
    font-size: 1.1rem;
    transition: color 0.3s;
}

.footer-right .footer-links a:hover {
    color: #e67e22; /* Hover effect */
}

@media (max-width: 768px) {
    .footer-content {
        flex-direction: column;
        align-items: center;
    }

    .footer-left, .footer-right {
        align-items: center;
    }

    .social-links {
        margin-top: 10px;
    }
}

</style>