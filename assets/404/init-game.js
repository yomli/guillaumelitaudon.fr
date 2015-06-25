var keyBindings = {
	up: ['UP_ARROW', 'K', 'W', 'Z'],
	down: ['DOWN_ARROW', 'J', 'S'],
	left: ['LEFT_ARROW', 'H', 'A', 'Q'],
	right: ['RIGHT_ARROW', 'L', 'D'],
	wait: ['SPACE']
};

var rendererWidth = 30;
var rendererHeight = 15;

var mapContainerEl = document.getElementById('game');
var consoleContainerEl = document.getElementById('console');


// create the game instance
var game = new RL.Game();

// add input keybindings
game.input.addBindings(keyBindings);

// loading maps and entities
game.map.loadTilesFromArrayString(map[0], mapCharToType, 'floor');
game.setMapSize(game.map.width, game.map.height);
game.entityManager.loadFromArrayString(map[0], entityMap[0]);


// set player starting position
game.player.x = playerStartX[0];
game.player.y = playerStartY[0];

// renderer
game.renderer.resize(rendererWidth, rendererHeight);
game.renderer.layers = [
	new RL.RendererLayer(game, 'map',       {draw: false,   mergeWithPrevLayer: false}),
	new RL.RendererLayer(game, 'entity',    {draw: true,   mergeWithPrevLayer: true}),
];

// append elements created by the game to the DOM
mapContainerEl.appendChild(game.renderer.canvas);

if(consoleContainerEl){
	consoleContainerEl.appendChild(game.console.el);
}

// set the stats
var statElements = {
	hpEl: document.getElementById('stat-hp'),
	hpMaxEl: document.getElementById('stat-hp-max'),
	scoreEl: document.getElementById('stat-score'),
};
RL.Util.merge(game.player, statElements);
game.player.renderHtml();

game.map.each(function(val, x, y){
	if((x+1) % 5 === 0 && (y+1) % 5 === 0){
		var tile = game.map.get(x, y);
		if(tile.type !== 'wall'){
			game.lighting.set(x, y, 100, 100, 100);
		}
	}
});

// start
game.start();

// prelude text
game.console.log("<strong>The Labyrinth of Yomli's website</strong>");
game.console.log("--------------------------------");
game.console.log("<strong>Yomli</strong>: So, you managed to get lost? Defeat me and I'll fix this broken link!");



var loadNextStage = function(theGame, stage) {
	stage--;

	// reset the entities
	theGame.entityManager.reset();

	// and reload
	theGame.map.loadTilesFromArrayString(map[stage], mapCharToType, 'floor');
	theGame.setMapSize(theGame.map.width, theGame.map.height);
	theGame.entityManager.loadFromArrayString(map[stage], entityMap[stage]);

	// set player starting position
	//theGame.player.x = playerStartX[stage];
	//theGame.player.y = playerStartY[stage];
	theGame.entityManager.add(playerStartX[stage], playerStartY[stage], theGame.player);

	theGame.input.addBindings(keyBindings);

	// renderer
	theGame.renderer.resize(rendererWidth, rendererHeight);
	theGame.renderer.layers = [
		new RL.RendererLayer(theGame, 'map',       {draw: false,   mergeWithPrevLayer: false}),
		new RL.RendererLayer(theGame, 'entity',    {draw: true,   mergeWithPrevLayer: true}),
	];

	// append elements created by the game to the DOM
	mapContainerEl.appendChild(theGame.renderer.canvas);

	theGame.map.each(function(val, x, y){
		if((x+1) % 5 === 0 && (y+1) % 5 === 0){
			var tile = theGame.map.get(x, y);
			if(tile.type !== 'wall'){
				theGame.lighting.set(x, y, 100, 100, 100);
			}
		}
	});

	theGame.console.log("--------------------------------");

};