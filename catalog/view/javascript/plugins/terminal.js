(function($) {
	var settings;
	
	// Initializes the terminal window and runs the commands.
	$.fn.terminal = function(options, params){
		if(options === "changeCommands"){
			changeCommands(params);
			return;
		}
		
		settings = $.extend({
			prompt: "",
			promptClass: "prompt",
			editorID: "",
			delayms: 10,
			commands: new Array(),
			commandControlStop: false,
			resultControlStop: false,
			end: false,
			resultEnd: true
		}, options);
		$(this).addClass("terminal");
		
		// Begin by placing the prompt
		$(this).append("<div id='current-row' class='row'><span class='" + settings.promptClass + "'>" + settings.prompt + "</span><span class='command'></span></div>");
		$(this).after("<div id='editor-window'></div>");
		beginCommands(0);
	};
	
	function changeCommands(params){
		// Send a control stop signal to main loop and begin the new loop
		settings.commands = params;
		$("#console-window").empty().append("<div id='current-row' class='row'><span class='" + settings.promptClass + "'>" + settings.prompt + "</span><span class='command'></span></div>");
		
		console.log("END: " + settings.end);
		if(settings.end){
			settings.end = false;
		}
		else {
			settings.commandControlStop = true;
			
			console.log("RESULT END: " + settings.resultEnd);
		}
		if(!settings.resultEnd){
			console.log("setting resultControlStop");
			settings.resultControlStop = true;
		}
		else {
			$("#editor-window").html("");
		}
		
		setTimeout(function(){
			beginCommands(0);
		}, settings.delayms);
	}
	
	function beginCommands(place){
		settings.end = false;
		
		(function loop(j, x){
			setTimeout(function(){
				if(settings.commandControlStop){
					settings.commandControlStop = false;
					return;
				}
				var $command = $("#current-row .command");
				$command = $command.text($command.text() + settings.commands[x].command.charAt(settings.commands[x].command.length - j));
				if(j--){
					loop(j, x);
				}
				else {
					if(parseInt(settings.commands[x].is_edit) !== 1){
						$("#current-row").attr("id", "").after("<div class='result'>" + settings.commands[x].result + "</div>").next().after("<div class='row' id='current-row'><span class='" + settings.promptClass + "'>" + settings.prompt + "</span><span class='command'></span></div>");
					}
					else {
						var elem = document.createElement('textarea');
						elem.innerHTML = settings.commands[x].result;
						editor(unescape(elem.value), x);
						settings.end = true;
						return;
					}

					// Start the next command
					if(++x < settings.commands.length){
						loop(settings.commands[x].command.length, x);
					}
					else {
						settings.end = true;
					}
				}
			}, settings.delayms);
		})(settings.commands[place].command.length, place);
	}

	function HtmlEncode(s)
	{
		var el = document.createElement("div");
		el.innerText = el.textContent = s;
		s = el.innerHTML;
		return s;
	}
	// Opens new editor window and animates code creation.
	function editor (text, newPlace){
		settings.resultEnd = false;
		
		(function loop(j){
			setTimeout(function(){
				var $editor = $("#editor-window");
				console.log(settings.resultControlStop);
				if(settings.resultControlStop){
					settings.resultControlStop = false;
					settings.resultEnd = true;
					$editor.html("");
					return;
				}
				
				if(text.charAt(text.length - j) === "\n"){
					$editor.html($editor.html() + "<br />");
				}
				else {
					$editor.html($editor.html() + text.charAt(text.length - j));
				}
				if(j--){
					loop(j);
				}
				else{
					// Start the next command
					if(++newPlace < settings.commands.length){
						beginCommands(newPlace);
					}
					settings.resultEnd = true;
				}
			}, settings.delayms);
		})(text.length);
	}
})( jQuery );