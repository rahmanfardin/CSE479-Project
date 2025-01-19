<?php
require_once 'dbcon.php';

$query = "SELECT username, score FROM dino ORDER BY score DESC LIMIT 100";
$result = $conn->query($query);

$leaderboard = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $leaderboard[] = $row;
    }
}

$conn->close();
echo json_encode($leaderboard);
?>