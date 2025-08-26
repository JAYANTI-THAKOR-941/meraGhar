CREATE TABLE `users` (
    `user_id` INT(11) NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `profile_image` VARCHAR(255) DEFAULT NULL,
    `phone` VARCHAR(15) DEFAULT NULL,
    `address` TEXT DEFAULT NULL,
    `date_of_birth` DATE DEFAULT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `otp` VARCHAR(6) DEFAULT NULL,
    `is_verified` TINYINT(1) NOT NULL DEFAULT 0,
    `user_type` ENUM('customer', 'service_provider', 'admin') NOT NULL DEFAULT 'customer',  
    PRIMARY KEY (`user_id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




CREATE TABLE pg_listings (
    pg_id INT AUTO_INCREMENT PRIMARY KEY,
    service_provider_id INT NOT NULL,
    pg_name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    rent DECIMAL(10,2) NOT NULL,
    description TEXT,
    available_rooms INT NOT NULL,
    amenities TEXT,
    services TEXT, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (service_provider_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE pg_images (
    image_id INT AUTO_INCREMENT PRIMARY KEY,
    pg_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    FOREIGN KEY (pg_id) REFERENCES pg_listings(pg_id) ON DELETE CASCADE
);


CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pg_id INT NOT NULL,
    user_id INT NOT NULL,
    payment_id VARCHAR(255) NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'Paid',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
