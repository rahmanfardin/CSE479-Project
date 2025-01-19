<?php
require_once 'dbcon.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>DINO | Leaderboard</title>
    <link rel="stylesheet" type="text/css" href="leaderboard.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
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
        <tbody id="leaderboard-body">
            <!-- Leaderboard data will be inserted here by JavaScript -->
        </tbody>
    </table>
    <a href="../">Back to Login</a>

    <script>
        function fetchLeaderboard() {
            fetch('fetch_leaderboard.php')
                .then(response => response.json())
                .then(data => {
                    const leaderboardBody = document.getElementById('leaderboard-body');
                    leaderboardBody.innerHTML = '';
                    data.forEach((entry, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${String(index + 1).padStart(2, '0')}</td>
                            <td>${entry.username}</td>
                            <td>${entry.score}</td>
                        `;
                        leaderboardBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching leaderboard:', error));
        }

        // Fetch leaderboard data every 1 second
        setInterval(fetchLeaderboard, 1000);

        // Initial fetch
        fetchLeaderboard();
    </script>
</body>
</html>