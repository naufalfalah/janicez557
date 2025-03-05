<?php

require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$phone = isset($_POST['phone']) ? $_POST['phone'] : null;

if (!$phone) {
    echo json_encode(['success' => false, 'message' => 'Phone number is required']);
    exit();
}

$otp = mt_rand(100000, 999999);

try {
    $stmt = $pdo->prepare("UPDATE otps SET otp = ?, created_at = NOW() WHERE phone = ?");
    $stmt->execute([$otp, $phone]);

    if ($stmt->rowCount() === 0) {
        echo json_encode(['success' => false, 'message' => 'No OTP record found for this phone number']);
        exit();
    }

    $message = "Your OTP code is: $otp";
    $sendResult = sendWpMessage($phone, $message);

    error_log("New OTP for $phone: $otp");

    echo json_encode(['success' => true, 'message' => 'OTP resent successfully']);
    exit();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    exit();
}

?>
