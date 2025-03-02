<?php
$servername = "localhost";
$username = "root"; // لو بتستخدم XAMPP أو MAMP
$password = ""; // في XAMPP بيكون فاضي
$dbname = "tryit"; // اسم قاعدة البيانات الجديد

$conn = new mysqli($servername, $username, $password, $dbname);

// التأكد من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

?>
