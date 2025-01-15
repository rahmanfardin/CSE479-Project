<?php
session_start();
if ($_SESSION['loggin']) {
    $user = $_SESSION['username'];
    $score = $_SESSION['score'];
} else {
    header("Location: pleaseSignup.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>RAWRRRR!</title>
    <link rel="stylesheet" href="style.css"> 
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body>
    <h1>Dinosaur Game!</h1>
	<p class="username">Welcome, <span id="username"><?php echo htmlspecialchars($user); ?></span></p>
    <p class="previous-score">Previous Highscore: <span id="previous-score"><?php echo htmlspecialchars($score); ?></span></p>
    <canvas id="game" height="200" width="800"></canvas>
    <p class="controls">press space bar to start</p>

    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
    
    <button id="refresh-button">Refresh High Score</button>

    <script src="js/helpers.js"></script>
    <script src="js/objects/game-object.js"></script>
    <script src="js/objects/cactus.js"></script>
    <script src="js/objects/dinosaur.js"></script>
    <script src="js/objects/background.js"></script>
    <script src="js/objects/score.js"></script>
    <script src="js/game.js"></script>
    <script>
        new Game({
            el: document.getElementById("game")
        });

        function updateHighScore() {
            fetch('get_highscore.php')
                .then(response => response.json())
                .then(data => {
                    if (data.score !== undefined) {
                        const previousScoreElement = document.getElementById('previous-score');
                        const previousScore = parseInt(previousScoreElement.textContent);
                        previousScoreElement.textContent = data.score;

                        if (data.score > previousScore) {
                            previousScoreElement.classList.add('highlight');
                        } else {
                            previousScoreElement.classList.remove('highlight');
                        }
                    } else {
                        alert('Error: ' + data.error);
                    }
                });
        }

        document.getElementById('refresh-button').addEventListener('click', function() {
            updateHighScore();
            location.reload();
        });

        // Fetch and update high score on page load
        updateHighScore();
    </script>
</body>
</html>