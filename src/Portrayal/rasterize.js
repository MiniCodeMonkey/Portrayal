var fs = require('fs'),
	page = require('webpage').create(),
	system = require('system'),
	address, output, size;

page.settings.userAgent = 'Portrayal (https://github.com/minicodemonkey/portrayal) 1.1.1';

if (system.args.length < 3 || system.args.length > 4) {
	console.log('Usage: rasterize.js URL filename');
	phantom.exit();
} else {
	address = system.args[1];
	output = system.args[2];
	page.viewportSize = { width: 1280, height: 600 };
	page.onConsoleMessage = function(msg) { console.log(msg); };
	page.open(address, function (status) {
		if (status !== 'success') {
			console.log('Unable to load the address!');
			phantom.exit(1);
		} else {
			window.setTimeout(function () {
				page.render(output);
				phantom.exit();
			}, 350);
		}
	});
}