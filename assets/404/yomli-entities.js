(function(root) {
'use strict';

var entId = 0;
var newEntity = function Entity(game, type) {
	this.game = game;
	this.type = type;
	var typeData = newEntity.Types[type];
	RL.Util.merge(this, typeData);
	this.id = entId++;
	if(this.init){
		this.init(game, type);
	}
};

newEntity.prototype = {
	constructor: newEntity,
	game: null,
	type: null,
	init: false,
	name: null,
	x: null,
	y: null,
	char: 'x',
	color: '#fff',
	bgColor: false,
	dead: false,
	onAdd: false,
	onRemve: false,

	hp:1,
	hpMax:1,

	damage:1,
	score:1,

	moving: false,
	enemy: false,
	playerLastSeen: false,

	takeDamage: function(amount) {
		this.hp -= amount;
		if(this.hp <= 0) {
			this.dead = true;
			this.game.console.log("You killed <strong>" + this.name + "</strong>.");
			this.game.player.scoreUp(this.score);
		}
	},

	heal: function(amount){
		this.hp += amount;	
		if(this.hp > this.hpMax){
			this.hp = this.hpMax;
		}
	},


	playerVisible: function() {
		return this.game.player.fov.get(this.x, this.y);
	},

	updatePlayerLastSeen: function() {
		if(this.playerVisible()) {
			this.playerLastSeen = {
				x: this.game.player.x,
				y: this.game.player.y
			};
		}
		if(this.playerLastSeen &&
			this.x === this.playerLastSeen.x &&
			this.y === this.playerLastSeen.y
			) {
			this.playerLastSeen = false;
		}
	},

	getRandomAdjacentTile: function() {
		var directions = ['up', 'down', 'left', 'right'];
		var adjacent = [];
		for(var i = directions.length - 1; i >= 0; i--) {
			var dir = directions[i];
			var offset = RL.Util.getOffsetCoordsFromDirection(dir);
			var adjTileX = this.x + offset.x;
			var adjTileY = this.y + offset.y;
			if(this.canMoveTo(adjTileX, adjTileY)) {
				adjacent.push({
					x: adjTileX,
					y: adjTileY
				});
			}
		}
		if(adjacent && adjacent.length) {
			return adjacent[Math.floor(Math.random() * adjacent.length)];
		}
		return false;
	},

	isAdjacent: function(x, y) {
		return(
			(x === this.x && (y === this.y - 1 || y === this.y + 1)) ||
			(y === this.y && (x === this.x - 1 || x === this.x + 1))
			);
	},

	getNextPathTile: function(x, y) {
		var path = this.getPathToTile(x, y);
		path.splice(0, 1);
		if(path[0] && path[0].x !== void 0 && path[0].y !== void 0) {
			return path[0];
		}
	},

	getPathToTile: function(x, y) {
		var _this = this,
		path = [],
		computeCallback = function(x, y) {
			path.push({
				x: x,
				y: y
			});
		},
		passableCallback = function(x, y) {
			if(_this.x === x && _this.y === y) {
				return true;
			}
			return _this.canMoveTo(x, y);
		},
		aStar = new ROT.Path.AStar(x, y, passableCallback, {
			topology: 4
		});

		aStar.compute(this.x, this.y, computeCallback);
		return path;
	},

	canMoveThrough: function(x, y){
		return this.game.entityCanMoveTo(this, x, y);
	},

	canMoveTo: function(x, y) {
		return this.game.entityCanMoveTo(this, x, y);
	},

	moveTo: function(x, y) {
		return this.game.entityMoveTo(this, x, y);
	},

	canSeeThrough: function(x, y){
		return this.game.entityCanSeeThrough(this, x, y);
	},

	bump: function(entity){
		// Combat is here
		if(entity === this.game.player && this.enemy === true){
			this.takeDamage(entity.damage);
			var damages = "damage";
			if(entity.damage > 1) damages += "s";
			this.game.console.log("Your attack makes <strong>" + entity.damage + "</strong> " + damages + " to <strong>" + this.name + "</strong>.");
			return true;
		}
		return false;
	},
		
	update: function() {
		if(this.moving === true) {
			var stumbleChance = this.turnsSinceStumble / this.maxTurnsWithoutStumble;
			if(this.turnsSinceStumble && Math.random() < stumbleChance) {
				this.turnsSinceStumble = 0;
				return true;
			}
			this.turnsSinceStumble++;
			this.updatePlayerLastSeen();
			if(this.isAdjacent(this.game.player.x, this.game.player.y)) {
				// Combat is here
				this.game.player.takeDamage(this.damage);
				var damages = "damage";
				if(this.damage > 1) damages += "s";
				this.game.console.log("<strong>" + this.name + "</strong> inflicts <strong>" + this.damage + " " +  damages +".</strong>");

				return true;
			}
			var destination;
			if(this.playerLastSeen) {
				destination = this.getNextPathTile(this.playerLastSeen.x, this.playerLastSeen.y);
			}
			if(!destination) {
				destination = this.getRandomAdjacentTile();
			}
			if(destination) {
				this.moveTo(destination.x, destination.y);
				return true;
			}
		} else if(this.enemy === true) {
			if(this.isAdjacent(this.game.player.x, this.game.player.y)) {
				// Combat is here
				this.game.player.takeDamage(this.damage);
				var damages = "damage";
				if(this.damage > 1) damages += "s";
				this.game.console.log("<strong>" + this.name + "</strong> inflicts <strong>" + this.damage + " " +  damages +".</strong>");

				return true;
			}
		}
	},

};

newEntity.Types = {
	test: {
		name: 'Crow',
		char: 'c',
		color: 'darkblue',
		bgColor: false,
		bump: function(entity){
			// if bumping entity is the player
			if(entity === this.game.player){
				// @TODO combat logic here
				this.game.console.log('You shot down a crow.');
				this.dead = true;
				return true;
			}
			return false;
		}
	}
};

RL.Util.merge(newEntity.prototype, RL.Mixins.TileDraw);
RL.Util.merge(newEntity.prototype, RL.Mixins.PerformableActionInterface);
RL.Util.merge(newEntity.prototype, RL.Mixins.ResolvableActionInterface);

newEntity.Types = {
		zombie: {
			name: 'Zombie',
			char: 'z',
			color: 'red',
			bgColor: false,
		},
	};


root.RL.Entity = newEntity;

}(this));