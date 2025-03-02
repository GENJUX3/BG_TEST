<?php
require 'db_connect.php'; // ملف الاتصال بقاعدة البيانات

// تفعيل عرض الأخطاء للتصحيح
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    // استقبال البيانات من الفورم
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $pass = isset($_POST['password']) ? trim($_POST['password']) : null;

    // طباعة البيانات للتأكد
    

    // التحقق من إدخال البيانات
    if (empty($email) || empty($pass)) {
        exit("❌ كل الحقول مطلوبة!");
    }

    // التحقق من صحة البريد الإلكتروني
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit("❌ البريد الإلكتروني غير صالح!");
    }

    // التحقق من وجود المستخدم في جدول users
    $sql = "SELECT id, username, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        exit("❌ المستخدم غير موجود! برجاء التسجيل.");
    }

    // جلب بيانات المستخدم
    $stmt->bind_result($id, $username, $hashedPass);
    $stmt->fetch();

    // التحقق من صحة كلمة المرور
    if (!password_verify($pass, $hashedPass)) {
        exit("❌ كلمة المرور غير صحيحة!");
    }

    // تسجيل الدخول بنجاح
    echo "✅ تم تسجيل الدخول بنجاح! مرحبًا، $username";

    // بدء جلسة المستخدم
    session_start();
    $_SESSION['user_id'] = $id;
    $_SESSION['username'] = $username;

    $stmt->close();
}

$conn->close();
?>
