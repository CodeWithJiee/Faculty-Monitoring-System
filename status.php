<?php
session_start();

$status = $_SESSION['status'] ?? null;
unset($_SESSION['status']); // clear after use

echo json_encode(['status' => $status]);
?>
