<?php
include("connect.php");

// Read the SQL file
$sql = file_get_contents('database_setup.sql');

// Execute multi query
if (mysqli_multi_query($conn, $sql)) {
    echo "Database setup completed successfully!<br>";
    echo "Tables created:<br>";
    echo "- users<br>";
    echo "- categories<br>";
    echo "- products<br>";
    echo "- cart<br>";
    echo "- orders<br>";
    echo "- order_items<br><br>";
    
    echo "Sample data added:<br>";
    echo "- 5 categories<br>";
    echo "- 10 products<br>";
    echo "- 2 test users (admin and regular user)<br><br>";
    
    echo "Test user credentials:<br>";
    echo "Admin: admin@example.com / admin123<br>";
    echo "User: user@example.com / user123<br>";
} else {
    echo "Error setting up database: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?> 