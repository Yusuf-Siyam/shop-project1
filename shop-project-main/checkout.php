<?php
session_start();
include("connect.php");

// Check if user is logged in
if(!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$userId = $_SESSION['user_id'];
$email = $_SESSION['email'];

// Get user information
$userFirstName = $userLastName = "";
$query = mysqli_query($conn, "SELECT * FROM `users` WHERE email='$email'");
while($row = mysqli_fetch_array($query)) {
    $userFirstName = $row['firstName'];
    $userLastName = $row['lastName'];
}

// Get cart items
$cartQuery = "SELECT c.*, p.name, p.price, p.image FROM cart c
              JOIN products p ON c.product_id = p.id 
              WHERE c.user_id = $userId";
$cartResult = mysqli_query($conn, $cartQuery);

$cartItems = [];
$totalAmount = 0;

if (mysqli_num_rows($cartResult) > 0) {
    while ($item = mysqli_fetch_assoc($cartResult)) {
        $cartItems[] = $item;
        $totalAmount += $item['price'] * $item['quantity'];
    }
}

// Handle checkout submission
$message = "";
$error = "";

if (isset($_POST['place_order'])) {
    // Validate form inputs
    $shippingAddress = mysqli_real_escape_string($conn, $_POST['address']);
    $shippingCity = mysqli_real_escape_string($conn, $_POST['city']);
    $shippingPostalCode = mysqli_real_escape_string($conn, $_POST['postal_code']);
    $shippingPhone = mysqli_real_escape_string($conn, $_POST['phone']);
    $paymentMethod = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $notes = isset($_POST['notes']) ? mysqli_real_escape_string($conn, $_POST['notes']) : '';
    
    // Create order
    $createOrderQuery = "INSERT INTO orders (user_id, total_amount, payment_method, shipping_address, 
                        shipping_city, shipping_postal_code, shipping_phone, notes) 
                        VALUES ($userId, $totalAmount, '$paymentMethod', '$shippingAddress', 
                        '$shippingCity', '$shippingPostalCode', '$shippingPhone', '$notes')";
    
    if (mysqli_query($conn, $createOrderQuery)) {
        $orderId = mysqli_insert_id($conn);
        
        // Add order items
        foreach ($cartItems as $item) {
            $productId = $item['product_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            
            $addItemQuery = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                            VALUES ($orderId, $productId, $quantity, $price)";
            mysqli_query($conn, $addItemQuery);
        }
        
        // Clear the cart
        mysqli_query($conn, "DELETE FROM cart WHERE user_id = $userId");
        
        // Redirect to order confirmation
        header("Location: order-confirmation.php?order_id=$orderId");
        exit();
    } else {
        $error = "Error creating order: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Shop - Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="e-shop.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <h1>E-<span>Shop</span></h1>
                </div>
                
                <ul class="nav-links">
                    <li><a href="homepage.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
                
                <div class="nav-icons">
                    <div class="nav-icon">
                        <a href="#" class="cart-icon" id="cart-btn">
                            <i class="fas fa-shopping-cart"></i>
                            <?php
                            $cartCountQuery = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id = $userId");
                            $cartCount = mysqli_fetch_assoc($cartCountQuery)['total'];
                            echo "<span class='count'>$cartCount</span>";
                            ?>
                        </a>
                    </div>
                    
                    <div class="nav-icon">
                        <a href="account.php"><i class="fas fa-user"></i></a>
                    </div>
                </div>
                
                <div class="hamburger">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </nav>
        </div>
    </header>

    <!-- Checkout Section -->
    <section class="checkout-section">
        <div class="container">
            <h2 class="section-title">Checkout</h2>
            
            <?php if(count($cartItems) > 0): ?>
                <?php if($error): ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <div class="checkout-container">
                    <div class="checkout-form">
                        <h3>Shipping Information</h3>
                        <form method="post" action="">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" id="first_name" name="first_name" value="<?php echo $userFirstName; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" value="<?php echo $userLastName; ?>" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" required>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" id="city" name="city" required>
                                </div>
                                <div class="form-group">
                                    <label for="postal_code">Postal Code</label>
                                    <input type="text" id="postal_code" name="postal_code" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="notes">Order Notes (Optional)</label>
                                <textarea id="notes" name="notes" rows="3"></textarea>
                            </div>
                            
                            <h3>Payment Method</h3>
                            <div class="payment-methods">
                                <div class="payment-method">
                                    <input type="radio" id="cod" name="payment_method" value="Cash on Delivery" checked>
                                    <label for="cod">
                                        <i class="fas fa-money-bill-wave"></i>
                                        Cash on Delivery
                                    </label>
                                </div>
                                
                                <div class="payment-method">
                                    <input type="radio" id="card" name="payment_method" value="Credit Card" disabled>
                                    <label for="card" class="disabled">
                                        <i class="far fa-credit-card"></i>
                                        Credit Card (Coming Soon)
                                    </label>
                                </div>
                                
                                <div class="payment-method">
                                    <input type="radio" id="paypal" name="payment_method" value="PayPal" disabled>
                                    <label for="paypal" class="disabled">
                                        <i class="fab fa-paypal"></i>
                                        PayPal (Coming Soon)
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" name="place_order" class="btn primary-btn place-order-btn">
                                Place Order <i class="fas fa-check"></i>
                            </button>
                        </form>
                    </div>
                    
                    <div class="order-summary">
                        <h3>Order Summary</h3>
                        <div class="order-items">
                            <?php foreach($cartItems as $item): ?>
                                <div class="order-item">
                                    <div class="order-item-img">
                                        <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                                    </div>
                                    <div class="order-item-info">
                                        <h4><?php echo $item['name']; ?></h4>
                                        <div class="order-item-details">
                                            <span class="order-item-price">$<?php echo $item['price']; ?></span>
                                            <span class="order-item-quantity">× <?php echo $item['quantity']; ?></span>
                                        </div>
                                    </div>
                                    <div class="order-item-total">
                                        $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="order-totals">
                            <div class="order-subtotal">
                                <span>Subtotal</span>
                                <span>$<?php echo number_format($totalAmount, 2); ?></span>
                            </div>
                            <div class="order-shipping">
                                <span>Shipping</span>
                                <span>Free</span>
                            </div>
                            <div class="order-total">
                                <span>Total</span>
                                <span>$<?php echo number_format($totalAmount, 2); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="empty-cart-message">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Your cart is empty</h3>
                    <p>You don't have any items in your cart to checkout.</p>
                    <a href="shop.php" class="btn primary-btn">Continue Shopping</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column footer-logo">
                    <h2>E-<span>Shop</span></h2>
                    <p>Your one-stop destination for all your shopping needs.</p>
                </div>
                
                <div class="footer-column footer-links">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="homepage.php">Home</a></li>
                        <li><a href="shop.php">Shop</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-column footer-links">
                    <h3>Categories</h3>
                    <ul>
                        <?php
                        $categoriesResult = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC LIMIT 4");
                        while($category = mysqli_fetch_assoc($categoriesResult)):
                        ?>
                        <li>
                            <a href="shop.php?category=<?php echo $category['name']; ?>">
                                <?php echo $category['name']; ?>
                            </a>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                
                <div class="footer-column footer-social">
                    <h3>Follow Us</h3>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="copyright">
            <div class="container">
                <p>&copy; <?php echo date('Y'); ?> E-Shop. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Toggle Mobile Navigation
        const hamburger = document.querySelector('.hamburger');
        const navLinks = document.querySelector('.nav-links');
        
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navLinks.classList.toggle('active');
        });
    </script>
</body>
</html> 