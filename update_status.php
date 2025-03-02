<?php
session_start();
require_once "db_connect.php";

if (!isset($_SESSION['user_id'])) {
    die(json_encode(["success" => false, "message" => "يجب تسجيل الدخول"]));
}

$user_id = $_SESSION['user_id'];
$status = $_POST['status'];

$query = "UPDATE users SET status = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $status, $user_id);
$stmt->execute();

echo json_encode(["success" => true]);

$conn->close();
?>
