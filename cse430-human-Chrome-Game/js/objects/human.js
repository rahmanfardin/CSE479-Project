(function(namespace) {
    var STEP_SPEED = 0.05; // Humans generally walk slower than the Dinosaur's step speed.
    var JUMP_DISTANCE = 300; // Adjusted jump distance for a human.
    var JUMP_HEIGHT = 100; // Adjusted jump height for a human.

    function Human(options) {
        this.scale = options.scale;
        this.x = options.left;
        this.y = options.bottom;
        this.colour = options.colour;
        this.jumpStart = null;
    }

    Human.prototype = Object.create(GameObject.prototype);
    Human.prototype.constructor = Human;

    Human.prototype.isJumping = function(offset) {
        return this.jumpStart !== null && this.jumpDistanceRemaining(offset) > 0;
    };

    Human.prototype.jumpDistanceRemaining = function(offset) {
        if (this.jumpStart === null) return 0;
        return this.jumpStart + JUMP_DISTANCE - offset;
    };

    Human.prototype.startJump = function(offset) {
        this.jumpStart = offset;
    };

    Human.prototype.jumpHeight = function(offset) {
        var distanceRemaining = this.jumpDistanceRemaining(offset);
        if (distanceRemaining > 0) {
            var maxPoint = JUMP_DISTANCE / 2;

            if (distanceRemaining >= maxPoint) {
                distanceRemaining -= JUMP_DISTANCE;
            }

            var arcPos = Math.abs(distanceRemaining / maxPoint);

            return JUMP_HEIGHT * arcPos;
        }
        return 0;
    };

    Human.prototype.hasLeftLegForward = function(offset) {
        return offset > 0 && Math.floor(offset * STEP_SPEED) % 2 === 0;
    };

    Human.prototype.hasRightLegForward = function(offset) {
        return offset > 0 && Math.floor(offset * STEP_SPEED) % 2 === 1;
    };

    Human.prototype.draw = function(context, offset) {
        var x = this.x,
            offsetY = this.y - this.jumpHeight(offset),
            y = offsetY;
    
        context.fillStyle = this.colour;
    
        // Head (Triangle)
        context.beginPath();
        context.moveTo(x + 13.5, y - 35); // Top point
        context.lineTo(x + 7, y - 25); // Bottom left point
        context.lineTo(x + 20, y - 25); // Bottom right point
        context.closePath();
        context.fill();
    
        // Body
        context.fillRect(x + 10, y - 23, 7, 13);
    
        // Arms
        context.fillRect(x + 7, y - 23, 4, 10);
        context.fillRect(x + 17, y - 23, 4, 10);
    
        // Legs
        if (this.hasLeftLegForward(offset)) {
            context.fillRect(x + 9, y - 13, 4, 13);
            context.fillRect(x + 13, y - 10, 4, 10);
        } else if (this.hasRightLegForward(offset)) {
            context.fillRect(x + 13, y - 13, 4, 13);
            context.fillRect(x + 9, y - 10, 4, 10);
        } else {
            context.fillRect(x + 9, y - 13, 4, 13);
            context.fillRect(x + 13, y - 13, 4, 13);
        }
    };
    Human.prototype.colliders = function(offset) {
        var y = this.y - this.jumpHeight(offset);
        return [{
            x: this.x + offset + 6,
            y: y - 0,
            width: 15,
            height: 40
        }];
    };

    namespace.Human = Human;
})(window);