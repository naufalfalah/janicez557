<?php

require_once 'database.php';
require_once 'helper_discord.php';

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
