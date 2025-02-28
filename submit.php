<?php

header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");

function safe_redirect($url) {
    if (!headers_sent()) {
        header("Location: https://janicez557.sg-host.com/" . $url);
        exit;
    } else {
        die("Cannot redirect, headers already sent.");
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    safe_redirect("registration/");
    exit;
}

// Database config
$dbConfig = [
    'host' => 'localhost',
    'name' => 'dbhnskgiz5vgt0',
    'user' => 'ueglrxglswpkr',
    'pass' => '|$jicqbd23h#',
];

// MySQL connection
$conn = new mysqli($dbConfig['host'], $dbConfig['user'], $dbConfig['pass'], $dbConfig['name']);

// Connection check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$household = htmlspecialchars($_POST['household']) ?? null;
$citizenship = htmlspecialchars($_POST['citizenship']) ?? null;
$requirement = htmlspecialchars($_POST['requirement']) ?? null;
$household_income = htmlspecialchars($_POST['household_income']) ?? null;
$ownership_status = htmlspecialchars($_POST['ownership_status']) ?? null;
$private_property_ownership = htmlspecialchars($_POST['private_property_ownership']) ?? null;
$first_time_applicant = htmlspecialchars($_POST['first_time_applicant']) ?? null;
$name = htmlspecialchars($_POST['name']) ?? null;
$phone = htmlspecialchars($_POST['phone']) ?? null;
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ?? null;

// SQL Query
$sql = "INSERT INTO users (household, citizenship, requirement, household_income, ownership_status, private_property_ownership, first_time_applicant, name, email, phone) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssss", $household, $citizenship, $requirement, $household_income, $ownership_status, $private_property_ownership, $first_time_applicant, $name, $email, $phone);
$stmt->execute();

// Close connection
$stmt->close();
$conn->close();

$msg = '';

switch (true) {
    case $citizenship === 'No, not Singapore Citizens or Permanent Residents' || 
         $requirement === 'No' || 
         $household_income === 'No' || 
         $private_property_ownership === 'Yes':
        safe_redirect("disqualification.html");
        exit;
    case $ownership_status === 'Yes, MOP completed':
        safe_redirect("congratulation.html");
        exit;
    case $ownership_status === 'Yes, still within MOP':
        safe_redirect("mop.html");
        exit;
    case $ownership_status === 'No, do not own any HDB':
        safe_redirect("appeal.html");
        exit;
    default:
        safe_redirect("/");
        exit;
}

?>