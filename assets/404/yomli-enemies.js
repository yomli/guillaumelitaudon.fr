RL.Entity.Types.bat = {
	name: 'Bat',
	char: 'b',
	color: 'darkslategray',
	bgColor: false,
	hp:1,
	hpMax:1,
	damage:1,
	score:200,
	moving:true,
	enemy:true
};

RL.Entity.Types.crow = {
	name: 'Crow',
	char: 'c',
	color: 'darkblue',
	bgColor: false,
	hp:1,
	hpMax:1,
	damage:1,
	score:200,
	moving:true,
	enemy:true
};

RL.Entity.Types.dragon = {
	name: 'Bone Dragon',
	char: 'd',
	color: 'white',
	bgColor: false,
	hp:7,
	hpMax:8,
	damage:1,
	score:1000,
	moving:false,
	enemy:true
};

RL.Entity.Types.eagle = {
	name: 'Eagle',
	char: 'e',
	color: 'saddlebrown',
	bgColor: false,
	hp:1,
	hpMax:1,
	damage:1,
	score:300,
	moving:true,
	enemy:true
};

RL.Entity.Types.frogman = {
	name: 'Frogman',
	char: 'f',
	color: 'darkgreen',
	bgColor: false,
	hp:1,
	hpMax:1,
	damage:1,
	score:300,
	moving:true,
	enemy:true
};

RL.Entity.Types.ghost = {
	name: 'Ghost',
	char: 'g',
	color: 'royalblue',
	bgColor: false,
	hp:2,
	hpMax:3,
	damage:1,
	score:300,
	moving:true,
	enemy:true
};

RL.Entity.Types.hound = {
	name: 'Hound',
	char: 'h',
	color: 'teal',
	bgColor: false,
	hp:1,
	hpMax:1,
	damage:1,
	score:200,
	moving:true,
	enemy:true
};

RL.Entity.Types.knight = {
	name: 'Knight',
	char: 'k',
	color: 'lightslategray',
	bgColor: false,
	hp:9,
	hpMax:10,
	damage:1,
	score:1400,
	moving:true,
	enemy:true
};

RL.Entity.Types.monkey = {
	name: 'Monkey',
	char: 'm',
	color: 'maroon',
	bgColor: false,
	hp:1,
	hpMax:1,
	damage:1,
	score:400,
	moving:true,
	enemy:true
};

RL.Entity.Types.redskeleton = {
	name: 'Red skeleton',
	char: 's',
	color: 'red',
	bgColor: false,
	hp:20,
	hpMax:20,
	damage:0,
	score:1500,
	moving:true,
	enemy:true
};

RL.Entity.Types.skeleton = {
	name: 'Skeleton',
	char: 's',
	color: 'lightblue',
	bgColor: false,
	hp:1,
	hpMax:1,
	damage:1,
	score:300,
	moving:true,
	enemy:true
};


RL.Entity.Types.tower = {
	name: 'Flesh Tower',
	char: 't',
	color: 'tomato',
	bgColor: false,
	hp:6,
	hpMax:8,
	damage:1,
	score:400,
	moving:false,
	enemy:true
};

RL.Entity.Types.zombie = {
	name: 'Zombie',
	char: 'z',
	color: 'rosybrown',
	bgColor: false,
	hp:1,
	hpMax:1,
	damage:1,
	score:100,
	moving:true,
	enemy:true
};

/**********************************
 * Bosses
 *********************************/

RL.Entity.Types.bossBat = {
	name: 'Vampire bat',
	char: 'B',
	color: 'darkslategray',
	bgColor: false,
	hp:8,
	hpMax:8,
	damage:2,
	score:3000,
	moving:true,
	enemy:true,
	takeDamage: function(amount) {
		this.hp -= amount;
		if(this.hp <= 0) {
			this.dead = true;
			this.game.console.log("You shot down the <strong>" + this.name + "</strong>!");
			this.game.player.scoreUp(this.score);
			loadNextStage(this.game, 2);
			this.game.console.log("<strong>Yomli</strong>: My Vampire bat was just a toy. Now, we'll see how you stand against an ancient curse…");
		}
	},
	
};

RL.Entity.Types.bossMummy = {
	name: 'Mummy',
	char: 'M',
	color: 'darkkhaki',
	bgColor: false,
	hp:12,
	hpMax:12,
	damage:2,
	score:3000,
	moving:true,
	enemy:true,
	takeDamage: function(amount) {
		this.hp -= amount;
		if(this.hp <= 0) {
			this.dead = true;
			this.game.console.log("You burned the <strong>" + this.name + "</strong>!");
			this.game.player.scoreUp(this.score);
			loadNextStage(this.game, 3);
			this.game.console.log("<strong>Yomli</strong>: What?! How?! OK, now I'm serious!");
		}
	},
};

RL.Entity.Types.bossMonster = {
	name: 'Undead monster',
	char: 'U',
	color: 'white',
	bgColor: false,
	hp:16,
	hpMax:16,
	damage:2,
	score:5000,
	moving:true,
	enemy:true,
	takeDamage: function(amount) {
		this.hp -= amount;
		if(this.hp <= 0) {
			this.dead = true;
			this.game.console.log("You defeated the <strong>" + this.name + "</strong>!");
			this.game.player.scoreUp(this.score);
			loadNextStage(this.game, 4);
			this.game.console.log("<strong>Yomli</strong>: Never trust the undead, this stuff fall in pieces. Prepare to meet HIM!");
		}
	},
};

RL.Entity.Types.bossDeath = {
	name: 'Death',
	char: 'D',
	color: 'darkslateblue',
	bgColor: false,
	hp:20,
	hpMax:20,
	damage:2,
	score:7000,
	moving:true,
	enemy:true,
	takeDamage: function(amount) {
		this.hp -= amount;
		if(this.hp <= 0) {
			this.dead = true;
			this.game.console.log("You banished the <strong>" + this.name + "</strong> himself (yes, he is a male)!");
			this.game.player.scoreUp(this.score);
			loadNextStage(this.game, 5);
			this.game.console.log("<strong>Yomli</strong>: So, you've come a long way. Come closer. I want to talk to you.");
		}
	},
};

RL.Entity.Types.bossYomli = {
	name: 'Yomli',
	char: 'Y',
	color: 'darkgreen',
	bgColor: false,
	hp:35,
	hpMax:35,
	damage:3,
	score:0,
	moving:true,
	enemy:true,
	takeDamage: function(amount) {
		this.hp -= amount;
		if(this.hp <= 0) {
			this.dead = true;
			this.game.console.log("You defeated <strong>" + this.name + "</strong>!");
			this.game.player.scoreUp(this.score);
			loadNextStage(this.game, 5);
			this.game.console.log("<strong>Yomli</strong>: I… I… OK, I'll fix that buggy website of mine.");
			this.game.console.log("<strong>Yomli</strong>: Take a screenshot and send it to <strong>guillaume.litaudon@gmail.com</strong> to prove you've defeated me.");
			this.game.console.log("GG. Thank you for playing!");
		}
	},
};

RL.Entity.Types.bossFinal = {
	name: 'Yomli',
	char: 'Y',
	color: 'olive',
	bgColor: false,
	hp:16,
	hpMax:24,
	damage:5,
	score:50000,
	moving:true,
	enemy:true
};