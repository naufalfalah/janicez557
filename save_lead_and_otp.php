<?php

require_once 'helper_2chat.php';
require_once 'lead_filter.php';

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

$household = isset($_POST['household']) ? $_POST['household'] : null;
$citizenship = isset($_POST['citizenship']) ? $_POST['citizenship'] : null;
$requirement = isset($_POST['requirement']) ? $_POST['requirement'] : null;
$household_income = isset($_POST['household_income']) ? $_POST['household_income'] : null;
$ownership_status = isset($_POST['ownership_status']) ? $_POST['ownership_status'] : null;
$private_property_ownership = isset($_POST['private_property_ownership']) ? $_POST['private_property_ownership'] : null;
$first_time_applicant = isset($_POST['first_time_applicant']) ? $_POST['first_time_applicant'] : null;
$name = isset($_POST['name']) ? $_POST['name'] : null;
$phone = isset($_POST['phone']) ? $_POST['phone'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;

$otp = mt_rand(100000, 999999);

if (is_fake_name($name)) {
    echo json_encode(['success' => false, 'message' => 'Invalid name', 'error' => 'name']);
    exit();
}

if (is_fake_phone($phone)) {
    echo json_encode(['success' => false, 'message' => 'Invalid phone number', 'error' => 'phone']);
    exit();
}

if (is_fake_email($email)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address', 'error' => 'email']);
    exit();
}

try {
    $stmt = $pdo->prepare("INSERT INTO users (household, citizenship, requirement, household_income, ownership_status, private_property_ownership, first_time_applicant, name, email, phone) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$household, $citizenship, $requirement, $household_income, $ownership_status, $private_property_ownership, $first_time_applicant, $name, $email, $phone]);

    $lead_id = $pdo->lastInsertId();
    if (!$lead_id) {
        echo json_encode(['success' => false, 'message' => 'Failed to retrieve lead_id']);
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO otps (lead_id, phone, otp, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$lead_id, $phone, $otp]);
    
    $message = "Your OTP code is: $otp";
    $sendResult = sendWpMessage($phone, $message);
    
    echo json_encode(['success' => true, 'message' => 'OTP generated successfully', 'data' => $sendResult]);
    exit();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    exit();
}

?>
