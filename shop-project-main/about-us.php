<?php
session_start();
include("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - E-Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6c63ff;
            --secondary-color: #f50057;
            --text-color: #333;
            --light-bg: #f8f9fa;
            --white: #ffffff;
            --shadow: 0 4px 24px rgba(0,0,0,0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light-bg);
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 20px;
        }

        .hero-section {
            text-align: center;
            padding: 4rem 0;
            background: linear-gradient(135deg, var(--primary-color), #8b85ff);
            color: var(--white);
            margin-bottom: 3rem;
        }

        .hero-section h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .hero-section p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .about-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .about-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: var(--shadow);
            text-align: center;
        }

        .about-card i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .about-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--text-color);
        }

        .about-card p {
            color: #666;
        }

        .team-section {
            margin-bottom: 4rem;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .section-title p {
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .team-member {
            background: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            overflow: hidden;
            text-align: center;
        }

        .member-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .member-info {
            padding: 1.5rem;
        }

        .member-info h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: var(--text-color);
        }

        .member-info p {
            color: #666;
            margin-bottom: 1rem;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .social-links a {
            color: var(--primary-color);
            font-size: 1.2rem;
            transition: color 0.3s;
        }

        .social-links a:hover {
            color: var(--secondary-color);
        }

        .stats-section {
            background: var(--white);
            padding: 4rem 0;
            margin-bottom: 4rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-item p {
            color: #666;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2rem;
            }

            .hero-section p {
                font-size: 1rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="container">
            <h1>About E-Shop</h1>
            <p>Your trusted destination for quality products and exceptional shopping experience</p>
        </div>
    </div>

    <div class="container">
        <div class="about-content">
            <div class="about-card">
                <i class="fas fa-shopping-bag"></i>
                <h3>Our Mission</h3>
                <p>To provide customers with high-quality products at competitive prices while ensuring an exceptional shopping experience.</p>
            </div>
            <div class="about-card">
                <i class="fas fa-eye"></i>
                <h3>Our Vision</h3>
                <p>To become the leading e-commerce platform known for customer satisfaction, product quality, and innovative shopping solutions.</p>
            </div>
            <div class="about-card">
                <i class="fas fa-heart"></i>
                <h3>Our Values</h3>
                <p>Quality, Integrity, Customer Satisfaction, and Innovation are the core values that drive our business forward.</p>
            </div>
        </div>

        <div class="stats-section">
            <div class="container">
                <div class="stats-grid">
                    <div class="stat-item">
                        <h3>10K+</h3>
                        <p>Happy Customers</p>
                    </div>
                    <div class="stat-item">
                        <h3>5K+</h3>
                        <p>Products</p>
                    </div>
                    <div class="stat-item">
                        <h3>24/7</h3>
                        <p>Customer Support</p>
                    </div>
                    <div class="stat-item">
                        <h3>100%</h3>
                        <p>Satisfaction</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="team-section">
            <div class="section-title">
                <h2>Our Team</h2>
                <p>Meet the dedicated professionals behind E-Shop's success</p>
            </div>
            <div class="team-grid">
                <div class="team-member">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a" alt="Team Member" class="member-image">
                    <div class="member-info">
                        <h3>John Doe</h3>
                        <p>Founder & CEO</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-facebook"></i></a>
                        </div>
                    </div>
                </div>
                <div class="team-member">
                    <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e" alt="Team Member" class="member-image">
                    <div class="member-info">
                        <h3>Jane Smith</h3>
                        <p>Operations Manager</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-facebook"></i></a>
                        </div>
                    </div>
                </div>
                <div class="team-member">
                    <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7" alt="Team Member" class="member-image">
                    <div class="member-info">
                        <h3>Mike Johnson</h3>
                        <p>Customer Support Lead</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-facebook"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 