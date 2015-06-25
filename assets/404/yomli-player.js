(function(root) {
	'use strict';

	var proto = root.RL.Player.prototype;

	var NewPlayer = function Player(game){
		proto.constructor.call(this, game);

	};

	var newPlayerPrototype = {
		constructor: NewPlayer,

		name: 'You',

		hp: 14,
		hpMax: 15,

		hpEl: null,
		hpMaxEl: null,
		scoreEl: null,

		damage:1,
		score: 0,

		takeDamage: function(amount) {
			if(this.game.gameOver){
				return;
			}
			this.hp -= amount;

			if (this.hp <= 0) {
				this.hp = 0;
				this.game.gameOver = true;
				this.game.console.log("You died. <strong>Game Over!</strong>");
			}

			this.renderHtml();
		},

		heal: function(amount){
			this.hp += amount;	
			if(this.hp > this.hpMax){
				this.hp = this.hpMax;
			}
			this.renderHtml();
		},

		scoreUp: function(amount){
			this.score += amount;	
			this.renderHtml();
		},

		renderHtml: function(){
			this.hpEl.innerHTML = "HP: " + this.hp;
			this.hpMaxEl.innerHTML = "/"+this.hpMax;
			this.scoreEl.innerHTML = "Score: " + this.score;
		},

		move: function(x, y){
			if(this.canMoveTo(x, y)){
				this.moveTo(x, y);
				return true;
			} else {
				var targetTileEnt = this.game.entityManager.get(x, y);
				if(targetTileEnt){
					return targetTileEnt.bump(this);
				} else {
					var targetTile = this.game.map.get(x, y);
					return targetTile.bump(this);
				}
			}
			return false;
		},
	};

	RL.Util.merge(NewPlayer.prototype, proto);
	RL.Util.merge(NewPlayer.prototype, newPlayerPrototype);

	root.RL.Player = NewPlayer;

}(this));
