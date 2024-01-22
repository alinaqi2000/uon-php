-- Create users Table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    user_type ENUM('admin', 'customer') NOT NULL
);

-- Create products Table
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    manufacturer VARCHAR(50),
    price DECIMAL(10, 2),
    image_url VARCHAR(255)
);

-- Create categories Table
CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(50) NOT NULL
);

-- Create product_categories Table (Associative Table)
CREATE TABLE product_categories (
    product_id INT,
    category_id INT,
    PRIMARY KEY (product_id, category_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

-- Create questions Table
CREATE TABLE questions (
    question_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    user_id INT,
    question TEXT,
    date_time DATETIME,
    approved BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Create answers Table
CREATE TABLE answers (
    answer_id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT,
    user_id INT,
    answer TEXT,
    date_time DATETIME,
    FOREIGN KEY (question_id) REFERENCES questions(question_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);



INSERT INTO users (username, password_hash, email, user_type) 
VALUES ('admin', '$2y$10$3pV0uXNvrDgn7NXxJJ5IPOmywYCbwJi7GdT/1.m1XeL5kt6zhiv0a', 'admin@example.com', 'admin');
