<?php
session_start();
require_once "db_connect.php";

if (!isset($_SESSION['user_id'])) {
    die(json_encode(["success" => false, "message" => "يجب تسجيل الدخول"]));
}

$user_id = $_SESSION['user_id'];

if ($_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES['avatar']['name']);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFilePath)) {
        $query = "UPDATE users SET avatar = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $targetFilePath, $user_id);
        $stmt->execute();

        echo json_encode(["success" => true, "new_avatar" => $targetFilePath]);
    } else {
        echo json_encode(["success" => false, "message" => "فشل في رفع الصورة"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "لم يتم اختيار صورة"]);
}

$conn->close();
?>
