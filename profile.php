<?php
session_start();
require_once "db_connect.php"; // ملف الاتصال بقاعدة البيانات

// التحقق من هوية المستخدم الحالي
$current_user_id = $_SESSION['user_id'] ?? null;
$profile_user_id = $_GET['user_id'] ?? $current_user_id;

// جلب بيانات المستخدم من قاعدة البيانات
$query = "SELECT username, avatar, status FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $profile_user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die(json_encode(["error" => "المستخدم غير موجود!"]));
}

// تحديد ما إذا كان صاحب الحساب أم زائر
$own_profile = ($current_user_id == $profile_user_id);

// إرجاع البيانات كـ JSON لاستخدامها في الجافاسكريبت
echo json_encode([
    "username" => $user['username'],
    "avatar" => !empty($user['avatar']) ? $user['avatar'] : "default-avatar.png",
    "status" => $user['status'],
    "own_profile" => $own_profile
]);

$conn->close();
?>
