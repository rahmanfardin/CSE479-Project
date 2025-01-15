(function(namespace) {
    var SCORE_FACTOR = 0.1;

    function formatOffset(offset) {
        // TODO pad with zeroes
        return Math.floor(offset * SCORE_FACTOR);
    }

    function ScoreBoard(options) {
        this.scale = options.scale;
        this.x = options.left;
        this.y = options.bottom;
        this.colour = options.colour;
        this.score = 0;
    }

    ScoreBoard.prototype = Object.create(GameObject.prototype);
    ScoreBoard.prototype.constructor = ScoreBoard;

    ScoreBoard.prototype.draw = function(context, offset) {
        this.score = formatOffset(offset);
        context.fillStyle = this.colour;
        context.font = "16px Courier";
        context.textAlign = "right"; 
        context.fillText(this.score, this.x, this.y);
    };

    ScoreBoard.prototype.gameOver = function() {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_score.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log("Score updated successfully");
            }
        };
        xhr.send("score=" + this.score);
    };

    namespace.ScoreBoard = ScoreBoard;
})(window);