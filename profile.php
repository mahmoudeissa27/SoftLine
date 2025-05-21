<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // إذا لم يتم تسجيل الدخول، توجه المستخدم إلى صفحة تسجيل الدخول
    header("Location: login.html");
    exit();
}

// الاتصال بقاعدة البيانات
$conn = new mysqli('localhost', 'root', '', 'softlinee_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// جلب بيانات المستخدم بناءً على معرف المستخدم المخزن في الجلسة
$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<h3>Error: User not found!</h3>";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="navbar">
        <span class="brand">SoftLine</span>
        <a href="index.html">Home</a>
        <a href="aboutus.html">About Us</a>
        <a href="services.html">Services</a>
        
    </div>

    <div class="profile">
        <h1>Welcome to Your Profile</h1>
        <div class="profile-card">
            <img src="f.jpeg" alt="Profile Picture">
            <h2><?php echo htmlspecialchars($user['username']); ?></h2>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <button onclick="window.location.href='logout.php';">Sign Out</button>
            
        </div>
    </div>

    <footer>
        <p>&copy; 2024 SoftLine. All Rights Reserved.</p>
    </footer>
</body>
</html>
