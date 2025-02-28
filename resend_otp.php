<?php

$host = 'localhost';
// $dbname = 'dbhnskgiz5vgt0';
// $user = 'ueglrxglswpkr';
// $pass = '|$jicqbd23h#';
$dbname = 'dbiqzpqa1fx0dl';
$user = 'root';
$pass = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

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

    error_log("New OTP for $phone: $otp");

    echo json_encode(['success' => true, 'message' => 'OTP resent successfully']);
    exit();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    exit();
}

?>
