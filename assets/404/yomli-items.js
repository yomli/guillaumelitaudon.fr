RL.Entity.Types.heart = {
		name: 'Heart',
		char: '❤',
		color: 'red',
		bgColor: false,
		bump: function(entity){
			entity.heal(1);
			if(entity === this.game.player){
				this.game.console.log('You regained <strong>1</strong> HP.');
				this.dead = true;
				return true;
			}
			return false;
		}
};

RL.Entity.Types.bigheart = {
		name: 'Big heart',
		char: '❤',
		color: 'red',
		bgColor: false,
		bump: function(entity){
			entity.heal(5);
			if(entity === this.game.player){
				this.game.console.log('You regained <strong>5</strong> hp.');
				this.dead = true;
				return true;
			}
			return false;
		}
};

RL.Entity.Types.greenmoney = {
		name: 'Money bag',
		char: '$',
		color: 'green',
		bgColor: false,
		bump: function(entity){
			if(entity === this.game.player){
				entity.scoreUp(100);
				this.game.console.log('You found <strong>100</strong> coins.');
				this.dead = true;
				return true;
			}
			return false;
		}
};

RL.Entity.Types.purplemoney = {
		name: 'Money bag',
		char: '$',
		color: 'orange',
		bgColor: false,
		bump: function(entity){
			if(entity === this.game.player){
				entity.scoreUp(400);
				this.game.console.log('You found <strong>400</strong> coins.');
				this.dead = true;
				return true;
			}
			return false;
		}
};

RL.Entity.Types.yellowmoney = {
		name: 'Money bag',
		char: '$',
		color: 'yellow',
		bgColor: false,
		bump: function(entity){
			if(entity === this.game.player){
				entity.scoreUp(700);
				this.game.console.log('You found <strong>700</strong> coins');
				this.dead = true;
				return true;
			}
			return false;
		}
};

RL.Entity.Types.cross = {
		name: 'Cross',
		char: 'x',
		color: 'blue',
		bgColor: false,
		bump: function(entity){
			if(entity === this.game.player){
				entity.damage += entity.damage;
				this.game.console.log('Double shot!');
				this.dead = true;
				return true;
			}
			return false;
		}
};

RL.Entity.Types.upgrade = {
		name: 'Better weapon',
		char: '}',
		color: 'red',
		bgColor: false,
		bump: function(entity){
			if(entity === this.game.player){
				entity.damage += 1;
				this.game.console.log('You found a better weapon.');
				this.dead = true;
				return true;
			}
			return false;
		}
};