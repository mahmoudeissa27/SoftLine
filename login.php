<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        $conn = new mysqli('localhost', 'root', '', 'softlinee_db');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $email;

                header("Location: profile.php");
                exit();
            } else {
                echo "<h3>Error: Incorrect password!</h3>";
            }
        } else {
            echo "<h3>Error: Email not found!</h3>";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<h3>Error: All fields are required!</h3>";
    }
}
?>
