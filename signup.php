<?php
// تفعيل عرض الأخطاء لتصحيح المشاكل
error_reporting(E_ALL);
ini_set('display_errors', 1);

// التحقق من أن النموذج قد تم إرساله
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استلام البيانات من النموذج
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // التحقق من أن الحقول غير فارغة
    if (!empty($username) && !empty($email) && !empty($password)) {
        // الاتصال بقاعدة البيانات
        $conn = new mysqli('localhost', 'root', '', 'softlinee_db');

        // التحقق من الاتصال
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // التحقق إذا كان البريد الإلكتروني موجودًا مسبقًا
        $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo "<h3>Email is already registered!</h3>";
            $stmt->close();
            $conn->close();
            exit();
        }
        $stmt->close();

        // تشفير كلمة المرور
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // إدخال البيانات إلى قاعدة البيانات
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            // عرض رسالة نجاح
            echo "<h3>User registered successfully! Redirecting to login page...</h3>";
            
            // توجيه المستخدم إلى صفحة تسجيل الدخول بعد 3 ثوانٍ
            echo "
            <script>
                setTimeout(function() {
                    window.location.href = 'login.html'; // توجيه المستخدم إلى صفحة تسجيل الدخول
                }, 3000); // تأخير لمدة 3 ثوانٍ
            </script>";
        } else {
            echo "<h3>Error: " . $stmt->error . "</h3>";
        }

        // إغلاق الاتصال
        $stmt->close();
        $conn->close();
    } else {
        echo "<h3>All fields are required!</h3>";
    }
}
?>
