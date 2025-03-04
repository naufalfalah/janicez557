<?php

require_once 'helper_discord.php';

$host = 'localhost';
// $dbname = 'dbhnskgiz5vgt0';
// $user = 'ueglrxglswpkr';
// $pass = '|$jicqbd23h#';
$dbname = 'dbiqzpqa1fx0dl';
$user = 'root';
$pass = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE verified_at IS NOT NULL AND send_discord IS NULL LIMIT 1");
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $userId = $user['id'];

        if (sendLeadToDiscord($user)) {
            $updateStmt = $pdo->prepare("UPDATE users SET send_discord = 1 WHERE id = :id");
            $updateStmt->execute(['id' => $userId]);

            echo "Lead $userId has been sent.\n";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
