<?php

require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$phone = $_POST['phone'] ?? '';
$otp = $_POST['otp'] ?? '';

if (empty($phone) || empty($otp)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit();
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT * FROM otps WHERE phone = :phone AND otp = :otp ORDER BY created_at DESC LIMIT 1");
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':otp', $otp);
    $stmt->execute();
    $otpData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$otpData) {
        echo json_encode(['success' => false, 'message' => 'Invalid OTP']);
        $pdo->rollBack();
        exit();
    }

    $lead_id = $otpData['lead_id'];

    $updateStmt = $pdo->prepare("UPDATE users SET verified_at = NOW() WHERE id = :lead_id");
    $updateStmt->bindParam(':lead_id', $lead_id);
    $updateStmt->execute();

    $pdo->commit();

    echo json_encode(['success' => true, 'message' => 'OTP verified, user updated']);
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
    exit();
}

?>
