-- Drop Existing Tables

DROP TABLE IF EXISTS answers;

DROP TABLE IF EXISTS questions;

DROP TABLE IF EXISTS product_categories;

DROP TABLE IF EXISTS products;

DROP TABLE IF EXISTS categories;

DROP TABLE IF EXISTS customers;


DROP TABLE IF EXISTS users;

-- Create users Table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    user_type ENUM('admin', 'employee') NOT NULL
);

-- Create products Table
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    detail LONGTEXT,
    manufacturer VARCHAR(50),
    price DECIMAL(10, 2),
    featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
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

-- Create customers Table
CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name TEXT,
    customer_email TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create questions Table
CREATE TABLE questions (
    question_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    customer_id INT,
    question TEXT,
    answered BOOLEAN DEFAULT FALSE,
    questioned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
);

-- Create answers Table
CREATE TABLE answers (
    answer_id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT,
    user_id INT,
    answer TEXT,
    answered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (question_id) REFERENCES questions(question_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Add users
INSERT INTO
    users (
        username,
        full_name,
        password_hash,
        email,
        user_type
    )
VALUES
    (
        'admin',
        "Admin",
        '$2y$10$3pV0uXNvrDgn7NXxJJ5IPOmywYCbwJi7GdT/1.m1XeL5kt6zhiv0a',
        'admin@gmail.com',
        'admin'
    ),
    (
        'employee',
        "Employee",
        '$2y$10$xQemfL7E3ZNACrjLey/PgOVNDC5Oyr7vW/lNTxQW4srGVc9nibqv.',
        'employee@gmail.com',
        'employee'
    );

-- Add categories
INSERT INTO
    categories (category_name)
VALUES
    ("TVs"),
    ("Computers"),
    ("Phones"),
    ("Gaming");

-- Add products
INSERT INTO
    products (
        user_id,
        name,
        description,
        detail,
        manufacturer,
        price,
        featured
    )
VALUES
    (
        2,
        "Smart TV",
        "A high-definition smart TV",
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac aliquet mi, et ornare ipsum. Curabitur id lorem sed ex efficitur egestas. Integer finibus hendrerit risus sagittis porta. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis egestas placerat massa ac porta. Proin a leo purus. Nam dolor dui, iaculis in laoreet id, venenatis sed est. Sed et facilisis metus.
        
        Fusce varius eros ligula, et sagittis mauris gravida sed. Maecenas tristique maximus ornare. Duis nec lectus tempus leo ullamcorper bibendum. Nam tempus augue sapien, vel mattis ex porttitor cursus. Suspendisse potenti. Suspendisse quis orci ex. Curabitur non orci orci.",
        "Samsung",
        799.99,
        1
    ),
    (
        2,
        "Gaming Laptop",
        "Powerful gaming laptop with RGB lighting",
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac aliquet mi, et ornare ipsum. Curabitur id lorem sed ex efficitur egestas. Integer finibus hendrerit risus sagittis porta. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis egestas placerat massa ac porta. Proin a leo purus. Nam dolor dui, iaculis in laoreet id, venenatis sed est. Sed et facilisis metus.
        
        Fusce varius eros ligula, et sagittis mauris gravida sed. Maecenas tristique maximus ornare. Duis nec lectus tempus leo ullamcorper bibendum. Nam tempus augue sapien, vel mattis ex porttitor cursus. Suspendisse potenti. Suspendisse quis orci ex. Curabitur non orci orci.",
        "ASUS",
        1499.99,
        1
    ),
    (
        2,
        "SAMSUNG Galaxy S24 Ultra",
        "Latest smartphone with advanced features",
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac aliquet mi, et ornare ipsum. Curabitur id lorem sed ex efficitur egestas. Integer finibus hendrerit risus sagittis porta. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis egestas placerat massa ac porta. Proin a leo purus. Nam dolor dui, iaculis in laoreet id, venenatis sed est. Sed et facilisis metus.
        
        Fusce varius eros ligula, et sagittis mauris gravida sed. Maecenas tristique maximus ornare. Duis nec lectus tempus leo ullamcorper bibendum. Nam tempus augue sapien, vel mattis ex porttitor cursus. Suspendisse potenti. Suspendisse quis orci ex. Curabitur non orci orci.",
        "Samsung",
        999.99,
        0
    ),
    (
        2,
        "Gaming Console",
        "Next-gen gaming console with 4K support",
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac aliquet mi, et ornare ipsum. Curabitur id lorem sed ex efficitur egestas. Integer finibus hendrerit risus sagittis porta. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis egestas placerat massa ac porta. Proin a leo purus. Nam dolor dui, iaculis in laoreet id, venenatis sed est. Sed et facilisis metus.
        
        Fusce varius eros ligula, et sagittis mauris gravida sed. Maecenas tristique maximus ornare. Duis nec lectus tempus leo ullamcorper bibendum. Nam tempus augue sapien, vel mattis ex porttitor cursus. Suspendisse potenti. Suspendisse quis orci ex. Curabitur non orci orci.",
        "Sony",
        499.99,
        0
    );

-- Add product_categories
INSERT INTO
    product_categories (product_id, category_id)
VALUES
    (1, 1),
    (2, 2),
    (2, 4),
    (3, 3),
    (4, 2),
    (4, 4);

-- Add customers
INSERT INTO
    customers (customer_name, customer_email)
VALUES
    ("john", "john@gmail.com"),
    ("doe", "doe@gmail.com");

-- Add questions
INSERT INTO
    questions (
        product_id,
        customer_id,
        question,
        answered
    )
VALUES
    (
        1,
        1,
        "Does it support 3D?",
        1
    ),
    (
        2,
        1,
        "What is the RAM size of the laptop?",
        1
    ),
    (
        3,
        1,
        "Is the smartphone water-resistant?",
        1
    ),
    (
        4,
        1,
        "Can I connect this to my PC?",
        1
    ),
    (
        4,
        2,
        "Can I play Blu-ray discs on this console?",
        1
    ),
    (
        2,
        2,
        "What is the the type of hard drive?",
        0
    );

-- Add answers
INSERT INTO
    answers (
        question_id,
        user_id,
        answer
    )
VALUES
    (
        1,
        2,
        "No, this TV does not support 3D."
    ),
    (
        2,
        2,
        "The laptop comes with 16GB of RAM."
    ),
    (
        3,
        2,
        "Yes, the smartphone is water-resistant with an IP68 rating."
    ),
    (
        4,
        2,
        "Yes, the console can be connected to your PC."
    ),
    (
        5,
        2,
        "Yes, the console has a built-in Blu-ray player."
    );