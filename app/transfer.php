<?php
session_start();

$STEPUP_WINDOW_SECONDS = 120; // sensitive actions must occur within 2 min of login

if (isset($_SESSION['user'])) {
    $age = time() - ($_SESSION['login_time'] ?? 0);

    if ($age > $STEPUP_WINDOW_SECONDS) {
        error_log("ATO_LAB SENSITIVE_ACTION_NO_STEPUP session_id=" . session_id() . " user=" . $_SESSION['user'] . " session_age=$age ip=" . $_SERVER['REMOTE_ADDR'] . "\n", 3, "/var/log/securebank/session.log");
        http_response_code(403);
        echo "Additional verification required for this action.";
    } else {
        error_log("ATO_LAB SESSION_ACTION session_id=" . session_id() . " user=" . $_SESSION['user'] . " action=transfer_funds ip=" . $_SERVER['REMOTE_ADDR'] . "\n", 3, "/var/log/securebank/session.log");
        echo "Transfer of \$500 initiated for " . $_SESSION['user'];
    }
} else {
    http_response_code(401);
    echo "No active session.";
}
?>
