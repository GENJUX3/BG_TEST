<?php
require_once "db_connect.php";

$query = "SELECT messages.message, messages.created_at, messages.user_id, messages.color, messages.text_color, 
                 users.username, users.avatar 
          FROM messages 
          JOIN users ON messages.user_id = users.id 
          ORDER BY messages.created_at DESC";

$result = $conn->query($query);

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = [
        "message" => $row["message"],
        "created_at" => $row["created_at"],
        "user_id" => $row["user_id"], // ✅ إرسال user_id
        "username" => $row["username"],
        "color" => $row["color"], // ✅ إرسال لون الخلفية
        "textColor" => $row["text_color"], // ✅ إرسال لون النص
        "avatar" => !empty($row["avatar"]) ? $row["avatar"] : "default-avatar.png" // ✅ إرسال صورة المستخدم أو صورة افتراضية
    ];
}

echo json_encode($messages);

$conn->close();
?>
