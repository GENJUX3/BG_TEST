<?php
require_once "db_connect.php"; // تأكد أن لديك ملف اتصال بقاعدة البيانات

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    // التحقق من أن كلمة المرور متطابقة
    if ($password !== $confirmPassword) {
        echo "❌ كلمات المرور غير متطابقة!";
        exit;
    }

    // التحقق من البريد واسم المستخدم
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "❌ البريد الإلكتروني أو اسم المستخدم مستخدم بالفعل! <br><button id='loginBtn' class='btn btn-success w-100 mt-2' onclick='redirectToLogin()'>تسجيل الدخول</button>";
        exit;
    }

    // تشفير كلمة المرور
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // إدخال البيانات إلى قاعدة البيانات
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "✅ تم التسجيل بنجاح!";
    } else {
        echo "❌ حدث خطأ أثناء التسجيل!";
    }

    $stmt->close();
    $conn->close();
}
?>
