<?php
// إعدادات الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "softlinee_db";

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// التحقق من وجود البيانات في النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cardholder_name = $_POST['cardholder_name'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $payment_method = $_POST['payment_method'];

    // التحقق من صحة البيانات
    if (empty($cardholder_name) || empty($card_number) || empty($expiry_date) || empty($cvv) || empty($payment_method)) {
        die("Please fill all the fields.");
    }

    // هنا يمكننا إضافة البيانات إلى قاعدة البيانات
    $stmt = $conn->prepare("INSERT INTO payments (cardholder_name, card_number, expiry_date, cvv, payment_method) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $cardholder_name, $card_number, $expiry_date, $cvv, $payment_method);

    if ($stmt->execute()) {
        // عرض رسالة "تم بنجاح"
        echo '<p style="color: green; text-align: center;">تمت العملية بنجاح!</p>';

        // عرض رسالة ثم التوجيه للصفحة الرئيسية بعد 3 ثواني
        echo '
        <script>
            setTimeout(function() {
                window.location.href = "index.html"; // التوجيه إلى الصفحة الرئيسية
            }, 3000); // 3000 ميللي ثانية = 3 ثواني
        </script>';
    } else {
        echo '<p style="color: red; text-align: center;">فشلت العملية. حاول مرة أخرى لاحقًا.</p>';
    }

    $stmt->close();
    $conn->close();
}
?>
