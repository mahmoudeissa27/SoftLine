<?php
// بيانات الاتصال بقاعدة البيانات
$servername = "localhost"; // اسم السيرفر
$username = "root"; // اسم المستخدم
$password = ""; // كلمة المرور
$dbname = "softlinee_db"; // اسم قاعدة البيانات

// إنشاء اتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// التحقق من إرسال البيانات من النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استقبال بيانات المنتج
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $payment_method = $_POST['payment_method'];

    // استعلام لإدخال البيانات إلى الجدول
    $sql = "INSERT INTO cart_items (product_name, price, payment_method) 
            VALUES ('$product_name', '$price', '$payment_method')";

    if ($conn->query($sql) === TRUE) {
        echo "تم إدخال البيانات بنجاح!";
    } else {
        echo "خطأ: " . $sql . "<br>" . $conn->error;
    }
}

// إغلاق الاتصال بقاعدة البيانات
$conn->close();
?>
