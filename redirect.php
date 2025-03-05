<?php

loadEnv(__DIR__ . '/.env');

function safe_redirect($url) {
    if (!headers_sent()) {
        header("Location: " . getenv('BASE_URL') . $url);
        exit;
    } else {
        die("Cannot redirect, headers already sent.");
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    safe_redirect("registration/");
    exit;
}

$citizenship = htmlspecialchars($_POST['citizenship']) ?? null;
$requirement = htmlspecialchars($_POST['requirement']) ?? null;
$household_income = htmlspecialchars($_POST['household_income']) ?? null;
$ownership_status = htmlspecialchars($_POST['ownership_status']) ?? null;
$private_property_ownership = htmlspecialchars($_POST['private_property_ownership']) ?? null;

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