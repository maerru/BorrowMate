<?php

session_start();
require_once "includes/db_Conn.php";

if (isset($_SESSION['user_id'])) {

    $logSql = "
        INSERT INTO tbl_logs(user_id, log_msg, log_date)
        VALUES ('".$_SESSION['user_id']."', 'Logged out', NOW())
    ";

    $conn->query($logSql);
}

session_destroy();

echo "
<script>
    window.location.href = 'HomePage.php';
</script>
";

?>