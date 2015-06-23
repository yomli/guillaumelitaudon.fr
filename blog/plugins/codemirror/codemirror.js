function demo_open(url) {

	var width = 800;
	var height = 430;
	var left = (screen.width-width)/2;
	var top = (screen.height-height)/2;
	var options =
		'height='+height+', width='+width+', top='+top+', left='+left+
		',menubar=no, location=no, titlebar=no, toolbar=yes, resizable=no';

	var myWindow = window.open(url, '_blank', options);
	myWindow.unload = close;
	return false;
}

function activeEditor(aTheme, showLineNumbers) {
	var options = {
		matchBrackets: true,
		// mode: 'htmlmixed',
		mode: 'php',
		indentUnit: 4,
		indentWithTabs: true,
		matchBrackets: true,
		autoCloseBrackets: true,
		autoCloseTags: true,
		lineWrapping: true,
		styleActiveLine: true,
		extraKeys: {
			'F11': function(cm) {cm.setOption('fullScreen', !cm.getOption('fullScreen'));},
			'Esc': function(cm) {if (cm.getOption('fullScreen')) cm.setOption('fullScreen', false);},
			'Ctrl-Space': 'autocomplete'
		},
		foldGutter: true,
	    gutters: ['CodeMirror-linenumbers', 'CodeMirror-foldgutter'],
		enterMode: 'keep',
		tabMode: 'shift'}
	if (showLineNumbers)
		options['lineNumbers'] = true;
	if (aTheme.length > 0)
		options['theme'] = aTheme;

	var myTextareas = ['id_content', 'id_chapo'];
	var editors = {};
	for (i=0; i<myTextareas.length; i++) {
		var id = myTextareas[i];
		var el = document.getElementById(id);
		if (el)
			editors[id] = CodeMirror.fromTextArea(el, options);
	}
	var fullscreen = document.getElementById('fullscreen');
	if (fullscreen)
		fullscreen.onclick = function() {
			editors['id_content'].setOption('fullScreen', !editors['id_content'].getOption('fullScreen'));
			editors['id_content'].focus();
			return false;
			}
	else
		console.log('fullscreen not found');
}

CodeMirror.colorize = (function() {

  var isBlock = /^(p|li|div|h\\d|pre|blockquote|td)$/;

  function textContent(node, out) {
    if (node.nodeType == 3) return out.push(node.nodeValue);
    for (var ch = node.firstChild; ch; ch = ch.nextSibling) {
      textContent(ch, out);
      if (isBlock.test(node.nodeType)) out.push("\n");
    }
  }

  return function(collection, defaultMode) {
    if (!collection) collection = document.body.getElementsByTagName("pre");

    for (var i = 0; i < collection.length; ++i) {
      var node = collection[i];
      var mode = node.getAttribute("data-lang") || defaultMode;
      if (!mode) continue;

      var text = [];
      textContent(node, text);
      node.innerHTML = "";
      CodeMirror.runMode(text.join(""), mode, node);

      // node.className += " cm-s-default";
      CodeMirror.defaults.lineNumbers = true;
      node.className += ' CodeMirror cm-s-' + CodeMirror.defaults.theme;
    }
  };
})();
