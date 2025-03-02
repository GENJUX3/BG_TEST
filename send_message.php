<?php
session_start();
require_once "db_connect.php"; // ملف الاتصال بقاعدة البيانات

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $message = trim($_POST["message"]);
    
    // استقبال اللون والخط إذا تم اختيارهما
    $color = isset($_POST["color"]) ? $_POST["color"] : null;
    $textColor = isset($_POST["textColor"]) ? $_POST["textColor"] : null;

    if (!empty($message)) {
        $stmt = $conn->prepare("INSERT INTO messages (user_id, message, color, text_color) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $message, $color, $textColor);

        if ($stmt->execute()) {
            echo "✅ Message sent!";
        } else {
            echo "❌ Error sending message!";
        }
        $stmt->close();
    }
    $conn->close();
}
?>
