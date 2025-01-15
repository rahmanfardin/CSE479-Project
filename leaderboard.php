<?php
require_once 'dbcon.php';
$count = 0;
$query = "SELECT username, score FROM dino ORDER BY score DESC LIMIT 10";
$result = $conn->query($query);

$leaderboard = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $leaderboard[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leaderboard</title>
    <link rel="stylesheet" type="text/css" href="leaderboard.css">
</head>
<body>
    <h1>Leaderboard</h1>
    <table id="leaderboard-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Username</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($leaderboard as $entry): ?>
                <tr>
                    <td><?php echo ++$count;?></td>  
                    <td><?php echo htmlspecialchars($entry['username']); ?></td>
                    <td><?php echo htmlspecialchars($entry['score']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="../">Back to Login</a>
</body>
</html>