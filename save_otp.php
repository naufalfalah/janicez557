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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'] ?? '';
    $otp = $_POST['otp'] ?? '';

    if (!empty($phone) && !empty($otp)) {
        $stmt = $pdo->prepare("INSERT INTO otp (phone, otp, created_at) VALUES (:phone, :otp, NOW())");
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':otp', $otp);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save OTP']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

?>
